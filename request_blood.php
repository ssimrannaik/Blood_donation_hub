<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $blood_type = $_POST['blood_type'];
    $location = $_POST['location'];

    // Insert request
    $stmt = $pdo->prepare("INSERT INTO requests (name, email, phone, blood_type, location) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $blood_type, $location]);

    // Find matching donors
    $stmt = $pdo->prepare("SELECT name, email, phone FROM donors WHERE blood_type = ?");
    $stmt->execute([$blood_type]);
    $donors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<h2>Matching Donors for Blood Type: ' . htmlspecialchars($blood_type) . '</h2>';
    if ($donors) {
        echo '<ul>';
        foreach ($donors as $donor) {
            echo '<li>';
            echo 'Name: ' . htmlspecialchars($donor['name']) . '<br>';
            echo 'Email: ' . htmlspecialchars($donor['email']) . '<br>';
            echo 'Phone: ' . htmlspecialchars($donor['phone']);
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No donors found for this blood type. Please check back later or contact us.</p>';
    }
}
?>
