<?php
require_once __DIR__ . "/includes/db.php";
$S = get_settings();
$announce = $S["announcement_text"] ?? "";
?>
<?php
$prodCards = function (array $items, string $link = 'product.php?slug='): string {
    return implode('', array_map(fn($p) => product_card($p, $link), $items));
};
?>
<?php include __DIR__ . "/includes/header.php"; ?>

<!-- Banner 1 — Printo 2-up -->
<div class="container-1280 mt-4">
  <div class="row g-3 row-cols-1 ">
    <div class="col"><a href="category.php" class="d-block overflow-hidden rounded-24 shadow-soft"><img src="assets/images/banner.png" alt="Promo" class="w-100 object-cover" style="aspect-ratio:16/7;object-fit:fill" loading="lazy" onerror="this.parentElement.style.background='linear-gradient(135deg,#700895,#a855f7)';this.parentElement.style.minHeight='180px';this.style.display='none'"></a></div>
   
  </div>
</div>

<!-- Categories — icon strip like reference image (Swiper) -->
<div class="container-1280 mt-3">
  <div class="swiper catSwiper" style="padding-bottom:20px;">
    <div class="swiper-wrapper">
      <?php foreach (get_categories() as $c): ?>
        <div class="swiper-slide">
          <a href="category.php?slug=<?= urlencode($c['slug']) ?>"
             class="text-decoration-none d-flex flex-column align-items-center gap-1 text-center p-2">

            <img src="<?= e($c['image']) ?>"
                 alt="<?= e($c['name']) ?>"
                 style="width:100px;height:100px;object-fit:cover;border-radius:12px;border:1px solid #f1f5f9"
                 loading="lazy">

            <span class="small fw-semibold text-dark"
                  style="font-size:12px;line-height:1.25">
              <?= e($c['name']) ?>
            </span>

          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="swiper-pagination cat-pagination" style="bottom:0;"></div>
  </div>
</div>

<!-- Banner 2 — secondary promos -->
<div class="container-1280 mt-4">
  <div class="row g-3 row-cols-2">
    <div class="col"><a href="category.php?slug=binding" class="d-block overflow-hidden rounded-24 shadow-soft"><img src="assets/images/thesis.png" alt="Promo" class="w-100 object-fill promo-square" loading="lazy" onerror="this.parentElement.style.background='linear-gradient(135deg,#02155c,#ff8cc8)';this.parentElement.style.minHeight='180px';this.style.display='none'"></a></div>
    <div class="col"><a href="category.php" class="d-block overflow-hidden rounded-24 shadow-soft"><img src="assets/images/banner2.png" alt="Promo" class="w-100 object-cover promo-square" loading="lazy" onerror="this.parentElement.style.background='linear-gradient(135deg,#00aeef,#5fd3ff)';this.parentElement.style.minHeight='180px';this.style.display='none'"></a></div>
  </div>
</div>

