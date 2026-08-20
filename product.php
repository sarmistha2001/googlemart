<?php
require_once __DIR__ . "/includes/db.php";
$S = get_settings();
$announce = $S["announcement_text"] ?? "";
$slug = $_GET["slug"] ?? "classic-visiting-cards-matte-350-gsm";
$P = get_product_by_slug($slug);
if (!$P) { $P = db()->query("SELECT * FROM products WHERE is_active=1 ORDER BY id LIMIT 1")->fetch(); }
$P["gallery"] = get_product_images((int)$P["id"]);
$P["related"] = get_related_by_category((int)$P["category_id"], (int)$P["id"], 8);
$wa = $S["whatsapp"] ?? "917008432909";
?>
<?php include __DIR__ . "/includes/header.php"; ?>
<div class="page-hero">
  <div class="container-1280">

    <h1 class="display fw-bold mt-3 page-hero-title"><?= e($P["name"]) ?></h1>

    <nav class="crumb premium-crumb small" aria-label="breadcrumb">
      <a href="index.php"><i data-lucide="home" style="width:12px;height:12px"></i> <span class="crumb-label">Home</span></a>
      <span class="sep"><i data-lucide="chevron-right" style="width:12px;height:12px"></i></span>
      <a href="categories.php">Categories</a>
      <span class="sep"><i data-lucide="chevron-right" style="width:12px;height:12px"></i></span>
      <a href="category.php?slug=<?= urlencode($P["cat_slug"]) ?>"><?= e($P["cat_name"]) ?></a>
      <span class="sep"><i data-lucide="chevron-right" style="width:12px;height:12px"></i></span>
      <span class="current"><?= e($P["name"]) ?></span>
    </nav>

  </div>
</div>

<style>
.page-hero-title {
  font-size: 34px;
  line-height: 1.2;
  word-break: break-word;
}

.premium-crumb {
  display: flex;
  align-items: center;
  gap: 6px;
  flex-wrap: nowrap;
  overflow-x: auto;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
  padding-bottom: 4px;
}
.premium-crumb::-webkit-scrollbar { display: none; }

.premium-crumb a,
.premium-crumb .current {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  flex-shrink: 0;
}

