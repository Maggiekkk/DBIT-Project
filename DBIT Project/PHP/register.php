<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = $_POST['user_type'];

    $sql = "INSERT INTO Users (name, email, password, user_type) VALUES ('$name', '$email', '$password', '$user_type')";

    if ($conn->query($sql) === TRUE) {
        $user_id = $conn->insert_id;
        if ($user_type == 'Volunteer') {
            $sql_volunteer = "INSERT INTO Volunteers (user_id) VALUES ('$user_id')";
            $conn->query($sql_volunteer);
        } elseif ($user_type == 'Admin') {
            $sql_admin = "INSERT INTO Admins (user_id) VALUES ('$user_id')";
            $conn->query($sql_admin);
        }
        echo "Registration successful";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}

