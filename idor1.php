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
        <?php
            // Data hardcode
            $users = [
                1 => [
                    'id' => 1,
                    'name' => $_SESSION['email'],
                    'role' => 'user',
                ],
                2 => [
                    'id' => 2,
                    'name' => 'Jane',
                    'role' => 'user',
                ],
                3 => [
                    'id' => 3,
                    'name' => 'David',
                    'role' => 'user',
                ],
                4 => [
                    'id' => 4,
                    'name' => 'John',
                    'role' => 'user',
                ],
                5 => [
                    'id' => 5,
                    'name' => 'Michael',
                    'role' => 'admin',
                ],
                20 => [
                    'id' => 20,
                    'name' => 'Alex',
                    'role' => 'user',
                ],
                15 => [
                    'id' => 15,
                    'name' => 'Lennon',
                    'role' => 'admin',
                ],
            ];

            // Mendapatkan informasi pengguna berdasarkan ID
            function getUserInfo($userId) {
                global $users;
                if (isset($users[$userId])) {
                    return $users[$userId];
                }
                return null;
            }

            // Mendapatkan daftar pengguna (hanya untuk admin)
            function getUsersList() {
                global $users;
                return $users;
            }

            // ID pengguna yang sedang aktif (biasanya diperoleh dari session)
            $activeUserId = $_POST['user_id'] ?? null; // Mengambil ID dari POST request

            // Mengambil informasi pengguna berdasarkan ID aktif
            $activeUserInfo = getUserInfo($activeUserId);

            // Mengecek apakah pengguna aktif adalah admin
            $isAdmin = ($activeUserInfo['role'] === 'admin');

            // Menampilkan informasi pengguna aktif
            if (isset($_POST['user_id'])){
                echo "Active User ID: " . $activeUserInfo['id'] . "<br>";
                echo "Active User Name: " . $activeUserInfo['name'] . "<br>";
                echo "Active User Role: " . $activeUserInfo['role'] . "<br>";
                
            }
            ?>

            <h2>My Profile</h2>
            <p style="padding:10px;border:1px black solid;background:lightyellow">Goal: Dump data user lainnya!.</p>

            <!-- Tombol "Lihat Profil Saya" -->
            <form method="POST" action="">
                <input type="hidden" name="user_id" value="1"> <!-- ID pengguna yang ingin dilihat profilnya -->
                <button type="submit" class="btn btn-primary">Lihat Profil Saya</button>
            </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
