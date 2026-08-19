<?php
require_once __DIR__ . "/includes/db.php";
$S = get_settings();
$announce = $S["announcement_text"] ?? "";
?>
<?php include __DIR__ . "/includes/header.php"; ?>
<nav class="container-1280 mt-3 small text-secondary d-flex gap-1 align-items-center flex-wrap"><a href="../index.php" class="text-secondary text-decoration-none">Home</a><i class="bi bi-chevron-right" style="font-size:8px"></i><a href="categories.php" class="text-secondary text-decoration-none">Categories</a></nav>
<div class="container-1280 mt-3">
  <div class="overflow-hidden rounded-24 shadow-soft">
    <img loading="lazy" src="https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=1400&q=80" alt="Business Cards" class="w-100 object-cover" style="aspect-ratio:16/5" onerror="this.style.display='none'">
  </div>
  <div class="text-center py-5">
    <span class="badge rounded-pill d-inline-flex align-items-center gap-2" style="background:var(--brandLight);color:var(--brand);font-size:9px;letter-spacing:.16em"><i data-lucide="layout-grid" style="width:12px;height:12px"></i> OUR PRODUCTS</span>
    <h1 class="display fw-bold mt-3 mx-auto" style="font-size:32px;max-width:22ch">Explore our complete range of <span style="color:var(--brand)">print &amp; gifting</span> products</h1>
    <p class="text-secondary mx-auto mt-3" style="font-size:14px;line-height:1.8;max-width:64ch">From premium visiting cards and stationery to personalised mugs, apparel and corporate gifts — discover everything you need under one roof, with free design help, fast delivery and quality you can trust.</p>
  </div>
  <div class="row g-4 mt-2">
    <div class="col-lg-12" id="products">
      <div class="row g-3  row-cols-2 row-cols-lg-5">
        <div class="col"><a href="../gm/product.php" class="card h-100 shadow-soft text-decoration-none p-2"><img src="https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=400&q=80" class="rounded-4 object-cover w-100" style="aspect-ratio:1/1" alt="Classic Matte" loading="lazy" onerror="this.style.display='none'"><div class="card-body p-2"><div class="small fw-semibold text-dark d-flex align-items-center gap-1"><i data-lucide="contact" style="width:14px;height:14px"></i> Classic Matte</div><div class="small text-secondary" style="font-size:11px;line-height:1.4">Smooth • Writable • 350 GSM</div></div></a></div>
        <div class="col"><a href="../gm/product.php" class="card h-100 shadow-soft text-decoration-none p-2"><img src="https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=400&q=80" class="rounded-4 object-cover w-100" style="aspect-ratio:1/1" alt="Premium Foil" loading="lazy" onerror="this.style.display='none'"><div class="card-body p-2"><div class="small fw-semibold text-dark d-flex align-items-center gap-1"><i data-lucide="sparkles" style="width:14px;height:14px"></i> Premium Foil</div><div class="small text-secondary" style="font-size:11px;line-height:1.4">Gold / Silver • 400 GSM</div></div></a></div>
        <div class="col"><a href="../gm/product.php" class="card h-100 shadow-soft text-decoration-none p-2"><img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=400&q=80" class="rounded-4 object-cover w-100" style="aspect-ratio:1/1" alt="Spot UV" loading="lazy" onerror="this.style.display='none'"><div class="card-body p-2"><div class="small fw-semibold text-dark d-flex align-items-center gap-1"><i data-lucide="gem" style="width:14px;height:14px"></i> Spot UV</div><div class="small text-secondary" style="font-size:11px;line-height:1.4">Raised Gloss • Premium</div></div></a></div>
        <div class="col"><a href="../gm/product.php" class="card h-100 shadow-soft text-decoration-none p-2"><img src="https://images.unsplash.com/photo-1493934558415-9d19f0b2b4d2?w=400&q=80" class="rounded-4 object-cover w-100" style="aspect-ratio:1/1" alt="Kraft" loading="lazy" onerror="this.style.display='none'"><div class="card-body p-2"><div class="small fw-semibold text-dark d-flex align-items-center gap-1"><i data-lucide="leaf" style="width:14px;height:14px"></i> Kraft</div><div class="small text-secondary" style="font-size:11px;line-height:1.4">Recycled • Natural Finish</div></div></a></div>
        <div class="col"><a href="../gm/product.php" class="card h-100 shadow-soft text-decoration-none p-2"><img src="https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=400&q=80" class="rounded-4 object-cover w-100" style="aspect-ratio:1/1" alt="Velvet Touch" loading="lazy" onerror="this.style.display='none'"><div class="card-body p-2"><div class="small fw-semibold text-dark d-flex align-items-center gap-1"><i data-lucide="heart" style="width:14px;height:14px"></i> Velvet Touch</div><div class="small text-secondary" style="font-size:11px;line-height:1.4">Soft • Luxurious Finish</div></div></a></div>
        <div class="col"><a href="../gm/product.php" class="card h-100 shadow-soft text-decoration-none p-2"><img src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=400&q=80" class="rounded-4 object-cover w-100" style="aspect-ratio:1/1" alt="Rounded Corners" loading="lazy" onerror="this.style.display='none'"><div class="card-body p-2"><div class="small fw-semibold text-dark d-flex align-items-center gap-1"><i data-lucide="scissors" style="width:14px;height:14px"></i> Rounded Corners</div><div class="small text-secondary" style="font-size:11px;line-height:1.4">Any Shape • Die Cut</div></div></a></div>
      </div>
     </div>
  </div>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>
