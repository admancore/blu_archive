<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertProvinces extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("
        INSERT INTO `provinces` (`id`, `prov_name`, `locationid`, `status`) VALUES
            (1, 'ACEH', 1, 1),
            (2, 'SUMATERA UTARA', 1, 1),
            (3, 'SUMATERA BARAT', 1, 1),
            (4, 'RIAU', 1, 1),
            (5, 'JAMBI', 1, 1),
            (6, 'SUMATERA SELATAN', 1, 1),
            (7, 'BENGKULU', 1, 1),
            (8, 'LAMPUNG', 1, 1),
            (9, 'KEPULAUAN BANGKA BELITUNG', 1, 1),
            (10, 'KEPULAUAN RIAU', 1, 1),
            (11, 'DKI JAKARTA', 1, 1),
            (12, 'JAWA BARAT', 1, 1),
            (13, 'JAWA TENGAH', 1, 1),
            (14, 'DI YOGYAKARTA', 1, 1),
            (15, 'JAWA TIMUR', 1, 1),
            (16, 'BANTEN', 1, 1),
            (17, 'BALI', 1, 1),
            (18, 'NUSA TENGGARA BARAT', 1, 1),
            (19, 'NUSA TENGGARA TIMUR', 1, 1),
            (20, 'KALIMANTAN BARAT', 1, 1),
            (21, 'KALIMANTAN TENGAH', 1, 1),
            (22, 'KALIMANTAN SELATAN', 1, 1),
            (23, 'KALIMANTAN TIMUR', 1, 1),
            (24, 'KALIMANTAN UTARA', 1, 1),
            (25, 'SULAWESI UTARA', 1, 1),
            (26, 'SULAWESI TENGAH', 1, 1),
            (27, 'SULAWESI SELATAN', 1, 1),
            (28, 'SULAWESI TENGGARA', 1, 1),
            (29, 'GORONTALO', 1, 1),
            (30, 'SULAWESI BARAT', 1, 1),
            (31, 'MALUKU', 1, 1),
            (32, 'MALUKU UTARA', 1, 1),
            (33, 'PAPUA', 1, 1),
            (34, 'PAPUA BARAT', 1, 1);
        ");
    }
}
