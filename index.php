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
        <h1>Burpsuite Playground</h1>
        <p>Halo ini adalah aplikasi sederhana untuk membantu pentester pemula dalam menggunakan aplikasi Burpsuite. </p><p>Di dalam aplikasi ini terdapat berbagai tantangan yang harus dilalui dengan menggunakan fitur yang ada di Burpsuite.</p>
        <p>Informasi terkait Burpsuite:</p>
        <ul>
            <li>Download: <a href="https://portswigger.net/burp/releases/community/latest" target="_blank">https://portswigger.net/burp/releases/community/latest</a></li>
            <li>Cara setting awal: <a href="https://portswigger.net/burp/documentation/desktop/getting-started" target="_blank">https://portswigger.net/burp/documentation/desktop/getting-started</a></li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
