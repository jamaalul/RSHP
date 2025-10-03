<?php
class DashboardController {
    private $auth;
    private $container;

    public function __construct($auth, $container) {
        $this->auth = $auth;
        $this->container = $container;
    }

    public function index() {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $content = __DIR__ . '/../views/dashboard/partials/welcome.php';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function showRole() {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $content = __DIR__ . '/../views/dashboard/partials/role/crud.php';
        $model = 'User';
        $method = 'getAllWithRoles';
        $container = $this->auth->getContainer();
        $key = 'Role';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function showUser() {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $content = __DIR__ . '/../views/dashboard/partials/user/crud.php';
        $model = 'User';
        $method = 'getAll';
        $container = $this->auth->getContainer();
        $key = 'User';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function editUser($id) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $userModel = $this->container->get(\Model\User::class);
        $user = $userModel->find($id)->user;

        $content = __DIR__ . '/../views/dashboard/partials/user/edit.php';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function editJhewan($id) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $jhewanModel = new \Model\JenisHewan($this->container);
        $jhewan = $jhewanModel->findJenisHewan($id);

        $content = __DIR__ . '/../views/dashboard/partials/jhewan/edit.php';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function addRas($idjenis) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $content = __DIR__ . '/../views/dashboard/partials/rhewan/add.php';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function storeRas($idjenis) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rasModel = new \Model\RasHewan($this->container);
            $rasModel->addRas($idjenis, $_POST['nama_ras']);
            header("Location: /dashboard/jhewan");
            exit;
        }
    }

    public function updateJhewan($id) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jhewanModel = new \Model\JenisHewan($this->container);
            $jhewanModel->updateJenisHewan($id, $_POST['nama']);
            header("Location: /dashboard/jhewan");
            exit;
        }
    }

    public function updateUser($id) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->container->get(\Model\User::class);
            $data = [
                'nama' => $_POST['nama'],
                'email' => $_POST['email']
            ];
            $userModel->update($id, $data);
            header("Location: /dashboard/user");
            exit;
        }
    }

    public function showJhewan() {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $content = __DIR__ . '/../views/dashboard/partials/jhewan/crud.php';
        $model = 'JenisHewan';
        $method = 'getAllwithRas';
        $container = $this->auth->getContainer();
        $key = 'JenisHewan';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function showRHewan() {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $content = __DIR__ . '/../views/dashboard/partials/rhewan/crud.php';
        $model = 'RasHewan';
        $method = 'getAll';
        $container = $this->auth->getContainer();
        $key = 'RasHewan';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function showPemilik() {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $content = __DIR__ . '/../views/dashboard/partials/pemilik/crud.php';
        $model = 'Pemilik';
        $method = 'getAll';
        $container = $this->auth->getContainer();
        $key = 'Pemilik';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function editRHewan($id) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $rasModel = new \Model\RasHewan($this->container);
        $ras = $rasModel->findRasHewan($id);

        $jhewanModel = new \Model\JenisHewan($this->container);
        $all_jenis = $jhewanModel->getAll();

        $content = __DIR__ . '/../views/dashboard/partials/rhewan/edit.php';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function editPet($id) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $petModel = new \Model\Pet($this->container);
        $pet = $petModel->find($id);

        $pemilikModel = new \Model\Pemilik($this->container);
        $all_pemilik = $pemilikModel->getAll();

        $rasModel = new \Model\RasHewan($this->container);
        $all_ras = $rasModel->getAll();

        $content = __DIR__ . '/../views/dashboard/partials/pet/edit.php';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function updatePet($id) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $petModel = new \Model\Pet($this->container);
            $data = [
                'nama' => $_POST['nama'],
                'tanggal_lahir' => $_POST['tanggal_lahir'],
                'warna_tanda' => $_POST['warna_tanda'],
                'jenis_kelamin' => $_POST['jenis_kelamin'],
                'idpemilik' => $_POST['idpemilik'],
                'idras_hewan' => $_POST['idras_hewan']
            ];
            $petModel->update($id, $data);
            header("Location: /dashboard/pet");
            exit;
        }
    }

    public function editPemilik($id) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $pemilikModel = new \Model\Pemilik($this->container);
        $pemilik = $pemilikModel->find($id);

        $content = __DIR__ . '/../views/dashboard/partials/pemilik/edit.php';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function updatePemilik($id) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pemilikModel = new \Model\Pemilik($this->container);
            $data = [
                'nama' => $_POST['nama'],
                'email' => $_POST['email'],
                'no_wa' => $_POST['no_wa'],
                'alamat' => $_POST['alamat'],
                'iduser' => $_POST['iduser']
            ];
            $pemilikModel->update($id, $data);
            header("Location: /dashboard/pemilik");
            exit;
        }
    }

    public function updateRHewan($id) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rasModel = new \Model\RasHewan($this->container);
            $rasModel->updateRasHewan($id, $_POST['nama_ras'], $_POST['idjenis_hewan']);
            header("Location: /dashboard/rhewan");
            exit;
        }
    }

    public function showPet() {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $content = __DIR__ . '/../views/dashboard/partials/pet/crud.php';
        $model = 'Pet';
        $method = 'getAllWithOwner';
        $container = $this->auth->getContainer();
        $key = 'Pet';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function showKategori() {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $content = __DIR__ . '/../views/dashboard/partials/kategori/crud.php';
        $model = 'Kategori';
        $method = 'getAll';
        $container = $this->auth->getContainer();
        $key = 'Kategori';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function showKategoriKlinis() {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $content = __DIR__ . '/../views/dashboard/partials/kategori_klinis/crud.php';
        $model = 'KategoriKlinis';
        $method = 'getAll';
        $container = $this->auth->getContainer();
        $key = 'KategoriKlinis';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function showKodeTindakanTerapi() {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $content = __DIR__ . '/../views/dashboard/partials/kode_tindakan_terapi/crud.php';
        $model = 'KodeTindakanTerapi';
        $method = 'getAllWithDetails';
        $container = $this->auth->getContainer();
        $key = 'KodeTindakanTerapi';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function editUserRoles($id) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $userModel = $this->container->get(\Model\User::class);
        $data = $userModel->find($id);

        $content = __DIR__ . '/../views/dashboard/partials/role/edit.php';
        include __DIR__ . '/../views/dashboard/layout.php';
    }

    public function updateUserRoles($id) {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->container->get(\Model\User::class);
            $data = [
                'nama' => $_POST['nama'],
                'email' => $_POST['email'],
                'roles' => $_POST['roles'] ?? []
            ];
            $userModel->update($id, $data);
            header("Location: /dashboard/role");
            exit;
        }
    }
}
