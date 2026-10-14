<?php
require '../config/database.php';
require '../app/models/Mahasiswa.php';
require '../app/controllers/MahasiswaController.php';

$db = (new Database())->connect();
$model = new Mahasiswa($db);
$controller = new MahasiswaController($model);

$page = $_GET['page'] ?? 'mahasiswa';
$action = $_GET['action'] ?? 'index';

if ($page !== 'mahasiswa') {
    http_response_code(404);
    exit('Halaman tidak ditemukan.');
}

match ($action) {
    'index'  => $controller->index(),
    'create' => $controller->create(),
    'store'  => $controller->store(),
    'edit'   => $controller->edit(),
    'update' => $controller->update(),
    'delete' => $controller->delete(),
    default  => (function () {
        http_response_code(404);
        exit('Action tidak ditemukan.');
    })()
};
?>