<?php
require_once __DIR__ . '/config.php';


$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

// ---------- DELETE ----------
if ($action === 'delete' && $id) {
    if ($id === (int)$_SESSION['admin_id']) {
        flash('error', 'You cannot delete your own account.');
        redirect('users.php');
    }
    db()->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
    flash('success', 'User deleted.');
    redirect('users.php');
}

// ---------- SAVE ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if ($username === '') {
        flash('error', 'Username is required.');
        redirect($id ? "users.php?action=edit&id=$id" : 'users.php?action=add');
    }

    $stmt = db()->prepare('SELECT id FROM users WHERE username = ? AND id != ?');
    $stmt->execute([$username, $id]);
    if ($stmt->fetchColumn()) {
        flash('error', 'Username already exists.');
        redirect($id ? "users.php?action=edit&id=$id" : 'users.php?action=add');
    }

    if ($id) {
        if ($password !== '') {
            if ($password !== $password2) {
                flash('error', 'Passwords do not match.');
                redirect("users.php?action=edit&id=$id");
            }
            if (strlen($password) < 6) {
                flash('error', 'Password must be at least 6 characters.');
                redirect("users.php?action=edit&id=$id");
            }
            db()->prepare('UPDATE users SET username = ?, password_hash = ? WHERE id = ?')
                ->execute([$username, password_hash($password, PASSWORD_DEFAULT), $id]);
        } else {
            db()->prepare('UPDATE users SET username = ? WHERE id = ?')->execute([$username, $id]);
        }
        flash('success', 'User updated.');
    } else {
        if ($password === '' || $password !== $password2) {
            flash('error', 'Password is required and must match.');
            redirect('users.php?action=add');
        }
        if (strlen($password) < 6) {
            flash('error', 'Password must be at least 6 characters.');
            redirect('users.php?action=add');
        }
        db()->prepare('INSERT INTO users (username, password_hash) VALUES (?,?)')
            ->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
        flash('success', 'User added.');
    }
    redirect('users.php');
}

// ---------- EDIT ----------
$row = null;
if ($action === 'edit' && $id) {
    $stmt = db()->prepare('SELECT id, username FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row) {
        flash('error', 'User not found.');
        redirect('users.php');
    }
}

// ---------- LIST ----------
if ($action === 'list') {
    $rows = db()->query('SELECT id, username, created_at FROM users ORDER BY id')->fetchAll();
    $page_title = 'Users';
    require __DIR__ . '/header.php';
    ?>
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <div>
        <h4 class="mb-0 fw-bold">Users</h4>
        <span class="text-secondary small"><?= count($rows) ?> total</span>
      </div>
      <a href="users.php?action=add" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Add User</a>
    </div>
    <div class="card" >
      <div class="table-responsive">
        <table class="table data mb-0 align-middle">
          <thead><tr><th>ID</th><th>Username</th><th>Created</th><th class="text-end">Actions</th></tr></thead>
          <tbody>
          <?php if (!$rows): ?>
            <tr><td colspan="4"><div class="empty-state"><i class="bi bi-person"></i><div>No users yet.</div></div></td></tr>
          <?php endif; ?>
          <?php foreach ($rows as $u): ?>
            <tr>
              <td class="text-secondary">#<?= $u['id'] ?></td>
              <td class="fw-semibold"><span class="rounded-circle bg-light text-dark d-inline-flex align-items-center justify-content-center me-2" style="width:30px;height:30px"><?= e(strtoupper(substr($u['username'], 0, 1))) ?></span><?= e($u['username']) ?> <?= (int)$u['id'] === (int)$_SESSION['admin_id'] ? '<span class="badge bg-info-subtle text-info-emphasis">you</span>' : '' ?></td>
              <td class="text-secondary small"><?= e($u['created_at']) ?></td>
              <td class="text-end text-nowrap">
                <a href="users.php?action=edit&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                <a href="users.php?action=delete&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this user?')"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php
    require __DIR__ . '/footer.php';
    exit;
}

// ---------- FORM ----------
$page_title = $action === 'edit' ? 'Edit User' : 'Add User';
require __DIR__ . '/header.php';
$v = $row ?? ['username' => ''];
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0 fw-bold"><?= $action === 'edit' ? 'Edit User' : 'Add User' ?></h4>
  <a href="users.php" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>
<div class="card" >
  <div class="card-body">
    <form method="post">
      <?php if ($id): ?><input type="hidden" name="id" value="<?= $id ?>"><?php endif; ?>
      <div class="row g-3">
        <div class="col-12">
          <label class="label-sm mb-1">Username *</label>
          <input class="form-control" name="username" value="<?= e($v['username']) ?>" required>
        </div>
        <div class="col-12">
          <label class="label-sm mb-1"><?= $action === 'edit' ? 'New password (leave blank to keep)' : 'Password *' ?></label>
          <input type="password" class="form-control" name="password" <?= $action === 'add' ? 'required' : '' ?>>
          <div class="form-text">Min 6 chars. Stored hashed (bcrypt).</div>
        </div>
        <div class="col-12">
          <label class="label-sm mb-1">Confirm password</label>
          <input type="password" class="form-control" name="password2">
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary px-4" name="save" value="1"><i class="bi bi-check-lg me-1"></i><?= $action === 'edit' ? 'Update' : 'Add' ?> User</button>
          <a href="users.php" class="btn btn-light">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/footer.php'; ?>
