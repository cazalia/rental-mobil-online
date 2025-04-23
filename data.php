<?php

$cars = [
    [
        'id'    => 'apv',
        'name'  => 'Suzuki APV',
        'image' => 'apv.jpg',
        'plate' => 'D 1234 APV',
        'features' => [
            'Tidak termasuk Supir',
            'Tidak termasuk BBM',
            'Tidak termasuk Parkir',
            'Tidak termasuk Tol'
        ],
        'price' => 350000
    ],
    [
        'id'    => 'avanza',
        'name'  => 'Toyota Avanza',
        'image' => 'avanza.jpg',
        'plate' => 'D 3591 UTS',
        'features' => [
            'Tidak termasuk Supir',
            'Tidak termasuk BBM',
            'Tidak termasuk Parkir',
            'Tidak termasuk Tol'
        ],
        'price' => 450000
    ],
    [
        'id'    => 'innova',
        'name'  => 'Toyota Kijang Innova',
        'image' => 'innova.jpg',
        'plate' => 'D 5678 INV',
        'features' => [
            'Tidak termasuk Supir',
            'Tidak termasuk BBM',
            'Tidak termasuk Parkir',
            'Tidak termasuk Tol'
        ],
        'price' => 600000
    ]
];


function formatRupiah($number, $withDay = true) {
    $formatted = 'Rp ' . number_format($number, 0, ',', '.');
    if ($withDay) {
        $formatted .= ' / Hari';
    }
    return $formatted;
}


function findCarById($id, $carsArray) {
    foreach ($carsArray as $car) {
        if (isset($car['id']) && $car['id'] === $id) {
            return $car;
        }
    }
    return null;
}

?>