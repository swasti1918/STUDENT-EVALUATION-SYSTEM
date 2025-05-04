<?php
require 'db.php';
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM teachers WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashed);
        $stmt->fetch();
        if (password_verify($pass, $hashed)) {
            $_SESSION['teacher'] = $user;
            header("Location: teacher.html"); // Redirect to teacher.html
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Teacher not found.";
    }
    $stmt->close();
}
?>

<h2>Login - Teacher</h2>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
    background: url('background.jpg') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

form {
    background: rgba(255, 255, 255, 0.85);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 400px;
}

input[type="text"], input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    margin: 10px 0 20px;
    border: none;
    border-radius: 8px;
    background-color: #f1f1f1;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    border: none;
    font-size: 18px;
    border-radius: 8px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

h2 {
    text-align: center;
    color: #333;
}

.error {
    color: red;
    text-align: center;
    font-weight: bold;
}
</style>

<?php if ($error): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>
