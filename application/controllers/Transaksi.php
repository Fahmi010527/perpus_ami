<?php
// Mencegah akses langsung ke file script
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function index() {
        // Menentukan judul halaman untuk ditampilkan di header
        $data['judul'] = 'Transaksi Peminjaman - Perpus AMI';

        // Mengambil data sesuai struktur database db_perpus
        $this->db->select('transaksi.*, buku.judul as judul_buku, users.nama_lengkap as nama_peminjam');
        $this->db->from('transaksi');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $this->db->join('users', 'users.id = transaksi.id_siswa'); 
        $data['transaksi'] = $this->db->get()->result();

        // Memuat view dengan urutan yang benar
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('admin/transaksi/index', $data);
        $this->load->view('layout/footer');
    }

    // Method untuk mencetak laporan
    public function cetak() {
        $data['judul'] = 'Laporan Transaksi Perpustakaan';
        
        $this->db->select('transaksi.*, buku.judul as judul_buku, users.nama_lengkap as nama_peminjam');
        $this->db->from('transaksi');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $this->db->join('users', 'users.id = transaksi.id_siswa');
        $data['transaksi'] = $this->db->get()->result();

        $this->load->view('admin/transaksi/cetak', $data);
    }

    // --- TAMBAHAN FITUR DETAIL ---
    // Mengambil data detail via AJAX untuk ditampilkan di Modal
    public function detail_ajax($id) {
        // Pastikan alias judul_buku dan nama_lengkap konsisten dengan JS
        $this->db->select('transaksi.*, buku.judul as judul_buku, users.nama_lengkap');
        $this->db->from('transaksi');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');
        $this->db->join('users', 'users.id = transaksi.id_siswa');
        $this->db->where('transaksi.id_transaksi', $id);
        $data = $this->db->get()->row();
        
        // Mengembalikan data dalam format JSON
        echo json_encode($data);
    }
}