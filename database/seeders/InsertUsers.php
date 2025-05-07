<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InsertUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("
        INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `is_admin`, `is_superadmin`, `is_active`, `bidang_id`, `seksi_id`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
        (1, 'admancore', 'admancore@gmail.com', NULL, 1, 1, 1, NULL, NULL, '$2y$10\$r6z98LqsxhL620G1znwk9eqg2hiw0Mic8P3.wrgJYaytLNbJlCZ/a', NULL, '2024-05-09 14:23:38', '2024-05-09 14:23:38'),
        (2, 'bossunsketto', 'bossunsketto@gmail.com', NULL, 1, 0, 1, NULL, NULL, '$2y$10\$ex4fpT2ymmzdegpac9OoTeTAwo6uJ74MXjulgQHsNU6zjG2WKIV6K', NULL, '2024-05-09 14:23:51', '2024-05-09 14:23:51'),
        (3, 'dash', 'dash@gmail.com', NULL, 1, 0, 1, NULL, NULL, '$2y$10\$pUpgny142z1lWHj3QYA10OpPbxnJWV9yYwhPKvjN2D1hDUUfCeVP.', NULL, '2024-05-09 14:24:04', '2024-05-09 14:24:04'),
        (4, 'TEST', 'test@gmail.com', NULL, 1, 0, 1, 1, 1, '$2y$10\$wjvnjl4mP6xZP.bQlHZMpemAMJvvLsT3zKHCzYOLMM92M13ZlgC1K', NULL, '2024-08-06 00:04:03', '2024-08-06 00:04:03')
        ");
    }
}
