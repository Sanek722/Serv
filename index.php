<?php
$mysqli = new mysqli("db", "user", "password", "appDB");
// вывод всеъ пользователей
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['entity'] == 'users') {
    $sql = "SELECT * FROM users";
    $result = $mysqli->query($sql);

    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    header("Content-Type: application/json");
    echo json_encode($users);
}
// Добавление пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['entity'] == 'users') {
    $data = json_decode(file_get_contents('php://input'), true);

    $name = $data['name'] ?? '';
    $surname = $data['surname'] ?? '';

    $sql = "INSERT INTO users (name, surname) VALUES ('$name', '$surname')";

    if ($mysqli->query($sql) == TRUE) {
        echo "User added successfully";
    } else {
        echo "Error: " . $mysqli->error;
    }
}

//удаление пользователя
if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && $_GET['entity'] == 'users') {
    $user_id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = $user_id";

    if ($mysqli->query($sql) == TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error: " . $mysqli->error;
    }
}


//обновление пользователя
if ($_SERVER['REQUEST_METHOD'] == 'PUT' && $_GET['entity'] == 'users') {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data['id'] ?? '';
    $name = $data['name'] ?? '';
    $surname = $data['surname'] ?? '';
    $sql = "UPDATE users SET name='$name', surname='$surname' WHERE id=$user_id";

    if ($mysqli->query($sql) == TRUE) {
        echo "User updated successfully";
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>