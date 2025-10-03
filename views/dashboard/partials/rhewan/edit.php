<?php
// The $ras and $all_jenis variables are passed from the editRHewan method in DashboardController
?>
<link rel="stylesheet" href="../../../../views/css/edit.css?v=1.1">
<div class="container">
    <h1>Edit Ras Hewan</h1>
    <form action="/dashboard/rhewan/update/<?php echo $ras->id; ?>" method="POST" class="edit-form">
        <div class="form-group">
            <label for="nama_ras">Nama Ras</label>
            <input type="text" id="nama_ras" name="nama_ras" value="<?php echo htmlspecialchars($ras->nama_ras); ?>" required>
        </div>
        <div class="form-group">
            <label for="idjenis_hewan">Jenis Hewan</label>
            <select name="idjenis_hewan" id="idjenis_hewan" required>
                <?php foreach ($all_jenis as $jenis): ?>
                    <option value="<?php echo $jenis->id; ?>" <?php echo ($jenis->id == $ras->idjenis_hewan) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($jenis->Nama); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>