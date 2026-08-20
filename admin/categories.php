<?php
require_once __DIR__ . '/config.php';
require_login();

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

// ---------- DELETE ----------
if ($action === 'delete' && $id) {
  $stmt = db()->prepare('SELECT image FROM categories WHERE id = ?');
  $stmt->execute([$id]);
  $cat = $stmt->fetch();

  if ($cat) {
    db()->prepare('DELETE FROM categories WHERE id = ?')->execute([$id]);
    delete_upload($cat['image']); // remove image file from uploads folder
    flash('success', 'Category deleted (image file removed from uploads).');
  }
  redirect('categories.php');
}

// ---------- SAVE (insert / update) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
  $name = trim($_POST['name'] ?? '');
  $slug = trim($_POST['slug'] ?? '');
  $icon = trim($_POST['icon'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $sort_order = (int)($_POST['sort_order'] ?? 0);
  $is_active = isset($_POST['is_active']) ? 1 : 0;

  if ($slug === '') {
    $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
  }

  $image = null;
  if ($id) {
    $stmt = db()->prepare('SELECT image FROM categories WHERE id = ?');
    $stmt->execute([$id]);
    $image = $stmt->fetchColumn() ?: null;
  }

  if (!empty($_FILES['image']['name'])) {
    $up = handle_upload($_FILES['image'], $image);
    if ($up['ok']) {
      $image = $up['path'];
    } else {
      flash('error', 'Image upload failed: ' . $up['error']);
      redirect($id ? "categories.php?action=edit&id=$id" : 'categories.php?action=add');
    }
  }

  if ($id) {
    db()->prepare('UPDATE categories SET name=?, slug=?, icon=?, image=?, description=?, sort_order=?, is_active=? WHERE id=?')
      ->execute([$name, $slug, $icon, $image, $description, $sort_order, $is_active, $id]);
    flash('success', 'Category updated.');
  } else {
    db()->prepare('INSERT INTO categories (name, slug, icon, image, description, sort_order, is_active) VALUES (?,?,?,?,?,?,?)')
      ->execute([$name, $slug, $icon, $image, $description, $sort_order, $is_active]);
    flash('success', 'Category added.');
  }
  redirect('categories.php');
}

// ---------- EDIT: fetch row ----------
$row = null;
if ($action === 'edit' && $id) {
  $stmt = db()->prepare('SELECT * FROM categories WHERE id = ?');
  $stmt->execute([$id]);
  $row = $stmt->fetch();
  if (!$row) {
    flash('error', 'Category not found.');
    redirect('categories.php');
  }
}

// ---------- LIST ----------
if ($action === 'list') {
  $base = 'SELECT c.*, (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id) AS product_count FROM categories c';
  $pg = paginate(db(), $base, 12);
  $rows = db()->query($base . " ORDER BY c.sort_order, c.id LIMIT {$pg['limit']} OFFSET {$pg['offset']}")->fetchAll();
  $page_title = 'Categories';
  require __DIR__ . '/header.php';
?>
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
      <h4 class="mb-0 fw-bold">Categories</h4>
      <span class="text-secondary small"><?= $pg['total'] ?> total • <?= $pg['limit'] ?> per page</span>
    </div>
    <a href="categories.php?action=add" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Add Category</a>
  </div>
  <div class="card">
    <div class="table-responsive">
      <table class="table data mb-0 align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Slug</th>
            <!-- <th>Icon</th> -->
            <th class="text-center">Products</th>
            <th class="text-center">Sort</th>
            <th class="text-center">Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$rows): ?>
            <tr>
              <td colspan="9">
                <div class="empty-state"><i class="bi bi-folder"></i>
                  <div>No categories yet. Click "Add Category" to create one.</div>
                </div>
              </td>
            </tr>
          <?php endif; ?>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td class="text-secondary">#<?= $r['id'] ?></td>
              <td><?php if ($r['image']): ?><img src="<?= e(img_url($r['image'])) ?>" class="thumb" alt=""><?php else: ?><span class="text-secondary">—</span><?php endif; ?></td>
              <td class="fw-semibold"><?= e($r['name']) ?></td>
              <td><code class="text-secondary"><?= e($r['slug']) ?></code></td>
             <?php /* <td><span class="badge bg-light text-dark border"><?= e($r['icon']) ?: '—' ?></span></td> */ ?>
              <td class="text-center"><span class="badge bg-light text-dark border"><?= (int)$r['product_count'] ?></span></td>
              <td class="text-center text-secondary"><?= (int)$r['sort_order'] ?></td>
              <td class="text-center"><?= $r['is_active'] ? '<span class="badge bg-success-subtle text-success">Active</span>' : '<span class="badge bg-secondary-subtle text-secondary">Inactive</span>' ?></td>
              <td class="text-end text-nowrap">
                <a href="categories.php?action=edit&id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <a href="categories.php?action=delete&id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category? Its image file will be removed.')"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
      <span class="small text-secondary">Showing <?= $pg['offset'] + 1 ?>–<?= min($pg['offset'] + $pg['limit'], $pg['total']) ?> of <?= $pg['total'] ?></span>
      <?php render_pagination($pg['page'], $pg['pages'], 'categories.php'); ?>
    </div>
  </div>
<?php
  require __DIR__ . '/footer.php';
  exit;
}

