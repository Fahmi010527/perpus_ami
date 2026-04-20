<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('role') != 'admin') {
            redirect('index.php/auth/login');
        }
    }

    public function index() {
        $data['judul'] = "Dashboard Admin - Perpustakaankuu";
        $data['nama_user'] = $this->session->userdata('nama_lengkap');

        // Statistik Utama
        $data['total_buku']    = $this->db->count_all('buku');
        $data['total_anggota'] = $this->db->where('role', 'siswa')->count_all_results('users');
        $data['total_pinjam']  = $this->db->where('status', 'dipinjam')->count_all_results('transaksi');

        // Grafik Bulanan
        $data['grafik_bulanan'] = [15, 30, 25, 45, 40, 60];

        // Grafik Kategori
        $query_kategori = $this->db->select('kategori, COUNT(*) as total')
                                   ->group_by('kategori')
                                   ->get('buku')
                                   ->result_array();
        
        $labels = [];
        $counts = [];
        foreach ($query_kategori as $row) {
            $labels[] = $row['kategori'];
            $counts[] = $row['total'];
        }
        
        $data['label_kategori'] = !empty($labels) ? $labels : ['Belum Ada Data'];
        $data['data_kategori']  = !empty($counts) ? $counts : [0];
        $data['grafik_member'] = [50, 80, 60, 90, 70, 100];

        // Aktivitas Terbaru
        $this->db->select('transaksi.*, users.nama_lengkap, buku.judul');
        $this->db->from('transaksi');
        $this->db->join('users', 'users.id = transaksi.id_siswa');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $this->db->order_by('transaksi.tanggal_pinjam', 'DESC');
        $this->db->limit(5);
        $data['peminjaman_terkini'] = $this->db->get()->result();

        // --- UPDATE LOAD VIEW AGAR SIDEBAR MUNCUL ---
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data); // Memanggil sidebar yang sudah diperbaiki
        $this->load->view('admin/v_dashboard', $data);
        $this->load->view('layout/footer');
    }
}