<?php

require_once 'includes/dbh.inc.php';
date_default_timezone_set('US/Eastern');

session_start();

//check if there is a user in session if not redirect to login
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
}

$errorMessage = '';
$dbUserInfo = array();

//Add <span> with red * for required field

function addSpan()
{
    echo isset($_SESSION['userModifyID']) ? '' : '<span class="text-danger"> *</span>';
}

if (isset($_SESSION['userModifyID'])) {
    $sql = 'SELECT * FROM tp_user WHERE id = '.$_SESSION['userModifyID'].';';
    $result = access_from_db($sql);
    $dbUserInfo = $result[0];

    $userFormField = array('prenom' => $dbUserInfo['firstName'], 'nom' => $dbUserInfo['lastName'], 'courriel' => $dbUserInfo['email'],
 'userName' => $dbUserInfo['userName'], 'password' => $dbUserInfo['userPassword'], );

    if (isset($_POST['submit'])) {
        if (!empty($_POST['prenom'])) {
            $userFormField['prenom'] = trim($_POST['prenom']);
        }
        if (!empty($_POST['nom'])) {
            $userFormField['nom'] = trim($_POST['nom']);
        }
        if (!empty($_POST['courriel'])) {
            $userFormField['courriel'] = trim($_POST['courriel']);
        }
        if (!empty($_POST['userName'])) {
            $userFormField['userName'] = trim($_POST['userName']);
        }
        if (!empty($_POST['password'])) {
            $passwordBCRYPT = ($_POST['password']);
            $userFormField['password'] = password_hash($passwordBCRYPT, PASSWORD_BCRYPT);
        }

        $timestamp = date('Y-m-d H:i:s');
        $sql = 'UPDATE tp_user SET firstName = "'.$userFormField['prenom'].'", lastName = "'.$userFormField['nom'].'", email = "'.$userFormField['courriel'].'",
         userName = "'.$userFormField['userName'].'", userPassword = "'.$userFormField['password'].'", modificationDate = "'.$timestamp.'" WHERE id = '.$_SESSION['userModifyID'].';';
        $result = access_from_db($sql);
        $errorMessage = '<p class="text-success"><i class="fas fa-check"></i> User Modified Successfully.<p>';
    }
} else {
    $userFormField = array('prenom' => '', 'nom' => '', 'courriel' => '', 'userName' => '', 'password' => '');

    if (isset($_POST['submit'])) {
        if (isset($_POST['prenom'])) {
            $userFormField['prenom'] = trim($_POST['prenom']);
        }
        if (isset($_POST['nom'])) {
            $userFormField['nom'] = trim($_POST['nom']);
        }
        if (isset($_POST['courriel'])) {
            $userFormField['courriel'] = trim($_POST['courriel']);
        }
        if (isset($_POST['userName'])) {
            $userFormField['userName'] = trim($_POST['userName']);
        }
        if (!empty($_POST['password'])) {
            $passwordBCRYPT = ($_POST['password']);
            $userFormField['password'] = password_hash($passwordBCRYPT, PASSWORD_BCRYPT);
        }
        if (array_search('', $userFormField)) {
            $errorMessage = '<h6 class="text-danger">* les champs sont obligatoires.</h6>';
        } else {
            $timestamp = date('Y-m-d H:i:s');
            $sql = 'INSERT INTO tp_user (firstName,lastName,email,userName,userPassword,creationDate,modificationDate) VALUES ("'.$userFormField['prenom'].'","'.$userFormField['nom'].'",
             "'.$userFormField['courriel'].'","'.$userFormField['userName'].'","'.$userFormField['password'].'","'.$timestamp.'","'.$timestamp.'")';
            $result = access_from_db($sql);
            $errorMessage = '<p class="text-success"><i class="fas fa-check"></i> User Added Successfully.<p>';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cee6f9b8dd.js" crossorigin="anonymous"></script>
    <title>Form</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php'; ?>
        <h5><?php echo isset($_SESSION['userModifyID']) ? 'Modify User: '.$userFormField['userName'] : '<span class="text-danger">* </span>Veuillez remplir tous les champs !'; ?>
        </h5>
        <hr>
        <form action="form.php" method="POST">
            <div class="form-group row">
                <label for="inputPrenom3" class="col-sm-2 col-form-label">Prénom<?= addSpan(); ?></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPrenom3" name="prenom" <?= isset($_SESSION['userModifyID']) ? 'value="'.$userFormField['prenom'].'"' : ''; ?>>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputNom3" class="col-sm-2 col-form-label">Nom<?= addSpan(); ?></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputNom3" name="nom" <?= isset($_SESSION['userModifyID']) ? 'value="'.$userFormField['nom'].'"' : ''; ?>>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Courriel<?= addSpan(); ?></label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail3" name="courriel" <?= isset($_SESSION['userModifyID']) ? 'value="'.$userFormField['courriel'].'"' : ''; ?>>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputUserName3" class="col-sm-2 col-form-label">UserName<?= addSpan(); ?></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputUserName3" name="userName" <?= isset($_SESSION['userModifyID']) ? 'value="'.$userFormField['userName'].'"' : ''; ?>>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password<?= addSpan(); ?></label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword3" name="password">
                </div>
            </div>
            <button type="submit" class="btn btn-secondary" name="submit">Sauvegarder</button>
            <hr>
            <?= $errorMessage; ?>
        </form>
    </div>
</body>

</html>