<?php
include_once 'config/database.php';
include_once 'presenters/BantuanPresenter.php';

$database = new Database();
$db = $database->getConnection();
$presenter = new BantuanPresenter($db);

$action = isset($_GET['act']) ? $_GET['act'] : '';

switch ($action) {
    case 'simpan':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $presenter->prosesTambah($_POST);
        }
        break;

    case 'ubah':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Mengubah nilai dan status di tabel atas
            $presenter->prosesUbah($_POST['id'], $_POST['nilai'], $_POST['status']);
        }
        break;
    
    case 'ubahsalur':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Mengubah status di tabel bawah
            $presenter->prosesUbahSalur($_POST['id'], $_POST['status']);
        }
        break;

    case 'hapus':
        if (isset($_GET['id'])) {
            $presenter->prosesHapus($_GET['id']);
        }
        break;

    case 'salur':
        if (isset($_GET['id'])) {
            // Memindah data ke tabel bawah
            $presenter->prosesSalur($_GET['id']);
        }
        break;

    default:
        $presenter->index(); // Tampilkan halaman utama (Home)
        break;
}
?>