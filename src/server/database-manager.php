<?php
class Database
{
    private PDO $conn;
    private array $allowedColumns = [
        'self_id', 'first_name', 'middle_name', 'last_name',
        'permanent_address', 'current_address', 'position_id',
        'is_active', 'joining_date',
    ];

    public function __construct()
    {
        $secrets = require __DIR__ . '/../database/secret.php';

        try {
            $this->conn = new PDO(
                "mysql:host={$secrets['DB_HOST']};dbname={$secrets['DB_NAME']}",
                $secrets['DB_USER'], $secrets['DB_PASS']
            );
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
            );

        } catch (Exception $err) {
            throw new RuntimeException(
                "Connection failed: {$err->getMessage()}\n", 0, $err
            );
        }
    }

/**
 * @param array{
 * self_id: int,
 * first_name: string,
 * middle_name?: string,
 * last_name: string,
 * permanent_address?: string,
 * current_address?: string,
 * position_id: int,
 * is_active?: 0|1,
 * joining_date?: string
 * } $data
 */
    public function createEmployee(array $data): bool
    {

        $columns = array_intersect(array_keys($data), $this->allowedColumns);
        $columnTemplates = array_map(
            fn(string $field): string => ":$field", $columns
        );
        $statement = $this->conn->prepare(
            'insert into employees (' . implode(', ', $columns) .
            ') values(' . implode(', ', $columnTemplates) . ')'
        );

        try {

            $statement->execute($data);
            return true;
        } catch (Exception $err) {
            error_log('Employee creation failed: ' . $err->getMessage());
            return false;
        }
    }

    public function getPositions(): array
    {
        $statement = $this->conn->prepare(
            'select * from positions order by id'
        );
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllEmployees(): array
    {
        $statement = $this->conn->prepare('select * from employees');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSelfIds(): array
    {
        $statement = $this->conn->prepare('select self_id from employees ');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getEmployee(int $mainId): false | array
    {
        $statement = $this->conn->prepare(
            'select * from employees where id = :id'
        );
        $statement->execute(['id' => $mainId]);

        $empData = $statement->fetch(PDO::FETCH_ASSOC);
        if (! $empData) {
            error_log(
                'getEmployee failed: No employee found for the given ID'
            );
            return false;
        }

        if (! is_array($empData)) {
            throw new RuntimeException(
                'getEmployee: expected array from fetch, got something else'
            );
        }
        return $empData;
    }

/**
 * @param array{
 * self_id?: int,
 * first_name?: string,
 * middle_name?: string,
 * last_name?: string,
 * permanent_address?: string,
 * current_address?: string,
 * position_id?: int,
 * is_active?: bool,
 * joining_date?: string
 * } $newData
 */
    public function updateEmployee(int $mainId, array $newData): bool
    {
        if (empty($newData)) {
            error_log('updateEmployee failed: No properties given to update');
            return false;
        }

        $originalData = $this->getEmployee($mainId);
        if ($originalData === false) {
            error_log('updateEmployee: employee not found with the given ID');
            return false;
        }

        unset($originalData['id']);

        $setClauses = [];
        $params = [];

        foreach ($newData as $key => $value) {
            if (
                array_key_exists($key, $originalData) &&
                $originalData[$key] !== $value
            ) {
                $setClauses[] = "$key = :$key";
                $params[$key] = $value;
            }
        }

        if (empty($setClauses)) {
            error_log("updateEmployee: No changes detected. Didn't update");
            return false;
        }

        $sql = 'update employees set ' . implode(', ', $setClauses)
            . ' where id = :id';
        $params['id'] = $mainId;

        $statement = $this->conn->prepare($sql);
        try {
            return $statement->execute($params);
        } catch (Exception $err) {
            error_log('Update Employee failed: ' . $err->getMessage());
            return false;
        }
    }

    public function deleteEmployee(int $mainId): bool
    {
        if ($this->getEmployee($mainId) === false) {
            error_log('Delete employee failed: No employee with the given ID');
            return false;
        }
        $statement = $this->conn->prepare(
            'delete from employees where id = :id'
        );

        try {
            $statement->execute(['id' => $mainId]);
            return true;
        } catch (exception $err) {
            error_log('Delete employee failed: ' . $err->getmessage());
            return false;
        }
    }
}
