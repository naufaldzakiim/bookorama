<?php 
// File         : delete_cart.php
// Deskripsi    : untuk menghapus session

// TODO 1: Inisialisasi data session
session_start();

// TODO 2: Hapus session
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}

// TODO 3: Redirect ke halaman show_cart.php
header('Location: show_cart.php');