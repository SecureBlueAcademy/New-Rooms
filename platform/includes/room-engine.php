<?php
// Guard: this file must be included by a room data file, never accessed directly.
if (!defined('CYBRIXEN_ROOM_ENGINE')) {
    http_response_code(403);
    exit('Direct access not permitted.');
}

// ============================================================
// room-engine.php — STATIC ROOM ENGINE — DO NOT MODIFY
// Deploy to: includes/room-engine.php (server root)
// Usage: require_once '../../includes/room-engine.php'; at the
//        end of every room data file.
//
// Required variables set by the data file before this include:
//   $room_config        — room metadata array
//   $answers_file       — absolute path to answers CSV
//   $room_tasks         — array of ['id'=>'task1','title'=>'...']
//   $js_config          — ['storage_key'=>'...','instagram_takeaways'=>[...]]
//   $task_questions_data — ['task1'=>[['id'=>'q0','text'=>'...']],...]
//   $task_contents      — [1 => 'HTML string', 2 => 'HTML string', ...]
// ============================================================

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/access-control.php';

if (!$auth->isLoggedIn()) {
    $auth->redirectToLogin();
}

// ── Subscriber-gated room check ──────────────────────────────
// Rooms are free by default. Only rooms in the page_access table
// with allowed_roles containing 'subscriber' require a subscription.
(function() use ($auth, $pdo) {
    $path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    try {
        $stmt = $pdo->prepare(
            "SELECT allowed_roles FROM page_access WHERE page_path = ? AND require_auth = 1 LIMIT 1"
        );
        $stmt->execute([$path]);
        $row = $stmt->fetch();
    } catch (PDOException $e) {
        return; // DB error — fail open, let user in
    }
    if (!$row) return; // no rule → free room

    $allowed = json_decode($row['allowed_roles'], true) ?: [];
    $user    = $auth->getCurrentUser();
    if (!in_array($user['role'], $allowed)) {
        header('Location: /pricing.php?locked=1');
        exit;
    }
})();

// ========================
// LOAD ANSWERS FROM CSV
// ========================
$answers = [];
if (file_exists($answers_file)) {
    if (($handle = fopen($answers_file, 'r')) !== false) {
        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) >= 3) {
                $question_id   = $data[1];
                $correct_answer = $data[2];
                $answers[$question_id] = [
                    'answer'      => $correct_answer,
                    'placeholder' => generatePlaceholder($correct_answer)
                ];
            }
        }
        fclose($handle);
    }
}

function generatePlaceholder($answer) {
    $placeholder = '';
    $words = explode(' ', $answer);
    foreach ($words as $word) {
        $processedWord = '';
        for ($i = 0; $i < strlen($word); $i++) {
            $char = $word[$i];
            $processedWord .= preg_match('/[a-zA-Z0-9]/', $char) ? '*' : $char;
        }
        $placeholder .= $processedWord . ' ';
    }
    return trim($placeholder);
}

// ========================
// HANDLE ANSWER SUBMISSION
// ========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'check_answer') {
        $question_id = $_POST['question_id'] ?? '';
        $user_answer = trim($_POST['answer'] ?? '');
        $response    = ['success' => false];

        if (isset($answers[$question_id])) {
            $correct_answer = $answers[$question_id]['answer'];
            $is_correct     = strcasecmp($user_answer, $correct_answer) === 0;

            if (!$is_correct && strpos($correct_answer, '/') !== false) {
                foreach (explode('/', $correct_answer) as $alt) {
                    if (strcasecmp($user_answer, trim($alt)) === 0) {
                        $is_correct = true;
                        break;
                    }
                }
            }

            $response = [
                'success'       => true,
                'is_correct'    => $is_correct,
                'correct_answer'=> $correct_answer,
                'placeholder'   => $answers[$question_id]['placeholder']
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

// ========================
// DERIVED VALUES
// ========================
$total_tasks = count($room_tasks);

// Derive JS task-to-question map from $task_questions_data
$js_task_questions = [];
foreach ($task_questions_data as $taskId => $questions) {
    $js_task_questions[$taskId] = array_column($questions, 'id');
}

// Build Instagram caption
$ig_lines = [
    '🎓 Achievement Unlocked: "' . $room_config['title'] . '" on CYBRIXEN!',
    '',
    'What I learned:',
];
foreach ($js_config['instagram_takeaways'] as $t) {
    $ig_lines[] = $t;
}
$ig_lines[] = '';
$ig_lines[] = 'Check out CYBRIXEN for more cybersecurity training!';
$ig_lines[] = '';
$ig_lines[] = '#cybersecurity #CYBRIXEN';
$js_instagram_caption = json_encode(implode("\n", $ig_lines));

// ========================
// RENDER QUESTIONS SECTION
// ========================
function renderQuestionsSection($taskId, $questionsData, $answers) {
    if (empty($questionsData[$taskId])) return '';

    $html  = '<div class="questions-section">';
    $html .= '<div class="questions-header"><i class="fas fa-question-circle"></i><h3>Knowledge Check</h3></div>';

    $questions = $questionsData[$taskId];
    foreach ($questions as $index => $question) {
        $qId         = $question['id'];
        $qNum        = $index + 1;
        $placeholder = isset($answers[$qId]) ? htmlspecialchars($answers[$qId]['placeholder']) : 'Enter your answer...';

        $html .= '<div class="question-item" id="question-' . $qId . '">';
        $html .= '<p class="question-text"><strong>Q' . $qNum . ':</strong> ' . $question['text'] . '</p>';
        $html .= '<div class="answer-form">';
        $html .= '<input type="text" id="answer-' . $qId . '" class="answer-input" placeholder="' . $placeholder . '">';
        $html .= '<button type="button" class="submit-btn" onclick="submitAnswer(\'' . $qId . '\', \'' . $taskId . '\')">Submit</button>';
        $html .= '<button type="button" class="reset-btn" onclick="resetAnswer(\'' . $qId . '\')">Reset</button>';
        $html .= '</div>';
        $html .= '<div id="feedback-' . $qId . '" class="feedback-message" style="display: none;"></div>';
        $html .= '</div>';
    }

    $html .= '</div>';
    return $html;
}
?>

<?php include __DIR__ . '/header.php'; ?>
<script src="/assets/cyber-background.js" defer></script>
<link rel="stylesheet" href="../../assets/rooms-style.css">

<style>
/* ========== CYBER BACKGROUND LAYERING ========== */
canvas {
    position: fixed !important;
    inset: 0;
    z-index: 0;
    pointer-events: none;
}
.room-page {
    position: relative;
    z-index: 1;
    background: transparent !important;
}
.room-gradient-bg {
    display: none !important;
}

/* ========== SIDEBAR HEADER ========== */
.sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--border-light);
}

