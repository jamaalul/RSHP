<!-- Sidebar -->
<aside style="position: relative">
    <h2>Dashboard</h2>
    <nav>
        <ul>
            <li>
                <a href="/dashboard">Home</a>
            </li>
            <?php
            $userRoles = $_SESSION['user']['roles'] ?? [];
            ?>
            <?php if (in_array('Administrator', $userRoles)): ?>
            <li><a href="/dashboard/role">Manajemen Role</a></li>
            <?php endif; ?>
            <?php if (in_array('Administrator', $userRoles)): ?>
            <li><a href="/dashboard/user">Data User</a></li>
            <?php endif; ?>
            <?php if (in_array('Administrator', $userRoles)): ?>
            <li><a href="/dashboard/jhewan">Jenis Hewan</a></li>
            <?php endif; ?>
            <?php if (in_array('Administrator', $userRoles)): ?>
            <li><a href="/dashboard/rhewan">Ras Hewan</a></li>
            <?php endif; ?>
            <?php if (array_intersect($userRoles, ['Resepsionis', 'Administrator'])): ?>
            <li><a href="/dashboard/pemilik">Data Pemilik</a></li>
            <?php endif; ?>
            <?php if (array_intersect($userRoles, ['Resepsionis', 'Administrator'])): ?>
            <li><a href="/dashboard/pet">Data Hewan</a></li>
            <?php endif; ?>
            <?php if (in_array('Administrator', $userRoles)): ?>
            <li><a href="/dashboard/kategori">Kategori</a></li>
            <?php endif; ?>
            <?php if (in_array('Administrator', $userRoles)): ?>
            <li><a href="/dashboard/kategori-klinis">Kategori Klinis</a></li>
            <?php endif; ?>
            <?php if (in_array('Administrator', $userRoles)): ?>
            <li><a href="/dashboard/kode-tindakan-terapi">Kode Tindakan Terapi</a></li>
            <?php endif; ?>
            <?php if (in_array('Resepsionis', $userRoles)): ?>
            <li><a href="/dashboard/temu-dokter">Temu Dokter</a></li>
            <?php endif; ?>
            <?php if (in_array('Dokter', $userRoles)): ?>
            <li><a href="/dashboard/rekam-medis">Rekam Medis</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <a href="/logout" style="position: absolute; width: calc(100% - 40px); bottom: 20px; border-radius: 4px; text-align: center; background-color: tomato; color: white; padding: 10px 20px; text-decoration: none; font-weight: bold">Logout</a>
</aside>