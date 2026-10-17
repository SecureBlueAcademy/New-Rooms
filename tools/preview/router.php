<?php
// Router for `php -S`: serves a placeholder for missing banner images, everything else as normal.
$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = $_SERVER['DOCUMENT_ROOT'] . $path;
if (preg_match('#\.(png|jpe?g|webp)$#i', $path) && !is_file($file)) {
    header('Content-Type: image/svg+xml');
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="320"><defs><linearGradient id="g" x1="0" x2="1"><stop offset="0" stop-color="#0047CC"/><stop offset="1" stop-color="#00D4FF"/></linearGradient></defs><rect width="1200" height="320" fill="url(#g)"/></svg>';
    return true;
}
if ($path === '/assets/cyber-background.js') { header('Content-Type: application/javascript'); return true; }
return false;
