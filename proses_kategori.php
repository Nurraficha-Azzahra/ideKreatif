<?php

// Menghubungkan ke file konfigurasi database
include("config.php");

// Memulai sesi untuk menyimpan notifikasi
session_start();

// Proses penambahan kategori baru
if (isset($_POST['simpan'])){
   // Mengambil data nama kategori dari form
   $category_name = $_POST['category_name'];

   // Query untuk menambahkan data kategori ke dalam database
   $query = "INSERT INTO categories (category_name) VALUES ('$category_name')";
   $exec = mysqli_query($conn, $query);

   // Menyimpan notifikasi berhasil atau gagal ke dalam session
   if ($exec){
     $_SESSION['notification'] = [
       'type' => 'primary', // Jenis notifikasi (contoh: primary untuk keberhasilan)
       'message' => 'ketegori berhasil ditambahkan!'
     ];
   } else {
     $_SESSION['notification'] = [
       'type' => 'danger', // Jenis notifikasi (contoh: danger untuk kegagalan)
       'message' => 'Gagal menambahkan ketegori: '. mysqli_error($conn)
     ];
   }

   // Redirect kembali ke halaman kategori
   header('Location: kategori.php');
   exit();
}

// Proses penghapusan ketegori
if (isset($_POST['delete'])){
  // Mengambil ID kategori dari paramentar URL
  $catID= $_POST['catID'];

  // Query untuk menghapus data kategori berdasarkan ID
  $exec = mysqli_query($conn, "DELETE FROM categories WHERE category_id='$catID'");

  // Menyimpan notifikasi berhasil atau gagal ke dalam session
  if ($exec){
    $_SESSION['notification'] = [
      'type' => 'primary', 
      'message' => 'ketegori berhasil dihapus!'
    ];
  } else {
    $_SESSION['notification'] = [
      'type' => 'danger', 
      'message' => 'Gagal menghapus ketegori: '. mysqli_error($conn)
    ];
  }

  // Redirect kembali ke halaman kategori
  header('Location: kategori.php');
  exit();
}

// Proses pembaruan ketegori
if (isset($_POST['update'])){
  // Mengambil data dari form pembaruan
  $catID = $_POST['catID'];
  $category_name = $_POST['category_name'];

  // Query untuk memperbarui data kategori berdasarkan ID
  $query = "UPDATE categories SET category_name = '$category_name' WHERE category_id='$catID'";
  $exec = mysqli_query($conn, $query);

  // Menyimpan notifikasi keberhasilan atau kegagalan ke dalam session
  if ($exec){
    $_SESSION['notification'] = [
      'type' => 'primary', 
      'message' => 'ketegori berhasil diperbarui!'
    ];
  } else {
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Gagal memperbarui ketegori: '. mysqli_error($conn)
    ];
  }

  // Redirect kembali ke halaman kategori
  header('Location: ketegori.php');
    exit();
 }