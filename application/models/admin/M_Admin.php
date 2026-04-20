<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Admin extends CI_Model {

    // Mengambil data statistik untuk grafik monitor profesional di Dashboard
    public function get_statistik_monitor() {
        $this->db->select('tanggal_pinjam, COUNT(id_transaksi) as jumlah');
        $this->db->from('transaksi');
        $this->db->group_by('tanggal_pinjam');
        $this->db->order_by('tanggal_pinjam', 'ASC');
        $this->db->limit(7); 
        return $this->db->get()->result();
    }

    // Mengambil semua data buku yang aktif
    public function get_semua_buku() {
        return $this->db->get_where('buku', ['is_deleted' => 0])->result();
    }
}