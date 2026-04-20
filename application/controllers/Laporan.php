<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function index() {
        $tgl_mulai = $this->input->get('tgl_mulai');
        $tgl_selesai = $this->input->get('tgl_selesai');

        $data['judul'] = 'Rekapitulasi Laporan - Perpus AMI';
        
        // Penyesuaian Query dengan struktur database asli
        $this->db->select('transaksi.*, users.nama_lengkap, buku.judul');
        $this->db->from('transaksi');
        $this->db->join('users', 'users.id = transaksi.id_siswa'); // Sesuaikan id_siswa
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku'); // Sesuaikan id_buku

        if($tgl_mulai && $tgl_selesai) {
            $this->db->where('tanggal_pinjam >=', $tgl_mulai);
            $this->db->where('tanggal_pinjam <=', $tgl_selesai);
        }

        $data['laporan'] = $this->db->get()->result();
        $data['tgl_mulai'] = $tgl_mulai;
        $data['tgl_selesai'] = $tgl_selesai;

        // Statistik
        $data['total_buku'] = $this->db->count_all('buku');
        $data['total_anggota'] = $this->db->get_where('users', ['role' => 'siswa'])->num_rows();
        $data['total_pinjam'] = $this->db->get_where('transaksi', ['status' => 'dipinjam'])->num_rows();
        $data['total_denda'] = $this->db->select_sum('denda')->get('transaksi')->row()->denda;

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('admin/laporan/index', $data);
        $this->load->view('layout/footer');
    }

    public function cetak_pdf() {
        $tgl_mulai = $this->input->get('tgl_mulai');
        $tgl_selesai = $this->input->get('tgl_selesai');

        $this->db->select('transaksi.*, users.nama_lengkap, buku.judul');
        $this->db->from('transaksi');
        $this->db->join('users', 'users.id = transaksi.id_siswa');
        $this->db->join('buku', 'buku.id_buku = transaksi.id_buku');

        if($tgl_mulai && $tgl_selesai) {
            $this->db->where('tanggal_pinjam >=', $tgl_mulai);
            $this->db->where('tanggal_pinjam <=', $tgl_selesai);
        }

        $data['laporan'] = $this->db->get()->result();
        $data['tgl_mulai'] = $tgl_mulai;
        $data['tgl_selesai'] = $tgl_selesai;

        $this->load->view('admin/laporan/cetak_pdf', $data);
    }
}