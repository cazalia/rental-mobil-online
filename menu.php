<?php
require_once 'data.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Mobil Online</title>
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
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px 40px;
        }

        h1.page-title {
            text-align: center;
            margin-bottom: 40px;
            color: var(--text-dark);
            font-weight: 700;
            font-size: 2.8em;
            margin-top: 0;
            letter-spacing: -1px;
        }

        .car-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 35px;
        }

        .car-item {
            background-color: var(--bg-card);
            border-radius: 12px;
            padding: 0;
            text-align: left;
            box-shadow: var(--shadow-md);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .car-item:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .car-item .image-wrapper {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .car-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .car-item:hover img {
            transform: scale(1.05);
        }

        .car-item .content-wrapper {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .car-item h3 {
            margin-top: 0;
            margin-bottom: 12px;
            font-size: 1.5em;
            font-weight: 600;
            color: var(--text-dark);
            line-height: 1.3;
        }

        .car-item ul {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
            font-size: 0.9em;
            color: var(--text-light);
            flex-grow: 1;
        }

        .car-item ul li {
            margin-bottom: 8px;
            padding-left: 22px;
            position: relative;
            line-height: 1.5;
        }

        .car-item ul li::before {
            content: '×';
            position: absolute;
            left: 0;
            top: 0px;
            font-size: 1.4em;
            line-height: 1;
            color: var(--danger-color);
            font-weight: bold;
        }

        .car-item .price-section {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .car-item .price {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.3em;
            margin: 0;
            line-height: 1;
            white-space: nowrap;
        }

        .car-item .order-button {
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9em;
            text-align: center;
            white-space: nowrap;
        }

        .car-item .order-button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .info-text {
            margin-top: 50px;
            text-align: center;
            font-style: normal;
            color: var(--text-light);
            font-size: 0.95em;
        }

         @media (max-width: 768px) {
            h1.page-title {
                font-size: 2.2em;
                margin-bottom: 30px;
            }
            .car-container {
                gap: 25px;
            }
            .car-item .image-wrapper {
                 height: 180px;
             }
         }
         @media (max-width: 480px) {
             h1.page-title {
                 font-size: 1.9em;
             }
             .car-item .content-wrapper {
                 padding: 20px;
             }
              .car-item .price-section {
                 flex-direction: column;
                 align-items: stretch;
                 gap: 10px;
             }
             .car-item .price {
                 text-align: center;
                 margin-bottom: 10px;
             }
         }
    </style>
</head>
<body>

    <div class="page-header-info">
        <p>Nama: Yudhiawan Dwi Nugraha</p>
        <p>NPM: 223111020</p>
    </div>

    <div class="container">
        <h1 class="page-title">Pilihan Mobil Rental Kami</h1>
        <div class="car-container">
            <?php foreach ($cars as $car): ?>
                <div class="car-item">
                    <div class="image-wrapper">
                        <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>">
                    </div>
                    <div class="content-wrapper">
                        <h3><?php echo htmlspecialchars($car['name']); ?></h3>
                        <ul>
                            <?php foreach ($car['features'] as $feature): ?>
                                <li><?php echo htmlspecialchars($feature); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="price-section">
                             <p class="price"><?php echo formatRupiah($car['price']); ?></p>
                             <a href="<?php echo htmlspecialchars('order.php?car=' . $car['id']); ?>" class="order-button">
                                Pesan
                             </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="info-text">* Harga dapat berubah sewaktu-waktu. Klik "Pesan" untuk detail lebih lanjut.</p>
    </div>
</body>
</html>
