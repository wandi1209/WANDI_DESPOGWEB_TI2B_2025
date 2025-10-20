<?php

$basePathImage = 'assets/images/menus/';

return [
    'kategori' => [
        [
            'id' => 1,
            'name'=> 'Nasi'
        ],
        [
            'id' => 2,
            'name'=> 'Sapi & Ayam'
        ],
        [
            'id' => 3,
            'name'=> 'Seafood'
        ],
        [
            'id' => 4,
            'name'=> 'Sayur'
        ],
        [
            'id' => 5,
            'name'=> 'Dimsum'
        ],
        [
            'id' => 6,
            'name'=> 'Hidangan Penutup'
        ],
        [
            'id' => 7,
            'name'=> 'Minuman'
        ],
    ],

    'menus' => [
        [
            'id' => 1,
            'name' => 'NASI GORENG XO SEAFOOD',
            'kategori_id' => 1,
            'harga' => 24000,
            'image_url' => $basePathImage . 'NASI-GORENG-XO-SEAFOOD.jpg'
        ],
        [
            'id' => 2,
            'name' => 'NASI GORENG SEAFOOD',
            'kategori_id' => 1,
            'harga' => 22000,
            'image_url' => $basePathImage .'NASI-GORENG-SEAFOOD.jpg'
        ],
        [
            'id' => 3,
            'name' => 'NASI GORENG ALA YANG CHOW',
            'kategori_id' => 1,
            'harga' => 20000,
            'image_url' => $basePathImage .'NASI-GORENG-A-LA-YANG-CHOW.jpg'
        ],
        [
            'id' => 4,
            'name' => 'NASI GORENG IKAN ASIN JAMBAL',
            'kategori_id' => 1,
            'harga' => 20000,
            'image_url' => $basePathImage .'NASI-GORENG-IKAN-ASIN-JAMBAL.jpg'
        ],
        [
            'id' => 5,
            'name' => 'NASI GORENG AYAM DENGAN NANAS',
            'kategori_id' => 1,
            'harga' => 20000,
            'image_url' => $basePathImage .'NASI-GORENG-AYAM-DENGAN-NANAS-MANIS-1-1.jpg'
        ],
        [
            'id' => 6,
            'name' => 'SAPI MONGOLIA',
            'kategori_id' => 2,
            'harga' => 20000,
            'image_url' => $basePathImage .'SAPI-MONGOLIA.jpg'
        ],
        [
            'id' => 7,
            'name' => 'SAPI LADA HITAM',
            'kategori_id' => 2,
            'harga' => 20000,
            'image_url' => $basePathImage .'SAPI-LADA-HITAM.jpg'
        ],
        [
            'id' => 8,
            'name' => 'SAPI LADA HITAM',
            'kategori_id' => 2,
            'harga' => 20000,
            'image_url' => $basePathImage .'LUMPIA-LIE-HONG-KIAN.jpg'
        ],
        [
            'id' => 9,
            'name' => 'KULIT AYAM GORENG LADA GARAM',
            'kategori_id' => 2,
            'harga' => 20000,
            'image_url' => $basePathImage .'KULIT-AYAM-GORENG-LADA-GARAM.jpg'
        ],
        [
            'id' => 10,
            'name' => 'KUAH SAPI SENGKEL',
            'kategori_id' => 2,
            'harga' => 20000,
            'image_url' => $basePathImage .'KUAH-SAPI-SENGKEL.jpg'
        ],
    ],

    'keranjang' => [],

    'order_menu' => [],

    'orders' => [],
];
?>