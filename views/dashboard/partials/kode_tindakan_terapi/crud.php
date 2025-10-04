<?php
// Ensure $model and $method are set
if (isset($model) && isset($method)) {
    // Create a new instance of the model
    $modelClass = 'Model\\' . $model;
    $modelInstance = new $modelClass($container);

    // Call the specified method on the model instance
    $data = $modelInstance->$method();

    // Get the column headers from the keys of the first item in the data array
    $headers = [];
    if (!empty($data)) {
        $headers = array_keys(get_object_vars($data[0]));
    }
} else {
    echo "<p>Model or method not specified.</p>";
    $data = [];
    $headers = [];
};
?>


<link rel="stylesheet" href="../../views/css/crud.css">
<div class="container">
    <h1>Manage <?php echo ucfirst($key); ?></h1>
    <table class="table">
        <thead>
            <tr>
                <?php foreach ($headers as $header): ?>
                    <th><?php echo htmlspecialchars($header); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <?php foreach ($headers as $header): ?>
                            <td><?php echo htmlspecialchars($row->$header); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?php echo count($headers) + 1; ?>" class="text-center">No data available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>