<?php

require 'config.php';


class db {
    private $mysqli;
    private $error;
    private $last;

    function __construct() {
        $this->mysqli = new MySQLi(host_address, login_database, pass_database, database_name);
    }

    public function query($sql) {
        $args = func_get_args();
        $sql = array_shift($args);
        $link = $this->mysqli;
        $args = array_map(function ($param) use ($link) {
            return "'" . $link->real_escape_string($param) . "'";
        }, $args);
        $sql = str_replace(array('%','?'), array('%%','%s'), $sql);
        array_unshift($args, $sql);
        $sql = call_user_func_array('sprintf', $args);
        $this->last = $this->mysqli->query($sql);
        if ($this->last === false) {
            throw new Exception('Database error: ' . $this->mysqli->error);
        }
        return $this;
    }

    public function insertDB($table_name, $array_keys_vals, $replace=false) {
        $insert = $replace ? 'REPLACE' : 'INSERT';
        $link = $this->mysqli;
        $table_name = $link->real_escape_string(db::deleteGarb($table_name));
        $keys = array_map(function ($param) use ($link) {
            return '`' . $link->real_escape_string(db::deleteGarb($param)) . '`';
        }, array_keys($array_keys_vals));
        $keys_str = implode(', ', $keys);
        $values = array_map(function ($param) use ($link) {
            return "'" . $link->real_escape_string($param) . "'";
        }, array_values($array_keys_vals));
        $values_str = implode(', ', $values);
        $sql = "$insert INTO `" . database_name . "`.`" . $table_name ."` (" . $keys_str . ") VALUES (" . $values_str . ");";
        $this->last = $this->mysqli->query($sql);
        if ($this->last === false) {
            throw new Exception('Database error: ' . $this->mysqli->error);
        }
        return $this;
    }

    public function updateDB($table_name, $array_keys_vals, $array_keys_vals_main) {
        $link = $this->mysqli;
        $table_name = $link->real_escape_string($this->deleteGarb($table_name));
        $keys = array_map(function ($param) use ($link) {
            return '`' . $link->real_escape_string(db::deleteGarb($param)) . '`';
        }, array_keys($array_keys_vals));

        $keys_str = implode(', ', $keys);

        $values = array_map(function ($param) use ($link) {
            return "'" . $link->real_escape_string($param) . "'";
        }, array_values($array_keys_vals));

        $values_str = implode(', ', $values);
        $main_values = array_map(function ($param) use ($link) {
            return "'" . $link->real_escape_string($param) . "'";
        }, array_values($array_keys_vals_main));
        $main_keys = array_map(function ($param) use ($link) {
            return "`" . $link->real_escape_string($param) . "`";
        }, array_keys($array_keys_vals_main));
        $main_arr = array();
        for($i = 0; $i < count($main_keys); $i++) {
            $main_arr[] = ($main_keys[$i] . ' = ' . $main_values[$i]);
        }
        $main_str = implode(', ', $main_arr);

        $sql = "INSERT INTO `" . database_name . "`.`" . $table_name ."` (" . $keys_str . ") VALUES (" . $values_str . ") ON DUPLICATE KEY UPDATE $main_str;";
        $this->last = $this->mysqli->query($sql);
        if ($this->last === false) {
            throw new Exception('Database error: ' . $this->mysqli->error);
        }
        return $this;

    }

    public function rowsAff() {
        return $this->mysqli->affected_rows();
    }

    public function deleteGarb($str) {
        return str_replace(array('`', '.', 'OR ', '=', 'AND', "'"), '', $str);
    }

    public function assoc() {
        return $this->last->fetch_assoc();
    }

    public function all() {
        $result = array();
        while ($row = $this->last->fetch_assoc()) $result[] = $row;
        return $result;
    }

    public function notNull(){
        return count($this->last->fetch_assoc()) !== 0;
    }
}