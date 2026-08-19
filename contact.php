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
      <span class="current">Contact Us</span>
    </nav>
    <h1 class="display fw-bold mt-3" style="font-size:34px">Contact Us</h1>
    <p class="lead mt-2" style="font-size:14px">Questions, bulk quotes or design help — we're one message away.</p>
  </div>
</div>

<!-- Section intro -->
<div class="page-section">
  <div class="container-1280 text-center">
    <span class="badge rounded-pill d-inline-flex align-items-center gap-2" style="background:var(--brandLight);color:var(--brand);font-size:9px;letter-spacing:.16em"><i data-lucide="messages-square" style="width:12px;height:12px"></i> WE'RE HERE TO HELP</span>
    <h2 class="display fw-bold mt-3 mx-auto" style="font-size:32px;max-width:35ch">Let's talk about your next <span style="color:var(--brand)">print or gift</span></h2>
    <p class="text-secondary mx-auto mt-3" style="font-size:14px;line-height:1.8;max-width:64ch">Whether you need a quick quote, design help, a bulk corporate order or simply want to know more about our services — our friendly team is ready to assist. Reach out through any channel below and we'll get back to you within 24 hours.</p>
  </div>
</div>

<!-- Contact information + form -->
<div class="page-section">
  <div class="container-1280">
    <div class="row g-4 g-lg-5">
      <!-- Left: contact information -->
      <div class="col-lg-5">
        <div class="page-card h-100">
          <span class="badge rounded-pill d-inline-flex align-items-center gap-2" style="background:var(--brandLight);color:var(--brand);font-size:9px;letter-spacing:.16em"><i data-lucide="contact" style="width:12px;height:12px"></i> CONTACT INFORMATION</span>
          <h2 class="display fw-bold mt-3" style="font-size:26px">Let's start a conversation</h2>
          <p class="text-secondary mt-2" style="font-size:13px;line-height:1.7">Reach out for orders, bulk quotes, design help or anything else — our team responds within 24 hours.</p>
          <div class="d-flex flex-column gap-3 mt-4">
            <div class="d-flex gap-3 align-items-start"><span class="contact-icon"><i data-lucide="map-pin" style="width:20px;height:20px"></i></span><div><div class="fw-bold" style="font-size:13px">Address</div><div class="text-secondary" style="font-size:13px">Falcon Residency, Patia, Bhubaneswar, Odisha 751024</div></div></div>
            <div class="d-flex gap-3 align-items-start"><span class="contact-icon"><i data-lucide="phone" style="width:20px;height:20px"></i></span><div><div class="fw-bold" style="font-size:13px">Phone</div><div><a href="tel:+917008432909" class="d-block text-decoration-none" style="color:var(--brand);font-weight:700;font-size:13px">+91 70084 32909</a><a href="tel:+918280800757" class="d-block text-decoration-none" style="color:var(--brand);font-weight:700;font-size:13px">+91 82808 00757</a></div></div></div>
            <div class="d-flex gap-3 align-items-start"><span class="contact-icon"><i data-lucide="mail" style="width:20px;height:20px"></i></span><div><div class="fw-bold" style="font-size:13px">Email</div><a href="mailto:googlemart@gmail.com" class="text-decoration-none" style="color:var(--brand);font-weight:700;font-size:13px">googlemart@gmail.com</a></div></div>
            <div class="d-flex gap-3 align-items-start"><span class="contact-icon"><i data-lucide="clock" style="width:20px;height:20px"></i></span><div><div class="fw-bold" style="font-size:13px">Working Hours</div><div class="text-secondary" style="font-size:13px">Mon – Sat: 9 AM – 8 PM</div></div></div>
          </div>
          <div class="d-flex gap-4 mt-4">
            <a class="social-btn-light" href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a class="social-btn-light" href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a class="social-btn-light" href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
            <a class="social-btn-light" href="#" aria-label="X"><i class="bi bi-twitter-x"></i></a>
            <a class="social-btn-light" href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
          </div>
          <div class="d-flex flex-wrap gap-2 mt-4 pt-3" style="border-top:1px solid #f1f5f9">
            <a href="tel:+917008432909" class="btn btn-brand rounded-pill px-3 fw-bold d-inline-flex align-items-center justify-content-center gap-1" style="font-size:12px;height:38px"><i data-lucide="phone" style="width:14px;height:14px"></i> Call Now</a>
            <a href="https://wa.me/917008432909" target="_blank" rel="noopener" class="btn btn-outline-success rounded-pill px-3 fw-bold d-inline-flex align-items-center justify-content-center gap-1" style="font-size:12px;height:38px"><i class="bi bi-whatsapp"></i> WhatsApp</a>
          </div>
        </div>
      </div>
      <!-- Right: form card -->
      <div class="col-lg-7">
        <div class="page-card h-100">
          <span class="badge rounded-pill d-inline-flex align-items-center gap-2" style="background:var(--brandLight);color:var(--brand);font-size:9px;letter-spacing:.16em">GET IN TOUCH</span>
          <h3 class="display fw-bold mt-2 mb-1" style="font-size:22px">Send Us a Message</h3>
          <p class="small text-secondary mb-4" style="font-size:12px">Fill in the form and we'll get back to you within 24 hours.</p>
          <form class="contact-form" onsubmit="alert('Thank you! Your message has been sent. We will get back to you shortly.');return false">
            <div class="row g-3">
              <div class="col-md-6"><label class="form-label small fw-semibold">Name</label><input type="text" class="form-control" placeholder="Your full name" required></div>
              <div class="col-md-6"><label class="form-label small fw-semibold">Email</label><input type="email" class="form-control" placeholder="you@example.com" required></div>
              <div class="col-md-6"><label class="form-label small fw-semibold">Phone</label><input type="tel" class="form-control" placeholder="+91 70084 32909"></div>
              <div class="col-md-6"><label class="form-label small fw-semibold">Subject</label><select class="form-select"><option>General enquiry</option><option>Bulk / corporate order</option><option>Design help</option><option>Order status</option></select></div>
              <div class="col-12"><label class="form-label small fw-semibold">Message</label><textarea class="form-control" rows="5" placeholder="Tell us what you need…" required></textarea></div>
              <div class="col-12 d-flex flex-wrap gap-2 align-items-center">
                <button type="submit" class="btn btn-brand rounded-pill px-4 fw-bold d-inline-flex align-items-center justify-content-center gap-1" style="font-size:13px;height:44px">Send Message <i data-lucide="send" style="width:14px;height:14px"></i></button>
                <a href="https://wa.me/917008432909" target="_blank" rel="noopener" class="btn btn-outline-secondary rounded-pill px-4 fw-bold d-inline-flex align-items-center justify-content-center gap-1" style="font-size:13px;height:44px"><i class="bi bi-whatsapp"></i> WhatsApp Us</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Map -->
<div class="page-section">
  <div class="container-1280">
    <div class="text-center mb-4">
      <span class="badge rounded-pill" style="background:var(--brandLight);color:var(--brand);font-size:9px;letter-spacing:.16em">FIND US</span>
      <h2 class="display fw-bold mt-2" style="font-size:26px">Visit our office for in-person meetings &amp; consultations</h2>
    </div>
    <div class="map-frame">
      <iframe title="Google Mart location map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3740.7149716821327!2d85.821917!3d20.353390299999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a19093deda105c3%3A0xe93278806172db7!2sGoogle%20Mart!5e0!3m2!1sen!2sin!4v1786703141310!5m2!1sen!2sin" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include __DIR__ . "/includes/footer.php"; ?>
