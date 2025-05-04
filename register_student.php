<?php
require 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username']);
    $pass = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO students (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $user, $pass);

    if ($stmt->execute()) {
        $message = "Student registered successfully! Redirecting to login...";
        // Redirect to the login_student.php page after successful registration
        header("Location: login_student.php");  // Change 'login_student.php' to your actual login page URL
        exit();  // Make sure no further code is executed after the redirect
    } else {
        $message = "Error: " . $stmt->error;
    }
}
?>

<h2>Register - Student</h2>
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
</style>

<?php echo $message; ?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Register</button>
</form>
