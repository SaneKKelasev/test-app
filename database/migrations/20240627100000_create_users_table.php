<?php

namespace Database\Migrations;

use Database\Migration;

require_once dirname(__DIR__) . '/Migration.php';

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        $sql = "CREATE TABLE `users` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL UNIQUE,
            `created_at` DATETIME NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $this->db->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE `users`;";

        $this->db->exec($sql);
    }
}
