<?php 
/**
 * View Dashboard Admin - Perpustakaankuu
 * Update: Sinkronisasi Sidebar & Pembersihan Tag HTML Ganda
 * Deskripsi: File ini sekarang hanya berisi KONTEN UTAMA dashboard.
 * Header, Sidebar, dan Footer dipanggil melalui Controller Admin.
 */
?>

<!-- Kodingan CSS Internal (Hanya yang spesifik untuk Dashboard) -->
<style>
    /* Area Konten Utama: Beri jarak kiri agar tidak tertutup sidebar */
    .main-content { margin-left: 250px; padding: 30px; transition: 0.5s; }
    
    /* Banner Sambutan: Menggunakan warna gradasi biru yang elegan */
    .welcome-banner { 
        background: linear-gradient(135deg, #0061f2 0%, #60a5fa 100%); 
        border-radius: 20px; 
        padding: 50px 40px; 
        color: white; 
        position: relative; 
        margin-bottom: 30px; 
        box-shadow: 0 10px 25px rgba(0,97,242,0.2);
        overflow: hidden; 
    }
    
    /* Desain Ilustrasi di dalam Banner */
    .admin-illustration { position: absolute; right: 30px; top: 20px; width: 180px; opacity: 0.9; z-index: 2; }
    
    /* Kartu Statistik: Desain modern dengan shadow tipis */
    .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); background: #fff; padding: 25px; height: 100%; transition: 0.4s; }
    /* Efek kartu terangkat saat hover */
    .card-custom:hover { transform: translateY(-7px); box-shadow: 0 12px 25px rgba(0,0,0,0.1); }
    
    /* Lingkaran tempat icon di dalam kartu */
    .icon-circle { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 15px; }
    
    /* Garis bawah tipis untuk list-group */
    .list-group-item { border: none; border-bottom: 1px solid #f0f0f0; }

    /* Responsif untuk layar kecil agar margin sidebar hilang */
    @media (max-width: 768px) {
        .main-content { margin-left: 0; padding: 15px; }
    }
</style>

<!-- Bagian Utama Konten Dashboard -->
<div class="main-content">
    
    <!-- Banner Selamat Datang -->
    <div class="welcome-banner" data-aos="fade-down">
        <div style="position: relative; z-index: 3; max-width: 60%;">
            <h1 class="font-weight-bold">Dashboard Analitik 📊</h1>
            <p style="font-size: 1.1rem; opacity: 0.9;">Selamat datang kembali, <strong><?= $nama_user; ?></strong>! Pantau performa perpustakaan Anda secara real-time di sini.</p>
            <button class="btn btn-light font-weight-bold text-primary mt-2 px-4 shadow-sm" style="border-radius: 10px;">Cek Aktivitas</button>
        </div>
        
        <!-- SVG Ilustrasi Admin -->
        <div class="admin-illustration d-none d-md-block">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="90" fill="white" fill-opacity="0.1"/>
                <path d="M100 40c-16.5 0-30 13.5-30 30s13.5 30 30 30 30-13.5 30-30-13.5-30-30-30zm0 70c-26.7 0-80 13.4-80 40v20h160v-20c0-26.6-53.3-40-80-40z" fill="#ffffff"/>
            </svg>
        </div>
    </div>

    <!-- Barisan Kartu Statistik (Atas) -->
    <div class="row mb-4">
        <!-- Kartu Total Koleksi -->
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
            <div class="card-custom text-center">
                <div class="icon-circle bg-light text-primary mx-auto"><i class="fas fa-book"></i></div>
                <h3 class="font-weight-bold mb-0"><?= number_format($total_buku); ?></h3>
                <small class="text-muted text-uppercase font-weight-bold">Koleksi Buku</small>
            </div>
        </div>
        <!-- Kartu Anggota Aktif -->
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
            <div class="card-custom text-center">
                <div class="icon-circle bg-light text-success mx-auto"><i class="fas fa-user-check"></i></div>
                <h3 class="font-weight-bold mb-0"><?= number_format($total_anggota); ?></h3>
                <small class="text-muted text-uppercase font-weight-bold">Anggota</small>
            </div>
        </div>
        <!-- Kartu Buku Dipinjam -->
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
            <div class="card-custom text-center">
                <div class="icon-circle bg-light text-warning mx-auto"><i class="fas fa-history"></i></div>
                <h3 class="font-weight-bold mb-0"><?= number_format($total_pinjam); ?></h3>
                <small class="text-muted text-uppercase font-weight-bold">Dipinjam</small>
            </div>
        </div>
        <!-- Kartu Status Sistem -->
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="400">
            <div class="card-custom text-center border-left border-primary" style="border-left-width: 5px !important;">
                <div class="icon-circle bg-light text-info mx-auto"><i class="fas fa-check-circle"></i></div>
                <h3 class="font-weight-bold mb-0">Aktif</h3>
                <small class="text-muted text-uppercase font-weight-bold">Status Server</small>
            </div>
        </div>
    </div>

    <!-- Barisan Grafik (Tengah) -->
    <div class="row">
        <!-- Grafik Garis Tren Peminjaman -->
        <div class="col-md-8 mb-4" data-aos="fade-right">
            <div class="card-custom">
                <h5 class="font-weight-bold mb-4"><i class="fas fa-chart-line text-primary mr-2"></i> Tren Peminjaman Bulanan</h5>
                <canvas id="lineChart" height="130"></canvas>
            </div>
        </div>
        <!-- Grafik Donut Kategori -->
        <div class="col-md-4 mb-4" data-aos="fade-left">
            <div class="card-custom">
                <h5 class="font-weight-bold mb-4"><i class="fas fa-chart-pie text-primary mr-2"></i> Populer</h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Barisan List & Grafik Batang (Bawah) -->
    <div class="row">
        <!-- List Peminjaman Terbaru -->
        <div class="col-md-6 mb-4" data-aos="fade-up">
            <div class="card-custom">
                <h5 class="font-weight-bold mb-3"><i class="fas fa-list text-primary mr-2"></i> Peminjaman Terbaru</h5>
                <ul class="list-group list-group-flush">
                    <?php if(!empty($peminjaman_terkini)): ?>
                        <?php foreach($peminjaman_terkini as $row): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                            <div>
                                <span class="font-weight-bold d-block text-dark"><?= $row->nama_lengkap; ?></span>
                                <small class="text-muted text-truncate d-inline-block" style="max-width: 200px;"><?= $row->judul; ?></small>
                            </div>
                            <span class="badge badge-pill badge-primary">Dipinjam</span>
                        </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item text-center text-muted small py-4">Belum ada transaksi hari ini.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <!-- Grafik Batang Kunjungan -->
        <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card-custom">
                <h5 class="font-weight-bold mb-4"><i class="fas fa-users text-primary mr-2"></i> Kunjungan Mingguan</h5>
                <canvas id="barChart" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Script Chart.js & Inisialisasi -->
<script>
    // Inisialisasi library AOS agar elemen muncul dengan animasi
    AOS.init({ duration: 800, once: true });

    // Inisialisasi Grafik Garis (Peminjaman Bulanan)
    var ctxLine = document.getElementById('lineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Data Peminjaman',
                data: <?= json_encode($grafik_bulanan); ?>,
                borderColor: '#0061f2',
                backgroundColor: 'rgba(0, 97, 242, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3
            }]
        },
        options: { responsive: true }
    });

    // Inisialisasi Grafik Donut (Kategori Terpopuler)
    var ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($label_kategori); ?>,
            datasets: [{
                data: <?= json_encode($data_kategori); ?>,
                backgroundColor: ['#0061f2', '#60a5fa', '#34d399', '#fbbf24', '#f87171'],
                borderWidth: 0
            }]
        },
        options: { 
            cutout: '70%', 
            plugins: { legend: { position: 'bottom' } } 
        }
    });

    // Inisialisasi Grafik Batang (Kunjungan Member)
    var ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Mgu 1', 'Mgu 2', 'Mgu 3', 'Mgu 4'],
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: <?= json_encode($grafik_member); ?>,
                backgroundColor: '#60a5fa',
                borderRadius: 8
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });
</script>