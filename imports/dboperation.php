<?php
    require_once(LIB_PATH.DS."configuration.php");

    class MySQLDatabase {
        private $connection;
        private $real_escape_string_exists;
        private $magic_quotes_active;

        function __construct() {
            $this->open_connection();
            $this->magic_quotes_active = get_magic_quotes_gpc();
            $this->real_escape_string_exists = function_exists("mysql_real_escape_string");
        }

        public function open_connection() {
            $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
            if(mysqli_connect_errno()) {
                die('Database connection failed!.');
            }else {
                $selected_db = mysqli_select_db($this->connection, DB_NAME);
                if(!$selected_db) {
                    die('Failed to select the database!.' . mysqli_connect_errno());
                }else {
                }
            }
        }

        public function close_connection() {
            if(isset($this->connection)) {
                mysqli_close($this->connection);
                unset($this->connection);
            }
        }

        public function querying($sql) {
            $result = mysqli_query($this->connection, $sql);
            if($result){
                $this->confirm_query($result);
            }
            return $result;
        }

        public function confirm_query($result_set) {
            if(!$result_set) {
                $message = "Database Query Failed";
                die($message);
            }
        }

        public function escape_value($value) {
            if($this->real_escape_string_exists) {
                if($this->magic_quotes_active) {
                    $value = stripcslashes($value);
                }
                $value = mysqli_real_escape_string($this->connection, $value);
            }else {
                if($this->magic_quotes_active) {
                    $value = addslashes($value);
                }
            }
            return $value;
        }

        public function fetch_array($result_set) {
            return mysqli_fetch_array($result_set);
        }

        public function num_rows($result_set) {
            return mysqli_num_rows($result_set);
        }

        public function insert_id() {
            return mysqli_insert_id($this->connection);
        }

        public function affected_rows() {
            return mysqli_affected_rows($this->connection);
        }
    }
    
    $DBInstance = new MySQLDatabase();
?>