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
      <span class="current">Privacy Policy</span>
    </nav>
    <h1 class="display fw-bold" style="font-size:34px">Privacy Policy</h1>
    <p class="lead mt-2" style="font-size:14px">Last updated: 14 August 2026</p>
  </div>
</div>

<!-- Policy content -->
<div class="page-section">
  <div class="container-1280">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="page-card policy-body">
          <h4>1. Introduction</h4>
          <p>Google Mart ("we", "us", "our") respects your privacy and is committed to protecting your personal information. This Privacy Policy explains what data we collect, how we use it, and the choices you have.</p>

          <h4>2. Information We Collect</h4>
          <ul>
            <li><strong>Contact details</strong> — name, phone number, email address, delivery address.</li>
            <li><strong>Order information</strong> — products ordered, quantities, artwork/files uploaded for printing.</li>
            <li><strong>Usage data</strong> — pages visited, device type, browser, and general analytics.</li>
          </ul>

          <h4>3. How We Use Your Information</h4>
          <ul>
            <li>To process and deliver your orders.</li>
            <li>To provide design support and respond to enquiries.</li>
            <li>To share offers, updates and design tips (only if you've opted in).</li>
            <li>To improve our website, services and customer experience.</li>
          </ul>

          <h4>4. Data Sharing</h4>
          <p>We never sell your personal data. We may share information with trusted partners — such as courier services and payment gateways — only as necessary to fulfil your order, under confidentiality obligations.</p>

          <h4>5. Payment Security</h4>
          <p>All payments are processed through secure, PCI-DSS compliant gateways. We do not store your card numbers or banking credentials on our servers.</p>

          <h4>6. Cookies</h4>
          <p>Our website uses cookies to remember your preferences and improve performance. You can disable cookies in your browser settings, though some features may not work as intended.</p>

          <h4>7. Data Retention</h4>
          <p>We retain your information only as long as needed to provide services, comply with legal obligations, and resolve disputes. You may request deletion of your data at any time.</p>

          <h4>8. Your Rights</h4>
          <ul>
            <li>Access and correct your personal information.</li>
            <li>Request deletion of your data.</li>
            <li>Opt out of marketing communications at any time.</li>
          </ul>

          <h4>9. Contact Us</h4>
          <p>For privacy-related questions, email <a href="mailto:googlemart@gmail.com" style="color:var(--brand);font-weight:700">googlemart@gmail.com</a> or call <a href="tel:+917008432909" style="color:var(--brand);font-weight:700">+91 70084 32909</a> / <a href="tel:+918280800757" style="color:var(--brand);font-weight:700">+91 82808 00757</a>.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include __DIR__ . "/includes/footer.php"; ?>
