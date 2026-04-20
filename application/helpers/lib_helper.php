<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Fungsi Enkripsi AES tetap ada sesuai permintaanmu
if (!function_exists('encrypt_pw')) {
    function encrypt_pw($password) {
        $key = "PERPUS_BOGOR_2026"; 
        $method = "AES-256-CBC";
        $iv = substr(hash('sha256', $key), 0, 16);
        return base64_encode(openssl_encrypt($password, $method, $key, 0, $iv));
    }
}

// Fungsi Cek Akses Jam Sekolah (Selalu aktif)
if (!function_exists('cek_akses_sekolah')) {
    function cek_akses_sekolah() {
        return true; 
    }
}