<?php /*
<div class="container-1280 mt-5">
  <div class="d-flex align-items-end justify-content-between">
    <div><h2 class="display fw-bold mb-1" style="font-size:22px">New Arrivals</h2><p class="small text-primary mb-0">18 services • Print, bind, flex &amp; gifting</p></div>
    <div class="d-flex align-items-center gap-2">
      <div class="d-flex gap-2"><button class="newArrival-prev btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Previous"><i data-lucide="chevron-left" style="width:14px;height:14px"></i></button><button class="newArrival-next btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Next"><i data-lucide="chevron-right" style="width:14px;height:14px"></i></button></div>
      <a href="categories.php" class="btn btn-outline-secondary btn-sm rounded-pill carousel-view d-none d-sm-inline-flex">View all <i data-lucide="arrow-right" class="ms-1"></i></a>
    </div>
  </div>
  <div class="swiper newArrivalSwiper mt-1"><div class="swiper-wrapper">
    <?php echo $prodCards(get_products('is_new', 1)); ?>
    </div>
    <!-- <div class="swiper-pagination newArrival-pagination mt-3"></div> -->
  </div>
 
</div>
*/ ?>
<!-- Trending Products -->
<div class="container-1280 mt-5">
  <div class="d-flex align-items-end justify-content-between">
    <div><h2 class="display fw-bold mb-1" style="font-size:22px">Professional Binding</h2><p class="small  text-primary  mb-0"> Book Binding • Hard Binding  •  Spiral Binding</p></div>
    <div class="d-flex align-items-center gap-2">
      <div class="d-flex gap-2"><button class="trend-prev btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Previous"><i data-lucide="chevron-left" style="width:14px;height:14px"></i></button><button class="trend-next btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Next"><i data-lucide="chevron-right" style="width:14px;height:14px"></i></button></div>
      <a href="categories.php" class="btn btn-outline-secondary btn-sm rounded-pill carousel-view d-none d-sm-inline-flex">View all <i data-lucide="arrow-right" class="ms-1"></i></a>
    </div>
  </div>
  <div class="swiper trendSwiper mt-1"><div class="swiper-wrapper">
    <?php echo $prodCards(get_products_by_cats([2])); ?>
    
  </div>
  <!-- <div class="swiper-pagination trend-pagination mt-3"></div> -->
</div>
</div>
<!-- Category highlight: Professional Printing -->
<div class="container-1280 mt-5">
  <div class="d-flex align-items-end justify-content-between">
    <div><h2 class="display fw-bold mb-1" style="font-size:22px">Professional Printing</h2><p class="small  text-primary  mb-0">Digital Print • Digital Xerox • Plan Xerox • Die Cutting • Visiting Card</p></div>
    <div class="d-flex align-items-center gap-2">
      <div class="d-flex gap-2"><button class="printStationery-prev btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Previous"><i data-lucide="chevron-left" style="width:14px;height:14px"></i></button><button class="printStationery-next btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Next"><i data-lucide="chevron-right" style="width:14px;height:14px"></i></button></div>
      <a href="categories.php" class="btn btn-outline-secondary btn-sm rounded-pill carousel-view d-none d-sm-inline-flex">View all <i data-lucide="arrow-right" class="ms-1"></i></a>
    </div>
  </div>
  <div class="swiper printStationerySwiper mt-1"><div class="swiper-wrapper">
    <?php echo $prodCards(get_products_by_cats([1,8,4,5,7])); ?>
    
  </div>
  <!-- <div class="swiper-pagination printStationery-pagination mt-3"></div> -->
</div>
</div>
<!-- Category highlight: Stationery Essentials -->
<div class="container-1280 mt-5">
  <div class="d-flex align-items-end justify-content-between">
    <div><h2 class="display fw-bold mb-1" style="font-size:22px">Stationery Essentials</h2><p class="small  text-primary  mb-0">Cards • Letterheads • Envelopes • Books</p></div>
    <div class="d-flex align-items-center gap-2">
      <div class="d-flex gap-2"><button class="printStationery-prev btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Previous"><i data-lucide="chevron-left" style="width:14px;height:14px"></i></button><button class="printStationery-next btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Next"><i data-lucide="chevron-right" style="width:14px;height:14px"></i></button></div>
      <a href="categories.php" class="btn btn-outline-secondary btn-sm rounded-pill carousel-view d-none d-sm-inline-flex">View all <i data-lucide="arrow-right" class="ms-1"></i></a>
    </div>
  </div>
  <div class="swiper printStationerySwiper mt-1"><div class="swiper-wrapper">
    <?php echo $prodCards(get_products_by_cats([1,2,4,5])); ?>
    
  </div>
  <!-- <div class="swiper-pagination printStationery-pagination mt-3"></div> -->
