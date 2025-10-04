<link rel="stylesheet" href="../../../../views/css/edit.css?v=1.1">
<div class="container">
    <h1>Add Pemilik</h1>
    <form action="/dashboard/pemilik/add" method="POST" class="edit-form">
        <div class="form-group">
            <label for="nama">Name</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="no_wa">Nomor HP</label>
            <input type="text" id="no_wa" name="no_wa" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>