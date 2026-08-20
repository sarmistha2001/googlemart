<?php
require_once __DIR__ . '/config.php';

$current = basename($_SERVER['SCRIPT_NAME']);
$nav = [
    'index.php'      => ['Dashboard', 'speedometer2'],
    'categories.php' => ['Categories', 'folder'],
    'products.php'   => ['Products', 'box'],
    'settings.php'   => ['Settings', 'gear'],
    'users.php'      => ['Users', 'person'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($page_title ?? 'Admin') ?> — Google Mart Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<!-- Favicon -->
<link rel="icon" type="image/jpeg" href="../assets/images/logo.jpeg">
<style>
  :root{--brand:#700895;--brand-dark:#5a0678;--brand-light:#f5f0ff;--bg:#f4f5fa}
  body{background:var(--bg);font-family:Inter,system-ui,-apple-system,sans-serif}
  .app{display:flex;min-height:100vh}
  .sidebar{width:236px;background:#1a1038;background:linear-gradient(180deg,#241550,#160c2e);color:#cfcbe8;display:flex;flex-direction:column;position:sticky;top:0;height:100vh;flex-shrink:0}
  .sidebar .brand{color:#fff;font-weight:800;padding:1.25rem 1.4rem;border-bottom:1px solid rgba(255,255,255,.08);letter-spacing:-.01em}
  .sidebar .brand small{display:block;font-weight:500;font-size:.72rem;color:#8d88b5;letter-spacing:.04em}
  .sidebar nav{padding:.9rem .75rem;flex-grow:1}
  .sidebar a.nav-link{color:#b7b2d8;display:flex;align-items:center;gap:.65rem;padding:.6rem .85rem;border-radius:.6rem;font-size:.92rem;font-weight:500;margin-bottom:.15rem;text-decoration:none;transition:.15s}
  .sidebar a.nav-link i{font-size:1.05rem;width:1.2rem;text-align:center}
  .sidebar a.nav-link:hover{background:rgba(255,255,255,.07);color:#fff}
  .sidebar a.nav-link.active{background:var(--brand);color:#fff;box-shadow:0 6px 18px rgba(112,8,149,.35)}
  .sidebar .side-foot{padding:1rem;border-top:1px solid rgba(255,255,255,.08)}
  .main{flex:1;min-width:0;display:flex;flex-direction:column}
  .topbar{background:#fff;border-bottom:1px solid #eceef4;padding:.85rem 1.6rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:900}
  .topbar h1{font-size:1.15rem;font-weight:700;margin:0;color:#1e1b4b}
  .content{padding:1.6rem;flex:1}
  .card{border:0;border-radius:.9rem;box-shadow:0 1px 3px rgba(20,10,60,.06);border:1px solid #eef0f6}
  .card .card-title{font-weight:700;color:#1e1b4b}
  .table thead th{font-size:.74rem;text-transform:uppercase;letter-spacing:.05em;color:#8a87a8;font-weight:700;background:#fafbfe;border-bottom:1px solid #eceef4;padding:.7rem .9rem;white-space:nowrap}
  .table td{padding:.8rem .9rem;vertical-align:middle;border-color:#f1f3f8;font-size:.9rem}
  .table tbody tr:hover{background:#faf9ff}
  .thumb{width:52px;height:52px;object-fit:cover;border-radius:.6rem;border:1px solid #eceef4;background:#fff;cursor:zoom-in}
  .btn{border-radius:.55rem;font-weight:600}
  .btn-sm{font-size:.8rem}
  .badge{font-weight:600;border-radius:.4rem}
  .form-control,.form-select{border-radius:.6rem;font-size:.9rem;border-color:#e2e5ef}
  .form-control:focus,.form-select:focus{border-color:var(--brand);box-shadow:0 0 0 .2rem rgba(112,8,149,.12)}
  .label-sm{font-size:.76rem;font-weight:700;color:#4a4769;letter-spacing:.02em;text-transform:uppercase}
  .stat-card .icon{width:46px;height:46px;border-radius:.75rem;display:flex;align-items:center;justify-content:center;font-size:1.2rem}
  .pagination .page-link{border-radius:.45rem;margin:0 .12rem;color:var(--brand);font-size:.82rem;border-color:#e2e5ef}
  .pagination .page-item.active .page-link{background:var(--brand);border-color:var(--brand)}
  .img-preview-box{border:2px dashed #d9dceb;border-radius:.7rem;padding:.6rem;display:inline-block;background:#fafbff}
  .img-preview-box img{max-height:120px;border-radius:.4rem}
  .empty-state{text-align:center;padding:2.5rem 1rem;color:#9a97b5}
  .empty-state i{font-size:2.2rem;opacity:.4}
  /* image modal */
  .img-modal{position:fixed;inset:0;background:rgba(10,5,30,.75);display:none;align-items:center;justify-content:center;z-index:2000;cursor:zoom-out}
  .img-modal.show{display:flex}
  .img-modal img{max-width:90vw;max-height:88vh;border-radius:.6rem;box-shadow:0 20px 60px rgba(0,0,0,.5)}
</style>
</head>
<body>
<div class="app">
  <aside class="sidebar">
    <div class="brand">Google Mart
      <small>ADMIN PANEL</small>
    </div>
    <nav>
      <?php foreach ($nav as $file => $item): ?>
        <a class="nav-link <?= $current === $file ? 'active' : '' ?>" href="<?= $file ?>">
          <i class="bi bi-<?= $item[1] ?>"></i> <?= $item[0] ?>
        </a>
      <?php endforeach; ?>
    </nav>
    <div class="side-foot">
      <div class="d-flex align-items-center gap-2 mb-2">
        <span class="rounded-circle bg-white bg-opacity-10 text-white d-flex align-items-center justify-content-center" style="width:34px;height:34px;font-weight:700"><?= e(strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1))) ?></span>
        <div class="text-white small fw-semibold lh-1"><?= e($_SESSION['admin_username'] ?? 'admin') ?></div>
      </div>
      <a href="logout.php" class="btn btn-sm btn-outline-light w-100"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
    </div>
  </aside>
  <div class="main">
    <div class="topbar">
      <h1><?= e($page_title ?? 'Admin') ?></h1>
      <div class="d-flex align-items-center gap-2">
        <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-box-arrow-up-right me-1"></i>View site</a>
      </div>
    </div>
    <div class="content">
      <?php $f = get_flash(); if ($f): ?>
        <div class="alert alert-<?= $f['type'] === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show border-0 shadow-sm">
          <i class="bi bi-<?= $f['type'] === 'error' ? 'x-circle' : 'check-circle' ?> me-2"></i><?= e($f['msg']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
