<?php
// The $all_pets and $all_dokters variables are passed from the addTemuDokter method in DashboardController
?>
<link rel="stylesheet" href="../../../../views/css/edit.css?v=1.1">
<div class="container">
    <h1>Add Temu Dokter</h1>
    <form action="/dashboard/temu-dokter/add" method="POST" class="edit-form">
        <div class="form-group">
            <label for="idpet">Pet</label>
            <select name="idpet" id="idpet" required>
                <?php foreach ($all_pets as $pet): ?>
                    <option value="<?php echo $pet->id; ?>">
                        <?php echo htmlspecialchars($pet->Nama); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="idrole_user">Dokter</label>
            <select name="idrole_user" id="idrole_user" required>
                <?php foreach ($all_dokters as $dokter): ?>
                    <option value="<?php echo $dokter->idrole_user; ?>">
                        <?php echo htmlspecialchars($dokter->nama); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>