<?php
require_once __DIR__ . "/includes/db.php";
$S = get_settings();
$announce = $S["announcement_text"] ?? "";
$catSlug = $_GET["slug"] ?? "visiting-card";
$catSt = db()->prepare("SELECT * FROM categories WHERE slug = ? AND is_active = 1 LIMIT 1");
$catSt->execute([$catSlug]);
$curCat = $catSt->fetch();
if (!$curCat) { $curCat = db()->query("SELECT * FROM categories WHERE is_active=1 ORDER BY sort_order LIMIT 1")->fetch(); }
$cats = get_categories();
$prods = get_products_by_category((int)$curCat["id"]);
$catCounts = [];
foreach (db()->query("SELECT category_id, COUNT(*) n FROM products WHERE is_active=1 GROUP BY category_id")->fetchAll() as $cc) {
    $catCounts[$cc["category_id"]] = (int)$cc["n"];
}
?>
<?php include __DIR__ . "/includes/header.php"; ?>
<nav class="container-1280 mt-3 small text-secondary d-flex gap-1 align-items-center flex-wrap"><a href="../index.php" class="text-secondary text-decoration-none">Home</a><i class="bi bi-chevron-right" style="font-size:8px"></i><a href="categories.php" class="text-secondary text-decoration-none">Categories</a><i class="bi bi-chevron-right" style="font-size:8px"></i><span class="fw-semibold text-dark"><?= e($curCat["name"]) ?></span></nav>
<div class="container-1280 mt-3">
  <div class="overflow-hidden rounded-24 shadow-soft">
    <img loading="lazy" src="https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=1400&q=80" alt="Business Cards" class="w-100 object-cover" style="aspect-ratio:16/5" onerror="this.style.display='none'">
  </div>
  <div class="row g-4 mt-2">
    <div class="col-lg-3"><div class="bg-white border rounded-4 p-4 shadow-soft sticky-top" style="top:76px">
      <div class="d-flex justify-content-between align-items-center mb-3"><span class="display fw-bold" style="font-size:16px">Categories</span><a href="categories.php" class="small text-brand fw-bold text-decoration-none">View All</a></div>
      <div class="cat-check-list">
        <?php foreach ($cats as $c): ?>
        <a href="category.php?slug=<?= urlencode($c['slug']) ?>" class="cat-link<?= $c['id']==$curCat['id'] ? ' active' : '' ?>"><i data-lucide="<?= e($c['icon']) ?>" style="width:18px;height:18px"></i><span><?= e($c['name']) ?></span><span class="cat-count"><?= (int)($catCounts[$c['id']] ?? 0) ?></span></a>
        <?php endforeach; ?>
      </div>
    </div></div>
    <div class="col-lg-9" id="products">
      <div class="row g-3 row-cols-2 row-cols-lg-4">
        <?php if (!$prods): ?><div class="col-12 text-center text-secondary py-5">No products in this category yet.</div><?php endif; ?>
        <?php foreach ($prods as $p): ?>
        <div class="col"><a href="product.php?slug=<?= urlencode($p['slug']) ?>" class="card h-100 shadow-soft text-decoration-none p-2"><img src="<?= e($p['main_image']) ?>" class="rounded-4 object-cover w-100" style="aspect-ratio:1/1" alt="<?= e($p['name']) ?>" loading="lazy" onerror="this.style.display='none'"><div class="card-body p-2"><div class="small fw-semibold text-dark d-flex align-items-center gap-1"><?= e($p['name']) ?></div><div class="small text-secondary" style="font-size:11px;line-height:1.4"></div></div></a></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>
