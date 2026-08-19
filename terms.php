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
      <span class="current">Terms &amp; Conditions</span>
    </nav>
    <h1 class="display fw-bold" style="font-size:34px">Terms &amp; Conditions</h1>
    <p class="lead mt-2" style="font-size:14px">Last updated: 14 August 2026</p>
  </div>
</div>

<!-- Policy content -->
<div class="page-section">
  <div class="container-1280">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="page-card policy-body">
          <h4>1. Acceptance of Terms</h4>
          <p>By accessing or using the Google Mart website, you agree to be bound by these Terms &amp; Conditions, our Privacy Policy, and all applicable laws. If you do not agree with any part of these terms, please do not use our services.</p>

          <h4>2. Services</h4>
          <p>Google Mart provides printing, personalisation, gifting and related services as described on our website. Product images and descriptions are for reference; final output may vary slightly based on material and print quality.</p>

          <h4>3. Orders &amp; Pricing</h4>
          <ul>
            <li>All prices are in Indian Rupees (₹) and inclusive of applicable taxes unless stated otherwise.</li>
            <li>Orders are confirmed once payment or approval is received. We may contact you to verify details before processing.</li>
            <li>Bulk and corporate pricing is custom-quoted and valid for the period mentioned in the quote.</li>
          </ul>

          <h4>4. User Responsibilities</h4>
          <p>You are responsible for providing accurate artwork, contact details and delivery information. You must ensure you own the rights to any content you ask us to print. Google Mart is not liable for copyright infringement arising from user-supplied content.</p>

          <h4>5. Design &amp; Proofing</h4>
          <p>For custom print jobs, a proof may be shared for approval. Once approved, changes may incur additional charges. We recommend carefully reviewing proofs — including spelling, colours and dimensions — before approval.</p>

          <h4>6. Shipping &amp; Delivery</h4>
          <ul>
            <li>Same-day delivery is available in select cities and depends on order time and product type.</li>
            <li>Standard delivery typically reaches 15,000+ pin codes within 2–3 business days.</li>
            <li>Delivery timelines are estimates and may be affected by weather, courier delays or incomplete addresses.</li>
          </ul>

          <h4>7. Returns &amp; Refunds</h4>
          <p>If you receive a defective or incorrect product, notify us within 48 hours of delivery with a photo. We will reprint or refund at our discretion. Custom/personalised products are non-returnable unless defective, due to their bespoke nature.</p>

          <h4>8. Limitation of Liability</h4>
          <p>To the maximum extent permitted by law, Google Mart's total liability for any claim arising from your use of our services shall not exceed the amount paid by you for the specific order.</p>

          <h4>9. Changes to Terms</h4>
          <p>We may update these terms from time to time. The latest version will always be available on this page, and continued use of our services constitutes acceptance of the updated terms.</p>

          <h4>10. Contact</h4>
          <p>For any questions about these terms, contact us at <a href="mailto:googlemart@gmail.com" style="color:var(--brand);font-weight:700">googlemart@gmail.com</a> or call <a href="tel:+917008432909" style="color:var(--brand);font-weight:700">+91 70084 32909</a> / <a href="tel:+918280800757" style="color:var(--brand);font-weight:700">+91 82808 00757</a>.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include __DIR__ . "/includes/footer.php"; ?>
