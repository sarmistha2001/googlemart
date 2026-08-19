<?php
require_once __DIR__ . "/includes/db.php";
$S = get_settings();
$announce = $S["announcement_text"] ?? "";
?>
<?php include __DIR__ . "/includes/header.php"; ?>
<div class="page-hero">
  <div class="container-1280">
    <nav class="crumb premium-crumb small" aria-label="breadcrumb">
      <a href="index.php"><i data-lucide="home" style="width:12px;height:12px"></i> Home</a>
      <span class="sep"><i data-lucide="chevron-right" style="width:12px;height:12px"></i></span>
      <span class="current">About Us</span>
    </nav>
    <h1 class="display fw-bold mt-3" style="font-size:34px">About Us</h1>
    <p class="lead mt-2" style="font-size:14px">India's favourite print &amp; gifting brand — trusted by 2M+ businesses since 2005.</p>
  </div>
</div>

<!-- Section 1: Story + image collage + feature blocks -->
<div class="page-section ">
  <div class="container-1280">
    <div class="row g-4 g-lg-5 align-items-center">
      <div class="col-lg-6">
        <span class="badge rounded-pill" style="background:var(--brandLight);color:var(--brand);font-size:9px;letter-spacing:.16em">OUR STORY</span>
        <h2 class="display fw-bold mt-3" style="font-size:30px;line-height:1.15">Providing the full range of <span style="color:var(--brand)">printing &amp; gifting</span></h2>
        <p class="text-secondary mt-3" style="font-size:14px;line-height:1.8">Google Mart started in 2005 as a small print shop in Bhubaneswar with a simple belief — every business, big or small, deserves premium print quality at fair prices. Today we're India's favourite print &amp; gifting brand, delivering everything from visiting cards to custom mugs, flex prints to corporate gifts.</p>
        <p class="text-secondary" style="font-size:14px;line-height:1.8">With in-house design help, same-day delivery in major cities and pan-India shipping to 15,000+ pin codes, we make it effortless for businesses and families to print, gift and grow.</p>
        <div class="d-flex flex-wrap gap-3 mt-4">
          <a href="contact.php" class="btn btn-brand rounded-pill px-4 fw-bold" style="font-size:13px;height:44px">Learn More <i data-lucide="arrow-right" style="width:15px;height:15px"></i></a>
          <a href="categories.php" class="btn btn-outline-secondary rounded-pill px-4 fw-bold" style="font-size:13px;height:44px">Explore Products</a>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="row g-3">
          <div class="col-8"><img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?w=900&q=80" alt="Printing press" class="w-100 rounded-4 object-cover shadow-soft" style="aspect-ratio:4/3" loading="lazy" onerror="this.style.display='none'"></div>
          <div class="col-4 d-flex flex-column gap-3">
            <img src="https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=400&q=80" alt="Digital print" class="w-100 rounded-4 object-cover shadow-soft" style="aspect-ratio:1/1" loading="lazy" onerror="this.style.display='none'">
            <img src="https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=400&q=80" alt="Custom mug" class="w-100 rounded-4 object-cover shadow-soft" style="aspect-ratio:1/1" loading="lazy" onerror="this.style.display='none'">
          </div>
        </div>
      </div>
    </div>
    <div class="row g-3 mt-5">
      <div class="col-md-4"><div class="page-card h-100 d-flex gap-3 align-items-start"><span class="icon-tile"><i data-lucide="handshake" style="width:22px;height:22px"></i></span><div><h5 class="mb-1" style="font-size:15px">Business Solutions</h5><p class="mb-0" style="font-size:12px">Cards, stationery, signage &amp; bulk kits for growing companies.</p></div></div></div>
      <div class="col-md-4"><div class="page-card h-100 d-flex gap-3 align-items-start"><span class="icon-tile" style="background:#fef2f8;color:var(--brand)"><i data-lucide="shield-check" style="width:22px;height:22px"></i></span><div><h5 class="mb-1" style="font-size:15px">Reliable &amp; Trusted</h5><p class="mb-0" style="font-size:12px">2M+ happy customers and a 4.7★ rating across the country.</p></div></div></div>
      <div class="col-md-4"><div class="page-card h-100 d-flex gap-3 align-items-start"><span class="icon-tile" style="background:#e8f7fd;color:#0369a1"><i data-lucide="globe" style="width:22px;height:22px"></i></span><div><h5 class="mb-1" style="font-size:15px">Comprehensive Coverage</h5><p class="mb-0" style="font-size:12px">Same-day in 4 metros and fast shipping to 15,000+ pin codes.</p></div></div></div>
    </div>
  </div>