</div>
</div>
<div class="container-1280 mt-5">
  <div class="d-flex align-items-end justify-content-between">
    <div><h2 class="display fw-bold mb-1" style="font-size:22px">Shop By Business Needs</h2><p class="small  text-primary  mb-0">Most loved by our customers</p></div>
    <div class="d-flex align-items-center gap-2">
      <div class="d-flex gap-2"><button class="bestSellers-prev btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Previous"><i data-lucide="chevron-left" style="width:14px;height:14px"></i></button><button class="bestSellers-next btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Next"><i data-lucide="chevron-right" style="width:14px;height:14px"></i></button></div>
      <a href="categories.php" class="btn btn-outline-secondary btn-sm rounded-pill carousel-view d-none d-sm-inline-flex">View all <i data-lucide="arrow-right" class="ms-1"></i></a>
    </div>
  </div>
  <div class="swiper bestSellersSwiper mt-1"><div class="swiper-wrapper">
    <?php echo $prodCards(get_products('is_featured', 1)); ?>
  </div></div>
</div>

<div class="container-1280 mt-4">
  <div class="row g-3 row-cols-2">
    <div class="col"><a href="category.php" class="d-block overflow-hidden rounded-24 shadow-soft"><img src="https://printo-s3.dietpixels.net/Mobile_1785999989.jpg?quality=70&format=webp&w=1200" alt="Promo" class="w-100 object-cover promo-square" loading="lazy" onerror="this.parentElement.style.background='linear-gradient(135deg,#02155c,#ff8cc8)';this.parentElement.style.minHeight='180px';this.style.display='none'"></a></div>
    <div class="col"><a href="category.php" class="d-block overflow-hidden rounded-24 shadow-soft"><img src="https://printo-s3.dietpixels.net/Mobile_1786445173.jpg?quality=70&format=webp&w=1200" alt="Promo" class="w-100 object-cover promo-square" loading="lazy" onerror="this.parentElement.style.background='linear-gradient(135deg,#00aeef,#5fd3ff)';this.parentElement.style.minHeight='180px';this.style.display='none'"></a></div>
  </div>
</div>


<!-- Category highlight: Apparel & Personalized Gifts -->
<div class="container-1280 mt-5">
  <div class="d-flex align-items-end justify-content-between">
    <div><h2 class="display fw-bold mb-1" style="font-size:22px">Apparel & Personalized Gifts</h2><p class="small  text-primary  mb-0">T-Shirt • Photo Frame • Mug Print • Gift</p></div>
    <div class="d-flex align-items-center gap-2">
      <div class="d-flex gap-2"><button class="apparel-prev btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Previous"><i data-lucide="chevron-left" style="width:14px;height:14px"></i></button><button class="apparel-next btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Next"><i data-lucide="chevron-right" style="width:14px;height:14px"></i></button></div>
      <a href="categories.php" class="btn btn-outline-secondary btn-sm rounded-pill carousel-view d-none d-sm-inline-flex">View all <i data-lucide="arrow-right" class="ms-1"></i></a>
    </div>
  </div>
  <div class="swiper apparelSwiper mt-1"><div class="swiper-wrapper">
    <?php echo $prodCards(get_products_by_cats([12,13,14,18])); ?>
    
  </div>
  <!-- <div class="swiper-pagination apparel-pagination mt-3"></div> -->
</div>
</div>

<!-- Category highlight: Business & Marketing Printing -->
<div class="container-1280 mt-5">
  <div class="d-flex align-items-end justify-content-between">
    <div><h2 class="display fw-bold mb-1" style="font-size:22px">Business & Marketing Printing</h2><p class="small  text-primary  mb-0">Visiting Card • Menu Print • Bill Book / Invitation Card • Digital Print</p></div>
    <div class="d-flex align-items-center gap-2">
      <div class="d-flex gap-2"><button class="photoGifts-prev btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Previous"><i data-lucide="chevron-left" style="width:14px;height:14px"></i></button><button class="photoGifts-next btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Next"><i data-lucide="chevron-right" style="width:14px;height:14px"></i></button></div>
      <a href="categories.php" class="btn btn-outline-secondary btn-sm rounded-pill carousel-view d-none d-sm-inline-flex">View all <i data-lucide="arrow-right" class="ms-1"></i></a>
    </div>
  </div>
  <div class="swiper photoGiftsSwiper mt-1"><div class="swiper-wrapper">
    <?php echo $prodCards(get_products_by_cats([8,7,11,1])); ?>
    
  </div>
  <!-- <div class="swiper-pagination photoGifts-pagination mt-3"></div> -->
