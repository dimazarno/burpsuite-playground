<?php
session_start();

// Fungsi untuk memeriksa apakah email ada dalam daftar akses
function checkAccess($email) {
    $allowedEmails = getEmailListFromFile("peserta");
    return in_array($email, $allowedEmails);
}

// Fungsi untuk membaca daftar email dari file
function getEmailListFromFile($filename) {
    $emails = array();
    $file = fopen($filename, "r");
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $emails[] = trim($line);
        }
        fclose($file);
    }
    return $emails;
}

// Jika ada permintaan login
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if (checkAccess($email)) {
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['email'] = $email;
        header('Location: index.php');
        exit;
    } else {
        echo 'Email tidak valid. Silakan coba lagi.';
        die();
    }
}

// Jika pengguna sudah login, alihkan ke halaman utama
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
    
} else {
    header('Location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

?>

<div class="full-screen-nav">
    <ul class="nav flex-column">
        <li class="nav-item" style="background:white;">
            <a class="nav-link active" href="#"><img src="https://www.ethic.ninja/wp-content/uploads/2019/07/logo_ethic_ninja_black.jpg" height="30px"></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="repeater1.php">Guestbook</a>
        </li>  
        <li class="nav-item">
            <a class="nav-link" href="idor1.php">Profile</a>
        </li>   
        <li class="nav-item">
            <a class="nav-link" href="intruder1.php">PIN</a>
        </li>  
        <li class="nav-item">
            <a class="nav-link" href="webtampering1.php">Games 1</a>
        </li>      
        <li class="nav-item">
            <a class="nav-link" href="webtampering2.php">Belanja</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="webtampering3.php">Games 2</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?logout=1">Logout</a>
        </li>
    </ul>
</div>