<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $passwordRaw = $_POST['password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $blood_type = $_POST['blood_type'] ?? '';
    $dob = $_POST['dob'] ?? '';

    if ($name === '' || $email === '' || $passwordRaw === '' || $blood_type === '' || $dob === '') {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please provide a valid email address.';
    } else {
        try {
            $check = $pdo->prepare('SELECT COUNT(*) FROM donors WHERE email = ?');
            $check->execute([$email]);

            if ($check->fetchColumn() > 0) {
                $error = 'An account with this email already exists. Please log in instead.';
            } else {
                $password = password_hash($passwordRaw, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO donors (name, email, password, phone, blood_type, dob) VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->execute([$name, $email, $password, $phone, $blood_type, $dob]);
                header('Location: login.php');
                exit;
            }
        } catch (PDOException $e) {
            $error = 'Registration failed. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Blood Donation Hub</title>
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

    <section class="register">
        <h1>Donor Registration</h1>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone">
            <label for="blood_type">Blood Type:</label>
            <select id="blood_type" name="blood_type" required>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>
            <button type="submit" class="cta-button">Register</button>
        </form>
        <?php if (isset($error)) echo '<p>' . $error . '</p>'; ?>
    </section>

    <footer>
        <p>&copy; 2025 Blood Donation Hub. All rights reserved.</p>
    </footer>
</body>
</html>
