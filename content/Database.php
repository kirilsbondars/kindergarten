<?php

class Database {
    private static string $host = 'localhost';
    private static string $username = 'root';
    private static string $password = '';
    private static string $db_name = 'kindergarten';
    private static mysqli $conn;

    public static function connect() {
        Database::$conn = new mysqli(Database::$host, Database::$username, Database::$password, Database::$db_name);
        if (Database::$conn->connect_error) {
            die("Connection failed: " . Database::$conn->connect_error);
        }
    }

    public static function prepare($sql) {
        return Database::$conn->prepare($sql);
    }

    public static function query($sql) {
        return Database::$conn->query($sql);
    }

    public static function close() {
        Database::$conn->close();
    }
}