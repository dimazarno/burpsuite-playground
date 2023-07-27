<?php
// Kekuatan musuh
$enemyPower = 9999;

// Kekuatan karakter
$characterPowers = [
    'Mage' => 6000,
    'Knight' => 4000,
    'Archer' => 7000
];

// Cek jika ada usaha manipulasi
if (isset($_POST['character'])) {
    $value = $_POST['character'];
    
    if ($value > $enemyPower ){
         $message = '<p style="border:1px solid black;padding:5px">Selamat, Anda berhasil!.</p>';
     } else {
         $message = '<p style="border:1px solid black;padding:5px">Jagoan anda kalah!</p>';
     }
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
        <h1>Boss Terakhir</h1>
        <p style="padding:10px;border:1px black solid;background:lightyellow">Goal: Kalahkan boss terakhir ini, pilih yang paling kuat!.</p>
        <img src="monster.jpeg" width="120px">
        <br>
        Kekuatan: 9999!
        <br>
        
        <?php if (isset($message)) { ?>
            <p><?php echo $message; ?></p>
        <?php } ?>
        
        <h2>Pilih Jagoanmu:</h2>
        <form method="POST" action="">
            <label for="knight">
                <input type="radio" name="character" id="knight" value="4000">
                Knight (Kekuatan: <?php echo $characterPowers['Knight']; ?>)
            </label><br>
            <label for="mage">
                <input type="radio" name="character" id="mage" value="6000">
                Mage (Kekuatan: <?php echo $characterPowers['Mage']; ?>)
            </label><br>
            <label for="archer">
                <input type="radio" name="character" id="archer" value="7000">
                Archer (Kekuatan: <?php echo $characterPowers['Archer']; ?>)
            </label><br>
            <button type="submit">Pilih</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



