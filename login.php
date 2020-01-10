<?php

require_once 'includes/dbh.inc.php';
session_start();

$userLoginField = array('userName' => '', 'password' => '');
$errorMessage = '';
$isValid = false;

//check if submit and get form fields info
if (isset($_POST['submit'])) {
    if (isset($_POST['userName'])) {
        $userLoginField['userName'] = trim($_POST['userName']);
    }
    if (isset($_POST['password'])) {
        $userLoginField['password'] = ($_POST['password']);
    }
    //check if form fields are empty and send back error message
    if (array_search('', $userLoginField)) {
        $errorMessage = '* les champs sont obligatoires.';
    } else {
        //check if user exist
        $sql = 'SELECT * FROM tp_user WHERE userName LIKE "'.$userLoginField['userName'].'";';
        $result = access_from_db($sql);

        // if user doesnt exist send back error message
        if (empty($result)) {
            $errorMessage = '* Invalid UserName or Password.';
        } else {
            $isValid = true;
            $dbUserInfo = $result[0];
            //check if password are equals if yes redirect to index.php
            if (password_verify($userLoginField['password'], $dbUserInfo['userPassword'])) {
                $_SESSION['userID'] = $dbUserInfo['id'];
                header('Location: index.php');
            } else {
                //if not send back error message
                $errorMessage = '* Invalid UserName or Password.';
            }
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Login</h1>
            <p class="lead">L'usager par default est <b>UserName: admin</b> et <b>Password: admin</b></p>
            <hr class="my-4">
            <form action="login.php" method="POST">
                <div class="form-group row">
                    <label for="inputUser3" class="col-sm-2 col-form-label">UserName<span class="text-danger">
                            *</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputUser3" name="userName">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password<span class="text-danger">
                            *</span></label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword3" name="password">
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary" name="submit">Login</button>
                <hr>
                <h6 class="text-danger"><?= $errorMessage; ?>
                </h6>
            </form>
        </div>
    </div>
</body>

</html>