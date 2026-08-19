<?php
require_once __DIR__ . '/config.php';
require_login();

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

// ---------- DELETE ----------
if ($action === 'delete' && $id) {
    $stmt = db()->prepare('SELECT main_image FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $img = $stmt->fetchColumn();

    // delete gallery images (files + rows)
    $stmt = db()->prepare('SELECT image_url FROM product_images WHERE product_id = ?');
    $stmt->execute([$id]);
    foreach ($stmt->fetchAll() as $gi) {
        delete_upload($gi['image_url']);
    }
    db()->prepare('DELETE FROM product_images WHERE product_id = ?')->execute([$id]);

    db()->prepare('DELETE FROM products WHERE id = ?')->execute([$id]);
    delete_upload($img); // remove main image file
    flash('success', 'Product deleted (main + gallery image files removed).');
    redirect('products.php');
}

// ---------- DELETE single gallery image ----------
if ($action === 'delete_img' && isset($_GET['img_id']) && $id) {
    $stmt = db()->prepare('SELECT image_url FROM product_images WHERE id = ? AND product_id = ?');
    $stmt->execute([(int)$_GET['img_id'], $id]);
    $gi = $stmt->fetch();
    if ($gi) {
        db()->prepare('DELETE FROM product_images WHERE id = ?')->execute([(int)$_GET['img_id']]);
        delete_upload($gi['image_url']); // remove file from uploads folder
        flash('success', 'Gallery image deleted (file removed from uploads).');
    }
    redirect('products.php?action=edit&id=' . $id);
}

// ---------- SAVE ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $category_id = (int)($_POST['category_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $main_image = trim($_POST['main_image_url'] ?? '');
    $short_desc = trim($_POST['short_desc'] ?? '');
    $badge = trim($_POST['badge'] ?? '');
    $related_ids = trim($_POST['related_ids'] ?? '');
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_new = isset($_POST['is_new']) ? 1 : 0;
    $is_trending = isset($_POST['is_trending']) ? 1 : 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if ($category_id <= 0 || $name === '') {
        flash('error', 'Category and name are required.');
        redirect($id ? "products.php?action=edit&id=$id" : 'products.php?action=add');
    }
    if ($slug === '') {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
    }

    if ($id) {
        $stmt = db()->prepare('SELECT main_image FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $old_img = $stmt->fetchColumn() ?: null;
    } else {
        $old_img = null;
    }

    // uploaded file overrides main_image field
    if (!empty($_FILES['main_image']['name'])) {
        $up = handle_upload($_FILES['main_image'], $old_img);
        if ($up['ok']) {
            $main_image = $up['path'];
        } else {
            flash('error', 'Image upload failed: ' . $up['error']);
            redirect($id ? "products.php?action=edit&id=$id" : 'products.php?action=add');
        }
    }

    if ($id) {
        db()->prepare('UPDATE products SET category_id=?, name=?, slug=?, description=?, main_image=?, short_desc=?, badge=?, is_featured=?, is_new=?, is_trending=?, related_ids=?, is_active=? WHERE id=?')
            ->execute([$category_id, $name, $slug, $description, $main_image, $short_desc, $badge, $is_featured, $is_new, $is_trending, $related_ids, $is_active, $id]);
        $productId = $id;
        flash('success', 'Product updated.');
    } else {
        db()->prepare('INSERT INTO products (category_id, name, slug, description, main_image, short_desc, badge, is_featured, is_new, is_trending, related_ids, is_active) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)')
            ->execute([$category_id, $name, $slug, $description, $main_image, $short_desc, $badge, $is_featured, $is_new, $is_trending, $related_ids, $is_active]);
        $productId = (int)db()->lastInsertId();
        flash('success', 'Product added.');
    }

    // ---- Gallery / related images upload (multi) ----
    $files = $_FILES['gallery'] ?? null;
    if ($files && is_array($files['name'])) {
        $added = 0;
        $n = count($files['name']);
        for ($i = 0; $i < $n; $i++) {
            $one = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i],
            ];
            if ($one['error'] === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            $up = handle_upload($one);
            if ($up['ok']) {
                $max = (int)db()->query('SELECT COALESCE(MAX(sort_order),-1) FROM product_images WHERE product_id=' . $productId)->fetchColumn();
                db()->prepare('INSERT INTO product_images (product_id, image_url, sort_order) VALUES (?,?,?)')
                    ->execute([$productId, $up['path'], $max + 1]);
                $added++;
            }
        }
        if ($added) {
            flash('success', ($id ? 'Product updated.' : 'Product added.') . " $added gallery image(s) uploaded.");
        }
    }

    redirect('products.php');
}

