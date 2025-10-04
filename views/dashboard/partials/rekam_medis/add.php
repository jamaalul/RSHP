<?php
// The $all_temu_dokter is passed from the addRekamMedis method in DashboardController
?>
<link rel="stylesheet" href="../../../../views/css/edit.css">
<div class="container">
    <h1>Add Rekam Medis</h1>
    <form action="/dashboard/rekam-medis/add" method="POST" class="edit-form">
        <div class="form-group">
            <label for="idreservasi_dokter">Reservasi</label>
            <select name="idreservasi_dokter" id="idreservasi_dokter" required>
                <option value="">Select Reservasi</option>
                <?php foreach ($all_temu_dokter as $temu): ?>
                    <option value="<?php echo $temu->id; ?>">
                        <?php echo "No. Urut " . htmlspecialchars($temu->id) . " - " . htmlspecialchars($temu->pet_nama) . " (Dokter: " . htmlspecialchars($temu->dokter_nama) . ")"; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="hidden" name="idpet" id="idpet">
        <input type="hidden" name="dokter_pemeriksa" id="dokter_pemeriksa">

        <div class="form-group">
            <label for="pet_nama">Pet</label>
            <input type="text" id="pet_nama" name="pet_nama" readonly>
        </div>
        <div class="form-group">
            <label for="dokter_nama">Dokter</label>
            <input type="text" id="dokter_nama" name="dokter_nama" readonly>
        </div>

        <div class="form-group">
            <label for="anamnesa">Anamnesa</label>
            <textarea id="anamnesa" name="anamnesa" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="temuan_klinis">Temuan Klinis</label>
            <textarea id="temuan_klinis" name="temuan_klinis" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="diagnosa">Diagnosa</label>
            <textarea id="diagnosa" name="diagnosa" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>

<script>
document.getElementById('idreservasi_dokter').addEventListener('change', function() {
    var reservasiId = this.value;
    if (reservasiId) {
        fetch('/dashboard/temu-dokter/details/' + reservasiId)
            .then(response => response.json())
            .then(data => {
                document.getElementById('idpet').value = data.idpet;
                document.getElementById('dokter_pemeriksa').value = data.dokter_pemeriksa;
                document.getElementById('pet_nama').value = data.pet_nama;
                document.getElementById('dokter_nama').value = data.dokter_nama;
            });
    } else {
        document.getElementById('idpet').value = '';
        document.getElementById('dokter_pemeriksa').value = '';
        document.getElementById('pet_nama').value = '';
        document.getElementById('dokter_nama').value = '';
    }
});
</script>