<?php
// The $user variable is passed from the editUser method in DashboardController
?>
<link rel="stylesheet" href="../../../views/css/edit.css?v=1.1">
<div class="container">
    <h1>Edit User</h1>
    <form action="/dashboard/user/update/<?php echo $user->iduser; ?>" method="POST" class="edit-form">
        <div class="form-group">
            <label for="nama">Name</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($user->nama); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>