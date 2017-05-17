<?php

require_once 'mysql_helper.php';
require_once 'config.php';

function getSubarrayValueByAnotherValue(array $array,$searched_key,$searched_value,$key2get) {
    foreach ($array as $sub_array) {
        if (isset($sub_array[$searched_key]) && isset($sub_array[$key2get])) {
            if ($sub_array[$searched_key] === $searched_value) {
                return $sub_array[$key2get];
            }
        }
    }
    return null;
}

function getSubarrayByElementValue(array $array,$searched_key,$searched_value) {
    foreach ($array as $sub_array) {
        if (isset($sub_array[$searched_key])) {
            if ($sub_array[$searched_key] === $searched_value) {
                return $sub_array;
            }
        }
    }
    return null;
}

function includeTemplate(string $path2template = null, array $data = null) : string
{
    if (!file_exists($path2template)) {
        return '';
    }
    ob_start();
    include $path2template;
    $template = ob_get_clean();
    return $template;
}

function relativeTime(int $time): string
{
    $now = time();
    $diff = $now - $time;

    if ((($diff) / (60 * 60)) >= 24) {
        return date('d.m.y в H:i', $time);
    }

    if (($diff / 60) <= 60) {
        return round($diff / 60) . " минут назад";
    }

    return round($diff / (60 * 60)) . " часов назад";
}

function db_select(mysqli $db_conn, string $sql, array $data = []): array
{
    $prepared_sql = db_get_prepare_stmt($db_conn,$sql,$data);

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
 * @param mysqli $db_conn
 * @param string $sql
 * @param array $data
 * @return bool|int
 */
function db_insert(mysqli $db_conn, string $sql, array $data = [])
{
    return getInsertOrUpdateResult($db_conn, $sql, $data, false);
}

/**
 * @param mysqli $db_conn
 * @param string $table_name
 * @param array $data
 * @param array $conditions
 * @return bool|int
 */
function db_update(mysqli $db_conn, string $table_name, array $data, array $conditions = [])
{
    $placeholders = [];
    $fieldsString = getFieldsString($data, $placeholders);
    $whereFields = getFieldsString($conditions, $placeholders);

    $sql = "UPDATE {$table_name} SET {$fieldsString} WHERE {$whereFields};";

    return getInsertOrUpdateResult($db_conn, $sql, $placeholders, true);
}

/**
 * @param mysqli $db_conn
 * @param string $sql
 * @param array $placeholders
 * @param bool $update
 * @return bool|int
 */
function getInsertOrUpdateResult(mysqli $db_conn, string $sql, array $placeholders = [], $update = true)
{
    $prepared_sql = db_get_prepare_stmt($db_conn, $sql, $placeholders);
    if (!$prepared_sql) {
        return false;
    }

    mysqli_stmt_execute($prepared_sql);

    if ($update) {
        $idOrCount = mysqli_affected_rows($db_conn);
    } else {
        $idOrCount = mysqli_insert_id($db_conn);
    }

    mysqli_stmt_close($prepared_sql);

    if ($idOrCount === 0) {
        return false;
    }

    return (int) $idOrCount;
}

function getFieldsString($data = [], array &$placeholders): string
{
    $fields = [];

    foreach ($data as $key => $value) {
        $fields[] = "`{$key}` = ?";
        $placeholders[] = $value;
    }

    $fieldsString = implode(', ', $fields);

    return $fieldsString;
}





