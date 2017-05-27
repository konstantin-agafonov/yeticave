<?php

namespace Yeticave\Core;

class Db {

    /**
     * @var mysqli
     */
    private static $connection = null;

    private function __construct() {}
    private function __clone() {}

    public static function init() {
        if (!isset(self::$connection)) {
            self::$connection = mysqli_connect(DB_HOST, DB_USER,DB_PASS,DB_NAME);
            if (self::$connection === false){
                die("Ошибка подключения: " . mysqli_connect_error());
            }
            mysqli_set_charset(self::$connection,'utf8');
        }
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
    private static function get_prepare_stmt(string $sql, $data = []) {
        $stmt = mysqli_prepare(self::$connection, $sql);

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

            /*echo '<pre>';
            var_dump($sql);
            var_dump($stmt);
            var_dump($types);
            var_dump($stmt_data);
            echo '</pre>';*/

            mysqli_stmt_bind_param($stmt, $types, ...$stmt_data);
        }

        return $stmt;
    }

    /**
     * @param string $sql
     * @param array $data
     * @return array
     */
    static function select(string $sql, array $data = []): array
    {
        $prepared_sql = self::get_prepare_stmt($sql,$data);

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
    static function insert(string $sql, array $data = [])
    {
        return self::getInsertOrUpdateResult($sql, $data, false);
    }

    /**
     * @param string $table_name
     * @param array $data
     * @param array $conditions
     * @return bool|int
     */
    static function update(string $table_name, array $data, array $conditions = [])
    {
        $placeholders = [];
        $fieldsString = self::getFieldsString($data, $placeholders);
        $whereFields = self::getFieldsString($conditions, $placeholders);

        $sql = "UPDATE {$table_name} SET {$fieldsString} WHERE {$whereFields};";

        return self::getInsertOrUpdateResult(self::$connection, $sql, $placeholders, true);
    }

    /**
     * @param string $sql
     * @param array $placeholders
     * @param bool $update
     * @return bool|int
     */
    static private function getInsertOrUpdateResult(string $sql, array $placeholders = [], $update = true)
    {
        $prepared_sql = self::get_prepare_stmt($sql, $placeholders);
        if (!$prepared_sql) {
            return false;
        }

        mysqli_stmt_execute($prepared_sql);

        if ($update) {
            $idOrCount = mysqli_affected_rows(self::$connection);
        } else {
            $idOrCount = mysqli_insert_id(self::$connection);
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
    static private function getFieldsString($data = [], array &$placeholders): string
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