<?php
include_once 'models/Bantuan.php';

class BantuanPresenter {
    private $model;

    public function __construct($db) {
        $this->model = new Bantuan($db);
    }

    public function index() {
        // Ambil Data Bantuan Masuk
        $stmtMasuk = $this->model->getSemuaBantuanMasuk();
        $dataMasuk = $stmtMasuk->fetchAll(PDO::FETCH_ASSOC);

        // Ambil Data Bantuan Salur (NEW)
        $stmtSalur = $this->model->getSemuaBantuanSalur();
        $dataSalur = $stmtSalur->fetchAll(PDO::FETCH_ASSOC);

        // Panggil View Tunggal
        include 'views/home.php'; 
    }

    public function prosesTambah($data) {
        $this->model->tambahBantuan($data);
        header("Location: index.php"); // Selalu kembali ke index
    }

    public function prosesUbah($id, $nilai, $status) {
        $this->model->updateBantuan($id, $nilai, $status);
        header("Location: index.php");
    }

    public function prosesHapus($id) {
        $this->model->hapusBantuan($id);
        header("Location: index.php");
    }

    public function prosesSalur($id) {
        // Sesuai soal, saat disalurkan bisa jadi 'tersalur' atau 'hilang'. 
        // Disini kita default 'tersalur', nanti bisa diubah di tabel bawah jika mau.
        $this->model->salurkanBantuan($id, 'tersalur');
        header("Location: index.php");
    }

    // Update status di tabel bawah (jika diperlukan sesuai gambar tombol 'Ubah')
    public function prosesUbahSalur($id, $status) {
        $this->model->updateStatusSalur($id, $status);
        header("Location: index.php");
    }
}
?>