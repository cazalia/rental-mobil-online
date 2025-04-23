<?php
session_start();
require_once 'data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no_ktp = isset($_POST['no_ktp']) ? htmlspecialchars(trim($_POST['no_ktp'])) : '';
    $nama = isset($_POST['nama']) ? htmlspecialchars(trim($_POST['nama'])) : '';
    $alamat = isset($_POST['alamat']) ? htmlspecialchars(trim($_POST['alamat'])) : '';
    $no_telp = isset($_POST['no_telp']) ? htmlspecialchars(trim($_POST['no_telp'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $jenis_pembayaran = isset($_POST['jenis_pembayaran']) ? htmlspecialchars($_POST['jenis_pembayaran']) : '';
    $supir = isset($_POST['supir']) ? htmlspecialchars($_POST['supir']) : '';
    $lama_sewa_hari = isset($_POST['lama_sewa']) ? (int)$_POST['lama_sewa'] : 0;
    $car_id = isset($_POST['car_id']) ? htmlspecialchars($_POST['car_id']) : '';
    $car_name = isset($_POST['car_name']) ? htmlspecialchars($_POST['car_name']) : '';
    $price_per_day = isset($_POST['price_per_day']) ? (float)$_POST['price_per_day'] : 0;

    $errors = [];
    if (empty($no_ktp) || !ctype_digit($no_ktp) || strlen($no_ktp) != 16 ) { $errors[] = "Nomor KTP tidak valid (harus 16 digit angka)."; }
    if (empty($nama)) { $errors[] = "Nama tidak boleh kosong."; }
    if (empty($alamat)) { $errors[] = "Alamat tidak boleh kosong."; }
    if (empty($no_telp) || !ctype_digit(str_replace(['+', '-', ' '], '', $no_telp))) { $errors[] = "Nomor Telepon tidak valid."; }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = "Format Email tidak valid.";}
    if ($lama_sewa_hari <= 0) { $errors[] = "Lama sewa tidak valid."; }
    if ($price_per_day <= 0) { $errors[] = "Data harga mobil tidak valid."; }


    $total_biaya = 0;
    $biaya_supir_per_hari = 150000;
    $total_biaya_supir = 0;

    if (empty($errors)) {
        $total_biaya = $price_per_day * $lama_sewa_hari;
        if ($supir === 'Ya') {
             $total_biaya_supir = $biaya_supir_per_hari * $lama_sewa_hari;
             $total_biaya += $total_biaya_supir;
        }
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - Yudhiawan Dwi Nugraha</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #28a745;
            --text-dark: #343a40;
            --text-light: #6c757d;
            --bg-light: #f8f9fa;
            --bg-card: #ffffff;
            --border-color: #dee2e6;
            --header-bg: #ffffff;
            --header-text: #495057;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 10px rgba(0, 0, 0, 0.08);
        }
         *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background: linear-gradient(to bottom, #eef2f7, var(--bg-light)); color: var(--text-dark); line-height: 1.6; font-size: 16px; min-height: 100vh;
        }
         .page-header-info {
            background-color: var(--header-bg); color: var(--header-text); text-align: center; padding: 12px 20px; box-shadow: var(--shadow-sm); border-bottom: 1px solid var(--border-color); font-size: 1em; position: sticky; top: 0; z-index: 1000;
         }
         .page-header-info p { margin: 4px 0; font-weight: 500; }
        .container {
            max-width: 750px; margin: 40px auto; padding: 35px 40px; background-color: var(--bg-card); border-radius: 12px; box-shadow: var(--shadow-md); border: 1px solid var(--border-color); margin-bottom: 40px;
        }
        h1.page-title { text-align: center; margin-top:0; margin-bottom: 30px; color: var(--primary-color); font-weight: 700; font-size: 2.2em; }
        h2 { margin-top: 35px; margin-bottom: 18px; font-size: 1.5em; border-bottom: 1px solid var(--border-color); padding-bottom: 10px; color: var(--text-dark); font-weight: 600; }
        h2:first-of-type { margin-top: 0; }
        .summary-item { margin-bottom: 12px; display: grid; grid-template-columns: 200px 1fr; gap: 10px; align-items: start; font-size: 1.05em; }
        .summary-item strong { font-weight: 600; color: var(--text-dark); }
        .summary-item span { word-wrap: break-word; color: var(--text-light); font-weight: 500; }
        .summary-item span.highlight { color: var(--text-dark); font-weight: 600; }
        .total-biaya { margin-top: 30px; padding-top: 20px; border-top: 2px solid var(--primary-color); font-size: 1.6em; font-weight: 700; text-align: right; color: var(--secondary-color); }
        .total-biaya strong { font-weight: 700; }
        .back-link { display: inline-block; text-align: center; margin-top: 30px; text-decoration: none; color: var(--primary-color); font-weight: 600; padding: 10px 20px; border: 1px solid var(--primary-color); border-radius: 6px; transition: background-color 0.3s, color 0.3s;}
        .back-link:hover { text-decoration: none; background-color: var(--primary-color); color: #fff;}
        .link-container { text-align: center; margin-top: 25px; }
        .error-list { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 20px; border-radius: 8px; margin-bottom: 30px; list-style: none;}
        .error-list li { margin-bottom: 8px; font-size: 1.05em; }
        .error-list strong { display: block; margin-bottom: 10px; font-weight: 600; font-size: 1.1em;}
        .thank-you-note { text-align: center; margin-top: 35px; color: var(--text-light); font-size: 1em; line-height: 1.7;}
        .thank-you-note strong { color: var(--secondary-color); }
    </style>
</head>
<body>
    <div class="page-header-info">
        <p>Nama: Yudhiawan Dwi Nugraha</p>
        <p>NPM: 223111020</p>
    </div>

    <div class="container">
        <h1 class="page-title">Konfirmasi Detail Pesanan</h1>

        <?php if (!empty($errors)): ?>
            <ul class="error-list">
                <li><strong>Terjadi Kesalahan Validasi:</strong></li>
                <?php foreach ($errors as $error): ?>
                    <li>- <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="link-container">
                 <a href="javascript:history.back()" class="back-link">Kembali ke Formulir</a>
            </div>
        <?php else: ?>

            <h2>Detail Mobil</h2>
            <div class="summary-item"><strong>Mobil:</strong> <span class="highlight"><?php echo $car_name; ?></span></div>
            <div class="summary-item"><strong>ID Mobil:</strong> <span><?php echo $car_id; ?></span></div>
            <div class="summary-item"><strong>Harga per Hari:</strong> <span><?php echo formatRupiah($price_per_day, false); ?></span></div>
            <div class="summary-item"><strong>Lama Sewa:</strong> <span><?php echo $lama_sewa_hari; ?> Hari</span></div>
            <div class="summary-item"><strong>Pakai Supir:</strong> <span><?php echo $supir; ?></span></div>
             <?php if ($supir === 'Ya'): ?>
                 <div class="summary-item"><strong>Biaya Supir:</strong> <span><?php echo formatRupiah($total_biaya_supir, false); ?> (@ <?php echo formatRupiah($biaya_supir_per_hari, false); ?>/hari)</span></div>
             <?php endif; ?>


            <h2>Data Penyewa</h2>
            <div class="summary-item"><strong>No KTP:</strong> <span><?php echo $no_ktp; ?></span></div>
            <div class="summary-item"><strong>Nama:</strong> <span class="highlight"><?php echo $nama; ?></span></div>
            <div class="summary-item"><strong>Alamat:</strong> <span><?php echo nl2br($alamat); ?></span></div>
            <div class="summary-item"><strong>No Telp:</strong> <span><?php echo $no_telp; ?></span></div>
            <div class="summary-item"><strong>Email:</strong> <span><?php echo $email; ?></span></div>

            <h2>Pembayaran</h2>
            <div class="summary-item"><strong>Jenis Pembayaran:</strong> <span><?php echo $jenis_pembayaran; ?></span></div>
            <div class="total-biaya">
                <strong>Total Biaya Sewa: <?php echo formatRupiah($total_biaya, false); ?></strong>
            </div>

            <p class="thank-you-note">
                <strong>Pesanan Anda telah kami terima!</strong> <br>
            </p>

            <div class="link-container">
                 <a href="menu.php" class="back-link">Sewa Mobil Lain</a>
             </div>

        <?php endif; ?>

    </div>
</body>
</html>

<?php
} else {
    header('Location: menu.php');
    exit;
}
?>