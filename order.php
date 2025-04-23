<?php
require_once 'data.php';

$selected_car_id = isset($_GET['car']) ? $_GET['car'] : null;
$selected_car = null;
if ($selected_car_id !== null) {
    $selected_car = findCarById($selected_car_id, $cars);
}
if ($selected_car === null) {
    header('Location: menu.php?error=Mobil tidak ditemukan');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan - <?php echo htmlspecialchars($selected_car['name']); ?> - Yudhiawan Dwi Nugraha</title>
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
            --input-border-color: #ced4da;
            --danger-color: #dc3545;
            --header-bg: #ffffff;
            --header-text: #495057;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 10px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

         *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #eef2f7, var(--bg-light));
            color: var(--text-dark);
            line-height: 1.6;
            font-size: 16px;
            min-height: 100vh;
        }

         .page-header-info {
            background-color: var(--header-bg);
            color: var(--header-text);
            text-align: center;
            padding: 12px 20px;
            box-shadow: var(--shadow-sm);
            border-bottom: 1px solid var(--border-color);
            font-size: 1em;
            position: sticky;
            top: 0;
            z-index: 1000;
         }
         .page-header-info p {
             margin: 4px 0;
             font-weight: 500;
         }

        .container {
            max-width: 960px;
            margin: 40px auto;
            padding: 35px 40px;
            background-color: var(--bg-card);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            margin-bottom: 40px;
        }

        h1.form-title {
            text-align: center;
            margin-top: 0;
            margin-bottom: 35px;
            color: var(--text-dark);
            font-weight: 700;
            font-size: 2.2em;
             letter-spacing: -0.5px;
        }

        .order-form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px 40px;
        }

        .form-section h2 {
             margin-top: 0;
             margin-bottom: 25px;
             font-size: 1.4em;
             border-bottom: 1px solid var(--border-color);
             padding-bottom: 12px;
             color: var(--primary-color);
             font-weight: 600;
         }


        .car-details-section {
            text-align: center;
            padding-top: 55px;
        }

        .car-details-section img {
            max-width: 100%;
            height: auto;
            max-height: 220px;
            object-fit: contain;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

         .car-details-section h3 {
             margin-top: 0;
             margin-bottom: 10px;
             font-size: 1.6em;
             font-weight: 600;
             color: var(--text-dark);
         }

        .car-details-section .price {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 30px;
            font-size: 1.5em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.95em;
            color: var(--text-dark);
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--input-border-color);
            border-radius: 6px;
            font-size: 1em;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background-color: #fff;
        }
         .form-group input:focus,
         .form-group textarea:focus,
         .form-group select:focus {
             outline: none;
             border-color: var(--primary-color);
             box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
         }
         .form-group input::placeholder,
         .form-group textarea::placeholder {
             color: #adb5bd;
             opacity: 1;
         }


        .form-group textarea {
            min-height: 90px;
            resize: vertical;
        }

        .form-group input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .radio-group label,
        .radio-group input[type="radio"] {
             display: inline-flex;
             align-items: center;
             margin-right: 20px;
             vertical-align: middle;
             cursor: pointer;
             font-size: 1em;
        }
         .radio-group input[type="radio"] {
             margin-right: 8px;
             width: 1.1em;
             height: 1.1em;
             accent-color: var(--primary-color);
         }
        .radio-group label {
             font-weight: 500;
        }


        .submit-button-container {
             grid-column: 1 / -1;
             text-align: right;
             margin-top: 15px;
             padding-top: 25px;
             border-top: 1px solid var(--border-color);
        }

        .submit-button {
            padding: 14px 35px;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1.05em;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            box-shadow: var(--shadow-sm);
        }

        .submit-button:hover {
            background-color: #0056b3;
             transform: translateY(-2px);
             box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        }

        @media (max-width: 900px) {
            .order-form-grid {
                grid-template-columns: 1fr;
            }
             .car-details-section {
                 grid-row: 1;
                 margin-bottom: 30px;
                 padding-top: 0;
             }
             .submit-button-container {
                 text-align: center;
             }
             .container {
                 padding: 25px;
             }
        }
        @media (max-width: 480px) {
             h1.form-title { font-size: 1.8em; }
             .form-section h2 { font-size: 1.2em; }
             .car-details-section h3 { font-size: 1.4em; }
        }
    </style>
