<?php
require_once 'Membre.php';
require_once 'CommunityManager.php';
session_start();

if (isset($_SESSION['communityManager']) && $_SESSION['communityManager'] !== null) {
    $communityManager = $_SESSION['communityManager'];
} else {
    $communityManager = new CommunityManager();
    $_SESSION['communityManager'] = $communityManager;
}

if (isset($_SESSION['user'])) {
    $loggedInAdmin = $_SESSION['user'];

    if (isset($_POST['delete_member'])) {
        $memberIdToDelete = $_POST['delete_member'];
        $communityManager->deleteMember($memberIdToDelete);

        header("Location: admin.php");
        exit();
    }

    $members = $communityManager->showAllMembers();

    echo "Welcome, Admin " . $loggedInAdmin->getFullName(); 

} else {
    // Redirect to login page if user information is not available
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin space</title>
</head>

<body>

    <style>
        body {

            width: 100%;
            height: 100vh;
            font-family: "Montserrat", sans-serif;
            background-color: #ecf0f3;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0e0e0;
        }
    </style>
    <h5>Member List:</h5>
    <table>
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Date of Birth</th>
            <th>Delete member</th>
        </tr>

        <?php
        foreach ($members as $member) {
            if (str_starts_with($member->getPseudo(), 'admin_') == false) {

                echo '<tr>
                        <td>' . $member->getFullName() . '</td>
                        <td>' . $member->getEmail() . '</td>
                        <td>' . $member->getDateOfBirth() . '</td>
                        <form action="admin.php" method="post">
                        <td> <button type="submit" name="delete_member" value="' . $member->getId() . '">Delete</button></td>
                        </form>
                        </tr>';
            }
        }
        ?>
    </table>

</body>

</html>