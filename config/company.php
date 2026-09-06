<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Profil Usaha & Kontak Resmi (Sesuai Pendaftaran iPaymu / Legal)
    |--------------------------------------------------------------------------
    |
    | Konfigurasi ini digunakan untuk menampilkan data usaha yang valid di
    | halaman Kontak, Footer website, dan dokumen kepatuhan (compliance).
    |
    */

    'name' => env('COMPANY_NAME', 'eVoters.id'),
    
    'brand' => env('COMPANY_BRAND', 'eVoters.id'),

    'owner' => env('COMPANY_OWNER', 'Aries Mulyono'),

    'address' => env('COMPANY_ADDRESS', 'Perum Villa Asri 1, Cicadas, Gunung Putri, Bogor, Jawa Barat, Indonesia'),

    'email' => env('COMPANY_EMAIL', 'proats.musiccenter@gmail.com'),

    'phone' => env('COMPANY_PHONE', '+62 895-3243-80409'),

    'whatsapp' => env('COMPANY_WHATSAPP', '62895324380409'),

    'hours' => env('COMPANY_HOURS', 'Senin - Minggu: 24 Jam'),
];