.reset-progress-btn {
    padding: 6px 12px;
    background: var(--surface);
    color: var(--text-secondary);
    border: 1px solid var(--border);
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 5px;
}
.reset-progress-btn:hover {
    background: var(--surface-light);
    border-color: var(--text-secondary);
    color: var(--text-primary);
}
.reset-progress-btn i { font-size: 0.7rem; }

/* ========== PROGRESS BAR ========== */
.room-progress-section { margin: 0 0 25px 0; padding: 0; }
.room-progress-bar {
    background: var(--surface);
    border-radius: 10px;
    height: 10px;
    overflow: hidden;
    border: 1px solid var(--border);
}
.room-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #28a745, #20c997);
    width: 0%;
    transition: width 0.5s ease;
    border-radius: 10px;
}
.room-progress-text {
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin-top: 8px;
    text-align: center;
}

/* ========== CONTENT BLOCK ========== */
.content-block {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.content-block h2 {
    color: var(--text-primary);
    font-size: 1.4rem;
    margin-top: 0;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--border-light);
}
.content-block h3 {
    color: var(--text-primary);
    font-size: 1.2rem;
    margin-top: 25px;
    margin-bottom: 15px;
}
.content-block p {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 15px;
    font-size: 0.95rem;
}
.content-block ul, .content-block ol {
    margin: 15px 0 15px 25px;
    padding: 0;
}
.content-block li {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 10px;
    font-size: 0.95rem;
}
.content-block strong { color: var(--text-primary); font-weight: 600; }

/* ========== TABLES ========== */
.content-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    overflow: hidden;
}
.content-table th {
    background: var(--surface-light);
    color: var(--text-primary);
    font-weight: 600;
    padding: 12px 15px;
    text-align: left;
    border-bottom: 2px solid var(--border);
    font-size: 0.9rem;
}
.content-table td {
    padding: 12px 15px;
    border-bottom: 1px solid var(--border-light);
    color: var(--text-secondary);
    font-size: 0.9rem;
}
.content-table tr:last-child td { border-bottom: none; }
.content-table tr:hover td { background: var(--surface-light); }