// ---------- FORM (add / edit) ----------
$page_title = $action === 'edit' ? 'Edit Category' : 'Add Category';
require __DIR__ . '/header.php';
$v = $row ?? ['name' => '', 'slug' => '', 'icon' => '', 'image' => '', 'description' => '', 'sort_order' => 0, 'is_active' => 1];
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0 fw-bold"><?= $action === 'edit' ? 'Edit Category' : 'Add Category' ?></h4>
  <a href="categories.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>
<div class="card">
  <div class="card-body">
    <form method="post" enctype="multipart/form-data">
      <?php if ($id): ?><input type="hidden" name="id" value="<?= $id ?>"><?php endif; ?>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="label-sm mb-1">Name *</label>
          <input class="form-control" name="name" value="<?= e($v['name']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="label-sm mb-1">Slug</label>
          <input class="form-control" name="slug" value="<?= e($v['slug']) ?>" placeholder="auto from name">
        </div>
        <div class="col-md-6">
          <label class="label-sm mb-1">Lucide Icon</label>
          <input class="form-control" name="icon" value="<?= e($v['icon']) ?>" placeholder="e.g. printer, book-open">
        </div>
        <div class="col-md-6">
          <label class="label-sm mb-1">Sort Order</label>
          <input type="number" class="form-control" name="sort_order" value="<?= (int)$v['sort_order'] ?>">
        </div>
        <!-- <div class="col-12">
          <label class="label-sm mb-1">Description (card sub-line)</label>
          <input class="form-control" name="description" value="<?= e($v['description']) ?>">
        </div> -->
        <div class="col-12">
          <label class="label-sm mb-1">Image</label>
          <div class="d-flex align-items-start gap-3">
            <div class="img-preview-box" id="previewBox">
              <?php if ($v['image']): ?><img src="<?= e(img_url($v['image'])) ?>" alt=""><?php else: ?><span class="text-secondary small">No image</span><?php endif; ?>
            </div>
            <div class="flex-grow-1">
              <input type="file" class="form-control preview-input" name="image" accept="image/*" data-preview="#previewBox">
              <div class="form-text">Max 5MB. jpg/png/webp/gif/svg. New upload replaces old file.</div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="ia" <?= $v['is_active'] ? 'checked' : '' ?>>
            <label class="form-check-label small" for="ia">Active (visible on site)</label>
          </div>
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary px-4" name="save" value="1"><i class="bi bi-check-lg me-1"></i><?= $action === 'edit' ? 'Update' : 'Add' ?> Category</button>
          <a href="categories.php" class="btn btn-light">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>