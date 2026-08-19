<?php
/**
 * Google Mart Admin — core config
 * DB connection (PDO), session, auth guard, upload/delete helpers
 */
session_start();

define('DB_HOST', 'localhost');
define('DB_NAME', 'gm_db');
define('DB_USER', 'root');
define('DB_PASS', '');

define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('UPLOAD_URL', 'uploads/');

// Max upload size: 5MB, allowed image types
define('MAX_SIZE', 5 * 1024 * 1024);
$ALLOWED_EXT = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];

/** @return PDO */
function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

/** Require admin login (redirect to login.php) */
function require_login(): void
{
    if (empty($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}

/** Escape output */
function e($s): string
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

/** Flash message helper */
function flash(string $type, string $msg): void
{
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

function get_flash(): ?array
{
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

/**
 * Handle a single image upload.
 * Returns: array ['ok'=>bool, 'path'=>relative path (e.g. uploads/abc.jpg), 'error'=>string]
 * On success the file is stored in UPLOAD_DIR.
 */
function handle_upload(array $file, ?string $oldPath = null): array
{
    global $ALLOWED_EXT;

    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['ok' => false, 'path' => null, 'error' => 'no_file'];
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'path' => null, 'error' => 'Upload failed (error ' . $file['error'] . ')'];
    }
    if ($file['size'] > MAX_SIZE) {
        return ['ok' => false, 'path' => null, 'error' => 'File too large (max 5MB)'];
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $ALLOWED_EXT)) {
        return ['ok' => false, 'path' => null, 'error' => 'Only jpg, jpeg, png, webp, gif, svg allowed'];
    }

    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0775, true);
    }

    $name = date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $dest = UPLOAD_DIR . $name;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return ['ok' => false, 'path' => null, 'error' => 'Could not save file'];
    }

    // Remove old image if a replacement was uploaded
    if ($oldPath) {
        delete_upload($oldPath);
    }

    return ['ok' => true, 'path' => UPLOAD_URL . $name, 'error' => null];
}

/** Delete a stored upload (path like uploads/xxx.jpg). Safe no-op if empty/not ours. */
function delete_upload(?string $path): void
{
    if (!$path || strpos($path, 'uploads/') !== 0) {
        return; // only delete files under our uploads dir
    }
    $file = UPLOAD_DIR . basename($path);
    if (is_file($file)) {
        unlink($file);
    }
}

/**
 * Display URL for a stored image, correct from inside /admin/.
 * Local uploads (uploads/...) get ../ prefix; external URLs pass through.
 */
function img_url(?string $path): string
{
    if (!$path) {
        return '';
    }
    if (strpos($path, 'uploads/') === 0) {
        return '../' . $path;
    }
    return $path;
}

/** Redirect helper */
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/** Pagination helper — returns [rows, total, page, pages] for a list query */
function paginate(PDO $pdo, string $baseSql, int $perPage = 12): array
{
    $page = max(1, (int)($_GET['page'] ?? 1));
    $total = (int)$pdo->query('SELECT COUNT(*) FROM (' . $baseSql . ') t')->fetchColumn();
    $pages = max(1, (int)ceil($total / $perPage));
    $page = min($page, $pages);
    $offset = ($page - 1) * $perPage;
    return ['page' => $page, 'pages' => $pages, 'total' => $total, 'offset' => $offset, 'limit' => $perPage];
}

function render_pagination(int $page, int $pages, string $baseUrl): void
{
    if ($pages <= 1) return;
    echo '<nav class="mt-3"><ul class="pagination pagination-sm mb-0">';
    $qs = $_GET;
    $mk = function (int $p) use ($qs, $baseUrl) {
        $qs['page'] = $p;
        return $baseUrl . '?' . http_build_query($qs);
    };
    echo '<li class="page-item ' . ($page <= 1 ? 'disabled' : '') . '"><a class="page-link" href="' . e($mk(max(1, $page - 1))) . '">‹</a></li>';
    for ($p = 1; $p <= $pages; $p++) {
        if ($pages > 9 && $p > 2 && $p < $pages - 1 && abs($p - $page) > 2) {
            if ($p === 3 || $p === $pages - 2) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
            continue;
        }
        echo '<li class="page-item ' . ($p === $page ? 'active' : '') . '"><a class="page-link" href="' . e($mk($p)) . '">' . $p . '</a></li>';
    }
    echo '<li class="page-item ' . ($page >= $pages ? 'disabled' : '') . '"><a class="page-link" href="' . e($mk(min($pages, $page + 1))) . '">›</a></li>';
    echo '</ul></nav>';
}
