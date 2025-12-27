<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($query) === 1) {
        $data = mysqli_fetch_assoc($query);
        if (password_verify($password, $data['password'])) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama'] = $data['nama_lengkap'];
            $_SESSION['status'] = "login";
            header("Location: ../index.php"); 
            exit;
        } else {
            $_SESSION['error'] = 'Password salah!';
            header("Location: ../login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = 'Username tidak ditemukan!';
        header("Location: ../login.php");
        exit;
    }
}
?>