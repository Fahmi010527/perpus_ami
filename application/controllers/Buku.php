<?php
// Mencegah akses langsung ke file script
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat model buku untuk interaksi database
        $this->load->model('Model_Buku');
        
        // Proteksi: Jika session username kosong, arahkan kembali ke login
        if (!$this->session->userdata('username')) {
            redirect('auth');
        }
    }

    public function index() {
        // Menentukan judul halaman untuk dikirim ke view
        $data['judul'] = "Koleksi Buku - Perpus AMI";
        // Mengambil nama lengkap user dari session
        $data['nama_user'] = $this->session->userdata('nama_lengkap');
        
        // Mengambil semua data buku dari tabel buku melalui model
        $data['buku'] = $this->Model_Buku->get_all_buku()->result();

        // Memuat template layout dan halaman utama buku
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('admin/buku/index', $data);
        $this->load->view('layout/footer');
    }

    /**
     * Fungsi untuk menyimpan data buku baru beserta upload cover
     */
    public function simpan() {
        // Konfigurasi library upload CI
        $config['upload_path']   = './assets/img/cover/'; // Pastikan folder ini ada
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 2048; // Limit 2MB
        $config['file_name']     = 'cover-' . time();

        $this->load->library('upload', $config);

        // Jika upload berhasil, ambil nama filenya, jika tidak pakai default
        if ($this->upload->do_upload('cover')) {
            $cover = $this->upload->data('file_name');
        } else {
            $cover = 'default.jpg';
        }

        // Menangkap data dari form input
        $data = [
            'judul'        => $this->input->post('judul'), // Menangkap judul
            'penulis'      => $this->input->post('penulis'), // Menangkap penulis
            'penerbit'     => $this->input->post('penerbit'), // Menangkap penerbit
            'tahun_terbit' => $this->input->post('tahun_terbit'), // Menangkap tahun
            'kategori'     => $this->input->post('kategori'), // Menangkap kategori
            'stok'         => $this->input->post('stok'), // Menangkap jumlah stok
            'cover'        => $cover, // Menyimpan nama file cover
            'status'       => ($this->input->post('stok') > 0) ? 'tersedia' : 'habis' // Set status otomatis
        ];

        // Menjalankan perintah insert ke database
        $this->db->insert('buku', $data);
        $this->session->set_flashdata('pesan', 'Buku baru berhasil ditambahkan!');
        redirect('index.php/buku');
    }

    /**
     * Fungsi untuk memperbarui data buku (Edit)
     */
    public function update() {
        $id = $this->input->post('id_buku');
        
        // Cek apakah ada upload cover baru
        $config['upload_path']   = './assets/img/cover/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name']     = 'cover-' . time();

        $this->load->library('upload', $config);

        $data = [
            'judul'        => $this->input->post('judul'),
            'penulis'      => $this->input->post('penulis'),
            'penerbit'     => $this->input->post('penerbit'),
            'tahun_terbit' => $this->input->post('tahun_terbit'),
            'kategori'     => $this->input->post('kategori'),
            'stok'         => $this->input->post('stok'),
            'status'       => ($this->input->post('stok') > 0) ? 'tersedia' : 'habis'
        ];

        // Jika user memilih file baru, update covernya
        if ($this->upload->do_upload('cover')) {
            $data['cover'] = $this->upload->data('file_name');
        }

        $this->db->where('id_buku', $id);
        $this->db->update('buku', $data);
        $this->session->set_flashdata('pesan', 'Data buku berhasil diperbarui!');
        redirect('index.php/buku');
    }

    /**
     * Fungsi untuk menghapus data buku
     */
    public function hapus($id) {
        $this->db->where('id_buku', $id);
        $this->db->delete('buku');
        $this->session->set_flashdata('pesan', 'Buku berhasil dihapus!');
        redirect('index.php/buku');
    }
}