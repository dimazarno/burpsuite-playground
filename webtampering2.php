<?php
$items = [
    'Handphone IPhone' => [
        'price' => 10000000,
        'image' => 'iphone14.jpg',
        'description' => 'Deskripsi Handphone IPhone 14'
    ],
    'Laptop Lenovo' => [
        'price' => 8000000,
        'image' => 'lenovo_laptop.jpg',
        'description' => 'Deskripsi Laptop Lenovo'
    ],
    'Kamera Canon' => [
        'price' => 5000000,
        'image' => 'canon_camera.jpg',
        'description' => 'Deskripsi Kamera Canon'
    ],
];

// Inisialisasi variabel kosong untuk daftar barang yang dipilih
$cartItems = [];

// Inisialisasi variabel total pembayaran
$totalPayment = 0;

// Periksa apakah ada data yang dikirimkan melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Periksa apakah ada item keranjang yang diposting
    echo "aaa";
    if (isset($_POST['cart']) && is_array($_POST['cart'])) {
        // Loop melalui item keranjang yang diposting dan tambahkan ke daftar barang yang dipilih
        foreach ($_POST['cart'] as $item => $quantity) {
            // Pastikan kuantitas yang diposting adalah bilangan bulat positif
            $quantity = intval($quantity);
            if ($quantity !== 0) {
                $cartItems[$item] = $quantity;
            }
        }
    }

    // Hitung total pembayaran berdasarkan barang yang dipilih
    foreach ($cartItems as $item => $quantity) {
        if (isset($items[$item])) {
            $totalPayment += $items[$item]['price'] * $quantity;
        }
    }

    // Tampilkan struk pembayaran setelah checkout
    if ($totalPayment > 0) {
        $message = "Terima kasih telah berbelanja. Berikut adalah rincian pembayaran Anda:";
        $message .= "<ul>";
        foreach ($cartItems as $item => $quantity) {
            $message .= "<li>$item: $quantity</li>";
        }
        $message .= "</ul>";
        $message .= "Total Pembayaran: $totalPayment";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Burpsuite Playground by Ethic Ninja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body,
        html {
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

        .product-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .product-card img {
            width: 200px;
            height: auto;
            margin-bottom: 10px;
        }

        .product-card .title {
            font-weight: bold;
        }

        .product-card .price {
            margin-top: 10px;
            font-weight: bold;
        }

        .product-card .description {
            margin-top: 10px;
            color: #777;
        }

        .checkout-form {
            margin-top: 20px;
        }

        .checkout-form label {
            display: block;
            margin-bottom: 10px;
        }

        .checkout-form button {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php include "navigation.php" ?>

    <div class="full-screen-content">
        <h1>Belanja</h1>
        <p style="padding:10px;border:1px black solid;background:lightyellow">Goal: Modifikasi pembelian sehingga harga yang harus dibayarkan dapat lebih murah!.</p>
        <form method="POST" action="">
        <div class="row">
            <?php foreach ($items as $item => $data) { ?>
                <div class="col-md-4">
                    <div class="product-card">
                        <h3 class="title"><?php echo $item; ?></h3>
                        <div class="price">Harga: <?php echo $data['price']; ?></div>
                        <div class="description"><?php echo $data['description']; ?></div>
                        
                            <div class="form-group">
                                <label for="<?php echo str_replace(' ', '_', $item); ?>">Jumlah:</label>
                                <input type="number" class="form-control" name="cart[<?php echo $item; ?>]" id="<?php echo str_replace(' ', '_', $item); ?>" min="0" value="<?php echo isset($cartItems[$item]) ? $cartItems[$item] : 0; ?>">
                            </div>
                        
                    </div>
                </div>
            <?php } ?>
        </div>

        
            <div class="form-group">
                <label for="total_payment">Total Pembayaran:</label>
                <input type="number" class="form-control" name="total_payment" id="total_payment" min="0" value="<?php echo $totalPayment; ?>">
            </div>
            <br><br>
            <button type="submit" class="btn btn-primary">Checkout</button>

        <?php if (isset($message)) { ?>
            <div class="alert alert-info mt-3"><?php echo $message; ?></div>
        <?php } ?>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
