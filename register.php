<?php
$conn = new mysqli("localhost", "root", "", "nama_database");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($check->num_rows > 0) {
        echo "Username sudah terdaftar!";
    } else {
        $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
        echo "Registrasi berhasil!";
    }
}
?>

<form method="post">
    <h2>Form Registrasi</h2>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Daftar</button>
</form>
