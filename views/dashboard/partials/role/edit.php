<?php
// The $data variable is passed from the editUserRoles method in DashboardController
$user = $data->user;
$all_roles = $data->all_roles;
?>
<link rel="stylesheet" href="../../../views/css/edit.css?v=1.1">
<div class="container">
    <h1>Edit User Roles: <?php echo htmlspecialchars($user->nama); ?></h1>
    <form action="/dashboard/role/update/<?php echo $user->iduser; ?>" method="POST" class="edit-form">
        <div class="form-group">
            <label for="nama">Name</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($user->nama); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" required>
        </div>
        <div class="form-group">
            <label>Roles</label>
            <?php foreach ($all_roles as $role): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" value="<?php echo $role->idrole; ?>" id="role_<?php echo $role->idrole; ?>" <?php echo in_array($role->idrole, $user->role_ids) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="role_<?php echo $role->idrole; ?>">
                        <?php echo htmlspecialchars($role->nama_role); ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
