<?php
class BukuController
{
    public function __construct(private Buku $model) {}

    public function index(): void
    {
        $buku = $this->model->getAll();
        require __DIR__ . '/../views/buku/index.php';
    }

    public function create(): void
    {
        require __DIR__ . '/../views/buku/create.php';
    }

    public function store(): void
    {
        $data = $this->validateInput($_POST);
        $this->model->insert($data);
        header('Location: index.php?page=buku');
        exit;
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $buku = $this->model->findById($id);

        if (!$buku) {
            http_response_code(404);
            exit('Data buku tidak ditemukan.');
        }

        require __DIR__ . '/../views/buku/edit.php';
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->validateInput($_POST);
        $this->model->update($id, $data);
        header('Location: index.php?page=buku');
        exit;
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->model->delete($id);
        header('Location: index.php?page=buku');
        exit;
    }

    private function validateInput(array $input): array
    {
        $data = [
            'isbn'         => trim($input['isbn'] ?? ''),
            'judul'        => trim($input['judul'] ?? ''),
            'penulis'      => trim($input['penulis'] ?? ''),
            'penerbit'     => trim($input['penerbit'] ?? ''),
            'tahun_terbit' => trim($input['tahun_terbit'] ?? ''),
            'harga'        => trim($input['harga'] ?? '')
        ];

        foreach ($data as $nilai) {
            if ($nilai === '') {
                exit('Semua field wajib diisi.');
            }
        }

        if (!ctype_digit($data['tahun_terbit'])
            || (int) $data['tahun_terbit'] < 1900
            || (int) $data['tahun_terbit'] > (int) date('Y')) {
            exit('Tahun terbit harus berupa angka antara 1900 dan tahun sekarang.');
        }

        if (!ctype_digit($data['harga'])) {
            exit('Harga harus berupa angka bulat positif.');
        }

        $data['tahun_terbit'] = (int) $data['tahun_terbit'];
        $data['harga']        = (int) $data['harga'];

        return $data;
    }
}
?>