.premium-crumb .current {
  max-width: 55vw;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.premium-crumb .sep {
  flex-shrink: 0;
  opacity: .6;
}

@media (max-width: 576px) {
  .page-hero-title {
    font-size: 22px;
    line-height: 1.3;
  }

  .premium-crumb {
    font-size: 11px;
    gap: 4px;
  }

  .premium-crumb .crumb-label {
    display: none; /* show only the home icon on very small screens to save space */
  }

  .premium-crumb a {
    padding: 2px 0;
  }
}

@media (min-width: 577px) and (max-width: 767px) {
  .page-hero-title {
    font-size: 26px;
  }
}
</style>
  
<div class="container-1280 mt-5">
  <div class="row g-4">
    <div class="col-lg-6">
      <div class="bg-white border rounded-24 shadow-soft p-3">
        <div class="rounded-4 overflow-hidden bg-light position-relative" style="aspect-ratio:4/3">
          <img id="mainImg" loading="lazy" src="<?= e($P["main_image"]) ?>" class="w-100 h-100 object-cover" style="cursor:zoom-in" onclick="openZoom(this.src)" onerror="this.style.display='none'">
          
          <button type="button" class="btn btn-light btn-sm rounded-circle position-absolute bottom-0 end-0 m-3 d-flex justify-content-center align-items-center p-0" style="width:32px;height:32px" onclick="openZoom(document.getElementById('mainImg').src)" aria-label="Zoom"><i data-lucide="expand" style="width:16px;height:16px"></i></button>
        </div>
        <div class="row g-2 mt-3 row-cols-4">
          <?php $imgs = array_merge([$P['main_image']], $P['gallery']); ?>
          <?php foreach (array_slice($imgs, 0, 3) as $k => $img): ?>
          <div class="col"><button type="button" onclick="setMainImg(this)" data-img="<?= e($img) ?>" class="thumb-btn <?= $k===0 ? 'active' : '' ?> p-0 w-100 border overflow-hidden rounded-4" ><img loading="lazy" decoding="async" onerror="this.style.display='none'" src="<?= e($img) ?>" class="w-100 object-cover" style="aspect-ratio:4/3"></button></div>
          <?php endforeach; ?>
          <div class="col"><button type="button" class="btn btn-dark w-100 h-100 rounded-4 small fw-bold" style="aspect-ratio:4/3" data-bs-toggle="modal" data-bs-target="#galleryModal">+<?= max(0, count($imgs)-3) ?><br><span class="small opacity-75">photos</span></button></div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="bg-white border rounded-24 shadow-soft p-4 p-sm-5">
        <div class="d-flex justify-content-between gap-3 align-items-start">
          <div>
            <span class="badge rounded-pill" style="background:var(--brandLight);color:var(--brand)"><?= e($P["cat_name"]) ?></span>
            <h1 class="display fw-bold mt-3" style="font-size:26px;line-height:1.15"><?= e($P["name"]) ?></h1>
          </div>
          
        </div>
        <div class="small text-secondary mt-3" style="line-height:1.8; height:220px"><p class="mb-0"><?= nl2br(e($P["description"] ?: "Premium quality product from Google Mart.")) ?></p></div>
        <div class="d-flex gap-2 mt-4"><button type="button" class="btn btn-brand rounded-pill flex-grow-1 fw-bold d-flex align-items-center justify-content-center gap-1" style="height:48px;font-size:13px" data-bs-toggle="modal" data-bs-target="#enquiryModal"><i class="bi bi-whatsapp" style="font-size:18px"></i> Enquiry Now</button><a href="tel:+<?= e($S["phone_1"] ?? '917008432909') ?>" class="btn btn-dark rounded-pill fw-bold d-flex align-items-center justify-content-center gap-1" style="height:48px;padding:0 24px;font-size:12px"><i data-lucide="phone" style="width:14px;height:14px"></i> Call Now</a></div>
        
      </div>

    <div class="row g-3 mt-1 row-cols-3">
    <div class="col">
        <div class="bg-white border rounded-4 p-3 shadow-soft h-100">
            <div class="small text-secondary" style="letter-spacing:.08em;font-size:9px">
                PRINT QUALITY
            </div>
            <div class="small fw-bold mt-1">
                Sharp, vibrant & high-resolution
            </div>
        </div>
    </div>

   <div class="col">
    <div class="bg-white border rounded-4 p-3 shadow-soft h-100">
        <div class="small text-secondary" style="letter-spacing:.08em;font-size:9px">
            PAPER OPTIONS
        </div>
        <div class="small fw-bold mt-1 text-success">
            Multiple GSM & finishes
        </div>
    </div>
</div>

    <div class="col">
        <div class="rounded-4 p-3 text-white h-100" style="background:var(--brand)">
            <div class="small opacity-75" style="letter-spacing:.08em;font-size:9px">
                SERVICE
            </div>
            <div class="small fw-bold mt-1">
                Design support & file checking
            </div>
        </div>
    </div>
</div>
    </div>
    
  </div>
  <div class="mt-5">
  <div class="d-flex align-items-end justify-content-between">
    <div>
      <h2 class="display fw-bold mb-1" style="font-size:22px">
        Related Products
      </h2>
      <p class="small text-secondary mb-0">
        You may also like these
      </p>
    </div>

    <a href="category.php"
       class="btn btn-outline-secondary btn-sm rounded-pill carousel-view d-none d-sm-inline-flex">
      View all
      <i data-lucide="arrow-right" class="ms-1"></i>
    </a>
  </div>

  <!-- Related Products Swiper -->
  <div class="swiper relatedSwiper mt-3" style="padding-bottom:25px;">

    <div class="swiper-wrapper">

      <?php foreach ($P['related'] as $r): ?>

        <div class="swiper-slide">

          <a href="product.php?slug=<?= urlencode($r['slug']) ?>"
             class="card h-100 shadow-soft text-decoration-none p-2">

            <img
              loading="lazy"
              src="<?= e($r['main_image']) ?>"
              class="rounded-4 object-cover w-100"
              style="aspect-ratio:1/1; object-fit:cover;"
              alt="<?= e($r['name']) ?>"
              onerror="this.style.display='none'">

            <div class="card-body p-2">
              <div class="small fw-semibold text-dark">
                <?= e($r['name']) ?>
              </div>
            </div>

          </a>

        </div>

      <?php endforeach; ?>

      <?php if (!$P['related']): ?>

        <div class="text-center text-secondary py-4">
          Related products coming soon.
        </div>

      <?php endif; ?>

    </div>

    <div class="swiper-pagination related-pagination"></div>

  </div>
</div>
</div>

<!-- Photo Zoom Modal -->
<div class="modal fade" id="photoZoomModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content bg-dark border-0"><div class="modal-body p-0 position-relative"><img id="zoomImg" src="" class="w-100 object-cover" style="max-height:80vh"><button type="button" class="btn btn-light rounded-circle position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"><i data-lucide="x" style="width:16px;height:16px"></i></button></div></div></div></div>

<!-- Gallery Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title display fw-bold" style="font-size:16px">All Photos</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="row g-2 row-cols-2 row-cols-md-3">
        <?php foreach (array_merge([$P['main_image']], $P['gallery']) as $img): ?>
        <div class="col"><img src="<?= e($img) ?>" class="gallery-thumb w-100 rounded-4 object-cover" style="aspect-ratio:4/3;cursor:pointer" onclick="pickFromGallery(this)"></div>
        <?php endforeach; ?>
      </div></div></div></div></div></div>
<!-- Enquiry Modal -->
<div class="modal fade" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 overflow-hidden" style="border:none">
      <div class="modal-header text-white border-0" style="background:linear-gradient(120deg,#e4007c,#b30064)">
        <div>
          <h5 class="modal-title fw-bold" id="enquiryModalLabel">Product Enquiry</h5>
          <p class="small mb-0" style="color:#fbdbe9;font-size:11px">We usually reply within 15 minutes</p>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="d-flex gap-3 align-items-center bg-light rounded-4 p-3 mb-4">
          <img id="enqImg" src="<?= e($P["main_image"]) ?>" alt="Product" class="rounded-3 object-cover" style="width:72px;height:72px">
          <div>
            <div class="small fw-bold" id="enqCategory"><?= e($P["cat_name"]) ?></div>
            <div class="fw-bold" id="enqName"><?= e($P["name"]) ?></div>
          </div>
        </div>
        <form id="enquiryForm" onsubmit="return submitEnquiry(event)">
          <div class="mb-3"><label class="form-label small fw-semibold">Name</label><input type="text" id="enqNameInput" class="form-control contact-form-control" placeholder="Your full name" required></div>
          <div class="mb-3"><label class="form-label small fw-semibold">Phone Number</label><input type="tel" id="enqPhoneInput" class="form-control contact-form-control" placeholder="+91 98765 43210" required></div>
          <div class="mb-3"><label class="form-label small fw-semibold">Email</label><input type="email" id="enqEmailInput" class="form-control contact-form-control" placeholder="you@example.com"></div>
          <div class="mb-4"><label class="form-label small fw-semibold">Message</label><textarea id="enqMsgInput" class="form-control contact-form-control" rows="3" placeholder="Tell us what you need…" required></textarea></div>
          <button type="submit" class="btn btn-brand rounded-pill w-100 fw-bold" style="height:46px;font-size:14px"><i class="bi bi-whatsapp me-1"></i> Send Enquiry</button>
          <div id="enqError" class="small text-danger text-center mt-2 d-none">Please fill the required fields.</div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// WhatsApp number to receive enquiries — falls back to the fixed number if $wa isn't set in PHP
const ENQUIRY_WHATSAPP_NUMBER = "<?= e(preg_replace('/[^0-9]/', '', $wa ?? '917008432909')) ?>";

function submitEnquiry(evt) {
  evt.preventDefault();

  const nameEl = document.getElementById('enqNameInput');
  const phoneEl = document.getElementById('enqPhoneInput');
  const emailEl = document.getElementById('enqEmailInput');
  const msgEl = document.getElementById('enqMsgInput');
  const errorEl = document.getElementById('enqError');

  const name = nameEl.value.trim();
  const phone = phoneEl.value.trim();
  const email = emailEl.value.trim();
  const message = msgEl.value.trim();

  // Required fields: name, phone, message (email is optional, matches the form's `required` attrs)
  if (!name || !phone || !message) {
    errorEl.classList.remove('d-none');
    return false;
  }
  errorEl.classList.add('d-none');

  const productName = document.getElementById('enqName')?.textContent?.trim() || '';
  const productCategory = document.getElementById('enqCategory')?.textContent?.trim() || '';

  const pageLink = window.location.href;

  const lines = [
    "Hello Google Mart, I'd like to enquire about a product:",
    "",
    "Product:" + productName,
    "Category:" + productCategory,
    "Link:" + pageLink,
    "",
    "Name: " + name,
    "Phone: " + phone,
  ];
  if (email) lines.push("Email:" + email);
  lines.push("", "Message: " + message);

  const text = encodeURIComponent(lines.join("\n"));
  const waUrl = "https://wa.me/" + ENQUIRY_WHATSAPP_NUMBER + "?text=" + text;

  window.open(waUrl, "_blank", "noopener");

  const modalEl = document.getElementById('enquiryModal');
  const modal = bootstrap.Modal.getInstance(modalEl);
  if (modal) modal.hide();

  evt.target.reset();

  return false;
}
</script>
<?php include __DIR__ . "/includes/footer.php"; ?>
