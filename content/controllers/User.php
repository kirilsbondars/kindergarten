<?php

class User {
    private $id;
    private $name;
    private $surname;
    private $username;
    private $password;
    private $isAdmin;

    public function __construct($id, $name, $surname, $username, $password, $isAdmin) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->username = $username;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }

    // setters and getters
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }

    public function getIsAdmin() {
        return $this->isAdmin;
    }

    // methods
    public function getFullName() {
        return $this->name . ' ' . $this->surname;
    }

    public function isAdmin() {
        return $this->getIsAdmin();
    }

    public static function login($username, $password) {
        $user = User::get_user_by_username($username);

        if ($user && password_verify($password, $user->getPassword())) {
            return $user;
        } else {
            return false;
        }
    }

    public function create(): bool
    {
        $sql = "INSERT INTO users (name, surname, username, password, is_admin) VALUES (?, ?, ?, ?, ?)";
        $stmt = Database::prepare($sql);
        $passwd_hash = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bind_param("sssss", $this->name, $this->surname, $this->username, $passwd_hash, $this->isAdmin);
        return $stmt->execute();
    }

    public function update(): bool
    {
        $sql = "UPDATE users SET name = ?, surname = ?, username = ?, password = ?, is_admin = ? WHERE id = ?";
        $stmt = Database::prepare($sql);
        $stmt->bind_param("sssssi", $this->name, $this->surname, $this->username, $this->password, $this->isAdmin, $this->id);
        return $stmt->execute();
    }

    public static function get_user($result) {
        $row = $result->fetch_assoc();
        if(!$row) {
            return false;
        }
        $user = new User($row['id'], $row['name'], $row['surname'], $row['username'], $row['password'], $row['is_admin']);
        return $user;
    }

    public static function get_user_by_username($username) {
        $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = Database::query($sql);
        return User::get_user($result);
    }

    public static function get_user_by_id($id) {
        $sql = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
        $result = Database::query($sql);
        return User::get_user($result);
    }

    public static function is_user_login(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function get_current_user() {
        if(User::is_user_login()) {
            return User::get_user_by_id($_SESSION['user_id']);
        }

        return false;
    }

}