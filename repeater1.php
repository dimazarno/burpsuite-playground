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
        session_start();

        // Menginisialisasi file penyimpanan data buku tamu
        $dataFile = 'guestbook.txt';

        // Fungsi untuk menyimpan data komentar ke file
        function saveComment($email, $comment) {
            global $dataFile;

            // Membuka file dalam mode append
            $file = fopen($dataFile, 'a');

            // Membuat format data yang akan disimpan
            $data = "Email: $email\n";
            $data .= "Comment: $comment\n\n";

            // Menulis data ke file
            fwrite($file, $data);

            // Menutup file
            fclose($file);
        }

        // Fungsi untuk mendapatkan daftar komentar dari file
        function getComments() {
            global $dataFile;

            // Membaca isi file
            $fileContent = file_get_contents($dataFile);

            // Memisahkan komentar berdasarkan baris kosong
            $commentsData = explode("\n\n", $fileContent);

            // Array untuk menyimpan data komentar
            $comments = array();

            foreach ($commentsData as $commentData) {
                // Membagi data komentar menjadi baris
                $lines = explode("\n", $commentData);

                // Mengekstrak email dan komentar dari baris data
                $email = str_replace("Email: ", "", $lines[0]);
                $comment = str_replace("Comment: ", "", $lines[1]);

                // Membuat array dengan email dan komentar
                $commentArray = array(
                    'email' => $email,
                    'comment' => $comment
                );

                // Menambahkan data komentar ke array komentar
                $comments[] = $commentArray;
            }

            return $comments;
        }

        // Memeriksa apakah form telah dikirimkan
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Mengambil nilai yang dikirimkan melalui form
            $comment = $_POST['comment'];
            $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');

            $email = $_SESSION['email'] ?? '';

            // Memastikan komentar dan email tidak kosong
            if (!empty($comment) && !empty($email)) {
                // Menyimpan komentar ke file
                saveComment($email, $comment);
            }
        }

        // Mendapatkan daftar komentar
        $comments = getComments();
        ?>

        <h1>Guestbook</h1>

        <p style="padding:10px;border:1px black solid;background:lightyellow">Goal: Pindahkan request dari HTTP history ke Repeater, lalu modifikasi inputan email/comment dan eksekusi repeater.</p>

        <!-- Form Buku Tamu -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="comment" class="form-label">Comment:</label>
                <textarea id="comment" name="comment" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <h2>List Buku Tamu</h2>
        <?php if (!empty($comments)) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment) { ?>
                        <tr>
                            <td><?php echo $comment['email']; ?></td>
                            <td><?php echo nl2br($comment['comment']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Tidak ada komentar.</p>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
