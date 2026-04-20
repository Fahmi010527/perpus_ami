<?php
// Mencegah akses langsung ke file script
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

    public function index() {
        $data['judul'] = 'Profil Saya - Perpus AMI';

        // Ambil ID dari session login
        $id_user = $this->session->userdata('id'); 
        
        // Pastikan menggunakan array ['id' => $id_user] dengan benar
        $data['user'] = $this->db->get_where('users', array('id' => $id_user))->row();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('admin/profil/index', $data);
        $this->load->view('layout/footer');
    }

    public function update() {
        $id = $this->input->post('id');
        
        $data = array(
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'username'     => $this->input->post('username')
        );

        // Logika upload foto
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path']   = './assets/img/profile/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name']     = 'user_'.time();
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('foto')) {
                $data['foto'] = $this->upload->data('file_name');
            }
        }

        $this->db->where('id', $id);
        $this->db->update('users', $data);
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-success">Profil berhasil diperbarui!</div>');
        redirect('index.php/profil');
    }

    public function ganti_password() {
        $id = $this->input->post('id');
        $password = $this->input->post('password'); 

        $this->db->where('id', $id);
        $this->db->update('users', array('password' => $password));
        
        $this->session->set_flashdata('pesan', '<div class="alert alert-success">Password berhasil diganti!</div>');
        redirect('index.php/profil');
    }
}