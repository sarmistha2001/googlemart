<?php
require_once __DIR__ . '/config.php';
require_login();

// Dashboard stats
$counts = [];
$tables = ['categories' => ['Categories', 'folder', '#f5f0ff', '#700895'], 'products' => ['Products', 'box', '#e8f3ff', '#1d6fd6'], 'product_images' => ['Gallery Images', 'images', '#fff4e5', '#e8870c'], 'settings' => ['Settings', 'gear', '#e9f9f1', '#1d9c5c'], 'users' => ['Users', 'person', '#fdeef2', '#d6336c']];
foreach ($tables as $tbl => $v) {
    $counts[$tbl] = (int)db()->query("SELECT COUNT(*) FROM `$tbl`")->fetchColumn();
}
$featured = (int)db()->query("SELECT COUNT(*) FROM products WHERE is_featured=1")->fetchColumn();
$new = (int)db()->query("SELECT COUNT(*) FROM products WHERE is_new=1")->fetchColumn();
$uploads = count(glob(UPLOAD_DIR . '*') ?: []);

$page_title = 'Dashboard';
require __DIR__ . '/header.php';
?>
<div class="row g-3">
  <?php
  $links = ['categories' => 'categories.php', 'products' => 'products.php', 'product_images' => 'products.php', 'settings' => 'settings.php', 'users' => 'users.php'];
  foreach ($tables as $tbl => $c): ?>
    <div class="col-6 col-md-4 col-xl">
      <a href="<?= $links[$tbl] ?>" class="text-decoration-none">
        <div class="card stat-card h-100">
          <div class="card-body d-flex align-items-center gap-3">
            <span class="icon" style="background:<?= $c[2] ?>;color:<?= $c[3] ?>"><i class="bi bi-<?= $c[1] ?>"></i></span>
            <div>
              <div class="fs-3 fw-bold lh-1" style="color:#1e1b4b"><?= $counts[$tbl] ?></div>
              <div class="text-secondary small"><?= $c[0] ?></div>
            </div>
          </div>
        </div>
      </a>
    </div>
  <?php endforeach; ?>
</div>

<div class="row g-3 mt-1">
  <div class="col-lg-4">
    <div class="card h-100"><div class="card-body">
      <div class="card-title d-flex align-items-center gap-2 mb-3"><i class="bi bi-stars text-warning"></i>Product Highlights</div>
      <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-secondary small">Featured (Best Sellers)</span><span class="badge bg-warning-subtle text-warning-emphasis"><?= $featured ?></span></div>
      <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-secondary small">New Arrivals</span><span class="badge bg-info-subtle text-info-emphasis"><?= $new ?></span></div>
      <div class="d-flex justify-content-between py-2"><span class="text-secondary small">Total products</span><span class="badge bg-light text-dark border"><?= $counts['products'] ?></span></div>
    </div></div>
  </div>
  <div class="col-lg-4">
    <div class="card h-100"><div class="card-body">
      <div class="card-title d-flex align-items-center gap-2 mb-3"><i class="bi bi-folder2-open text-primary"></i>Storage</div>
      <div class="d-flex justify-content-between py-2 border-bottom"><span class="text-secondary small">Files in uploads/</span><span class="badge bg-light text-dark border"><?= $uploads ?></span></div>
      <div class="d-flex justify-content-between py-2"><span class="text-secondary small">Gallery rows</span><span class="badge bg-light text-dark border"><?= $counts['product_images'] ?></span></div>
    </div></div>
  </div>
  <div class="col-lg-4">
    <div class="card h-100" style="background:linear-gradient(135deg,#700895,#a855f7);color:#fff"><div class="card-body">
      <div class="d-flex align-items-center gap-2 mb-3 fw-semibold"><i class="bi bi-lightning-charge-fill"></i>Quick actions</div>
      <div class="d-flex flex-column gap-2">
        <a href="categories.php?action=add" class="btn btn-sm btn-light"><i class="bi bi-plus-lg me-1"></i>Add category</a>
        <a href="products.php?action=add" class="btn btn-sm btn-light"><i class="bi bi-plus-lg me-1"></i>Add product</a>
        <a href="settings.php" class="btn btn-sm btn-outline-light"><i class="bi bi-gear me-1"></i>Site settings</a>
      </div>
    </div></div>
  </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