/* ========== INFO / WARNING / SUCCESS BOXES ========== */
.info-box, .warning-box, .success-box {
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
    border-left: 4px solid;
}
.info-box    { background: rgba(0,123,255,0.08);  border-left-color: #007bff; }
.warning-box { background: rgba(255,193,7,0.08);  border-left-color: #ffc107; }
.success-box { background: rgba(40,167,69,0.08);  border-left-color: #28a745; }
.info-box h4, .warning-box h4, .success-box h4 {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 0;
    margin-bottom: 10px;
    color: var(--text-primary);
    font-size: 1rem;
}
.info-box h4 i    { color: #007bff; }
.warning-box h4 i { color: #ffc107; }
.success-box h4 i { color: #28a745; }
.info-box p, .warning-box p, .success-box p {
    margin-bottom: 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
}

/* ========== QUESTIONS SECTION ========== */
.questions-section {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 25px;
    margin-top: 30px;
}
.questions-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--border-light);
}
.questions-header h3 {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}
.questions-header i { color: var(--text-secondary); font-size: 1.1rem; }
.question-item {
    margin-bottom: 25px;
    padding-bottom: 25px;
    border-bottom: 1px solid var(--border-light);
}
.question-item:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
.question-text {
    font-size: 1rem;
    color: var(--text-primary);
    margin-bottom: 15px;
    line-height: 1.5;
}
.question-text strong { color: var(--text-primary); font-weight: 600; }
.answer-form { display: flex; gap: 10px; align-items: center; }
.answer-input {
    flex: 1;
    padding: 10px 15px;
    background: var(--background);
    border: 1px solid var(--border);
    border-radius: 6px;
    color: var(--text-primary);
    font-size: 0.95rem;
    font-family: var(--font-primary);
    height: 40px;
    min-height: 40px;
    transition: all 0.3s ease;
}
.answer-input:focus { outline: none; border-color: var(--text-secondary); }
.answer-input.correct {
    background: rgba(40,167,69,0.1) !important;
    border-color: #28a745 !important;
    color: #155724 !important;
    font-weight: 500;
}
.submit-btn, .reset-btn {
    padding: 10px 20px;
    background: var(--surface);
    color: var(--text-primary);
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    height: 40px;
    min-width: 80px;
    white-space: nowrap;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}
.submit-btn:hover, .reset-btn:hover { background: var(--surface-light); }
.submit-btn:disabled, .reset-btn:disabled { opacity: 0.5; cursor: not-allowed; }
.submit-btn {
    background: var(--success);
    color: white;
    border-color: var(--success);
}
.submit-btn:hover { background: #218838; border-color: #1e7e34; }
.feedback-message {
    font-size: 0.9rem;
    margin-top: 10px;
    padding: 10px 15px;
    border-radius: 6px;
    display: none;
    align-items: center;
    gap: 10px;
}
.feedback-success {
    background: rgba(40,167,69,0.1);
    color: #28a745;
    border: 1px solid rgba(40,167,69,0.2);
}
.feedback-error {
    background: rgba(220,53,69,0.1);
    color: #dc3545;
    border: 1px solid rgba(220,53,69,0.2);
}

/* ========== TASK NAVIGATION (SIDEBAR) ========== */
.task-nav-item.completed {
    background: var(--surface) !important;
    border-color: var(--border) !important;
}
.task-nav-item.completed .task-number {
    position: relative;
    border-color: var(--border) !important;
    background: var(--surface) !important;
    color: var(--text-primary) !important;
}
.task-nav-item.completed .task-number::after {
    content: '✓';
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    color: #28a745;
    font-size: 14px;
    font-weight: bold;
    background: white;
    width: 100%; height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    border: 2px solid #28a745;
}
.task-nav-item.completed::after { display: none !important; }
.task-number {
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--text-primary);
    font-weight: 600;
    position: relative;
}
.task-nav-item.active .task-number {
    background: var(--surface);
    border-color: var(--text-primary);
}
.task-subtitle { display: none; }
.task-title i { color: var(--text-secondary) !important; }
.task-nav-item:hover:not(.disabled) {
    background: var(--surface-light) !important;
    border-color: var(--border) !important;
    transform: translateX(3px) !important;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05) !important;
}
.task-nav-item.active {
    background: var(--surface-light) !important;
    border-color: var(--border) !important;
    box-shadow: 0 0 15px rgba(0,0,0,0.05) !important;
}
.task-nav-item.active::before { display: none !important; }
.task-nav-title { font-weight: 500 !important; }

/* ========== CONFETTI ========== */
.confetti {
    position: fixed;
    width: 15px; height: 15px;
    background: #f00;
    top: 0; opacity: 0;
    z-index: 9999;
    pointer-events: none;
}

/* ========== CONFIRMATION MODAL ========== */
.confirmation-modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.85);
    backdrop-filter: blur(10px);
    z-index: 10002;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: fadeIn 0.3s ease;
}
.confirmation-content {
    background: var(--surface);
    border-radius: 20px;
    width: 90%; max-width: 450px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 25px 60px rgba(0,0,0,0.4);
    border: 1px solid var(--border);
    animation: slideUp 0.3s ease;
    position: relative;
}
.confirmation-icon {
    font-size: 3rem;
    color: #ffc107;
    margin-bottom: 20px;
    display: block;
    animation: pulse 1s infinite alternate;
}
.confirmation-title { font-size: 1.5rem; color: var(--text-primary); margin-bottom: 15px; font-weight: 700; }
.confirmation-message { color: var(--text-secondary); line-height: 1.5; margin-bottom: 30px; font-size: 1rem; }
.confirmation-actions { display: flex; gap: 15px; justify-content: center; }
.confirm-btn, .cancel-btn {
    padding: 12px 28px;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid;
    min-width: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.confirm-btn { background: #dc3545; color: white; border-color: #dc3545; }
.confirm-btn:hover { background: #c82333; border-color: #bd2130; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(220,53,69,0.3); }
.cancel-btn { background: var(--surface); color: var(--text-primary); border-color: var(--border); }
.cancel-btn:hover { background: var(--surface-light); border-color: var(--text-secondary); transform: translateY(-2px); }

/* ========== COMPLETION MODAL (COMPACT) ========== */
@keyframes fadeIn  { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { transform: translateY(20px) scale(0.98); opacity: 0; } to { transform: translateY(0) scale(1); opacity: 1; } }
@keyframes bounce  { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
@keyframes pulse   { 0% { transform: scale(1); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }

.room-completion-modal {
    display: none;
    position: fixed;
    top: 80px; left: 0;
    width: 100%; height: calc(100% - 80px);
    background: rgba(0,0,0,0.92);
    backdrop-filter: blur(8px);
    z-index: 10000;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.3s ease;
    padding: 10px;
}
.room-completion-content {
    background: var(--surface);
    border-radius: 16px;
    width: 85%; max-width: 500px;
    min-height: 500px; max-height: 85vh;
    animation: slideUp 0.4s ease;
    box-shadow: 0 15px 40px rgba(0,0,0,0.5);
    border: 1px solid var(--border);
    position: relative;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.modal-close-btn {
    position: absolute;
    top: 10px; right: 10px;
    width: 28px; height: 28px;
    background: var(--surface-light);
    border: 1px solid var(--border);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-primary);
    font-size: 0.9rem;
    cursor: pointer;
    z-index: 100;
    transition: all 0.2s ease;
}
.modal-close-btn:hover { background: var(--primary); color: white; border-color: var(--primary); transform: rotate(90deg); }
.completion-content {
    padding: 25px 30px 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    flex: 1;
}
.completion-icon-section { text-align: center; }
.completion-icon {
    font-size: 2.8rem;
    color: var(--text-primary);
    margin-bottom: 12px;
    display: block;
    animation: bounce 1.5s infinite;
}
.completion-title { font-size: 1.6rem; color: var(--text-primary); font-weight: 700; }
.completion-subtitle { font-size: 0.95rem; color: var(--text-primary); margin: 0; }
.completion-subtitle strong { color: var(--text-primary); font-weight: 600; }
.completion-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    width: 100%;
}
.stat-item {
    background: var(--surface-light);
    border-radius: 10px;
    padding: 15px 10px;
    text-align: center;
    transition: all 0.2s ease;
}
.stat-item:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.08); }
.stat-icon {
    font-size: 1.4rem;
    color: var(--primary);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px; height: 40px;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.stat-value { font-size: 1.4rem; font-weight: 700; color: var(--text-primary); display: block; margin: 3px 0; line-height: 1; }
.stat-label { font-size: 0.75rem; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px; }
.completion-share { width: 100%; text-align: center; }
.share-title { font-size: 1.1rem; color: var(--text-primary); margin-bottom: 15px; font-weight: 600; }
.share-buttons { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
.share-btn {
    height: 45px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}
.share-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 12px rgba(0,0,0,0.15); }
.share-linkedin  { background: linear-gradient(135deg, #0077b5, #00a0dc); }
.share-facebook  { background: linear-gradient(135deg, #1877f2, #3b5998); }
.share-twitter   { background: linear-gradient(135deg, #1da1f2, #0c85d0); }
.share-instagram { background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d); }
.completion-action { width: 100%; text-align: center; }
.continue-btn {
    padding: 10px 25px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.2);
    width: 100%; max-width: 200px;
}
.continue-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(var(--primary-rgb), 0.3); }

/* ========== PRACTICAL LAUNCH BUTTON ========== */
.practical-launch-wrapper { text-align: center; margin: 35px 0 25px 0; }
.practical-launch-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 16px 36px;
    background: linear-gradient(135deg, #0f2027, #1a3a4a, #0f2027);
    border: 1px solid var(--accent, #00d4ff);
    border-radius: 10px;
    color: var(--accent, #00d4ff);
    font-size: 1.05rem;
    font-weight: 600;
    text-decoration: none;
    letter-spacing: 0.03em;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 0 18px rgba(0,212,255,0.2), inset 0 0 20px rgba(0,212,255,0.03);
}
.practical-launch-btn::before {
    content: '';
    position: absolute;
    top: -50%; left: -75%;
    width: 50%; height: 200%;
    background: linear-gradient(120deg, transparent, rgba(0,212,255,0.08), transparent);
    transform: skewX(-20deg);
    transition: left 0.5s ease;
}
.practical-launch-btn:hover {
    background: linear-gradient(135deg, #0f2027, #1f4a5e, #0f2027);
    box-shadow: 0 0 30px rgba(0,212,255,0.4), inset 0 0 25px rgba(0,212,255,0.06);
    transform: translateY(-2px);
    color: #33ddff;
}
.practical-launch-btn:hover::before { left: 125%; }
.launch-icon { font-size: 1.2rem; }
.launch-arrow { font-size: 1.1rem; transition: transform 0.3s ease; }
.practical-launch-btn:hover .launch-arrow { transform: translateX(4px); }
.launch-note { margin-top: 12px; font-size: 0.85rem; color: var(--text-secondary); font-style: italic; }

/* ========== TOOL ACCESS SECTION ========== */
.tool-access-section {
    background: rgba(0, 0, 0, 0.05);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 20px;
    margin: 25px 0;
    text-align: center;
}
.tool-access-section p {
    color: var(--text-secondary);
    margin-bottom: 15px;
    font-size: 0.95rem;
    line-height: 1.5;
}
.content-tools-btn {
    background: linear-gradient(135deg, #0056b3, #004085);
    color: white;
    border: 1px solid #ffffff1c;
    border-radius: 8px;
    padding: 10px 24px;
    font-size: 0.95rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    min-width: 180px;
    justify-content: center;
}
.content-tools-btn:hover {
    background: linear-gradient(135deg, #0056b3, #004085);
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 91, 187, 0.3);
    color: white;
    text-decoration: none;
}

/* ========== RESPONSIVE ========== */
@media (max-width: 992px) {
    .room-completion-content { width: 90%; max-width: 450px; }
}
@media (max-width: 768px) {
    .completion-content { padding: 20px 25px 25px; gap: 15px; }
    .completion-icon { font-size: 2.5rem; }
    .completion-title { font-size: 1.4rem; }
    .confirmation-content { padding: 25px 20px; width: 95%; }
    .confirmation-actions { flex-direction: column; gap: 10px; }
    .confirm-btn, .cancel-btn { width: 100%; min-width: auto; }
}
@media (max-width: 480px) {
    .room-completion-content { width: 95%; max-width: 400px; }
    .completion-stats { grid-template-columns: 1fr; gap: 8px; max-width: 200px; }
    .share-buttons { grid-template-columns: repeat(2, 1fr); max-width: 200px; margin: 0 auto; }
}
</style>

<div class="room-page">

    <!-- ========== CONFIRMATION MODAL ========== -->
    <div id="confirmationModal" class="confirmation-modal">
        <div class="confirmation-content">
            <i class="fas fa-exclamation-triangle confirmation-icon"></i>
            <h3 class="confirmation-title">Reset Progress</h3>
            <p class="confirmation-message">
                Are you sure you want to reset all progress?<br>
                This will clear all answers and completion status.
            </p>
            <div class="confirmation-actions">
                <button class="confirm-btn" onclick="confirmReset()"><i class="fas fa-redo"></i> Yes, Reset</button>
                <button class="cancel-btn" onclick="closeConfirmationModal()"><i class="fas fa-times"></i> Cancel</button>
            </div>
        </div>
    </div>

    <!-- Background -->
    <div class="room-gradient-bg"></div>

    <!-- ========== COMPLETION MODAL ========== -->
    <div id="roomCompletionModal" class="room-completion-modal">
        <div class="room-completion-content">
            <button class="modal-close-btn" onclick="closeCompletionModal()"><i class="fas fa-times"></i></button>
            <div class="completion-content">
                <div class="completion-icon-section">
                    <i class="fas fa-trophy completion-icon"></i>
                    <h2 class="completion-title">Congratulations!</h2>
                    <p class="completion-subtitle">You have completed <strong><?php echo htmlspecialchars($room_config['title']); ?></strong></p>
                </div>
                <div class="completion-stats">
                    <div class="stat-item">
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                        <span class="stat-value"><?php echo $total_tasks; ?></span>
                        <span class="stat-label">Tasks</span>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon"><i class="fas fa-signal"></i></div>
                        <span class="stat-value"><?php echo htmlspecialchars($room_config['difficulty']); ?></span>
                        <span class="stat-label">Level</span>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon"><i class="fas fa-clock"></i></div>
                        <span class="stat-value"><?php echo htmlspecialchars($room_config['estimated_time']); ?></span>
                        <span class="stat-label">Time</span>
                    </div>
                </div>
                <div class="completion-share">
                    <h3 class="share-title">Share Achievement</h3>
                    <div class="share-buttons">
                        <button class="share-btn share-linkedin"  onclick="shareAchievement('linkedin')"><i class="fab fa-linkedin-in"></i></button>
                        <button class="share-btn share-facebook"  onclick="shareAchievement('facebook')"><i class="fab fa-facebook-f"></i></button>
                        <button class="share-btn share-twitter"   onclick="shareAchievement('twitter')"><i class="fab fa-twitter"></i></button>
                        <button class="share-btn share-instagram" onclick="shareAchievement('instagram')"><i class="fab fa-instagram"></i></button>
                    </div>
                </div>
                <div class="completion-action">
                    <button class="continue-btn" onclick="closeCompletionModal()">Continue Learning</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== HERO SECTION ========== -->
    <div class="room-hero-section">
        <img src="<?php echo htmlspecialchars($room_config['banner']); ?>" alt="<?php echo htmlspecialchars($room_config['title']); ?>" class="room-banner">
        <div class="room-banner-overlay"></div>
        <div class="room-hero-content">
            <div class="room-icon"><i class="<?php echo htmlspecialchars($room_config['icon']); ?>"></i></div>
            <div class="room-title-wrapper">
                <h1 class="room-title"><?php echo htmlspecialchars($room_config['title']); ?></h1>
                <p class="room-description"><?php echo htmlspecialchars($room_config['description']); ?></p>
                <div class="room-meta">
                    <div class="room-meta-item"><i class="fas fa-signal"></i><span>Level: <?php echo htmlspecialchars($room_config['difficulty']); ?></span></div>
                    <div class="room-meta-item"><i class="fas fa-clock"></i><span>Time: <?php echo htmlspecialchars($room_config['estimated_time']); ?></span></div>
                    <div class="room-meta-item"><i class="fas fa-tasks"></i><span><?php echo $total_tasks; ?> Tasks</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== MAIN CONTENT ========== -->
    <div class="room-container">
        <div class="room-content-layout">

            <!-- SIDEBAR -->
            <div class="room-sidebar">
                <div class="sidebar-header">
                    <h3><i class="fas fa-tasks"></i> Tasks</h3>
                    <button class="reset-progress-btn" onclick="showConfirmationModal()">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
                <div class="room-progress-section">
                    <div class="room-progress-bar">
                        <div class="room-progress-fill" id="roomProgressFill"></div>
                    </div>
                    <div class="room-progress-text" id="roomProgressText">0% Complete</div>
                </div>
                <ul class="tasks-list" id="tasksList">
                    <?php foreach ($room_tasks as $index => $task):
                        $taskNum     = $index + 1;
                        $activeClass = ($taskNum === 1) ? 'active' : '';
                    ?>
                    <li class="task-nav-item <?php echo $activeClass; ?>"
                        data-task="<?php echo $task['id']; ?>"
                        onclick="switchTask('<?php echo $task['id']; ?>')">
                        <div class="task-number"><?php echo $taskNum; ?></div>
                        <div class="task-nav-content">
                            <div class="task-nav-title"><?php echo htmlspecialchars($task['nav_title'] ?? $task['title']); ?></div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- CONTENT AREA -->
            <div class="task-content-area" id="taskContentArea">
                <?php foreach ($room_tasks as $index => $task):
                    $taskNum      = $index + 1;
                    $taskId       = $task['id'];
                    $isFirst      = ($taskNum === 1);
                    $isLast       = ($taskNum === $total_tasks);
                    $displayStyle = $isFirst ? 'block' : 'none';
                ?>
                <div id="<?php echo $taskId; ?>Content" class="task-content" style="display: <?php echo $displayStyle; ?>;">
                    <div class="task-header">
                        <h1 class="task-title">
                            <i class="fas fa-book"></i>
                            Task <?php echo $taskNum; ?>: <?php echo htmlspecialchars($task['title']); ?>
                        </h1>
                    </div>
                    <div class="task-body">
                        <?php echo $task_contents[$taskNum] ?? ''; ?>
                        <?php echo renderQuestionsSection($taskId, $task_questions_data, $answers); ?>
                    </div>
                    <div class="task-navigation">
                        <button class="nav-btn nav-btn-outline" onclick="previousTask()"<?php echo $isFirst ? ' disabled' : ''; ?>>
                            <i class="fas fa-arrow-left"></i> Previous
                        </button>
                        <div class="task-progress">
                            <strong><?php echo $taskNum; ?></strong> of <strong><?php echo $total_tasks; ?></strong> Tasks
                        </div>
                        <button class="nav-btn" onclick="nextTask()"<?php echo $isLast ? ' disabled' : ''; ?>>
                            Next Task <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>

<script>
// ========================
// ROOM CONFIGURATION (PHP-INJECTED)
// ========================
const STORAGE_KEY    = <?php echo json_encode($js_config['storage_key']); ?>;
const ROOM_TITLE     = <?php echo json_encode($room_config['title']); ?>;
const INSTAGRAM_CAP  = <?php echo $js_instagram_caption; ?>;
let   totalTasks     = <?php echo $total_tasks; ?>;
const taskQuestions  = <?php echo json_encode($js_task_questions); ?>;

// ========================
// ROOM STATE
// ========================
let currentTask      = 'task1';
let completedTasks   = [];
let answeredQuestions = {};

// ========================
// CONFIRMATION MODAL
// ========================
function showConfirmationModal() {
    document.getElementById('confirmationModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeConfirmationModal() {
    document.getElementById('confirmationModal').style.display = 'none';
    document.body.style.overflow = '';
}
function confirmReset() {
    closeConfirmationModal();
    localStorage.removeItem(STORAGE_KEY);
    completedTasks    = [];
    answeredQuestions = {};
    currentTask       = 'task1';

    document.querySelectorAll('.answer-input').forEach(input => {
        input.value = '';
        input.disabled = false;
        input.classList.remove('correct');
        input.placeholder = input.getAttribute('data-original-placeholder') || 'Enter your answer...';
    });
    document.querySelectorAll('.feedback-message').forEach(div => {
        div.style.display = 'none';
        div.innerHTML = '';
    });
    document.querySelectorAll('.task-nav-item').forEach(item => item.classList.remove('completed'));

    closeCompletionModal();
    switchTask('task1');
    updateProgressBar();
    saveProgressToDatabase();
}

// ========================
// TASK NAVIGATION
// ========================
function initRoomPage() {
    document.querySelectorAll('.answer-input').forEach(input => {
        input.setAttribute('data-original-placeholder', input.placeholder);
    });

    const style = document.createElement('style');
    style.textContent = `
        .answer-input::placeholder       { opacity: 0.85 !important; color: var(--text-secondary) !important; }
        .answer-input:focus::placeholder { opacity: 0.6 !important; }
        .answer-input.correct::placeholder { opacity: 0 !important; }
    `;
    document.head.appendChild(style);

    loadProgress();
    switchTask('task1');
    updateTaskNavigation();
    updateProgressBar();

    if (completedTasks.length === totalTasks) {
        setTimeout(() => showRoomCompletion(), 1000);
    }
}

function switchTask(taskId) {
    document.querySelectorAll('.task-content').forEach(c => c.style.display = 'none');
    const content = document.getElementById(taskId + 'Content');
    if (content) content.style.display = 'block';

    document.querySelectorAll('.task-nav-item').forEach(item => {
        item.classList.remove('active');
        if (item.getAttribute('data-task') === taskId) item.classList.add('active');
    });

    currentTask = taskId;
    updateTaskNavigation();
    window.scrollTo({ top: 0, behavior: 'instant' });
}

function nextTask() {
    const n = parseInt(currentTask.replace('task', ''));
    if (n < totalTasks) switchTask('task' + (n + 1));
}
function previousTask() {
    const n = parseInt(currentTask.replace('task', ''));
    if (n > 1) switchTask('task' + (n - 1));
}
function updateTaskNavigation() {
    const n = parseInt(currentTask.replace('task', ''));
    document.querySelectorAll('.task-progress strong:first-child').forEach(s => s.textContent = n);
    document.querySelectorAll('.task-progress strong:nth-child(2)').forEach(s => s.textContent = totalTasks);
}

// ========================
// ANSWER SUBMISSION
// ========================
function submitAnswer(questionId, taskId) {
    const answerInput = document.getElementById('answer-' + questionId);
    const feedbackDiv = document.getElementById('feedback-' + questionId);
    const submitBtn   = answerInput.closest('.answer-form').querySelector('.submit-btn');
    const resetBtn    = answerInput.closest('.answer-form').querySelector('.reset-btn');

    if (!answerInput || answerInput.value.trim() === '') {
        showFeedback(feedbackDiv, 'Please enter an answer.', 'error');
        return;
    }

    const userAnswer = answerInput.value.trim();
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    submitBtn.disabled = true;
    resetBtn.disabled  = true;

    fetch(window.location.href, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ action: 'check_answer', question_id: questionId, answer: userAnswer })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            if (data.is_correct) {
                answeredQuestions[questionId] = userAnswer;
                answerInput.classList.add('correct');
                answerInput.disabled = true;
                showFeedback(feedbackDiv, '<i class="fas fa-check-circle"></i> Correct! Well done.', 'success');
                checkTaskCompletion(taskId);
                saveProgress();
                if (completedTasks.length === totalTasks) {
                    setTimeout(() => { showRoomCompletion(); saveProgressToDatabase(); }, 1500);
                }
            } else {
                showFeedback(feedbackDiv, '<i class="fas fa-times-circle"></i> Incorrect. Try again.', 'error');
            }
        } else {
            showFeedback(feedbackDiv, '<i class="fas fa-exclamation-triangle"></i> Error checking answer.', 'error');
        }
    })
    .catch(() => showFeedback(feedbackDiv, '<i class="fas fa-exclamation-triangle"></i> Network error. Please try again.', 'error'))
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled  = false;
        resetBtn.disabled   = false;
    });
}

function checkTaskCompletion(taskId) {
    const qIds = taskQuestions[taskId] || [];
    if (qIds.every(qId => answeredQuestions[qId]) && !completedTasks.includes(taskId)) {
        completedTasks.push(taskId);
        const navItem = document.querySelector(`[data-task="${taskId}"]`);
        if (navItem) navItem.classList.add('completed');
        updateProgressBar();
        saveProgress();
    }
}

function showFeedback(div, message, type) {
    div.innerHTML   = message;
    div.className   = `feedback-message feedback-${type}`;
    div.style.display = 'flex';
    if (type === 'error') setTimeout(() => div.style.display = 'none', 5000);
}

function resetAnswer(questionId) {
    const input = document.getElementById('answer-' + questionId);
    const div   = document.getElementById('feedback-' + questionId);
    if (input) {
        input.value = '';
        input.disabled = false;
        input.classList.remove('correct');
        input.placeholder = input.getAttribute('data-original-placeholder') || 'Enter your answer...';
    }
    if (div) { div.style.display = 'none'; div.innerHTML = ''; }
    delete answeredQuestions[questionId];

    const navItem = document.querySelector(`[data-task="${currentTask}"]`);
    if (navItem && completedTasks.includes(currentTask)) {
        completedTasks = completedTasks.filter(id => id !== currentTask);
        navItem.classList.remove('completed');
    }
    updateProgressBar();
    saveProgress();
}

// ========================
// PROGRESS
// ========================
function updateProgressBar() {
    const pct = (completedTasks.length / totalTasks) * 100;
    const fill = document.getElementById('roomProgressFill');
    const text = document.getElementById('roomProgressText');
    if (fill) fill.style.width = pct + '%';
    if (text) text.textContent = Math.round(pct) + '% Complete';
}

function saveProgress() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify({
        completedTasks, answeredQuestions, lastAccessed: new Date().toISOString()
    }));
}

function loadProgress() {
    const saved = localStorage.getItem(STORAGE_KEY);
    if (!saved) return;
    const p = JSON.parse(saved);
    completedTasks    = p.completedTasks    || [];
    answeredQuestions = p.answeredQuestions || {};

    completedTasks.forEach(taskId => {
        const navItem = document.querySelector(`[data-task="${taskId}"]`);
        if (navItem) navItem.classList.add('completed');
    });
    Object.keys(answeredQuestions).forEach(qId => {
        const input = document.getElementById('answer-' + qId);
        if (input) { input.value = answeredQuestions[qId]; input.classList.add('correct'); input.disabled = true; }
    });
    updateProgressBar();
}

// ========================
// ROOM COMPLETION
// ========================
function showRoomCompletion() {
    document.getElementById('roomCompletionModal').style.display = 'flex';
    createConfetti();
    document.body.style.overflow = 'hidden';
    saveProgressToDatabase();
}
function closeCompletionModal() {
    document.body.style.overflow = '';
    document.getElementById('roomCompletionModal').style.display = 'none';
    document.querySelectorAll('.confetti').forEach(c => c.remove());
}
function createConfetti() {
    const colors = ['#28a745','#20c997','#ffc107','#dc3545','#007bff','#6f42c1'];
    for (let i = 0; i < 100; i++) {
        const el = document.createElement('div');
        el.className = 'confetti';
        el.style.left = Math.random() * 100 + 'vw';
        el.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        el.style.transform = `rotate(${Math.random() * 360}deg)`;
        document.body.appendChild(el);
        const anim = el.animate(
            [{ top: '0px', opacity: 1, transform: `rotate(0deg) scale(1)` },
             { top: '100vh', opacity: 0, transform: `rotate(${Math.random()*360}deg) scale(0)` }],
            { duration: Math.random() * 3000 + 2000, easing: 'cubic-bezier(0.215,0.610,0.355,1)' }
        );
        anim.onfinish = () => el.remove();
    }
}

// ========================
// SOCIAL SHARING
// ========================
function shareAchievement(platform) {
    const baseURL = window.location.origin + window.location.pathname;
    switch (platform) {
        case 'linkedin':
            window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(baseURL)}`, '_blank', 'width=700,height=600,noopener,noreferrer');
            break;
        case 'facebook':
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(baseURL)}`, '_blank', 'width=700,height=600,noopener,noreferrer');
            break;
        case 'twitter':
            const twitterText = encodeURIComponent(`Completed "${ROOM_TITLE}" on CYBRIXEN! Check it out: ${baseURL} #cybersecurity #CYBRIXEN`);
            window.open(`https://twitter.com/intent/tweet?text=${twitterText}`, '_blank', 'width=700,height=400,noopener,noreferrer');
            break;
        case 'instagram':
            navigator.clipboard.writeText(INSTAGRAM_CAP)
                .then(() => showInstagramInstructions())
                .catch(() => {
                    const ta = document.createElement('textarea');
                    ta.value = INSTAGRAM_CAP;
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                    alert('Caption copied to clipboard!');
                });
            break;
    }
}
function showInstagramInstructions() {
    const modal = document.createElement('div');
    modal.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.95);display:flex;align-items:center;justify-content:center;z-index:10001;padding:20px;';
    const box = document.createElement('div');
    box.style.cssText = 'background:var(--surface);padding:30px;border-radius:16px;max-width:500px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.5);';
    box.innerHTML = `
        <i class="fas fa-check-circle" style="font-size:2.5rem;color:#28a745;margin-bottom:15px;display:block;"></i>
        <h3 style="color:var(--text-primary);margin-bottom:10px;font-size:1.3rem;">Caption Copied!</h3>
        <p style="color:var(--text-secondary);font-size:0.95rem;margin-bottom:20px;">Open Instagram and paste the caption into your post.</p>
        <button onclick="this.closest('div[style*=\\"position:fixed\\"]').remove()"
                style="padding:10px 24px;background:var(--surface-light);color:var(--text-primary);border:1px solid var(--border);border-radius:8px;cursor:pointer;font-weight:600;">
            Close
        </button>`;
    modal.appendChild(box);
    document.body.appendChild(modal);
    modal.addEventListener('click', e => { if (e.target === modal) modal.remove(); });
}

// ========================
// DATABASE PROGRESS SAVING
// ========================
function saveProgressToDatabase() {
    const pct = Math.round((completedTasks.length / totalTasks) * 100);
    const formData = new FormData();
    formData.append('room_path',           window.location.pathname);
    formData.append('room_name',           ROOM_TITLE);
    formData.append('progress_percentage', pct);
    formData.append('tasks_completed',     completedTasks.length);
    formData.append('total_tasks',         totalTasks);
    formData.append('is_completed',        completedTasks.length === totalTasks ? '1' : '0');
    formData.append('time_spent',          '0');
    formData.append('answers_data',        JSON.stringify(answeredQuestions));

    fetch('/save-progress.php', { method: 'POST', body: formData, credentials: 'same-origin' })
        .then(r => r.ok ? r.json() : Promise.reject(r))
        .then(data => { if (data.success) showNotification('Progress saved!', 'success'); })
        .catch(() => {});
}

function showNotification(message, type = 'info') {
    if (!document.querySelector('#notification-styles')) {
        const s = document.createElement('style');
        s.id = 'notification-styles';
        s.textContent = `
            @keyframes slideIn { from { transform:translateX(100%); opacity:0; } to { transform:translateX(0); opacity:1; } }
            @keyframes slideOut { from { transform:translateX(0); opacity:1; } to { transform:translateX(100%); opacity:0; } }
        `;
        document.head.appendChild(s);
    }
    const n = document.createElement('div');
    const bg = type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#007bff';
    const icon = type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ';
    n.style.cssText = `position:fixed;top:20px;right:20px;padding:15px 25px;background:${bg};color:white;border-radius:5px;box-shadow:0 5px 15px rgba(0,0,0,0.2);z-index:10000;font-weight:500;display:flex;align-items:center;gap:10px;animation:slideIn 0.3s ease;`;
    n.innerHTML = `<span style="font-weight:bold;">${icon}</span> ${message}`;
    document.body.appendChild(n);
    setTimeout(() => {
        n.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => n.parentNode && n.parentNode.removeChild(n), 300);
    }, 5000);
}

// ========================
// ENTER KEY + INIT
// ========================
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.answer-input').forEach(input => {
        input.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                submitAnswer(this.id.replace('answer-', ''), currentTask);
            }
        });
    });
    initRoomPage();
});
</script>

<?php include __DIR__ . '/../chatbot.php'; ?>
<?php include __DIR__ . '/footer.php'; ?>
