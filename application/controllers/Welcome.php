<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memanggil model Admin dari sub-folder admin
        $this->load->model('admin/M_Admin');
        // Helper lib untuk fitur jam sekolah
        $this->load->helper('lib');
    }

    public function index() {
        $data['title'] = "Perpustakaankuu - Jendela Dunia";
        
        // Mengambil daftar buku dari model yang baru dibuat
        $data['buku'] = $this->M_Admin->get_semua_buku();
        
        $this->load->view('v_landing', $data);
    }
}