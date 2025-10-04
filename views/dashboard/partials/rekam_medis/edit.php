<?php
// The $rekam_medis, $all_pets, $all_dokters, and $all_temu_dokter variables are passed from the editRekamMedis method in DashboardController
?>
<link rel="stylesheet" href="../../../../views/css/edit.css?v=1.1">
<div class="container">
    <h1>Edit Rekam Medis</h1>
    <form action="/dashboard/rekam-medis/update/<?php echo $rekam_medis->idrekam_medis; ?>" method="POST" class="edit-form">
        <div class="form-group">
            <label for="idpet">Pet</label>
            <select name="idpet" id="idpet" required>
                <?php foreach ($all_pets as $pet): ?>
                    <option value="<?php echo $pet->id; ?>" <?php echo ($pet->id == $rekam_medis->idpet) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($pet->Nama); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="dokter_pemeriksa">Dokter</label>
            <select name="dokter_pemeriksa" id="dokter_pemeriksa" required>
                <?php foreach ($all_dokters as $dokter): ?>
                    <option value="<?php echo $dokter->idrole_user; ?>" <?php echo ($dokter->idrole_user == $rekam_medis->dokter_pemeriksa) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($dokter->nama); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="idreservasi_dokter">Reservasi</label>
            <select name="idreservasi_dokter" id="idreservasi_dokter">
                <option value="">None</option>
                <?php foreach ($all_temu_dokter as $temu): ?>
                    <option value="<?php echo $temu->id; ?>" <?php echo ($temu->id == $rekam_medis->idreservasi_dokter) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($temu->id); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="anamnesa">Anamnesa</label>
            <textarea id="anamnesa" name="anamnesa" rows="4" required><?php echo htmlspecialchars($rekam_medis->anamnesa); ?></textarea>
        </div>
        <div class="form-group">
            <label for="temuan_klinis">Temuan Klinis</label>
            <textarea id="temuan_klinis" name="temuan_klinis" rows="4" required><?php echo htmlspecialchars($rekam_medis->temuan_klinis); ?></textarea>
        </div>
        <div class="form-group">
            <label for="diagnosa">Diagnosa</label>
            <textarea id="diagnosa" name="diagnosa" rows="4" required><?php echo htmlspecialchars($rekam_medis->diagnosa); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/dashboard/rekam-medis/delete/<?php echo $rekam_medis->idrekam_medis; ?>" class="btn btn-danger">Delete</a>
    </form>
</div>