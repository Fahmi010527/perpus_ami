<?php
// Mencegah akses langsung ke file script
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat library dan helper yang wajib ada
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();

        // Keamanan: Cek apakah user sudah login
        $is_logged_in = $this->session->userdata('logged_in');
        $role         = $this->session->userdata('role');

        if (!$is_logged_in || $role != 'siswa') {
            redirect('index.php/auth/login');
            exit; 
        }

        // OTOMATIS: Jalankan pengecekan denda & kirim notif setiap kali halaman diakses
        $this->_auto_update_denda();
    }

    /**
     * PRIVATE FUNCTION: Menghitung denda secara real-time dan simulasi kirim WA
     */
    private function _auto_update_denda() {
        $id_siswa = $this->session->userdata('id');
        $tgl_sekarang = date('Y-m-d');
        $biaya_denda_per_hari = 1000; // Contoh: Rp 1.000 per hari

        // Ambil transaksi yang masih dipinjam dan sudah lewat batas pengembalian
        $this->db->where('id_siswa', $id_siswa);
        $this->db->where('status', 'dipinjam');
        $this->db->where('batas_pengembalian <', $tgl_sekarang);
        $list_telat = $this->db->get('transaksi')->result_array();

        foreach ($list_telat as $row) {
            // Hitung selisih hari keterlambatan
            $tgl_batas = new DateTime($row['batas_pengembalian']);
            $tgl_skrg  = new DateTime($tgl_sekarang);
            $selisih   = $tgl_skrg->diff($tgl_batas)->days;

            $total_denda = $selisih * $biaya_denda_per_hari;

            // Update denda ke database
            $this->db->where('id_transaksi', $row['id_transaksi']);
            $this->db->update('transaksi', [
                'denda' => $total_denda,
                'status_denda' => 'belum_lunas'
            ]);

            // Panggil fungsi kirim WA (Simulasi)
            $this->_kirim_notif_wa($row['id_transaksi'], $total_denda);
        }
    }

    /**
     * PRIVATE FUNCTION: Simulasi Integrasi WhatsApp API
     */
    private function _kirim_notif_wa($id_transaksi, $nominal_denda) {
        // Ambil info buku dan nomor HP user
        $this->db->select('users.no_hp, users.nama_lengkap, buku.judul');
        $this->db->from('transaksi');
        $this->db->join('users', 'users.id = transaksi.id_siswa');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $this->db->where('transaksi.id_transaksi', $id_transaksi);
        $data = $this->db->get()->row_array();

        if (!empty($data['no_hp'])) {
            $pesan = "Halo *" . $data['nama_lengkap'] . "*, pinjaman buku *" . $data['judul'] . "* Anda telah melewati batas. Denda saat ini: *Rp " . number_format($nominal_denda, 0, ',', '.') . "*. Mohon segera dikembalikan ke perpustakaan.";
            
            // Logika ini biasanya dikirim ke API seperti Fonnte/Wablas/Starsender
            // Contoh implementasi CURL jika kamu sudah punya token API:
            /*
            curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => array('target' => $data['no_hp'], 'message' => $pesan),
                CURLOPT_HTTPHEADER => array('Authorization: TOKEN_API_KAMU'),
            ));
            curl_exec($curl);
            */
        }
    }

    /**
     * Halaman Dashboard Utama
     */
    public function index() {
        $id_siswa = $this->session->userdata('id');
        $data['nama_user'] = $this->session->userdata('nama');
        $data['judul']     = "Dashboard Perpustakaankuu";

        // Statistik: Mengambil data dari tabel transaksi
        $data['total_pinjaman'] = $this->db->where('id_siswa', $id_siswa)->from('transaksi')->count_all_results();
        $data['sedang_dipinjam'] = $this->db->where(['id_siswa' => $id_siswa, 'status' => 'dipinjam'])->from('transaksi')->count_all_results();
        $data['selesai_dibaca'] = $this->db->where(['id_siswa' => $id_siswa, 'status' => 'dikembalikan'])->from('transaksi')->count_all_results();

        // Tambahan: Total denda yang belum dibayar untuk alert di Dashboard
        $this->db->select_sum('denda');
        $this->db->where(['id_siswa' => $id_siswa, 'status_denda' => 'belum_lunas']);
        $data['total_tagihan_denda'] = $this->db->get('transaksi')->row()->denda;

        // Data Buku yang sedang dipinjam (untuk tabel di dashboard)
        $this->db->select('transaksi.*, buku.judul, buku.penulis, buku.cover as sampul');
        $this->db->from('transaksi');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $this->db->where('transaksi.id_siswa', $id_siswa);
        $this->db->where('transaksi.status', 'dipinjam');
        $query_buku = $this->db->get()->result_array();

        $data['buku_pinjam'] = !empty($query_buku) ? $query_buku : [];

        $this->load->view('user/v_dashboard', $data);
    }

    /**
     * Fitur Pinjaman Saya (Riwayat Lengkap)
     */
    public function pinjaman() {
        $id_siswa = $this->session->userdata('id');
        $data['nama_user'] = $this->session->userdata('nama');
        $data['judul']     = "Pinjaman Saya";

        // Ambil SEMUA transaksi baik yang sudah kembali maupun belum
        $this->db->select('transaksi.*, buku.judul, buku.penulis, buku.cover as sampul');
        $this->db->from('transaksi');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $this->db->where('transaksi.id_siswa', $id_siswa);
        $this->db->order_by('transaksi.id_transaksi', 'DESC');
        $data['riwayat'] = $this->db->get()->result_array();

        $this->load->view('user/v_pinjaman', $data);
    }

    /**
     * Fitur Profil Siswa
     */
    public function profil() {
        $id_siswa = $this->session->userdata('id');
        $data['nama_user'] = $this->session->userdata('nama');
        $data['judul']     = "Profil Saya";

        // Ambil data user lengkap dari database
        $data['user'] = $this->db->get_where('users', ['id' => $id_siswa])->row_array();

        $this->load->view('user/v_profil', $data);
    }

    /**
     * Fitur Update Foto Profil
     */
    public function update_foto() {
        $id_siswa = $this->session->userdata('id');
        
        // Folder penyimpanan
        $config['upload_path']          = './assets/img/profile/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 2048; 
        $config['file_name']            = 'user_' . $id_siswa . '_' . time();

        $this->load->library('upload', $config);

        // Pastikan folder ada
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        if (!$this->upload->do_upload('foto_profil')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
            redirect('index.php/user/profil');
        } else {
            $upload_data = $this->upload->data();
            $nama_file = $upload_data['file_name'];

            // Update database
            $this->db->where('id', $id_siswa);
            $this->db->update('users', ['foto' => $nama_file]);

            $this->session->set_flashdata('success', 'Foto profil berhasil diperbarui!');
            redirect('index.php/user/profil');
        }
    }

    /**
     * Fitur Cari Buku (Katalog) dengan Fitur Search Otomatis
     */
    public function cari_buku() {
        $data['nama_user'] = $this->session->userdata('nama');
        $data['judul']     = "Katalog Buku";

        // Ambil keyword dari form pencarian (method GET)
        $keyword = $this->input->get('keyword');

        if (!empty($keyword)) {
            // Jika ada kata kunci, cari judul, penulis, atau kategori yang mirip
            $this->db->like('judul', $keyword);
            $this->db->or_like('penulis', $keyword);
            $this->db->or_like('kategori', $keyword);
            $data['buku'] = $this->db->get('buku')->result_array();
        } else {
            // Jika tidak ada kata kunci, ambil semua data buku
            $data['buku'] = $this->db->get('buku')->result_array();
        }

        $this->load->view('user/v_cari_buku', $data);
    }

    /**
     * Fitur Detail Buku
     */
    public function detail_buku($id) {
        $data['nama_user'] = $this->session->userdata('nama');
        $data['judul']     = "Detail Buku";

        // Ambil data buku berdasarkan ID
        $data['buku'] = $this->db->get_where('buku', ['id_buku' => $id])->row_array();

        if (empty($data['buku'])) {
            show_404();
        }

        $this->load->view('user/v_detail_buku', $data);
    }

    /**
     * PROSES PINJAM BUKU (BARU)
     * Mengurangi stok dan menambah data ke tabel transaksi
     */
    public function proses_pinjam($id_buku) {
        $id_siswa = $this->session->userdata('id');

        // SECURITY: Cek apakah siswa masih punya denda yang belum lunas sebelum boleh pinjam lagi
        $cek_denda = $this->db->where(['id_siswa' => $id_siswa, 'status_denda' => 'belum_lunas', 'denda >' => 0])->get('transaksi')->num_rows();
        if ($cek_denda > 0) {
            $this->session->set_flashdata('error', 'Gagal meminjam! Selesaikan dulu denda Anda sebelum meminjam buku baru.');
            redirect('index.php/user/pinjaman');
            return;
        }
        
        // 1. Ambil data buku untuk cek stok
        $buku = $this->db->get_where('buku', ['id_buku' => $id_buku])->row_array();
        
        if ($buku && $buku['stok'] > 0) {
            // 2. Siapkan data transaksi
            $data_transaksi = [
                'id_siswa'           => $id_siswa,
                'id_buku'            => $id_buku,
                'tanggal_pinjam'     => date('Y-m-d'),
                'batas_pengembalian' => date('Y-m-d', strtotime('+7 days')), // Durasi pinjam 7 hari
                'status'             => 'dipinjam',
                'denda'              => 0,
                'status_denda'       => 'lunas'
            ];

            // 3. Simpan Transaksi
            $this->db->insert('transaksi', $data_transaksi);

            // 4. Update Stok Buku (Kurangi 1)
            $this->db->set('stok', 'stok - 1', FALSE);
            $this->db->where('id_buku', $id_buku);
            $this->db->update('buku');

            // Cek jika stok menjadi 0, update status buku menjadi habis
            if (($buku['stok'] - 1) <= 0) {
                $this->db->where('id_buku', $id_buku);
                $this->db->update('buku', ['status' => 'habis']);
            }

            $this->session->set_flashdata('success', 'Berhasil meminjam buku <b>'.$buku['judul'].'</b>. Selamat membaca!');
            redirect('index.php/user/pinjaman');
        } else {
            $this->session->set_flashdata('error', 'Gagal meminjam. Stok buku sedang kosong.');
            redirect('index.php/user/cari_buku');
        }
    }

    /**
     * Logout dan kembali ke Landing Page
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }
}