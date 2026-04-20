<?php
// Mencegah akses langsung ke script demi keamanan
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota extends CI_Controller {

    public function index() {
        // Judul halaman untuk ditampilkan di title browser
        $data['judul'] = 'Data Anggota - Perpus AMI';
        
        // PERBAIKAN DI SINI (Baris 8): Menggunakan penulisan array [] yang benar
        // Pastikan tidak ada titik dua (:) di dalam kurung siku kecuali untuk key => value
        $data['anggota'] = $this->db->get_where('users', ['role' => 'siswa', 'is_deleted' => 0])->result();

        // Memuat template dan view secara berurutan
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('admin/anggota/index', $data);
        $this->load->view('layout/footer');
    }

    // Fungsi untuk menambah anggota baru beserta upload foto
    public function tambah() {
        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'username'     => $this->input->post('username'),
            'password'     => $this->input->post('password'), // Sebaiknya gunakan password_hash jika sudah production
            'kelas'        => $this->input->post('kelas'),
            'role'         => 'siswa',
            'is_deleted'   => 0
        ];

        // Logika upload foto jika ada file yang dipilih
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path']   = './assets/img/profile/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['file_name']     = 'user_' . time();
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $data['foto'] = $upload_data['file_name'];
            }
        }

        $this->db->insert('users', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success shadow-sm">Anggota berhasil ditambahkan secara sistem!</div>');
        redirect('index.php/anggota');
    }

    // Fungsi untuk mengedit data anggota, password, dan foto profil
    public function edit() {
        $id = $this->input->post('id');
        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'username'     => $this->input->post('username'),
            'kelas'        => $this->input->post('kelas')
        ];

        // Jika password diisi, maka update passwordnya
        if ($this->input->post('password')) {
            $data['password'] = $this->input->post('password');
        }

        // Logika update foto profil
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path']   = './assets/img/profile/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['file_name']     = 'user_' . time();
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $data['foto'] = $upload_data['file_name'];
            }
        }

        $this->db->where('id', $id);
        $this->db->update('users', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-info shadow-sm">Data anggota telah berhasil diperbarui.</div>');
        redirect('index.php/anggota');
    }

    // Fungsi untuk menampilkan halaman cetak kartu
    public function kartu($id) {
        $data['judul'] = 'Cetak Kartu Anggota';
        // Mengambil data user spesifik berdasarkan ID
        $data['user'] = $this->db->get_where('users', ['id' => $id])->row();
        $this->load->view('admin/anggota/kartu', $data);
    }

    // Fungsi hapus (Soft Delete)
    public function hapus($id) {
        $this->db->where('id', $id);
        $this->db->update('users', ['is_deleted' => 1]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger shadow-sm">Anggota berhasil dihapus.</div>');
        redirect('index.php/anggota');
    }
}