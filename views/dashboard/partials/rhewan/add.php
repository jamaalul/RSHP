<?php
// The $idjenis variable is passed from the addRas method in DashboardController
?>
<link rel="stylesheet" href="../../../../views/css/edit.css">
<div class="container">
    <h1>Tambah Ras Hewan</h1>
    <form action="/dashboard/rhewan/store/<?php echo $idjenis; ?>" method="POST" class="edit-form">
        <div class="form-group">
            <label for="nama_ras">Nama Ras</label>
            <input type="text" id="nama_ras" name="nama_ras" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
</div>