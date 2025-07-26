<?php
include 'helper/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $connection->prepare($sql); // gunakan $connection, bukan $conn

    if ($stmt) {
        $stmt->bind_param("ss", $username, $password); // gunakan "ss" karena hanya 2 string (username dan password)

        if ($stmt->execute()) {
            echo "<p style='color:green;'>User berhasil ditambahkan!</p>";
        } else {
            echo "<p style='color:red;'>Gagal menambahkan user: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color:red;'>Statement error: " . $connection->error . "</p>";
    }
}
?>

<!-- Form HTML -->
<form method="POST" action="adduser.php">
  <label>Username:</label><br>
  <input type="text" name="username" required><br><br>

  <label>Password:</label><br>
  <input type="password" name="password" required><br><br>

  <button type="submit">Add User</button>
</form>
