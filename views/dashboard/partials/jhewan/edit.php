<?php
// The $jhewan variable is passed from the editJhewan method in DashboardController
?>
<link rel="stylesheet" href="../../../views/css/edit.css?v=1.1">
<div class="container">
    <h1>Edit Jenis Hewan</h1>
    <form action="/dashboard/jhewan/update/<?php echo $jhewan->id; ?>" method="POST" class="edit-form">
        <div class="form-group">
            <label for="nama">Nama Jenis Hewan</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($jhewan->nama); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>