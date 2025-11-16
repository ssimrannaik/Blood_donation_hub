<?php
session_start();
if (!isset($_SESSION['donor_id'])) {
    header('Location: login.php');
    exit;
}
include 'config.php';

$donor_id = $_SESSION['donor_id'];
$stmt = $pdo->prepare("SELECT name, email, phone, blood_type, dob, last_donation FROM donors WHERE id = ?");
$stmt->execute([$donor_id]);
$donor = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Blood Donation Hub</title>
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

    <section class="dashboard">
        <div class="dashboard-header">
            <h1>Your Dashboard</h1>
            <a class="cta-button" href="logout.php">Logout</a>
        </div>

        <?php if ($donor): ?>
            <div class="panel">
                <h2>Your Profile</h2>
                <ul class="profile-list">
                    <li><span>Name</span><strong><?php echo htmlspecialchars($donor['name']); ?></strong></li>
                    <li><span>Email</span><strong><?php echo htmlspecialchars($donor['email']); ?></strong></li>
                    <li><span>Phone</span><strong><?php echo htmlspecialchars($donor['phone']); ?></strong></li>
                    <li><span>Blood Type</span><strong><?php echo htmlspecialchars($donor['blood_type']); ?></strong></li>
                    <li><span>Date of Birth</span><strong><?php echo htmlspecialchars($donor['dob']); ?></strong></li>
                    <li><span>Last Donation</span><strong><?php echo $donor['last_donation'] ? htmlspecialchars($donor['last_donation']) : 'Not recorded'; ?></strong></li>
                </ul>
            </div>
        <?php else: ?>
            <p class="panel">We couldn't load your profile details right now. Please try again later.</p>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2025 Blood Donation Hub. All rights reserved.</p>
    </footer>
</body>
</html>
