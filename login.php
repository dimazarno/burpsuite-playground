<!DOCTYPE html>
<html>
<head>
    <title>Web Aplikasi Sederhana</title>
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
    <div class="full-screen-nav">
        <ul class="nav flex-column">
            <li class="nav-item" style="background:white;">
                <a class="nav-link active" href="#"><img src="https://www.ethic.ninja/wp-content/uploads/2019/07/logo_ethic_ninja_black.jpg" height="30px"></a>
            </li>
        </ul>
    </div>

    <div class="full-screen-content">
        <h1>Login</h1>
        <form method="POST" action="index.php">
            <input type="email" name="email" placeholder="Masukkan email" required>
            <button type="submit">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>