</div>
</div>

<!-- Category highlight: Corporate & Identification -->
<div class="container-1280 mt-5">
  <div class="d-flex align-items-end justify-content-between">
    <div><h2 class="display fw-bold mb-1" style="font-size:22px">Corporate & Identification</h2><p class="small  text-primary  mb-0">ID Card / Lanyard • Badge • Corporate Gift</p></div>
    <div class="d-flex align-items-center gap-2">
      <div class="d-flex gap-2"><button class="packaging-prev btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Previous"><i data-lucide="chevron-left" style="width:14px;height:14px"></i></button><button class="packaging-next btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Next"><i data-lucide="chevron-right" style="width:14px;height:14px"></i></button></div>
      <a href="categories.php" class="btn btn-outline-secondary btn-sm rounded-pill carousel-view d-none d-sm-inline-flex">View all <i data-lucide="arrow-right" class="ms-1"></i></a>
    </div>
  </div>
  <div class="swiper packagingSwiper mt-1"><div class="swiper-wrapper">
    <?php echo $prodCards(get_products_by_cats([9,10,17])); ?>
    
  </div>
  <!-- <div class="swiper-pagination packaging-pagination mt-3"></div> -->
</div>
</div>


<div class="container-1280 pt-4">
  <div class="row g-3 align-items-stretch">
    <div class="col-lg-7">
      <div class="hero p-4 p-sm-5 text-white h-100 position-relative">
        <h1 class="display fw-bold lh-1 mt-3" style="font-size:clamp(26px,4vw,35px)">Print.<br>Gift. Grow<br><span style="color:#FFD23F">your business.</span></h1>
        <p class="text-white-50 mt-3" style="max-width:42ch">Custom printing trusted by 2M+ businesses. 100+ products, free design help, delivered anywhere — even same-day.</p>
        <div class="d-flex flex-wrap gap-2 mt-4">
          <a href="categories.php" class="btn btn-light rounded-pill px-4 fw-bold" style="color:var(--brand)">Explore Products <i data-lucide="arrow-right" class="ms-1"></i></a>
          <a href="../contact.html" class="btn btn-outline-light rounded-pill px-4">Contact Now</a>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="row g-3 h-100">
        <div class="col-6"><a href="../product.html" class="card h-100 shadow-soft text-decoration-none"><img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=600&q=80" class="card-img-top object-cover" style="height:188px" onerror="this.style.display='none'"><div class="card-body"><div class="small fw-bold text-brand" style="letter-spacing:.1em">BESTSELLER</div><div class="fw-bold text-dark">Premium Visiting Cards</div><span class="small fw-semibold text-brand">Shop now →</span></div><span class="badge bg-success position-absolute top-0 end-0 m-2">SAME DAY</span></a></div>
        <div class="col-6"><a href="../product.html" class="card h-100 bg-dark text-white overflow-hidden text-decoration-none"><img loading="lazy" src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&q=80" class="card-img-top object-cover opacity-75" style="height:188px" onerror="this.style.display='none'"><div class="card-img-overlay d-flex flex-column justify-content-end" style="background:linear-gradient(to top,rgba(0,0,0,.6),transparent)"><div class="small fw-bold text-warning" style="letter-spacing:.1em">APPAREL</div><div class="fw-bold">Custom T-Shirts</div><div class="small text-white-50">Polo, Round Neck</div></div></a></div>
        <div class="col-7 d-none d-md-block"><a href="../product.html" class="card h-100 d-flex flex-row shadow-soft text-decoration-none"><div class="card-body"><div class="bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width:32px;height:32px"><i data-lucide="gift"></i></div><div class="fw-bold text-dark mt-2" style="line-height:1.1">Photo Gifts & Mugs</div><div class="small text-secondary">Make it personal</div><span class="badge bg-dark mt-2">From ₹149</span></div><img loading="lazy" src="https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=400&q=80" class="object-cover rounded-end-4" style="width:46%" onerror="this.style.display='none'"></a></div>
        <div class="col-5 d-none d-sm-flex"><a href="../category.html" class="card h-100 text-decoration-none p-3 d-flex flex-column justify-content-between" style="background:var(--accent)"><div><div class="small fw-bold opacity-50">Bulk?</div><div class="display fw-bold" style="font-size:14px;line-height:1.1">Get quote in Under 5 mins</div></div><span class="btn btn-dark btn-sm rounded-pill">Request <i data-lucide="arrow-up-right" style="width:14px;height:14px"></i></span></a></div>
      </div>
    </div>
  </div>
