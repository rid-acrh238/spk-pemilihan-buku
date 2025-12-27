<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['register'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['error'] = 'Username sudah digunakan!';
        header("Location: ../register.php");
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (nama_lengkap, username, password) VALUES ('$nama', '$username', '$password_hash')";
        
        if (mysqli_query($koneksi, $query)) {
            $_SESSION['success'] = 'Registrasi Berhasil! Silakan Login.';
            header("Location: ../login.php");
        } else {
            $_SESSION['error'] = 'Terjadi kesalahan sistem!';
            header("Location: ../register.php");
        }
    }
}
?>