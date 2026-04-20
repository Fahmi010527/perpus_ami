<!-- Sidebar Container -->
<div class="sidebar shadow-sm" data-aos="fade-right">
    <!-- Judul Sidebar dengan Ikon Modern -->
    <h4 class="text-primary font-weight-bold mb-4 text-center">
        <i class="fas fa-book-reader"></i> Perpus AMI
    </h4>
    
    <!-- Navigasi Dashboard -->
    <!-- Logika active mengecek apakah segment URI saat ini adalah 'admin' -->
    <a href="<?= base_url('index.php/admin'); ?>" class="nav-item <?= ($this->uri->segment(1) == 'admin') ? 'active' : ''; ?>">
        <i class="fas fa-home mr-2"></i> Dashboard
    </a>
    
    <!-- Navigasi Data Buku -->
    <a href="<?= base_url('index.php/buku'); ?>" class="nav-item <?= ($this->uri->segment(1) == 'buku') ? 'active' : ''; ?>">
        <i class="fas fa-book mr-2"></i> Data Buku
    </a>
    
    <!-- Menu Anggota -->
    <a href="<?= base_url('index.php/anggota'); ?>" class="nav-item <?= ($this->uri->segment(1) == 'anggota') ? 'active' : ''; ?>">
        <i class="fas fa-users mr-2"></i> Anggota
    </a>

    <!-- Menu Transaksi -->
    <a href="<?= base_url('index.php/transaksi'); ?>" class="nav-item <?= ($this->uri->segment(1) == 'transaksi') ? 'active' : ''; ?>">
        <i class="fas fa-exchange-alt mr-2"></i> Transaksi
    </a>
    
    <!-- Menu Laporan -->
    <a href="<?= base_url('index.php/laporan'); ?>" class="nav-item <?= ($this->uri->segment(1) == 'laporan') ? 'active' : ''; ?>">
        <i class="fas fa-file-alt mr-2"></i> Laporan
    </a>
    
    <!-- Garis Pemisah (Divider) -->
    <hr class="my-3">

    <!-- Menu Profil User -->
    <a href="<?= base_url('index.php/profil'); ?>" class="nav-item <?= ($this->uri->segment(1) == 'profil') ? 'active' : ''; ?>">
        <i class="fas fa-user-circle mr-2"></i> Profil
    </a>
    
    <!-- Tombol Keluar dengan Konfirmasi Keamanan -->
    <a href="<?= base_url('index.php/auth/login/logout'); ?>" class="nav-item text-danger" onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
        <i class="fas fa-power-off mr-2"></i> Keluar
    </a>
</div>

<style>
/* CSS Tambahan untuk mempercantik Sidebar jika diperlukan */
.sidebar .nav-item {
    display: block;
    padding: 12px 20px;
    color: #555;
    text-decoration: none;
    transition: all 0.3s;
    border-radius: 10px;
    margin-bottom: 5px;
}

.sidebar .nav-item:hover {
    background-color: #f8f9fa;
    color: #007bff;
    padding-left: 25px; /* Efek geser saat hover */
}

.sidebar .nav-item.active {
    background-color: #e7f1ff;
    color: #007bff;
    font-weight: bold;
}

.sidebar .nav-item.text-danger:hover {
    background-color: #fff5f5;
    color: #dc3545 !important;
}
</style>