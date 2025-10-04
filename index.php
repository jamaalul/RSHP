<?php
session_start();

$config = require __DIR__ . '/config.php';
require __DIR__ . '/core/Container.php';
require __DIR__ . '/core/Auth.php';
require __DIR__ . '/core/Router.php';

// Autoload models
spl_autoload_register(function ($class) {
    //-This autoloading is namespace based.
    //-Therefore, the class must be in the Model namespace.
    $class = str_replace('Model\\', '', $class);
    $file = __DIR__ . '/Model/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

require __DIR__ . '/controllers/HomeController.php';
require __DIR__ . '/controllers/AuthController.php';
require __DIR__ . '/controllers/DashboardController.php';

// init services
$container = new Core\Container($config);
$auth = $container->get('auth');
$router = new Router();

// routes
$router->get('/', [new HomeController(), 'index']);
$router->get('/login', [new AuthController($auth), 'loginForm']);
$router->post('/login', [new AuthController($auth), 'login']);
$router->get('/logout', [new AuthController($auth), 'logout']);
$router->get('/dashboard', [new DashboardController($auth, $container), 'index']);
$router->get('/dashboard/role', [new DashboardController($auth, $container), 'showRole']);
$router->get('/dashboard/role/edit/{id}', [new DashboardController($auth, $container), 'editUserRoles']);
$router->post('/dashboard/role/update/{id}', [new DashboardController($auth, $container), 'updateUserRoles']);

$router->get('/dashboard/user', [new DashboardController($auth, $container), 'showUser']);
$router->get('/dashboard/user/edit/{id}', [new DashboardController($auth, $container), 'editUser']);
$router->post('/dashboard/user/update/{id}', [new DashboardController($auth, $container), 'updateUser']);
$router->get('/dashboard/user/add', [new DashboardController($auth, $container), 'addUser']);
$router->post('/dashboard/user/add', [new DashboardController($auth, $container), 'insertUser']);

$router->get('/dashboard/jhewan', [new DashboardController($auth, $container), 'showJhewan']);
$router->get('/dashboard/jhewan/edit/{id}', [new DashboardController($auth, $container), 'editJhewan']);
$router->post('/dashboard/jhewan/update/{id}', [new DashboardController($auth, $container), 'updateJhewan']);

$router->get('/dashboard/rhewan', [new DashboardController($auth, $container), 'showRHewan']);
$router->get('/dashboard/rhewan/add/{idjenis}', [new DashboardController($auth, $container), 'addRas']);
$router->post('/dashboard/rhewan/store/{idjenis}', [new DashboardController($auth, $container), 'storeRas']);
$router->get('/dashboard/rhewan/edit/{id}', [new DashboardController($auth, $container), 'editRHewan']);
$router->post('/dashboard/rhewan/update/{id}', [new DashboardController($auth, $container), 'updateRHewan']);

$router->get('/dashboard/pemilik', [new DashboardController($auth, $container), 'showPemilik']);
$router->get('/dashboard/pemilik/edit/{id}', [new DashboardController($auth, $container), 'editPemilik']);
$router->post('/dashboard/pemilik/update/{id}', [new DashboardController($auth, $container), 'updatePemilik']);
$router->get('/dashboard/pemilik/add', [new DashboardController($auth, $container), 'addPemilik']);
$router->post('/dashboard/pemilik/add', [new DashboardController($auth, $container), 'insertPemilik']);

$router->get('/dashboard/pet', [new DashboardController($auth, $container), 'showPet']);
$router->get('/dashboard/pet/edit/{id}', [new DashboardController($auth, $container), 'editPet']);
$router->post('/dashboard/pet/update/{id}', [new DashboardController($auth, $container), 'updatePet']);
$router->get('/dashboard/pet/add', [new DashboardController($auth, $container), 'addPet']);
$router->post('/dashboard/pet/add', [new DashboardController($auth, $container), 'insertPet']);

$router->get('/dashboard/kategori', [new DashboardController($auth, $container), 'showKategori']);
$router->get('/dashboard/kategori-klinis', [new DashboardController($auth, $container), 'showKategoriKlinis']);
$router->get('/dashboard/kode-tindakan-terapi', [new DashboardController($auth, $container), 'showKodeTindakanTerapi']);

$router->get('/dashboard/temu-dokter', [new DashboardController($auth, $container), 'showTemuDokter']);
$router->get('/dashboard/temu-dokter/add', [new DashboardController($auth, $container), 'addTemuDokter']);
$router->post('/dashboard/temu-dokter/add', [new DashboardController($auth, $container), 'insertTemuDokter']);
$router->get('/dashboard/temu-dokter/details/{id}', [new DashboardController($auth, $container), 'getTemuDokterDetails']);

$router->get('/dashboard/rekam-medis', [new DashboardController($auth, $container), 'showRekamMedis']);
$router->get('/dashboard/rekam-medis/add', [new DashboardController($auth, $container), 'addRekamMedis']);
$router->post('/dashboard/rekam-medis/add', [new DashboardController($auth, $container), 'insertRekamMedis']);
$router->get('/dashboard/rekam-medis/edit/{id}', [new DashboardController($auth, $container), 'editRekamMedis']);
$router->post('/dashboard/rekam-medis/update/{id}', [new DashboardController($auth, $container), 'updateRekamMedis']);

// dispatch request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
