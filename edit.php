<?php
require_once 'Membre.php';
require_once 'CommunityManager.php';
session_start();
if (isset($_SESSION['user'])) {
    $communityManager = $_SESSION['communityManager'];
    $loggedInMember = $communityManager->getMemberById($_SESSION['user']);


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize input
        $fullName = $_POST['fullName'];
        $dateOfBirth = $_POST['dateOfBirth'];
        $password = $_POST['password'];

        // Update user information
        $loggedInMember->setFullName($fullName);
        $loggedInMember->setDateOfBirth($dateOfBirth);
        $loggedInMember->setPassword($password);

    }
} else {
    // Redirect to login page if the user is not logged in
    header("Location: signin.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Space</title>
    <link rel="stylesheet" href="profail_style.css">
    <script src="https://kit.fontawesome.com/e3ff8bb9fb.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container_user">

        <?php

        if ($loggedInMember) {
            echo  "Welcome, " . "<strong>" . $loggedInMember->getFullName() . "</strong>";
            echo '<div class="profail_img">
                    <img src="profailIMG.avif" alt="profail_img" class="image">
                  </div>';
            echo '<div class="info_user">  
                    <p><strong>Email:</strong> ' . $loggedInMember->getEmail() . '</p>
                    <p><strong>Date of Birth:</strong> ' . $loggedInMember->getDateOfBirth() . '</p>
                    <p><strong>Username:</strong> ' . $loggedInMember->getPseudo() . '</p>
                    <p><strong>Password:</strong> ****** </p>
                  </div>';
            echo '<form action="signin.html" method="post">
                    <button type="submit" value="Logout">Logout</button>
                  </form>';
            echo '<form action="edit.html" method="post">
                  <button type="submit" value="Edit" name="UserEdit">Edit</button>
                </form>';
        } else {
            echo '<p>Please <a href="signin.html">login</a> to access your personal space.</p>';
        }

        ?>
    </div>
</body>

</html>