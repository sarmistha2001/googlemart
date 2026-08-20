<?php
require_once __DIR__ . "/includes/db.php";
$S = get_settings();
$announce = $S["announcement_text"] ?? "";

$q = trim($_GET['q'] ?? '');

$products = [];
$categories = [];

if ($q !== '') {
    $like = '%' . $q . '%';

    $stmt = db()->prepare(
        "SELECT p.*, c.name AS cat_name, c.slug AS cat_slug
         FROM products p
         LEFT JOIN categories c ON c.id = p.category_id
         WHERE p.is_active = 1 AND (p.name LIKE ? OR p.description LIKE ?)
         ORDER BY p.name
         LIMIT 40"
    );
    $stmt->execute([$like, $like]);
    $products = $stmt->fetchAll();

    $stmt2 = db()->prepare(
        "SELECT * FROM categories WHERE is_active = 1 AND name LIKE ? ORDER BY sort_order LIMIT 10"
    );
    $stmt2->execute([$like]);
    $categories = $stmt2->fetchAll();
}
?>
<?php include __DIR__ . "/includes/header.php"; ?>
<nav class="container-1280 mt-3 small text-secondary d-flex gap-1 align-items-center flex-wrap"><a href="index.php" class="text-secondary text-decoration-none">Home</a><i class="bi bi-chevron-right" style="font-size:8px"></i><span class="fw-semibold text-dark">Search</span></nav>

<div class="container-1280 mt-3">
  <div class="text-center py-4">
    <h1 class="display fw-bold" style="font-size:26px">
      <?= $q !== '' ? 'Results for "' . e($q) . '"' : 'Search products &amp; categories' ?>
    </h1>
    <?php if ($q !== ''): ?>
      <p class="text-secondary small mb-0"><?= count($products) ?> product<?= count($products) === 1 ? '' : 's' ?> found<?= $categories ? ', ' . count($categories) . ' matching categor' . (count($categories) === 1 ? 'y' : 'ies') : '' ?></p>
    <?php endif; ?>
  </div>

  <?php if ($q === ''): ?>
    <div class="text-center text-secondary py-5">Type something in the search box above to find products or categories.</div>
  <?php elseif (!$products && !$categories): ?>
    <div class="text-center text-secondary py-5">
      No results for "<?= e($q) ?>". Try a different keyword, or <a href="categories.php">browse all categories</a>.
    </div>
  <?php else: ?>

    <?php if ($categories): ?>
    <div class="mb-4">
      <h2 class="fw-bold mb-3" style="font-size:16px">Matching Categories</h2>
      <div class="row g-3 row-cols-2 row-cols-lg-5">
        <?php foreach ($categories as $c): ?>
        <div class="col">
          <a href="category.php?slug=<?= urlencode($c['slug']) ?>" class="card h-100 shadow-soft text-decoration-none p-2">
            <img src="<?= e($c['image']) ?>" class="rounded-4 object-cover w-100" style="aspect-ratio:1/1" alt="<?= e($c['name']) ?>" loading="lazy" onerror="this.style.display='none'">
            <div class="card-body p-2">
              <div class="small fw-semibold text-dark d-flex align-items-center gap-1"><i data-lucide="<?= e($c['icon'] ?: 'layout-grid') ?>" style="width:14px;height:14px"></i> <?= e($c['name']) ?></div>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <?php if ($products): ?>
    <div>
      <h2 class="fw-bold mb-3" style="font-size:16px">Products</h2>
      <div class="row g-3 row-cols-2 row-cols-lg-4">
        <?php foreach ($products as $p): ?>
        <div class="col">
          <a href="product.php?slug=<?= urlencode($p['slug']) ?>" class="card h-100 shadow-soft text-decoration-none p-2">
            <img src="<?= e($p['main_image']) ?>" class="rounded-4 object-cover w-100" style="aspect-ratio:1/1" alt="<?= e($p['name']) ?>" loading="lazy" onerror="this.style.display='none'">
            <div class="card-body p-2">
              <div class="small fw-semibold text-dark"><?= e($p['name']) ?></div>
              <div class="small text-secondary" style="font-size:11px"><?= e($p['cat_name'] ?? '') ?></div>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  <?php endif; ?>
</div>

<?php include __DIR__ . "/includes/footer.php"; ?>