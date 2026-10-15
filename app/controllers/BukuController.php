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
        [$data, $error] = $this->validateInput($_POST);
        if ($error) {
            $this->flash('error', $error);
            $this->redirect('index.php?page=buku&action=create');
        }

        try {
            $this->model->insert($data);
            $this->flash('success', 'Data buku berhasil ditambahkan.');
        } catch (PDOException $e) {
            $this->flash('error', $this->pesanDatabase($e, 'menambahkan'));
            $this->redirect('index.php?page=buku&action=create');
        }

        $this->redirect('index.php?page=buku');
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

        [$data, $error] = $this->validateInput($_POST);
        if ($error) {
            $this->flash('error', $error);
            $this->redirect('index.php?page=buku&action=edit&id=' . $id);
        }

        try {
            $this->model->update($id, $data);
            $this->flash('success', 'Data buku berhasil diperbarui.');
        } catch (PDOException $e) {
            $this->flash('error', $this->pesanDatabase($e, 'memperbarui'));
            $this->redirect('index.php?page=buku&action=edit&id=' . $id);
        }

        $this->redirect('index.php?page=buku');
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->model->delete($id);
            $this->flash('success', 'Data buku berhasil dihapus.');
        } catch (PDOException $e) {
            $this->flash('error', $this->pesanDatabase($e, 'menghapus'));
        }

        $this->redirect('index.php?page=buku');
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    private function redirect(string $url): never
    {
        header('Location: ' . $url);
        exit;
    }

    private function pesanDatabase(PDOException $e, string $aksi): string
    {
        // Kode 1062 = duplicate entry (ISBN kembar)
        if (($e->errorInfo[1] ?? 0) === 1062) {
            return 'Gagal ' . $aksi . ' data: ISBN sudah terdaftar.';
        }
        return 'Gagal ' . $aksi . ' data karena terjadi kesalahan pada database.';
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
                return [null, 'Semua field wajib diisi.'];
            }
        }

        if (!ctype_digit($data['tahun_terbit'])
            || (int) $data['tahun_terbit'] < 1900
            || (int) $data['tahun_terbit'] > (int) date('Y')) {
            return [null, 'Tahun terbit harus berupa angka antara 1900 dan tahun sekarang.'];
        }

        if (!ctype_digit($data['harga'])) {
            return [null, 'Harga harus berupa angka bulat positif.'];
        }

        $data['tahun_terbit'] = (int) $data['tahun_terbit'];
        $data['harga']        = (int) $data['harga'];

        return [$data, null];
    }
}
?>