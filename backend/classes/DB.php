<?php
require_once 'db_config.php';

class Database {
    private $con;

    public function __construct() {
        global $dbhost, $dbuser, $dbpass, $dbname;

        $this->con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        if (!$this->con) {
            die("Failed to connect to database: " . mysqli_connect_error());
        }

        mysqli_set_charset($this->con, 'utf8mb4');
    }

    public function query($sql) {
        $result = mysqli_query($this->con, $sql);
        if (!$result) {
            die('Query Error: ' . mysqli_error($this->con));
        }
        return $result;
    }

    public function fetchAll($sql) {
        $result = $this->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function fetchOne($sql) {
        $result = $this->query($sql);
        return mysqli_fetch_assoc($result);
    }

    public function escape($value) {
        return mysqli_real_escape_string($this->con, $value);
    }

    public function lastInsertId() {
        return mysqli_insert_id($this->con);
    }

    public function affectedRows() {
        return mysqli_affected_rows($this->con);
    }
}
?>