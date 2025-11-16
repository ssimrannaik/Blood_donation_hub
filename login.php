<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM donors WHERE email = ?");
    $stmt->execute([$email]);
    $donor = $stmt->fetch();

    if ($donor && password_verify($password, $donor['password'])) {
        $_SESSION['donor_id'] = $donor['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Blood Donation Hub</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Blood Donation Hub</div>
            <ul>
                <li><a href="../index.html">Home</a></li>
                <li><a href="../request-blood.html">Request Blood</a></li>
                <li><a href="../eligibility.html">Am I Eligible?</a></li>
                <li><a href="../contact.html">Contact Us</a></li>
                <li><a href="register.php">Register as Donor</a></li>
                <li><a href="login.php">Donor Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="login">
        <h1>Donor Login</h1>
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="cta-button">Login</button>
        </form>
        <?php if (isset($error)) echo '<p>' . $error . '</p>'; ?>
        <p><a href="register.php">Register</a></p>
    </section>

    <footer>
        <p>&copy; 2025 Blood Donation Hub. All rights reserved.</p>
    </footer>
</body>
</html>