</div>

<!-- Section 2: Expertise (reversed layout) -->
<div class="page-section bg-white">
  <div class="container-1280">
    <div class="row g-4 g-lg-5 align-items-center">
      <div class="col-lg-6 order-lg-2">
        <span class="badge rounded-pill" style="background:#fef9e7;color:#b45309;font-size:9px;letter-spacing:.16em">OUR EXPERTISE</span>
        <h2 class="display fw-bold mt-3" style="font-size:30px;line-height:1.15">Our industry-proven <span style="color:var(--brand)">print competence</span></h2>
        <p class="text-secondary mt-3" style="font-size:14px;line-height:1.8">From 300 DPI digital printing and die cutting to binding, apparel and personalised gifts — our team masters every craft in-house. Premium materials, precise finishing and quality checks on every single order.</p>
        <div class="d-flex flex-wrap gap-3 mt-4">
          <a href="category.php" class="btn btn-brand rounded-pill px-4 fw-bold" style="font-size:13px;height:44px">Learn More <i data-lucide="arrow-right" style="width:15px;height:15px"></i></a>
        </div>
      </div>
      <div class="col-lg-6 order-lg-1">
        <img src="https://images.unsplash.com/photo-1587613865763-4b8b0d19e8ab?w=900&q=80" alt="Printing workshop" class="w-100 rounded-4 object-cover shadow-soft" style="aspect-ratio:16/10" loading="lazy" onerror="this.style.display='none'">
      </div>
    </div>
  </div>
</div>

<!-- Section 3: Stats band -->
<div class="page-section">
  <div class="container-1280">
    <div class="store-locator rounded-4 p-4 p-sm-5">
      <div class="row g-3 row-cols-2 row-cols-lg-4 text-center">
        <div class="col"><div class="text-white"><div class="display fw-bold" style="font-size:34px;color:#fff200">19+</div><div class="small" style="color:#e9d5ff">Years of excellence</div></div></div>
        <div class="col"><div class="text-white"><div class="display fw-bold" style="font-size:34px;color:#fff200">2M+</div><div class="small" style="color:#e9d5ff">Happy customers</div></div></div>
        <div class="col"><div class="text-white"><div class="display fw-bold" style="font-size:34px;color:#fff200">100+</div><div class="small" style="color:#e9d5ff">Products &amp; services</div></div></div>
        <div class="col"><div class="text-white"><div class="display fw-bold" style="font-size:34px;color:#fff200">4.7★</div><div class="small" style="color:#e9d5ff">Average rating</div></div></div>
      </div>
    </div>
  </div>
</div>

