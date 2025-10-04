<link rel="stylesheet" href="../../../views/css/edit.css?v=1.2">
<div class="container">
    <h1>Add User</h1>
    <form action="/dashboard/user/add" method="POST" class="edit-form">
        <div class="form-group">
            <label for="nama">Name</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>