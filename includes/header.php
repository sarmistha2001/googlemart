<?php
/**
 * Google Mart common header — mega menu: 9 fixed items (embedded below).
 * Requires includes/db.php functions: db(), e(), get_settings().
 */
if (!function_exists('db')) { require_once __DIR__ . '/db.php'; }
if (!isset($S)) { $S = get_settings(); }
if (!isset($announce)) { $announce = $S['announcement_text'] ?? ''; }

/**
 * Build a lookup of active product names -> slug, so menu items whose
 * label matches an actual product can link straight to that product page
 * instead of just the category page.
 */
$menuProductLookup = [];
foreach (db()->query("SELECT name, slug FROM products WHERE is_active=1") as $pr) {
    $menuProductLookup[mb_strtolower(trim($pr['name']))] = $pr['slug'];
}

/**
 * Build a lookup of active category slugs, so we never link to a
 * category.php?slug=... that doesn't actually exist in the DB.
 */
$menuCategorySlugs = [];
foreach (db()->query("SELECT slug FROM categories WHERE is_active=1") as $cat) {
    $menuCategorySlugs[$cat['slug']] = true;
}

function resolve_menu_link(string $label, string $categorySlug): string
{
    global $menuProductLookup, $menuCategorySlugs;

    $key = mb_strtolower(trim($label));
    if (isset($menuProductLookup[$key])) {
        return 'product.php?slug=' . urlencode($menuProductLookup[$key]);
    }

    if (isset($menuCategorySlugs[$categorySlug])) {
        return 'category.php?slug=' . urlencode($categorySlug);
    }

    return 'categories.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1"/>
<title><?= e($S['site_name'] ?? 'Google Mart') ?> – Digital Print Shop in Patia, Bhubaneswar | Fast &amp; Affordable Printing</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<!-- Favicon -->
<link rel="icon" type="image/jpeg" href="assets/images/logo.jpeg">
<script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-light" style="background:#fcfbff!important">
<!-- Top Announcement — Printo style -->
<div class="top-announce" style="background:#02155c;color:#fff;font-size:12px;padding:6px 10px;text-align:center;font-weight:700;line-height:1.4">
  <a href="#" class="text-white text-decoration-none"><?= e($announce) ?></a>
</div>

<!-- Main header — sticky -->
<?php $waNum = $S['whatsapp'] ?? '917008432909'; $phNum = preg_replace('/[^0-9]/', '', $S['phone_1'] ?? '917008432909'); ?>
<div class="bg-white" style="position:sticky;top:0;z-index:1030;box-shadow:0 4px 6px rgba(0,0,0,.08)">
  <div class="container-1280 d-flex align-items-center gap-2 gap-md-3" style="height:64px">
    <a class="d-flex align-items-center gap-2 text-decoration-none flex-shrink-0" href="index.php">
      <img src="assets/images/logo.jpeg" alt="Google Mart" class="brand-logo" style="height:52px">
    </a>
    <div class="flex-grow-1 d-flex justify-content-center" style="max-width:720px;min-width:0">
      <div class="position-relative w-100">
        <form action="search.php" method="get" class="position-relative w-100">
          <input name="q" value="<?= e($_GET['q'] ?? '') ?>" placeholder="Search" aria-label="Search" class="form-control" style="height:42px;border-radius:12px;border:1px solid #E5E7EB;padding-left:14px;padding-right:44px;background:#fff;font-size:14px;box-shadow:none">
          <button class="btn position-absolute top-50 end-0 translate-middle-y me-1 d-flex align-items-center justify-content-center" style="width:34px;height:34px;border-radius:50%;color:#8D9199" type="submit"><i data-lucide="search" style="width:16px;height:16px"></i></button>
        </form>
      </div>
    </div>
    <div class="d-flex align-items-center gap-3 ms-auto flex-shrink-0 d-none d-md-flex">
      <a href="https://wa.me/<?= e($waNum) ?>" target="_blank" rel="noopener" class="d-flex align-items-center justify-content-center rounded-circle text-white text-decoration-none" style="width:42px;height:42px;background:#25d366;flex-shrink:0" aria-label="WhatsApp"><i class="bi bi-whatsapp" style="font-size:24px;line-height:1"></i></a>
      <a href="tel:+<?= e($phNum) ?>" class="d-flex align-items-center gap-1 text-decoration-none text-white fw-bold px-3 py-2 rounded-pill flex-shrink-0" style="background:#02155c;font-size:13px"><i data-lucide="phone" style="width:15px;height:15px"></i><span class="d-none d-lg-inline">Contact Now</span></a>
    </div>
    <button class="btn d-lg-none p-0 border-0 flex-shrink-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav" aria-controls="mobileNav"><i data-lucide="menu" style="width:22px;height:22px"></i></button>
  </div>
  
</div>
<!-- Mega menu — desktop (9 fixed items) -->
<?php $GMENU = [
    ['title' => 'All Products', 'link' => 'categories.php', 'key' => 'all-products', 'groups' => [
        ['Printing Services', ['Digital Print','digital-print'],['Digital Xerox','digital-xerox'],['Plan Xerox','plan-xerox'],['Flex Print','flex-print'],['Die Cutting','die-cutting'],['Menu Print','menu-print']],
        ['Business Printing', ['Visiting Card','visiting-card'],['Bill Book / Invitation Card','bill-book'],['Binding','binding'],['ID Card / Lanyard','id-card-lanyard'],['Badge','badge']],
        ['Personalized Products', ['T-Shirt','t-shirt'],['Photo Frame','photo-frame'],['Mug Print','mug-print'],['Laser Engraving','laser-engraving'],['Gift','gift']],
        ['Stationery', ['Office & Art Stationery','office-art'],['Paper & Board','office-art'],['Art & Craft Supplies','office-art'],['Notebooks','office-art'],['Pens & Pencils','office-art']],
        ['Corporate', ['Corporate Gift','corporate-gift'],['ID Cards','id-card-lanyard'],['Lanyards','id-card-lanyard'],['Badges','badge'],['Visiting Cards','visiting-card']],
        ['Popular Services', ['Visiting Card','visiting-card'],['Digital Print','digital-print'],['Flex Print','flex-print'],['Photo Frame','photo-frame'],['Mug Print','mug-print'],['T-Shirt','t-shirt']],
    ]],
    ['title' => 'Printings', 'link' => 'category.php?slug=digital-print', 'key' => 'printings', 'groups' => [
        ['Digital Printing', ['Book Print','digital-print'],['Poster Print','digital-print'],['Certificate Print','digital-print'],['Brochure Print','digital-print'],['Letterhead Print','digital-print'],['Envelope Print','digital-print'],['Booklet','digital-print'],['Flyers Printing','digital-print']],
        ['Marketing Print', ['Visiting Card','visiting-card'],['Tent Card','digital-print'],['Dangler Print','digital-print'],['Sticker Print','digital-print'],['Photo Print','digital-print'],['Invitation Card Print','digital-print'],['Corporate Brochure Print','digital-print'],['Paper Tag Print','digital-print']],
        ['Customized Print', ['Customized Label Stickers','digital-print'],['Customized Envelope','digital-print'],['Customized Spiral / Wiro Notebook','digital-print'],['Table Calendar','digital-print'],['Foil Printing','digital-print'],['Wedding Card Printing','digital-print'],['Bell Book Print','digital-print']],
        ['Large Format', ['Digital Flex Print','flex-print'],['One Way Vision','flex-print'],['Vinyl Print','flex-print'],['Canvas Print','flex-print'],['Sunboard Print','flex-print'],['Backlit Print','flex-print'],['Banner Print','flex-print'],['Fabric Media','flex-print']],
    ]],
    ['title' => 'Bindings', 'link' => 'category.php?slug=binding', 'key' => 'bindings', 'groups' => [
        ['Book Binding', ['Thesis Binding','binding'],['Project Binding','binding'],['Soft Binding','binding'],['Leather Binding','binding'],['Album Binding','binding']],
        ['Hard Binding', ['Digital Cover Hard Binding','binding'],['Digital & Foil Cover Hard Binding','binding'],['Velvet Cover Binding','binding'],['Cloth / Rexin Binding','binding']],
        ['Spiral & Wiro', ['Spiral Binding','binding'],['Wiro Binding','binding']],
    ]],
    ['title' => 'Trophies & Medals', 'link' => 'category.php?slug=badge', 'key' => 'trophies', 'groups' => [
        ['Trophies', ['Customized Trophies','badge'],['Corporate Trophies','badge'],['Sports Trophies','badge'],['Achievement Trophies','badge']],
        ['Medals', ['Gold Medals','badge'],['Silver Medals','badge'],['Bronze Medals','badge'],['Customized Medals','badge']],
        ['Awards', ['Mementos','badge'],['Award Plaques','badge'],['Recognition Awards','badge']],
    ]],
    ['title' => 'Business Cards', 'link' => 'category.php?slug=visiting-card', 'key' => 'biz-cards', 'groups' => [
        ['Standard Cards', ['Plain Visiting Card','visiting-card'],['Texture Paper Visiting Card','visiting-card'],['Non-Tearable Visiting Card','visiting-card'],['Matte Laminate Visiting Card','visiting-card'],['Gloss Visiting Card','visiting-card']],
        ['Premium Cards', ['Velvet Visiting Card','visiting-card'],['Foil Print Visiting Card','visiting-card'],['UV / Foil Visiting Card','visiting-card'],['Golden Paper Visiting Card','visiting-card']],
        ['Special Cards', ['Corner Cutting Visiting Card','visiting-card'],['Any Shape Visiting Card','visiting-card'],['Metal Engraving Visiting Card','visiting-card'],['PVC Visiting Card','visiting-card']],
    ]],
    ['title' => 'Personalized Gifts', 'link' => 'category.php?slug=gift', 'key' => 'gifts', 'groups' => [
        ['Photo Gifts', ['Photo Frame','photo-frame'],['LED Photo Frame','photo-frame'],['Aluminium LED Photo Frame','photo-frame'],['Table-top LED Photo Frame','photo-frame']],
        ['Mug Gifts', ['White Sublimation Mug','mug-print'],['Beer Mug','mug-print'],['Frosted Beer Mug','mug-print'],['Colour Mugs','mug-print'],['Magic Cups','mug-print'],['Patch Mug','mug-print'],['Heart Handle Mug','mug-print'],['Metallic Ceramic Mugs','mug-print']],
        ['Custom Gifts', ['Gift','gift'],['Laser Engraving','laser-engraving'],['Photo Engraving','laser-engraving']],
    ]],
    ['title' => 'Stationery & Office Supplies', 'link' => 'category.php?slug=office-art', 'key' => 'stationery', 'groups' => [
        ['Paper & Boards', ['Handmade Paper','office-art'],['Cambridge Paper','office-art'],['Ivory Paper','office-art'],['Heather Colour Paper','office-art'],['Newsprint Paper','office-art'],['Canvas Sheet','office-art'],['Canvas Board','office-art'],['Mount Board','office-art'],['MDF Board','office-art']],
        ['Art Supplies', ['Sketch Book','office-art'],['Art & Craft Items','office-art'],['T-Scale','office-art'],['French Curve','office-art'],['Staedtler Pencil','office-art'],['Hip Curve','office-art'],['Drafter','office-art'],['Shading Pencil','office-art'],['Charcoal Pencil','office-art']],
        ['Office Supplies', ['Scientific Calculator','office-art'],['All Pens','office-art'],['Spiral Notebook','office-art'],['Classmate Copy','office-art'],['Cellotape','office-art'],['Pencil Pouch','office-art'],['Key Chain','office-art'],['Paper Bag','office-art']],
        ['Craft & Accessories', ['Lace','office-art'],['Ribbon','office-art'],['Puzzles','office-art'],['Spray Paint','office-art'],['Birthday Items','office-art'],['Balloon','office-art'],['Bubble Wrap','office-art'],['Thermocol','office-art']],
    ]],
    ['title' => 'Rubber Stamps', 'link' => 'category.php?slug=stamps', 'key' => 'stamps', 'groups' => [
        ['Office Stamps', ['Self-Inking Stamp','stamps'],['Office Stamp','stamps'],['Address Stamp','stamps'],['Name Stamp','stamps']],
        ['Custom Stamps', ['Customized Rubber Stamp','stamps'],['Round Stamp','stamps'],['Signature Stamp','stamps'],['Company Stamp','stamps']],
    ]],
    ['title' => 'Corporate Gifts', 'link' => 'category.php?slug=corporate-gift', 'key' => 'corp-gifts', 'groups' => [
        ['Corporate Gifting', ['Corporate Gift','corporate-gift'],['Customized Gifts','corporate-gift'],['Employee Gifts','corporate-gift'],['Promotional Gifts','corporate-gift']],
        ['Branded Products', ['T-Shirts','t-shirt'],['Mugs','mug-print'],['Photo Frames','photo-frame'],['Lanyards','id-card-lanyard'],['ID Cards','id-card-lanyard']],
        ['Recognition', ['Badges','badge'],['Trophies','badge'],['Medals','badge'],['Awards','badge']],
    ]],
]; ?>
<div class="d-none  d-lg-block position-relative" style="background:#f8f9fa;border-top:1px solid #eee;border-bottom:1px solid #eee">
  <div class="menu-80">
    <div class="d-flex justify-content-center align-items-stretch" style="gap:0;overflow:visible">
      <?php $gi = 0; foreach ($GMENU as $gm): $style = $gi === 0 ? 'color:#e8488e!important;font-weight:700;' : 'font-weight:500;'; ?>
      <div class="mega-item position-static d-flex align-items-center"><a href="<?= e($gm['link']) ?>" class="nav-link px-2 d-flex align-items-center gap-1" data-mega="<?= e($gm['key']) ?>" style="<?= $style ?>font-size:13px;padding:10px 12px;white-space:nowrap"><?= e($gm['title']) ?> <i data-lucide="chevron-down" style="width:10px;height:10px;opacity:.6" class="mega-chevron"></i></a></div>
      <?php $gi++; endforeach; ?>
    </div>
  </div>
  <!-- Mega panels -->
  <div class="mega-panels position-absolute start-50 translate-middle-x" style="top:100%;z-index:1029;width:80vw;left:50%">
    <?php foreach ($GMENU as $gm): ?>
    <div class="mega-panel bg-white border-top shadow-soft d-none" data-panel="<?= e($gm['key']) ?>" style="border-color:#f1f5f9!important">
      <div class="px-4 py-3">
        <div class="d-flex align-items-center gap-2 mb-2"><span class="small fw-bold" style="color:var(--brand)"><?= e($gm['title']) ?></span><span class="small text-secondary">— <?= array_sum(array_map(fn($g) => count($g) - 1, $gm['groups'])) ?> items</span><a href="<?= e($gm['link']) ?>" class="ms-auto small fw-bold text-brand text-decoration-none">View all →</a></div>
        <div class="row g-3">
          <?php foreach ($gm['groups'] as $grp): $heading = array_shift($grp); ?>
          <div class="col-6 col-lg-3">
            <div class="small fw-bold text-uppercase mb-1" style="font-size:11px;letter-spacing:.05em;color:#02155c"><?= e($heading) ?></div>
            <?php foreach ($grp as $lk): ?>
            <a href="<?= e(resolve_menu_link($lk[0], $lk[1])) ?>" class="d-block text-decoration-none small py-1" style="color:#334155;font-size:12px;line-height:1.6"><?= e($lk[0]) ?></a>
            <?php endforeach; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>


<!-- Mobile offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileNav" aria-labelledby="mobileNavLabel">
  <div class="offcanvas-header border-bottom"><span class="display fw-bold" id="mobileNavLabel"><img src="assets/images/logo.jpeg" alt="Google Mart" class="brand-logo" style="height:64px;width:auto;background:#fff;border-radius:12px;padding:6px;box-shadow:0 8px 24px rgba(0,0,0,.35)"></span><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
  <div class="offcanvas-body p-0">
    <div class="d-flex flex-column">
      <?php foreach ($GMENU as $i => $gm): $panelId = 'mnav-' . e($gm['key']); ?>
      <div class="mnav-item border-bottom" style="border-color:#f1f5f9!important">
        <div class="d-flex align-items-stretch">
          <a href="<?= e($gm['link']) ?>" class="flex-grow-1 text-decoration-none fw-semibold text-dark px-3" style="padding-top:12px;padding-bottom:12px;font-size:14px"><?= e($gm['title']) ?></a>
          <button type="button" class="btn border-0 px-3 mnav-toggle" data-bs-toggle="collapse" data-bs-target="#<?= $panelId ?>" aria-expanded="false" aria-controls="<?= $panelId ?>" aria-label="Toggle <?= e($gm['title']) ?> submenu">
            <i data-lucide="chevron-down" style="width:16px;height:16px" class="mnav-chevron"></i>
          </button>
        </div>
        <div class="collapse" id="<?= $panelId ?>">
          <div class="pb-2 ps-3">
            <?php foreach ($gm['groups'] as $grp): $h = array_shift($grp); ?>
            <div class="small fw-bold text-uppercase mt-2 mb-1" style="font-size:10px;letter-spacing:.05em;color:#02155c"><?= e($h) ?></div>
            <?php foreach ($grp as $lk): ?>
            <a href="<?= e(resolve_menu_link($lk[0], $lk[1])) ?>" class="text-decoration-none text-secondary d-block" style="padding:4px 0 4px 10px;font-size:13px"><?= e($lk[0]) ?></a>
            <?php endforeach; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
      <hr class="m-0">
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.mnav-toggle').forEach(function (btn) {
    var targetSel = btn.getAttribute('data-bs-target');
    var targetEl = document.querySelector(targetSel);
    if (!targetEl) return;

    targetEl.addEventListener('shown.bs.collapse', function () {
      btn.setAttribute('aria-expanded', 'true');
      var chevron = btn.querySelector('.mnav-chevron');
      if (chevron) chevron.style.transform = 'rotate(180deg)';
    });
    targetEl.addEventListener('hidden.bs.collapse', function () {
      btn.setAttribute('aria-expanded', 'false');
      var chevron = btn.querySelector('.mnav-chevron');
      if (chevron) chevron.style.transform = 'rotate(0deg)';
    });
  });
});
</script>

<style>
.mnav-chevron { transition: transform .2s ease; }
.mnav-toggle { background: transparent; color: #64748b; }
.mnav-toggle:focus { box-shadow: none; }
</style>