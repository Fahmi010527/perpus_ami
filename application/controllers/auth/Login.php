<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    // --- (Konstruktor dan Fungsi Login Tetap Sama) ---
    public function __construct() {
        parent::__construct();
        $this->load->model('M_Auth');
        $this->load->library('session');
    }

    public function index() {
        if ($this->session->userdata('logged_in') == TRUE) {
            $role = $this->session->userdata('role');
            redirect('index.php/' . ($role == 'admin' ? 'admin' : 'user'));
        }
        $this->load->view('auth/v_login');
    }

    public function proses_login() {
        $username = trim($this->input->post('username', TRUE));
        $password = trim($this->input->post('password', TRUE));
        $user = $this->db->get_where('users', ['username' => $username])->row();

        if ($user) {
            if ($password === $user->password) {
                $data_session = [
                    'id'        => $user->id,
                    'username'  => $user->username,
                    'nama'      => $user->nama_lengkap,
                    'role'      => strtolower($user->role),
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($data_session);
                if ($this->session->userdata('role') == 'admin') {
                    redirect('index.php/admin');
                } else {
                    redirect('index.php/user');
                }
            } else {
                $this->session->set_flashdata('error', 'Password salah!');
                redirect('index.php/auth/login');
            }
        } else {
            $this->session->set_flashdata('error', 'Username tidak ada!');
            redirect('index.php/auth/login');
        }
    }

    // --- UPDATE FUNGSI LOGOUT (KEMBALI KE LANDING PAGE) ---
    public function logout() {
        // Hapus semua data login
        $this->session->sess_destroy();
        
        /**
         * redirect(base_url()) akan mengarahkan user ke 
         * halaman paling depan (Landing Page / Welcome Page).
         */
        redirect(base_url()); 
    }
}