</div>
<!-- Category highlight: Office & Creative Supplies -->
<div class="container-1280 mt-5">
  <div class="d-flex align-items-end justify-content-between">
    <div><h2 class="display fw-bold mb-1" style="font-size:22px">Office & Creative Supplies</h2><p class="small  text-primary  mb-0">Visiting Card • T-shirt • Laser Engraving • Gift</p></div>
    <div class="d-flex align-items-center gap-2">
      <div class="d-flex gap-2"><button class="corporate-prev btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Previous"><i data-lucide="chevron-left" style="width:14px;height:14px"></i></button><button class="corporate-next btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Next"><i data-lucide="chevron-right" style="width:14px;height:14px"></i></button></div>
      <a href="categories.php" class="btn btn-outline-secondary btn-sm rounded-pill carousel-view d-none d-sm-inline-flex">View all <i data-lucide="arrow-right" class="ms-1"></i></a>
    </div>
  </div>
  <div class="swiper corporateSwiper mt-1"><div class="swiper-wrapper">
    <?php echo $prodCards(get_products_by_cats([8,12,15,18])); ?>
    
  </div>
  <!-- <div class="swiper-pagination corporate-pagination mt-3"></div> -->
</div>
</div>

<!-- Category highlight: Advertising & Display -->
<div class="container-1280 mt-5">
  <div class="d-flex align-items-end justify-content-between">
    <div><h2 class="display fw-bold mb-1" style="font-size:22px">Advertising & Display</h2><p class="small  text-primary  mb-0">Flex Print • Die Cutting • Visiting Card</p></div>
    <div class="d-flex align-items-center gap-2">
      <div class="d-flex gap-2"><button class="digitalOffset-prev btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Previous"><i data-lucide="chevron-left" style="width:14px;height:14px"></i></button><button class="digitalOffset-next btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Next"><i data-lucide="chevron-right" style="width:14px;height:14px"></i></button></div>
      <a href="categories.php" class="btn btn-outline-secondary btn-sm rounded-pill carousel-view d-none d-sm-inline-flex">View all <i data-lucide="arrow-right" class="ms-1"></i></a>
    </div>
  </div>
  <div class="swiper digitalOffsetSwiper mt-1"><div class="swiper-wrapper">
    <?php echo $prodCards(get_products_by_cats([3,6,8])); ?>
    </div>
    <!-- <div class="swiper-pagination digitalOffset-pagination mt-3"></div> -->
  </div>
</div>

<!-- Category highlight: Personalized Gifts -->
<div class="container-1280 mt-5">
  <div class="d-flex align-items-end justify-content-between">
    <div><h2 class="display fw-bold mb-1" style="font-size:22px">Personalized Gifts</h2><p class="small  text-primary  mb-0">Photo Frame • Mug Print • Gift</p></div>
    <div class="d-flex align-items-center gap-2">
      <div class="d-flex gap-2"><button class="homeDecor-prev btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Previous"><i data-lucide="chevron-left" style="width:14px;height:14px"></i></button><button class="homeDecor-next btn btn-light rounded-circle border carousel-nav d-flex align-items-center justify-content-center p-0" style="width:36px;height:36px" aria-label="Next"><i data-lucide="chevron-right" style="width:14px;height:14px"></i></button></div>
      <a href="categories.php" class="btn btn-outline-secondary btn-sm rounded-pill carousel-view d-none d-sm-inline-flex">View all <i data-lucide="arrow-right" class="ms-1"></i></a>
    </div>
  </div>
  <div class="swiper homeDecorSwiper mt-1"><div class="swiper-wrapper">
    <?php echo $prodCards(get_products_by_cats([13,14,18])); ?>
    
  </div>
  <!-- <div class="swiper-pagination homeDecor-pagination mt-3"></div> -->
