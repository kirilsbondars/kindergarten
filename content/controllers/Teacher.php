<?php

class Teacher {
    private $id;
    private $name;
    private $surname;
    private $age;
    private $description;
    private $image;

    public function __construct($id, $name, $surname, $age, $description, $image) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->age = $age;
        $this->description = $description;
        $this->image = $image;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getAge() {
        return $this->age;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getImage() {
        return $this->image;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public static function get_all() {
        $sql = "SELECT * FROM teachers";
        $result = Database::query($sql);

        $teacher_objects = [];
        while ($teacher_item = $result->fetch_assoc()) {
            $teacher = new Teacher($teacher_item['id'], $teacher_item['name'], $teacher_item['surname'],
                $teacher_item['age'], $teacher_item['description'], $teacher_item['image']);
            $teacher_objects[] = $teacher;
        }

        return $teacher_objects;
    }

    public static function get_teacher_by_id($id) {
        $sql = "SELECT * FROM teachers WHERE id = $id";
        $result = Database::query($sql);

        if ($result->num_rows > 0) {
            $teacher_item = $result->fetch_assoc();
            $teacher = new Teacher($teacher_item['id'], $teacher_item['name'], $teacher_item['surname'],
                $teacher_item['age'], $teacher_item['description'], $teacher_item['image']);
            return $teacher;
        } else {
            return null;
        }
    }

    public function create(): bool
    {
        $sql = "INSERT INTO teachers (name, surname, age, description, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = Database::prepare($sql);
        $stmt->bind_param("ssiss", $this->name, $this->surname, $this->age, $this->description, $this->image);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM teachers WHERE id = ?";
        $stmt = Database::prepare($sql);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    public function update(): bool
    {
        $sql = "UPDATE teachers SET name = ?, surname = ?, age = ?, description = ?, image = ? WHERE id = ?";
        $stmt = Database::prepare($sql);
        $stmt->bind_param("ssissi", $this->name, $this->surname, $this->age, $this->description, $this->image, $this->id);
        return $stmt->execute();
    }

    public function getPathToImage() {
        return '/img/' . $this->image;
    }

    public function getFullName() {
        return $this->name . ' ' . $this->surname;
    }
}