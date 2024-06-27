<?php

class MigrateCommand
{
    protected $db;

    protected $migrationsDirectory;

    protected $migrationsTable;

    public function __construct(PDO $db, $migrationsDirectory, $migrationsTable)
    {
        $this->db = $db;
        $this->migrationsDirectory = $migrationsDirectory;
        $this->migrationsTable = $migrationsTable;
    }

    public function handle()
    {
        $this->createMigrationsTable();

        $files = scandir($this->migrationsDirectory);

        foreach ($files as $file) {
            if (! preg_match('/^(\d{14})_(.+)\.php$/', $file, $matches)) {
                continue;
            }

            $className = ucwords($matches[2], "_");
            $className = implode('', explode("_", $className));
            require_once dirname(__DIR__) . '/database/migrations/' . $file;
            $migrationClass = 'Database\\Migrations\\' . $className;
            $migration = new $migrationClass($this->db);

            if ($this->isMigrated($matches[1])) {
                $migration->down();
                $this->deleteMigrated($matches[1]);
            } else {
                $migration->up();
                $this->addMigrated($matches[1]);
            }
        }
    }

    protected function createMigrationsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->migrationsTable}` (
            `migration` VARCHAR(255) NOT NULL PRIMARY KEY
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $this->db->exec($sql);
    }

    protected function isMigrated($migration)
    {
        $sql = "SELECT COUNT(*) FROM `{$this->migrationsTable}` WHERE `migration` = ?;";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$migration]);

        return (int) $stmt->fetchColumn() > 0;
    }

    protected function addMigrated($migration)
    {
        $sql = "INSERT INTO `{$this->migrationsTable}` (`migration`) VALUES (?);";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$migration]);
    }

    protected function deleteMigrated($migration)
    {
        $sql = "DELETE FROM `{$this->migrationsTable}` WHERE `migration` = ?;";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([$migration]);
    }
}
