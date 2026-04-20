<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat model, helper url, dan database
        $this->load->model('M_Auth');
        $this->load->helper(['url']);
        $this->load->database();
    }

    public function index() {
        // Memastikan file v_register ada di folder views/auth/
        $this->load->view('auth/v_register');
    }

    public function proses_daftar() {
        // 1. Ambil input dari form
        $nama     = $this->input->post('nama');
        $username = $this->input->post('username');
        $kelas    = $this->input->post('kelas');
        $password = $this->input->post('password');

        /**
         * 2. TANPA HASH (Plain Text)
         * Password disimpan langsung apa adanya sesuai permintaanmu
         */
        $password_plain = $password;

        // 3. Siapkan data sesuai struktur tabel 'users' di database kamu
        $data_simpan = array(
            'nama_lengkap' => $nama,     // Sesuai kolom di DB[cite: 1]
            'username'     => $username, // Sesuai kolom di DB[cite: 1]
            'kelas'        => $kelas,    // Sesuai kolom di DB[cite: 1]
            'password'     => $password_plain, // Disimpan tanpa enkripsi[cite: 1]
            'role'         => 'siswa',   // Default sebagai siswa[cite: 1]
            'is_deleted'   => 0          // Status aktif[cite: 1]
        );

        // 4. Insert ke tabel 'users'[cite: 1]
        $simpan = $this->db->insert('users', $data_simpan);

        if ($simpan) {
            echo "<script>
                alert('Pendaftaran Berhasil! Silakan Login.'); 
                window.location='" . base_url('index.php/auth/login') . "';
            </script>";
        } else {
            echo "<script>
                alert('Gagal Daftar! Pastikan Username belum digunakan.'); 
                history.go(-1);
            </script>";
        }
    }
}