</head>
<body>

    <div class="page-header-info">
        <p>Nama: Yudhiawan Dwi Nugraha</p>
        <p>NPM: 223111020</p>
    </div>

    <div class="container">
        <h1 class="form-title">Formulir Pemesanan Mobil</h1>

        <form action="proses_order.php" method="POST" class="order-form-grid">

            <div class="form-section">
                <h2>Identitas Penyewa</h2>
                <div class="form-group">
                    <label for="no_ktp">No KTP</label>
                    <input type="text" id="no_ktp" name="no_ktp" required placeholder="Masukkan 16 digit nomor KTP Anda">
                </div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required placeholder="Sesuai KTP">
                </div>
                 <div class="form-group">
                    <label for="alamat">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" rows="3" required placeholder="Jl. Contoh No. 1, RT/RW, Kelurahan, Kecamatan, Kota"></textarea>
                </div>
                <div class="form-group">
                    <label for="no_telp">No Telp/Hp Aktif</label>
                    <input type="tel" id="no_telp" name="no_telp" required placeholder="Contoh: 081234567890">
                </div>
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" required placeholder="Contoh: namaanda@email.com">
                </div>
                <div class="form-group">
                    <label>Jenis Pembayaran</label>
                    <div class="radio-group">
                        <input type="radio" id="transfer" name="jenis_pembayaran" value="Transfer" checked>
                        <label for="transfer">Transfer Bank</label>
                        <input type="radio" id="tunai" name="jenis_pembayaran" value="Tunai">
                        <label for="tunai">Tunai di Tempat</label>
                    </div>
                </div>
            </div>

            <div class="car-details-section">
                <img src="<?php echo htmlspecialchars($selected_car['image']); ?>" alt="<?php echo htmlspecialchars($selected_car['name']); ?>">
                <h3><?php echo htmlspecialchars($selected_car['name']); ?></h3>
                <p class="price"><?php echo formatRupiah($selected_car['price']); ?></p>

                <div class="form-group">
                    <label for="plat_no">Plat Nomor</label>
                    <input type="text" id="plat_no" name="plat_no" value="<?php echo htmlspecialchars($selected_car['plate']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Dengan Supir?</label>
                    <div class="radio-group">
                        <input type="radio" id="supir_ya" name="supir" value="Ya">
                        <label for="supir_ya">Ya (+ Biaya)</label>
                        <input type="radio" id="supir_tidak" name="supir" value="Tidak" checked>
                        <label for="supir_tidak">Tidak</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lama_sewa">Lama Sewa (Hari)</label>
                    <select id="lama_sewa" name="lama_sewa" required>
                        <option value="" disabled>-- Pilih Durasi --</option>
                        <?php for ($i = 1; $i <= 7; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo ($i == 4) ? 'selected' : ''; ?>>
                                <?php echo $i; ?> Hari
                            </option>
                        <?php endfor; ?>
                         <option value="10">10 Hari</option>
                         <option value="14">14 Hari</option>
                    </select>
                </div>
                 <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($selected_car['id']); ?>">
                 <input type="hidden" name="car_name" value="<?php echo htmlspecialchars($selected_car['name']); ?>">
                 <input type="hidden" name="price_per_day" value="<?php echo htmlspecialchars($selected_car['price']); ?>">
            </div>

            <div class="submit-button-container">
                <button type="submit" class="submit-button">Proses Pesanan</button>
            </div>

        </form>
    </div>

</body>
</html>