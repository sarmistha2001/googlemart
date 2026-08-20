<?php
require_once __DIR__ . "/includes/db.php";
$S = get_settings();
$announce = $S["announcement_text"] ?? "";

$cats = get_categories();

$catCounts = [];
foreach (db()->query("SELECT category_id, COUNT(*) n FROM products WHERE is_active=1 GROUP BY category_id")->fetchAll() as $cc) {
    $catCounts[$cc["category_id"]] = (int)$cc["n"];
}
?>
<?php include __DIR__ . "/includes/header.php"; ?>
<nav class="container-1280 mt-3 small text-secondary d-flex gap-1 align-items-center flex-wrap"><a href="../index.php" class="text-secondary text-decoration-none">Home</a><i class="bi bi-chevron-right" style="font-size:8px"></i><span class="fw-semibold text-dark">Categories</span></nav>
<div class="container-1280 mt-3">
  <div class="overflow-hidden rounded-24 shadow-soft">
    <img loading="lazy" src="https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=1400&q=80" alt="Business Cards" class="w-100 object-cover" style="aspect-ratio:16/5" onerror="this.style.display='none'">
  </div>
  <div class="text-center py-5">
    <span class="badge rounded-pill d-inline-flex align-items-center gap-2" style="background:var(--brandLight);color:var(--brand);font-size:9px;letter-spacing:.16em"><i data-lucide="layout-grid" style="width:12px;height:12px"></i> OUR PRODUCTS</span>
    <h1 class="display fw-bold mt-3 mx-auto" style="font-size:32px;max-width:22ch">Explore our complete range of <span style="color:var(--brand)">print &amp; gifting</span> categories</h1>
    <p class="text-secondary mx-auto mt-3" style="font-size:14px;line-height:1.8;max-width:64ch">From premium visiting cards and stationery to personalised mugs, apparel and corporate gifts — discover everything you need under one roof, with free design help, fast delivery and quality you can trust.</p>
  </div>
  <div class="row g-4 mt-2">
    <div class="col-lg-12" id="products">
      <div class="row g-3 row-cols-2 row-cols-lg-5">
        <?php if (!$cats): ?>
        <div class="col-12 text-center text-secondary py-5">No categories available yet.</div>
        <?php endif; ?>
        <?php foreach ($cats as $c): ?>
        <div class="col">
          <a href="category.php?slug=<?= urlencode($c['slug']) ?>" class="card h-100 shadow-soft text-decoration-none p-2">
            <img src="<?= e($c['image']) ?>" class="rounded-4 object-cover w-100" style="aspect-ratio:1/1" alt="<?= e($c['name']) ?>" loading="lazy" onerror="this.style.display='none'">
            <div class="card-body p-2">
              <div class="small fw-semibold text-dark d-flex align-items-center gap-1"><i data-lucide="<?= e($c['icon'] ?: 'layout-grid') ?>" style="width:14px;height:14px"></i> <?= e($c['name']) ?></div>
              <div class="small text-secondary" style="font-size:11px;line-height:1.4"><?= (int)($catCounts[$c['id']] ?? 0) ?> product<?= ((int)($catCounts[$c['id']] ?? 0) === 1 ? '' : 's') ?></div>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>