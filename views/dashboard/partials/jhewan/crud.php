<?php
// Ensure $model and $method are set
if (isset($model) && isset($method)) {
    // Create a new instance of the model
    $modelClass = 'Model\\' . $model;
    $modelInstance = new $modelClass($container);

    // Call the specified method on the model instance
    $data = $modelInstance->$method();
} else {
    echo "<p>Model or method not specified.</p>";
    $data = [];
};
?>

<link rel="stylesheet" href="../../views/css/crud.css">
<div class="container">
    <h1>Manage <?php echo ucfirst($key); ?></h1>
    <table class="table">
        <thead>
            <tr>
                <th>Jenis</th>
                <th>Ras</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td>
                            <div>
                                <?php echo htmlspecialchars($row['Nama']); ?>
                                <br><br>
                                <a href="/dashboard/jhewan/edit/<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            </div>
                        </td>
                        <td>
                            <ul style="list-style-type: none; padding: 0;">
                                <?php if (!empty($row['ras'])): ?>
                                    <?php foreach ($row['ras'] as $ras): ?>
                                        <li>
                                            <?php echo htmlspecialchars($ras['nama_ras']); ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </td>
                        <td>
                            <a href="/dashboard/rhewan/add/<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Tambah Ras</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No data available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>