<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name   = htmlspecialchars(trim($_POST['name']));
    $email  = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $date   = trim($_POST['date']);
    $time   = trim($_POST['time']);
    $guests = (int) $_POST['guests'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
        exit;
    }

    // Insert into database using prepared statement
    $stmt = $conn->prepare("INSERT INTO reservations (name, email, date, time, guests) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $name, $email, $date, $time, $guests);

    if ($stmt->execute()) {
        // Customer confirmation email
        $customerSubject = "Your Detroit Dine Easy Reservation";
        $customerMessage = "Hello $name,\n\nThank you for reserving a table with Detroit Dine Easy!\n\nReservation Details:\nDate: $date\nTime: $time\nGuests: $guests\n\nWe look forward to seeing you!\n\n- Detroit Dine Easy";
        $headers = "From: no-reply@detroitdineeasy.com\r\n";
        $headers .= "Reply-To: no-reply@detroitdineeasy.com\r\n";

        // Restaurant admin notification email
        $adminEmail = "detroitdineeasy@gmail.com";
        $adminSubject = "New Table Reservation from $name";
        $adminMessage = "Reservation Details:\n\nName: $name\nEmail: $email\nDate: $date\nTime: $time\nGuests: $guests";

        $customerSent = mail($email, $customerSubject, $customerMessage, $headers);
        $adminSent = mail($adminEmail, $adminSubject, $adminMessage, $headers);

        if ($customerSent && $adminSent) {
            echo "<script>alert('Reservation successful! Confirmation sent to your email.'); window.location.href='index.html';</script>";
        } elseif ($customerSent) {
            echo "<script>alert('Reservation saved. Confirmation sent to you. Admin email failed.'); window.location.href='index.html';</script>";
        } elseif ($adminSent) {
            echo "<script>alert('Reservation saved. Admin notified. Your confirmation email failed.'); window.location.href='index.html';</script>";
        } else {
            echo "<script>alert('Reservation saved. Email notifications failed.'); window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('Database error: {$stmt->error}'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
