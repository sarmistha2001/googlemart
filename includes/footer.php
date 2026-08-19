<?php
/** Google Mart common footer — uses $S settings + db helpers. */
if (!function_exists('db')) { require_once __DIR__ . '/db.php'; }
if (!isset($S)) { $S = get_settings(); }
$siteName = $S['site_name'] ?? 'Google Mart';
$addr = $S['address'] ?? 'Falcon Residency, Patia, Bhubaneswar, Odisha 751024';
$phone1 = $S['phone_1'] ?? '+91 70084 32909';
$phone2 = $S['phone_2'] ?? '+91 82808 00757';
$email = $S['email'] ?? 'googlemart@gmail.com';
$hours = $S['working_hours'] ?? 'Mon – Sat: 9 AM – 8 PM';
$copyright = $S['copyright_text'] ?? '© 2026 Google Mart';
$credit = $S['footer_credit'] ?? 'Drafticode';
?>
<style>
  .footer-premium a,
  .footer-premium a:hover,
  .footer-premium a:focus,
  .footer-premium a:visited {
    text-decoration: none !important;
  }
</style>
<footer class="footer-premium text-white-50">
  <div class="footer-glow"></div>
  <div class="container-1280">
    <div class="row g-4 g-lg-5 py-5">
      <div class="col-12 col-lg-5">
        <div class="d-flex gap-3 align-items-center text-white">
          <img src="assets/images/logo.jpeg" alt="<?= e($siteName) ?>" class="brand-logo" style="height:64px;width:auto;background:#fff;border-radius:12px;padding:6px;box-shadow:0 8px 24px rgba(0,0,0,.35)">
          <div>
            <span class="display fw-bold fs-4 text-white d-block"><?= e($siteName) ?></span>
            <span class="small" style="color:#a78bfa;letter-spacing:.18em;font-size:10px">PRINT • GIFT • GROW</span>
          </div>
        </div>
        <p class="small mt-3" style="max-width:38ch;line-height:1.7">India's favourite print &amp; gifting brand. Premium quality, fair pricing, delivered fast.</p>
        <div class="d-flex gap-2 mt-3">
          <a href="#" class="social-btn rounded-circle d-flex justify-content-center align-items-center" style="width:36px;height:36px;background:rgba(255,255,255,.07)"><i class="bi bi-instagram" style="font-size:15px"></i></a>
          <a href="#" class="social-btn rounded-circle d-flex justify-content-center align-items-center" style="width:36px;height:36px;background:rgba(255,255,255,.07)"><i class="bi bi-facebook" style="font-size:15px"></i></a>
          <a href="#" class="social-btn rounded-circle d-flex justify-content-center align-items-center" style="width:36px;height:36px;background:rgba(255,255,255,.07)"><i class="bi bi-linkedin" style="font-size:15px"></i></a>
          <a href="#" class="social-btn rounded-circle d-flex justify-content-center align-items-center" style="width:36px;height:36px;background:rgba(255,255,255,.07)"><i class="bi bi-twitter-x" style="font-size:15px"></i></a>
        </div>
      </div>
      <div class="col-6 col-lg-2">
        <div class="small fw-bold text-white mb-3" style="font-size:13px">Products</div>
        <ul class="list-unstyled small d-flex flex-column gap-2">
          <li><a href="categories.php" class="footer-link-inline">All Products</a></li>
          <li><a href="category.php?slug=visiting-card" class="footer-link-inline">Visiting Cards</a></li>
          <li><a href="category.php?slug=t-shirt" class="footer-link-inline">Apparel</a></li>
          <li><a href="category.php?slug=mug-print" class="footer-link-inline">Photo Gifts</a></li>
          <li><a href="category.php?slug=office-art" class="footer-link-inline">Stationery</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-2">
        <div class="small fw-bold text-white mb-3" style="font-size:13px">Company</div>
        <ul class="list-unstyled small d-flex flex-column gap-2">
          <li><a href="about.php" class="footer-link-inline">About Us</a></li>
          <li><a href="contact.php" class="footer-link-inline">Contact Us</a></li>
          <li><a href="terms.php" class="footer-link-inline">Terms &amp; Conditions</a></li>
          <li><a href="privacy.php" class="footer-link-inline">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="col-12 col-lg-3">
        <div class="small fw-bold text-white mb-3" style="font-size:13px">Get in touch</div>
        <ul class="list-unstyled small d-flex flex-column gap-2">
          <li><i data-lucide="map-pin" class="fc-icon"></i><span><?= e($addr) ?></span></li>
          <li><i data-lucide="phone" class="fc-icon"></i><span><a href="tel:<?= e(preg_replace('/[^0-9]/','',$phone1)) ?>" class="footer-link-inline"><?= e($phone1) ?></a> &nbsp; <a href="tel:<?= e(preg_replace('/[^0-9]/','',$phone2)) ?>" class="footer-link-inline"><?= e($phone2) ?></a></span></li>
          <li><i data-lucide="mail" class="fc-icon"></i><a href="mailto:<?= e($email) ?>" class="footer-link-inline"><?= e($email) ?></a></li>
          <li><i data-lucide="clock" class="fc-icon"></i><span><?= e($hours) ?></span></li>
        </ul>
      </div>
    </div>
    <div class="border-top py-3 d-flex flex-wrap gap-2 justify-content-between small" style="border-color:rgba(255,255,255,.08)!important;font-size:11px">
      <span><?= e($copyright) ?> • <?= e($credit) ?></span>
      <span class="d-flex gap-3"><a href="privacy.php" class="footer-link-inline">Privacy</a><a href="terms.php" class="footer-link-inline">Terms</a><a href="#" class="footer-link-inline">Sitemap</a></span>
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="assets/js/script.js"></script>
<script>lucide.createIcons()</script>
</body>
</html>