<!-- Section 4: Team -->
<div class="page-section">
  <div class="container-1280">
    <div class="text-center mb-4">
      <span class="badge rounded-pill" style="background:var(--brandLight);color:var(--brand);font-size:9px;letter-spacing:.16em">OUR TEAM</span>
      <h2 class="display fw-bold mt-2" style="font-size:26px">Meet our <span style="color:var(--brand)">expert team</span></h2>
      <p class="small text-secondary mx-auto mt-2" style="font-size:13px;max-width:52ch">A passionate crew of designers, print masters and support stars working to make your order perfect.</p>
    </div>
    <div class="row g-3 row-cols-2 row-cols-lg-4">
      <div class="col"><div class="team-card rounded-4 overflow-hidden"><img src="https://i.pravatar.cc/400?img=32" alt="Arjun Mehta" class="w-100 object-cover" style="aspect-ratio:1/1" loading="lazy" onerror="this.style.display='none'"><div class="p-3 text-center text-white"><div class="fw-bold" style="font-size:14px">Arjun Mehta</div><div class="small" style="color:#d4c4ea;font-size:11px">Founder &amp; CEO</div></div></div></div>
      <div class="col"><div class="team-card rounded-4 overflow-hidden"><img src="https://i.pravatar.cc/400?img=47" alt="Priya Sharma" class="w-100 object-cover" style="aspect-ratio:1/1" loading="lazy" onerror="this.style.display='none'"><div class="p-3 text-center text-white"><div class="fw-bold" style="font-size:14px">Priya Sharma</div><div class="small" style="color:#d4c4ea;font-size:11px">Design Director</div></div></div></div>
      <div class="col"><div class="team-card rounded-4 overflow-hidden"><img src="https://i.pravatar.cc/400?img=12" alt="Rohan Das" class="w-100 object-cover" style="aspect-ratio:1/1" loading="lazy" onerror="this.style.display='none'"><div class="p-3 text-center text-white"><div class="fw-bold" style="font-size:14px">Rohan Das</div><div class="small" style="color:#d4c4ea;font-size:11px">Production Manager</div></div></div></div>
      <div class="col"><div class="team-card rounded-4 overflow-hidden"><img src="https://i.pravatar.cc/400?img=44" alt="Ananya Nair" class="w-100 object-cover" style="aspect-ratio:1/1" loading="lazy" onerror="this.style.display='none'"><div class="p-3 text-center text-white"><div class="fw-bold" style="font-size:14px">Ananya Nair</div><div class="small" style="color:#d4c4ea;font-size:11px">Client Success Lead</div></div></div></div>
    </div>
  </div>
</div>

<!-- Section 5: Achievements -->
<div class="page-section">
  <div class="container-1280">
    <div class="text-center mb-4">
      <span class="badge rounded-pill" style="background:var(--brandLight);color:var(--brand);font-size:9px;letter-spacing:.16em">ACHIEVEMENTS</span>
      <h2 class="display fw-bold mt-2" style="font-size:26px">Awards &amp; Milestones</h2>
    </div>
    <div class="row g-3">
      <div class="col-md-6 col-lg-3"><div class="page-card h-100 text-center"><div class="icon-tile mx-auto" style="background:#fef2f8;color:var(--brand)"><i data-lucide="award" style="width:22px;height:22px"></i></div><h5 class="mt-3" style="font-size:14px">Best Regional Print Brand</h5><p class="mb-0" style="font-size:12px">Odisha Business Excellence Awards, 2023</p></div></div>
      <div class="col-md-6 col-lg-3"><div class="page-card h-100 text-center"><div class="icon-tile mx-auto" style="background:#fef9e7;color:#b45309"><i data-lucide="trophy" style="width:22px;height:22px"></i></div><h5 class="mt-3" style="font-size:14px">2M+ Orders Served</h5><p class="mb-0" style="font-size:12px">Milestone crossed in 2024</p></div></div>
      <div class="col-md-6 col-lg-3"><div class="page-card h-100 text-center"><div class="icon-tile mx-auto" style="background:#e8f7fd;color:#0369a1"><i data-lucide="badge-check" style="width:22px;height:22px"></i></div><h5 class="mt-3" style="font-size:14px">ISO 9001 Certified</h5><p class="mb-0" style="font-size:12px">Quality management systems</p></div></div>
      <div class="col-md-6 col-lg-3"><div class="page-card h-100 text-center"><div class="icon-tile mx-auto" style="background:#ecfdf5;color:#047857"><i data-lucide="heart" style="width:22px;height:22px"></i></div><h5 class="mt-3" style="font-size:14px">4.7/5 Google Rating</h5><p class="mb-0" style="font-size:12px">34,000+ verified reviews</p></div></div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include __DIR__ . "/includes/footer.php"; ?>
