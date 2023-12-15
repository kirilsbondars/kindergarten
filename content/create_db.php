<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kindergarten";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br/>";
} else {
    echo "Error creating database: " . $conn->error . "<br/>";
}
$conn->close();

$conn_db = new mysqli($servername, $username, $password, $dbname);
if ($conn_db->connect_error) {
    die("Connection failed: " . $conn_db->connect_error);
}

$table_users = "CREATE TABLE Users (
id INT(12) AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
surname VARCHAR(255) NOT NULL,
username VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
is_admin BOOLEAN DEFAULT FALSE
);";
$table_news = "CREATE TABLE News (
id INT(12) AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255) NOT NULL,
image VARCHAR(255) NOT NULL,
description TEXT NOT NULL,
created_at DATETIME DEFAULT NOW()
);";
$table_comments = "CREATE TABLE Comments (
id INT(12) AUTO_INCREMENT PRIMARY KEY,
text VARCHAR(255) NOT NULL,
user_id INT(12) NOT NULL,
created_at DATETIME DEFAULT NOW(),
FOREIGN KEY (user_id) REFERENCES Users(id)
);";
$table_teachers = "CREATE TABLE Teachers (
id INT(12) AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
surname VARCHAR(255) NOT NULL,
age INT(3) NOT NULL,
description TEXT NOT NULL,
image BLOB NOT NULL
);";
$tables = array('Users' => $table_users, 'News' => $table_news,
    'Comments' => $table_comments, 'Teachers' => $table_teachers);

$creation_results = array();
foreach($tables as $name => $sql) {
    $query = @$conn_db->query($sql);
    if(!$query)
        $creation_results[] = "Error creating $name table: $conn_db->error";
    else
        $creation_results[] = "Table $name was successfully created";
}
foreach($creation_results as $msg) {
    echo "$msg <br>";
}


$data_users = "INSERT INTO Users (name, surname, is_admin)
VALUES ('Kirils', 'Bondars', true),
       ('Anna', 'Bondare', false),
       ('Ilona', 'Bondare', false)";
$data_news = "INSERT INTO News (title, image, description)
VALUES ('News article 1', 'immage', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, '),
       ('News article 2', 'image', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do e'),
       ('News article 3', 'image', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod')";
$data_comments = "INSERT INTO Comments (text, user_id)
VALUES ('comment number 1', '1'),
       ('comment number 2', '2'),
       ('comment number 3', '3')";
$data_teachers = "INSERT INTO Teachers (name, surname, age, description, image)
VALUES ('Kirils', 'Bondars', '22', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,', 'image'),
       ('Anna', 'Bondare', '55', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,', 'image'),
       ('Elizabete', 'Juju', '43', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,', 'image')";
$data = array('Users' => $data_users, 'News' => $data_news,
    'Comments' => $data_comments, 'Teachers' => $data_teachers);

$insert_results = array();
foreach($data as $name => $sql) {
    $query = @$conn_db->query($sql);
    if(!$query)
        $insert_results[] = "Error inserting records into $name table: $conn_db->error";
    else
        $insert_results[] = "Records were insert into $name table";
}
foreach($insert_results as $msg) {
    echo "$msg <br>";
}

$conn_db->close();