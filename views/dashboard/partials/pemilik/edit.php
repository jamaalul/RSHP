<?php
// The $pemilik variable is passed from the editPemilik method in DashboardController
?>
<link rel="stylesheet" href="../../../../views/css/edit.css?v=1.1">
<div class="container">
    <h1>Edit Pemilik</h1>
    <form action="/dashboard/pemilik/update/<?php echo $pemilik->idpemilik; ?>" method="POST" class="edit-form">
        <input type="hidden" name="iduser" value="<?php echo $pemilik->iduser; ?>">
        <div class="form-group">
            <label for="nama">Name</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($pemilik->nama); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($pemilik->email); ?>" required>
        </div>
        <div class="form-group">
            <label for="no_wa">Nomor HP</label>
            <input type="text" id="no_wa" name="no_wa" value="<?php echo htmlspecialchars($pemilik->no_wa); ?>" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($pemilik->alamat); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/dashboard/pemilik/delete/<?php echo $pemilik->idpemilik; ?>" class="btn btn-danger">Delete</a>
    </form>
</div>