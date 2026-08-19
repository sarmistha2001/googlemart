<?php
/** Google Mart shared DB helpers — include at top of every .php page */
function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO('mysql:host=localhost;dbname=gm_db;charset=utf8mb4', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

function e(?string $s): string
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function get_settings(): array
{
    $out = [];
    foreach (db()->query('SELECT setting_key, setting_value FROM settings')->fetchAll() as $r) {
        $out[$r['setting_key']] = $r['setting_value'];
    }
    return $out;
}

function get_categories(): array
{
    return db()->query('SELECT id, name, slug, icon, image, description FROM categories WHERE is_active=1 ORDER BY sort_order, id')->fetchAll();
}

function get_products(string $flag, int $val = 1): array
{
    $st = db()->prepare("SELECT p.*, c.icon AS icon, c.name AS cat_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.$flag = ? AND p.is_active=1 ORDER BY p.id DESC LIMIT 18");
    $st->execute([$val]);
    return $st->fetchAll();
}

function get_products_by_cats(array $ids): array
{
    if (!$ids) return [];
    $in = implode(',', array_map('intval', $ids));
    return db()->query("SELECT p.*, c.icon AS icon, c.name AS cat_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.category_id IN ($in) AND p.is_active=1 ORDER BY p.id DESC LIMIT 18")->fetchAll();
}

function get_products_by_category(int $catId): array
{
    $st = db()->prepare('SELECT p.*, c.icon AS icon, c.name AS cat_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.category_id = ? AND p.is_active=1 ORDER BY p.id DESC');
    $st->execute([$catId]);
    return $st->fetchAll();
}

function get_product_by_slug(string $slug): ?array
{
    $st = db()->prepare('SELECT p.*, c.name AS cat_name, c.slug AS cat_slug FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.slug = ? AND p.is_active=1 LIMIT 1');
    $st->execute([$slug]);
    $r = $st->fetch();
    return $r ?: null;
}

function get_product_images(int $productId): array
{
    $st = db()->prepare('SELECT image_url FROM product_images WHERE product_id = ? ORDER BY sort_order, id');
    $st->execute([$productId]);
    return $st->fetchAll(PDO::FETCH_COLUMN);
}

function get_related_products(string $idsCsv): array
{
    $ids = array_filter(array_map('intval', explode(',', $idsCsv)));
    if (!$ids) return [];
    $in = implode(',', $ids);
    return db()->query("SELECT p.*, c.icon AS icon FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.id IN ($in) AND p.is_active=1")->fetchAll();
}

/** Render a product card (swiper slide) */
function product_card(array $p, string $link = 'product.php?slug='): string
{
    $img = $p['main_image'] ? htmlspecialchars($p['main_image']) : '';
    $name = htmlspecialchars($p['name']);
    $href = $link . urlencode($p['slug']);

    return '<div class="swiper-slide"><a href="' . $href . '" class="card h-100 shadow-soft text-decoration-none p-2">'
        . '<img src="' . $img . '" class="rounded-4 object-cover w-100" style="aspect-ratio:1/1" alt="' . $name . '" loading="lazy" onerror="this.style.display=\'none\'">'
        . '<div class="card-body p-2">'
        . '<div class="small fw-semibold text-dark">' . $name . '</div>'
        . '</div></a></div>';
}