<?php
// PREVIEW STUB ONLY. Stands in for the platform's includes/auth.php so rooms render locally.
// Send the cookie preview_logged_out=1 to simulate a visitor who is not logged in.
if (!class_exists('PreviewAuth')) {
    class PreviewAuth {
        public function isLoggedIn() { return empty($_COOKIE['preview_logged_out']); }
        public function redirectToLogin() { header('Location: /login.php'); http_response_code(302); exit; }
        public function getCurrentUser() { return ['id' => 1, 'username' => 'preview', 'role' => 'subscriber']; }
    }
}
$auth = $auth ?? new PreviewAuth();
if (!isset($pdo)) {
    $pdo = new PDO('sqlite::memory:');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
