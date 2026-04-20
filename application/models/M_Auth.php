<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Auth extends CI_Model {

    /**
     * Fungsi untuk cek login dengan Plain Text
     * Mencocokkan langsung username dan password[cite: 1]
     */
    public function cek_login($user, $pass) {
        $this->db->where('username', $user);     // Cek Username[cite: 1]
        $this->db->where('password', $pass);     // Cek Password (Teks Biasa)[cite: 1]
        $this->db->where('is_deleted', 0);       // Pastikan user tidak dihapus[cite: 1]
        
        // Mengambil 1 baris data hasil query[cite: 1]
        return $this->db->get('users')->row();
    }
}