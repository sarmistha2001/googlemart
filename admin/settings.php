<?php
require_once __DIR__ . '/config.php';
require_login();

$groups_meta = [
    'general' => ['General', 'globe2'],
    'contact' => ['Contact Details', 'telephone'],
    'social'  => ['Social Links', 'share'],
    'footer'  => ['Footer', 'file-earmark-text'],
];

// ---------- SAVE ALL KEY/VALUE SETTINGS ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    foreach (($_POST['settings'] ?? []) as $key => $value) {
        $stmt = db()->prepare('SELECT id FROM settings WHERE setting_key = ?');
        $stmt->execute([$key]);
        if ($stmt->fetchColumn()) {
            db()->prepare('UPDATE settings SET setting_value = ? WHERE setting_key = ?')->execute([(string)$value, $key]);
        } else {
            db()->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (?,?)')->execute([$key, (string)$value]);
        }
    }
    flash('success', 'Settings saved.');
    redirect('settings.php');
}

// ---------- LOGO UPLOAD ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_logo'])) {
    $stmt = db()->prepare('SELECT setting_value FROM settings WHERE setting_key = "site_logo"');
    $stmt->execute();
    $old = $stmt->fetchColumn() ?: null;

    if (!empty($_FILES['logo']['name'])) {
        $up = handle_upload($_FILES['logo'], $old);
        if ($up['ok']) {
            db()->prepare('UPDATE settings SET setting_value = ? WHERE setting_key = "site_logo"')->execute([$up['path']]);
            flash('success', 'Logo updated (old file removed).');
        } else {
            flash('error', 'Logo upload failed: ' . $up['error']);
        }
    }
    redirect('settings.php');
}

$rows = db()->query('SELECT * FROM settings ORDER BY group_name, setting_key')->fetchAll();
$grouped = [];
foreach ($rows as $r) {
    $grouped[$r['group_name']][] = $r;
}
$logo = null;
$stmt = db()->prepare('SELECT setting_value FROM settings WHERE setting_key = "site_logo"');
$stmt->execute();
$logo = $stmt->fetchColumn() ?: null;

$page_title = 'Settings';
require __DIR__ . '/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0 fw-bold">Site Settings</h4>
  <a href="index.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>
</div>

<div class="row g-4">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-center gap-2 mb-3"><i class="bi bi-image text-primary"></i>Site logo</div>
        <form method="post" enctype="multipart/form-data">
          <div class="img-preview-box mb-3">
            <?php if ($logo): ?><img src="<?= e(img_url($logo)) ?>" style="max-height:64px" alt=""><?php else: ?><span class="text-secondary small">No logo</span><?php endif; ?>
          </div>
          <input type="file" class="form-control preview-input" name="logo" accept="image/*" data-preview="#logoPreview">
          <div id="logoPreview" class="img-preview-box mt-2 d-none"><img src="" alt=""></div>
          <div class="form-text mb-2">New upload replaces the current logo file.</div>
          <button class="btn btn-primary btn-sm" name="save_logo" value="1"><i class="bi bi-upload me-1"></i>Upload logo</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-12">
    <form method="post">
      <?php foreach ($grouped as $group => $items): ?>
        <?php $meta = $groups_meta[$group] ?? [$group, 'tag']; ?>
        <div class="card mb-3">
          <div class="card-header bg-white fw-semibold d-flex align-items-center gap-2"><i class="bi bi-<?= $meta[1] ?> text-primary"></i><?= $meta[0] ?></div>
          <div class="card-body">
            <div class="row g-3">
              <?php foreach ($items as $s): ?>
                <div class="col-md-6">
                  <label class="label-sm mb-1"><?= e($s['setting_key']) ?></label>
                  <textarea class="form-control" name="settings[<?= e($s['setting_key']) ?>]" rows="<?= strlen((string)$s['setting_value']) > 60 ? 2 : 1 ?>"><?= e($s['setting_value']) ?></textarea>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <button class="btn btn-primary px-4" name="save_settings" value="1"><i class="bi bi-check-lg me-1"></i>Save all settings</button>
    </form>
  </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
