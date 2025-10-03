<?php
// The $pet, $all_pemilik, and $all_ras variables are passed from the editPet method in DashboardController
?>
<link rel="stylesheet" href="../../../../views/css/edit.css?v=1.1">
<div class="container">
    <h1>Edit Pet</h1>
    <form action="/dashboard/pet/update/<?php echo $pet->idpet; ?>" method="POST" class="edit-form">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($pet->nama); ?>" required>
        </div>
        <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo htmlspecialchars($pet->tanggal_lahir); ?>" required>
        </div>
        <div class="form-group">
            <label for="warna_tanda">Warna/Tanda</label>
            <input type="text" id="warna_tanda" name="warna_tanda" value="<?php echo htmlspecialchars($pet->warna_tanda); ?>" required>
        </div>
        <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" required>
                <option value="J" <?php echo ($pet->jenis_kelamin == 'J') ? 'selected' : ''; ?>>Jantan</option>
                <option value="B" <?php echo ($pet->jenis_kelamin == 'B') ? 'selected' : ''; ?>>Betina</option>
            </select>
        </div>
        <div class="form-group">
            <label for="idpemilik">Pemilik</label>
            <select name="idpemilik" id="idpemilik" required>
                <?php foreach ($all_pemilik as $pemilik): ?>
                    <option value="<?php echo $pemilik->id; ?>" <?php echo ($pemilik->id == $pet->idpemilik) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($pemilik->Nama); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="idras_hewan">Ras</label>
            <select name="idras_hewan" id="idras_hewan" required>
                <?php foreach ($all_ras as $ras): ?>
                    <option value="<?php echo $ras->id; ?>" <?php echo ($ras->id == $pet->idras_hewan) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($ras->Nama); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>