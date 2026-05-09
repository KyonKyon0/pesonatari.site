<?php
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(['httponly'=>true,'secure'=>isset($_SERVER['HTTPS']),'samesite'=>'Lax']);
    session_start();
}
function e(string $text): string { return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); }
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_check(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf'] ?? '';
        if (!hash_equals($_SESSION['csrf'] ?? '', $token)) {
            http_response_code(419); exit('CSRF token tidak valid');
        }
    }
}
function redirect(string $url): void { header('Location: ' . $url); exit; }
function paginate(int $page, int $perPage): array { $page=max(1,$page); return [($page-1)*$perPage,$perPage]; }
function upload_image(string $field, string $dir): ?string {
    if (empty($_FILES[$field]['name'])) return null;
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ALLOWED_IMAGE_EXT, true)) return null;
    if ($_FILES[$field]['size'] > (UPLOAD_MAX_MB*1024*1024)) return null;
    $name = bin2hex(random_bytes(8)) . '.webp';
    $target = __DIR__ . '/../../public/uploads/' . $dir . '/' . $name;
    $tmp = $_FILES[$field]['tmp_name'];
    $imgData = file_get_contents($tmp);
    $img = @imagecreatefromstring($imgData);
    if (!$img) return null;
    imagepalettetotruecolor($img);
    imagewebp($img, $target, 75);
    imagedestroy($img);
    return 'uploads/' . $dir . '/' . $name;
}
