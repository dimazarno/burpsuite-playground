<?php
// Set username dan PIN yang diharapkan
$expectedUsername = "administrator";
$expectedPin = "475";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai yang dikirimkan melalui form
    $username = $_POST['username'];
    $pin = $_POST['pin'];       

    if ($username!==$expectedUsername) die('username tidak ditemukan');
    if ($pin!==$expectedPin) die('Pin salah!');

    $error = "<h1>PIN Anda Benar!</h1>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Burpsuite Playground by Ethic Ninja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .full-screen-nav {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background: #333;
            color: #fff;
            overflow-y: auto;
            padding: 20px;
        }

        .full-screen-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .full-screen-nav ul li {
            margin-bottom: 10px;
        }

        .full-screen-nav ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .full-screen-nav ul li a:hover {
            color: #17a2b8;
        }

        .full-screen-content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include "navigation.php" ?>

    <div class="full-screen-content">
        <h2>Login</h2>
        <?php if (isset($error)) { ?>
            <p><?php echo $error; ?></p>
        <?php } ?>

        <p style="padding:10px;border:1px black solid;background:lightyellow">Goal: Cari tahu apa username yang terdaftar beserta PIN-nya.</p>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="pin">PIN (3 Angka)</label>
                <input type="password" id="pin" name="pin" class="form-control" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
