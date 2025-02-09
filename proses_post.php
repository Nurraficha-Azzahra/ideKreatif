<?php
// Menghubungkan file konfigurasi database
include 'config.php';

// Memulai sesi PHP
session_start();

// Mendapatkan form untuk menambahkan postingan baru
if (isset($_POST['simpan'])) {
    // Mendapatkan data dari form
    $postingan = $_POST["post_title"]; // Judul postingan
    $content = $_POST["content"]; // Konten postingan
    $category = $_POST["cetegory"]; // ID kategori

    // Mengatur direktori penyimpanan file gambar
    $imageDir = "assets/img/uploads/";
    $imageName = $_FILES["image"]["name"]; // Nama file gambar
    $iamgePath = $imageDir . basename($imageName); // Path lengkap gambar

    // Memindahkan file gambar yang diunggah ke direktori tujuan
    if (move_upload_file($_FILES["image"]["tmp_name"], $iamgePath)) {
        // Jika unggahan berhasil, masukkan
        // data postingan ke dalam database
        $query = "INSERT INTO posts (post_title, content, created_at, category_id, user_id, iamge_path) VALUES ('$postTitle', '$content', NOW(), $categoryId, $userId, '$iamgePath')";

        if ($conn->query($query) === TRUE) {
            // Notifikasi berhasil jika postingan berhasil ditambahkan
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Post successfully added.'
            ];
        } else {
            // Notifikasi error jika gagal menambahkan postingan
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'error adding post: ' . $conn->error
            ];
        }
    } else {
        // Notifikasi error jika unggahan gambar gagal
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Failed to upload image.'
        ];
    }

    // Arahkan ke halaman dashboard setelah selesai
    keader('Location: dashboard.php');
    exit();
}