// ---------- EDIT ----------
$row = null;
if ($action === 'edit' && $id) {
    $stmt = db()->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row) {
        flash('error', 'Product not found.');
        redirect('products.php');
    }
}

$cats = db()->query('SELECT id, name FROM categories ORDER BY sort_order, id')->fetchAll();

// ---------- LIST ----------
if ($action === 'list') {
    $base = 'SELECT p.*, c.name AS cat_name FROM products p LEFT JOIN categories c ON c.id=p.category_id';
    $pg = paginate(db(), $base, 10);
    $rows = db()->query($base . " ORDER BY p.id DESC LIMIT {$pg['limit']} OFFSET {$pg['offset']}")->fetchAll();
    $page_title = 'Products';
    require __DIR__ . '/header.php';
    ?>
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <div>
        <h4 class="mb-0 fw-bold">Products</h4>
        <span class="text-secondary small"><?= $pg['total'] ?> total • <?= $pg['limit'] ?> per page</span>
      </div>
      <a href="products.php?action=add" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Add Product</a>
    </div>
    <div class="card">
      <div class="table-responsive">
        <table class="table data mb-0 align-middle">
          <thead><tr><th>ID</th><th>Image</th><th>Name</th><th>Category</th><th>Badge</th><th>Flags</th><th class="text-center">Imgs</th><th class="text-end">Actions</th></tr></thead>
          <tbody>
          <?php if (!$rows): ?>
            <tr><td colspan="8"><div class="empty-state"><i class="bi bi-box"></i><div>No products yet. Click "Add Product" to create one.</div></div></td></tr>
          <?php endif; ?>
          <?php foreach ($rows as $r): ?>
            <?php $cnt = (int)db()->query('SELECT COUNT(*) FROM product_images WHERE product_id=' . (int)$r['id'])->fetchColumn(); ?>
            <tr>
              <td class="text-secondary">#<?= $r['id'] ?></td>
              <td><?php if ($r['main_image']): ?><img src="<?= e(img_url($r['main_image'])) ?>" class="thumb" alt=""><?php else: ?><span class="text-secondary">—</span><?php endif; ?></td>
              <td class="fw-semibold"><?= e($r['name']) ?><br><small class="text-secondary"><?= e($r['slug']) ?></small></td>
              <td><span class="badge bg-light text-dark border"><?= e($r['cat_name'] ?? '—') ?></span></td>
              <td><?= $r['badge'] ? '<span class="badge bg-dark">' . e($r['badge']) . '</span>' : '<span class="text-secondary">—</span>' ?></td>
              <td>
                <?php if ($r['is_featured']) echo '<span class="badge bg-warning-subtle text-warning-emphasis">Featured</span> '; ?>
                <?php if ($r['is_new']) echo '<span class="badge bg-info-subtle text-info-emphasis">New</span> '; ?>
                <?php if ($r['is_trending']) echo '<span class="badge bg-success-subtle text-success-emphasis">Trending</span> '; ?>
                <?php if (!$r['is_featured'] && !$r['is_new'] && !$r['is_trending']) echo '<span class="text-secondary">—</span>'; ?>
              </td>
              <td class="text-center"><span class="badge bg-light text-dark border"><?= $cnt ?></span></td>
              <td class="text-end text-nowrap">
                <a href="products.php?action=edit&id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                <a href="products.php?action=delete&id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this product? Main + gallery image files will be removed.')"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="small text-secondary">Showing <?= $pg['offset'] + 1 ?>–<?= min($pg['offset'] + $pg['limit'], $pg['total']) ?> of <?= $pg['total'] ?></span>
        <?php render_pagination($pg['page'], $pg['pages'], 'products.php'); ?>
      </div>
    </div>
    <?php
    require __DIR__ . '/footer.php';
    exit;
}

// ---------- FORM ----------
$page_title = $action === 'edit' ? 'Edit Product' : 'Add Product';
require __DIR__ . '/header.php';
$v = $row ?? ['category_id' => 0, 'name' => '', 'slug' => '', 'description' => '', 'main_image' => '', 'short_desc' => '', 'badge' => '', 'related_ids' => '', 'is_featured' => 0, 'is_new' => 0, 'is_trending' => 0, 'is_active' => 1];

// existing gallery images
$gallery = [];
if ($id) {
    $stmt = db()->prepare('SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order, id');
    $stmt->execute([$id]);
    $gallery = $stmt->fetchAll();
}
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0 fw-bold"><?= $action === 'edit' ? 'Edit Product' : 'Add Product' ?></h4>
  <a href="products.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>
