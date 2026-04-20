<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Buku extends CI_Model {

    public function get_all_buku() {
        // Filter buku yang belum dihapus[cite: 1]
        $this->db->where('is_deleted', 0);
        return $this->db->get('buku');
    }

    public function delete_buku($id) {
        // Logika soft delete: update status is_deleted dan waktu hapus[cite: 1]
        $data = [
            'is_deleted' => 1,
            'deleted_at' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_buku', $id);
        return $this->db->update('buku', $data);
    }
}