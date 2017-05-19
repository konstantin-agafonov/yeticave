<?php

class Db {

    /**
     * @var mysqli
     */
    private $connection;

    /**
     * Db constructor.
     * @param string $dbHost
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbName
     */
    function __construct(string $dbHost,string $dbUser,string $dbPass,string $dbName) {
        $this->connection = mysqli_connect(DB_HOST, DB_USER,DB_PASS,DB_NAME);
        if ($this->connection == false){
            die("Ошибка подключения: " . mysqli_connect_error());
        }
        mysqli_set_charset($this->connection,'utf8');
    }

    /**
     * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
     *
     * @param $link mysqli Ресурс соединения
     * @param $sql string SQL запрос с плейсхолдерами вместо значений
     * @param array $data Данные для вставки на место плейсхолдеров
     *
     * @return bool|mysqli_stmt Подготовленное выражение
     */
    private function get_prepare_stmt(string $sql, $data = []) {
        $stmt = mysqli_prepare($this->connection, $sql);

        if ($data) {
            $types = '';
            $stmt_data = [];

            foreach ($data as $value) {
                $type = null;

                if (is_int($value)) {
                    $type = 'd';
                }
                else if (is_string($value)) {
                    $type = 's';
                }
                else if (is_double($value)) {
                    $type = 'd';
                }

                if ($type) {
                    $types .= $type;
                    $stmt_data[] = $value;
                }
            }

            mysqli_stmt_bind_param($stmt, $types, ...$stmt_data);
        }

        return $stmt;
    }

    /**
     * @param string $sql
     * @param array $data
     * @return array
     */
    function select(string $sql, array $data = []): array
    {
        $prepared_sql = $this->get_prepare_stmt($sql,$data);

        if ($prepared_sql === false) {
            return [];
        }

        mysqli_stmt_execute($prepared_sql);

        $result = mysqli_stmt_get_result($prepared_sql);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_stmt_close($prepared_sql);
        mysqli_free_result($result);

        return $data;
    }

    /**
     * @param string $sql
     * @param array $data
     * @return bool|int
     */
    function insert(string $sql, array $data = [])
    {
        return $this->getInsertOrUpdateResult($sql, $data, false);
    }

    /**
     * @param string $table_name
     * @param array $data
     * @param array $conditions
     * @return bool|int
     */
    function update(string $table_name, array $data, array $conditions = [])
    {
        $placeholders = [];
        $fieldsString = $this->getFieldsString($data, $placeholders);
        $whereFields = $this->getFieldsString($conditions, $placeholders);

        $sql = "UPDATE {$table_name} SET {$fieldsString} WHERE {$whereFields};";

        return $this->getInsertOrUpdateResult($this->connection, $sql, $placeholders, true);
    }

    /**
     * @param string $sql
     * @param array $placeholders
     * @param bool $update
     * @return bool|int
     */
    private function getInsertOrUpdateResult(string $sql, array $placeholders = [], $update = true)
    {
        $prepared_sql = $this->get_prepare_stmt($sql, $placeholders);
        if (!$prepared_sql) {
            return false;
        }

        mysqli_stmt_execute($prepared_sql);

        if ($update) {
            $idOrCount = mysqli_affected_rows($this->connection);
        } else {
            $idOrCount = mysqli_insert_id($this->connection);
        }

        mysqli_stmt_close($prepared_sql);

        if ($idOrCount === 0) {
            return false;
        }

        return (int) $idOrCount;
    }

    /**
     * @param array $data
     * @param array $placeholders
     * @return string
     */
    private function getFieldsString($data = [], array &$placeholders): string
    {
        $fields = [];

        foreach ($data as $key => $value) {
            $fields[] = "`{$key}` = ?";
            $placeholders[] = $value;
        }

        $fieldsString = implode(', ', $fields);

        return $fieldsString;
    }


}