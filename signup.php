<?php
require_once 'CommunityManager.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $dateOfBirth = $_POST['dateOfBirth'];

    try {
        if (isset($_SESSION['communityManager']) && $_SESSION['communityManager'] !== null) {
            $communityManager = $_SESSION['communityManager'];
        } else {
            $communityManager = new CommunityManager();
            $_SESSION['communityManager'] = $communityManager;
        }

        $communityManager->registerMember($fullName, $email, $pseudo, $password, $dateOfBirth);
        echo "Registration successful! Welcome, " . htmlspecialchars($fullName);


        echo '<p>Please <a href="signin.html">login</a> to access your personal space.</p>';
    } catch (Exception $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "Invalid request method.";
}
?>
