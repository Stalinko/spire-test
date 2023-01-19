<?php

class MysqlStorage implements DbStorage
{
    private readonly PDO $pdo;

    public function __construct(array $config)
    {
        $this->pdo = new \PDO(
            sprintf("mysql:dbname=%s;host=%s", $config['DATABASE_NAME'], $config['DATABASE_HOST']),
            $config['DATABASE_USER'],
            $config['DATABASE_PASS']
        );
    }

    public function save(string $table, array $data): void
    {
        $query = "INSERT INTO `$table` (`" . implode('`, `', array_keys($data)) . '`) VALUES (' . rtrim(str_repeat('?, ', count($data =
                array_values($data))), ', ') . ')';

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);
    }
}