</div>
</div>



<!-- Store locator — premium -->
<div class="container-1280 mt-6">
  <div class="store-locator rounded-24 overflow-hidden">
    <div class="row g-0">
      <div class="col-lg-6 p-4 p-sm-5 d-flex flex-column justify-content-center">
        <span class="badge rounded-pill d-inline-flex align-items-center gap-2 align-self-start" style="background:var(--brandLight);color:var(--brand);font-size:9px;letter-spacing:.16em"><i data-lucide="map-pin" style="width:12px;height:12px"></i> BHUBANESWAR • ODISHA</span>
        <h3 class="display fw-bold mt-3 text-white" style="font-size:24px;line-height:1.15">Visit a Google Mart store<br><span style="color:#fff200">near you</span></h3>
        <p class="small mt-2" style="font-size:13px;color:#d4c4ea;max-width:40ch">Walk in with a file, walk out with prints. Same-day is real at our stores — with free design help on site.</p>
        <div class="d-flex flex-wrap gap-2 mt-4">
          <span class="store-chip"><i data-lucide="store" style="width:13px;height:13px"></i> Falcon Residency, Patia</span>
          <span class="store-chip"><i data-lucide="clock-3" style="width:13px;height:13px"></i> Mon–Sat: 9 AM – 8 PM</span>
          <span class="store-chip"><i data-lucide="star" style="width:13px;height:13px;fill:#fff200;color:#fff200"></i> 4.8 ★ (642)</span>
        </div>
        <div class="d-flex flex-wrap gap-3 mt-4">
          <a href="https://www.google.com/maps/search/?api=1&query=Falcon+Residency+Patia+Bhubaneswar+Odisha" target="_blank" rel="noopener" class="btn btn-light rounded-pill px-4 fw-bold" style="color:var(--brand);font-size:12px">Get Directions <i data-lucide="navigation" style="width:14px;height:14px"></i></a>
          <a href="tel:+917008432909" class="btn btn-outline-light rounded-pill px-4 fw-bold" style="font-size:12px"><i data-lucide="phone" style="width:14px;height:14px"></i> Call Store</a>
        </div>
        <div class="small mt-4 d-flex gap-2 align-items-center" style="font-size:12px;color:#b9a6d6"><i data-lucide="clock" style="width:14px;height:14px"></i> Open Mon–Sat 9 AM–8 PM • Design help available</div>
      </div>
      <div class="col-lg-6 position-relative" style="min-height:320px">
        <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=900&q=80" class="position-absolute top-0 start-0 w-100 h-100 object-cover" onerror="this.style.display='none'">
        <div class="store-map-overlay"></div>
        <div class="position-absolute bottom-0 start-0 end-0 m-3 bg-white rounded-4 p-3 d-flex gap-3 align-items-center shadow-soft border">
          <span class="rounded-3 text-white d-flex justify-content-center align-items-center flex-shrink-0" style="width:40px;height:40px;background:var(--brand)"><i data-lucide="navigation" style="width:18px;height:18px"></i></span>
          <span class="small"><span class="fw-bold d-block" style="font-size:12px">Google Mart — Patia, Bhubaneswar</span><span class="text-secondary" style="font-size:12px">Open now • Mon–Sat</span></span>
          <a href="https://maps.google.com/?q=Falcon+Residency+Patia+Bhubaneswar" target="_blank" rel="noopener" class="btn btn-dark btn-sm rounded-pill ms-auto">Directions</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . "/includes/footer.php"; ?>
