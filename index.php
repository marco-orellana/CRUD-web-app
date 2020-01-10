<?php

session_start();

//include dbh
require_once 'includes/dbh.inc.php';

//unset userModifyId
unset($_SESSION['userModifyID']);

//get id of user who is logged and error message
$userID = $_SESSION['userID'];
$errorMessage = '';

//check if there is a user in session if not redirect to login
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
}

//check if logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
}

//redirect to form when we want to add an user
if (isset($_GET['ajouter'])) {
    header('Location: form.php');
}

//redirect to form if we want to modify with the id of user to modify
if (isset($_GET['modify'])) {
    $_SESSION['userModifyID'] = $_GET['userModifyID'];
    header('Location: form.php');
}

//delete user
if (isset($_GET['delete'])) {
    if ($userID == $_GET['userModifyID']) {
        $errorMessage = "<h6 class='text-danger'>* You Cannot Delete Yourself.</h6>";
    } else {
        $sql_delete = 'DELETE FROM tp_user WHERE id = '.$_GET['userModifyID'].'';
        access_from_db($sql_delete);
        $errorMessage = '<p class="text-success"><i class="fas fa-check"></i> User Deleted Successfully.<p>';
    }
}

//preparing sql and load users from db
$sql_get_all = 'SELECT id ,firstName, lastName, email , creationDate, modificationDate FROM tp_user';
$array_result = access_from_db($sql_get_all);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cee6f9b8dd.js" crossorigin="anonymous"></script>
    <title>Index</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php'; ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Courriel</th>
                    <th scope="col">Date de création</th>
                    <th scope="col">Date de modification</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($array_result as $array_user): ?>
                <tr <?=($userID == $array_user['id'] ? 'class ="table-active"' : ''); ?>>
                    <td><?=$array_user['firstName']; ?>
                    </td>
                    <td><?=$array_user['lastName']; ?>
                    </td>
                    <td><?=$array_user['email']; ?>
                    </td>
                    <td><?=$array_user['creationDate']; ?>
                    </td>
                    <td><?=$array_user['modificationDate']; ?>
                    </td>
                    <td>
                        <form class="form-inline" action="index.php" method="GET"><button class="btn" type="submit" name="modify" value="true"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn" type="submit" name="delete" value="true"><i class="fas fa-times"></i></button> <input type="hidden" name="userModifyID" value="<?=$array_user['id']; ?>">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <hr>
        <?= $errorMessage; ?>
    </div>
</body>

</html>