<div class="card">
  <div class="card-body">
    <form method="post" enctype="multipart/form-data">
      <?php if ($id): ?><input type="hidden" name="id" value="<?= $id ?>"><?php endif; ?>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="label-sm mb-1">Category *</label>
          <select class="form-select" name="category_id" required>
            <option value="">— Select —</option>
            <?php foreach ($cats as $c): ?>
              <option value="<?= $c['id'] ?>" <?= (int)$v['category_id'] === (int)$c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="label-sm mb-1">Badge</label>
          <input class="form-control" name="badge" value="<?= e($v['badge']) ?>" placeholder="SAME DAY / NEW / BESTSELLER…">
        </div>
        <div class="col-md-6">
          <label class="label-sm mb-1">Name *</label>
          <input class="form-control" name="name" value="<?= e($v['name']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="label-sm mb-1">Slug</label>
          <input class="form-control" name="slug" value="<?= e($v['slug']) ?>" placeholder="auto from name">
        </div>
        <div class="col-12">
          <label class="label-sm mb-1">Short description (card sub-line)</label>
          <input class="form-control" name="short_desc" value="<?= e($v['short_desc']) ?>">
        </div>
        <div class="col-12">
          <label class="label-sm mb-1">Description (detail page)</label>
          <textarea class="form-control" name="description" rows="4"><?= e($v['description']) ?></textarea>
        </div>
        <div class="col-12">
          <label class="label-sm mb-1">Main image</label>
          <div class="d-flex align-items-start gap-3">
            <div class="img-preview-box" id="previewBox">
              <?php if ($v['main_image']): ?><img src="<?= e(img_url($v['main_image'])) ?>" alt=""><?php else: ?><span class="text-secondary small">No image</span><?php endif; ?>
            </div>
            <div class="flex-grow-1">
              <input type="file" class="form-control preview-input" name="main_image" accept="image/*" data-preview="#previewBox">
              <div class="form-text">Upload new file to replace. Or paste URL below.</div>
              <input class="form-control mt-2" name="main_image_url" value="<?= e($v['main_image'] && strpos($v['main_image'], 'uploads/') !== 0 ? $v['main_image'] : '') ?>" placeholder="or external image URL (https://…)">
            </div>
          </div>
        </div>

        <!-- Gallery / related images -->
        <div class="col-12">
          <div class="border-top pt-3">
            <label class="label-sm mb-2">Gallery / Related images</label>
            <?php if ($gallery): ?>
              <div class="row g-2 mb-2">
                <?php foreach ($gallery as $gi): ?>
                  <div class="col-6 col-md-3 col-lg-2">
                    <div class="border rounded p-1 position-relative">
                      <img src="<?= e(img_url($gi['image_url'])) ?>" class="w-100 rounded thumb img-zoom" style="height:80px;object-fit:cover" alt="">
                      <a href="products.php?action=delete_img&id=<?= $id ?>&img_id=<?= $gi['id'] ?>" class="btn btn-sm btn-outline-danger w-100 mt-1" style="font-size:.72rem" onclick="return confirm('Delete this image? File removed from uploads.')"><i class="bi bi-trash me-1"></i>Delete</a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <div class="text-secondary small mb-2">No gallery images yet.</div>
            <?php endif; ?>
            <input type="file" class="form-control" name="gallery[]" accept="image/*" multiple>
            <div class="form-text">Select multiple images. Saved when you click Save. Files stored in uploads/ folder.</div>
          </div>
        </div>

        <div class="col-md-6">
          <label class="label-sm mb-1">Related product IDs</label>
          <input class="form-control" name="related_ids" value="<?= e($v['related_ids']) ?>" placeholder="comma list: 2,5,8">
        </div>
        <div class="col-12 d-flex flex-wrap gap-4 pt-1">
          <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_featured" id="f1" <?= $v['is_featured'] ? 'checked' : '' ?>><label class="form-check-label small" for="f1">Featured</label></div>
          <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_new" id="f2" <?= $v['is_new'] ? 'checked' : '' ?>><label class="form-check-label small" for="f2">Popular</label></div>
          <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_trending" id="f3" <?= $v['is_trending'] ? 'checked' : '' ?>><label class="form-check-label small" for="f3">Trending</label></div>
          <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" id="f4" <?= $v['is_active'] ? 'checked' : '' ?>><label class="form-check-label small" for="f4">Active</label></div>
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary px-4" name="save" value="1"><i class="bi bi-check-lg me-1"></i><?= $action === 'edit' ? 'Update' : 'Add' ?> Product</button>
          <a href="products.php" class="btn btn-light">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
