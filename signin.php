<?php
require_once 'CommunityManager.php';
session_start();

if (isset($_SESSION['communityManager']) && $_SESSION['communityManager'] !== null) {
    $communityManager = $_SESSION['communityManager'];
} else {
    $communityManager = new CommunityManager();
    $_SESSION['communityManager'] = $communityManager;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    $loggedInMember = $communityManager->login($pseudo, $password);
    $loggedInAdmin = $communityManager->loginAdmin($pseudo, $password);


    if ($loggedInMember && $loggedInAdmin === null) {
        // Set user session upon successful login
        echo "Login successful! Welcome, " . "<strong>" . $loggedInMember->getFullName() . "</strong>";
    } else if ($loggedInMember && $loggedInAdmin) {
        $_SESSION['user'] = $loggedInAdmin; // Store user information in session
        header("Location: admin.php");
        exit();
    } else {
        echo "Login failed.";
    }
} else {
    echo "Invalid request method.";
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

        if ($loggedInMember  && $loggedInAdmin === null) {

            echo '<div class="profail_img">
                    <img src="profailIMG.avif" alt="profail_img" class="image">
                  </div>';
            echo '<div class="info_user">  
                    <p><strong>Email:</strong> ' . $loggedInMember->getEmail() . '</p>
                    <p><strong>Date of Birth:</strong> ' . $loggedInMember->getDateOfBirth() . '</p>
                    <p><strong>Username:</strong> ' . $loggedInMember->getPseudo() . '</p>
                    <p><strong>Password:</strong> ****** </p>
                  </div>';
            echo '<form action="" method="post">
                  <button type="submit" name="logout" value="Logout">Logout</button>
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