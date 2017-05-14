<?php

function includeTemplate(string $path2template = null, array $data = null) : string {
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

require_once 'mysql_helper.php';

function db_select(
                object $db_conn,
                string $sql,
                array $data = []
            ) : array {
    $prepared_sql = db_get_prepare_stmt($db_conn,$sql,$data);
    $result = mysqli_stmt_execute($prepared_sql);
    if (!$result) {
        $error = mysqli_error($db_conn);
        die("Ошибка MySQL: " . $error);
    }
    return mysqli_fetch_all($result,MYSQLI_ASSOC);
}

function db_insert(
                object $db_conn,
                string $sql,
                array $data = []
            ) : array {
    $prepared_sql = db_get_prepare_stmt($db_conn,$sql,$data);
    $result = mysqli_stmt_execute($prepared_sql);
    if (!$result) {
        $error = mysqli_error($db_conn);
        die("Ошибка MySQL: " . $error);
    }
    $records_count = mysqli_num_rows($result);
    return $records_count;
}

function db_update(
                object $db_conn,
                string $table_name,
                array $data,
                array $conditions
            ) : array {

    $field_names = [];
    $field_val_phldr = [];
    foreach ($data as $key => $value) {
        $field_names[] = $key;
        $field_val_phldr[] = '?';
    }

    $where_clause = '';
    if (isset($conditions)) {
        $where_clause = ' where ';
        $where_conditions = [];
        foreach ($conditions as $name => $value) {
            $where_conditions[] = " " . mysqli_real_escape_string($name) . " = ? ";
        }
        $where_clause .= explode(' and ',$where_conditions);
    }

    $update_sql = 'update ' . mysqli_real_escape_string($table_name)
        . ' (' . explode(',',$field_names) . ') values ('
        . explode(',',$field_val_phldr) . ') '
        . $where_clause . ';';

    $prepared_sql = db_get_prepare_stmt($db_conn,$update_sql,array_merge(array_values($data),array_values($conditions)));
    $result = mysqli_stmt_execute($prepared_sql);
    if (!$result) {
        $error = mysqli_error($db_conn);
        die("Ошибка MySQL: " . $error);
    }
    $records_count = mysqli_num_rows($result);
    return $records_count;
}

