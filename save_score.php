<?php
session_start();
// Mendapatkan data email dan skor dari metode POST
$email = $_SESSION['email'];
$score = $_POST['score'];

// Validasi data email dan skor
if (!empty($email) && is_numeric($score)) {
    // Format data sebagai baris CSV
    $data = $email . ',' . $score . "\n";

    // Menentukan path file flat file
    $file = 'scores.csv';

    // Menyimpan data ke dalam file
    file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

    // Respon berhasil
    echo "Skor berhasil disimpan.";
} else {
    // Respon gagal
    echo "Terjadi kesalahan saat menyimpan skor.";
}
