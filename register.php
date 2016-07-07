<?php

require_once __DIR__ . "/src/connection.php";
require_once __DIR__ . "/src/functions.php";
require_once __DIR__ . "/src/header.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userToRegister = new User();
    $userToRegister->setLogin($_POST['login']);
    $userToRegister->setHashedPassword($_POST['password1'], $_POST['password2']);
    $userToRegister->activateUser();
    $registerSucess = $userToRegister->saveToDB($db_conn);

    if ($registerSucess) {
        $_SESSION['loggedUserId'] = $userToRegister->getId();
        header("Location: index.php");
    } else {
        echo "Rejestracja nie udała się";
    }
}
$db_conn->close();
$db_conn = null;
?>


<div class='container'>
    <div class="col-md-6">
        <h2>Podaj login i hasło</h2>
        <form class="form-horizontal" role="form" action="#" method="post">
            <div class='form-group'>
                <label class='col-md-2 control-label'>Login:</label>
                <div class="col-sm-8">
                    <input class='form-control' id="focusedInput" type="text" name="login" placeholder="Login"></label>
                </div>
            </div>
            <div class='form-group'>
                <label class='col-md-2 control-label'>Hasło:</label>
                <div class="col-sm-8">
                    <input class='form-control' type="password" name="password1">
                </div>
            </div>
            <div class='form-group'>
                <label class='col-md-2 control-label'>Potwierdź hasło:</label>
                <div class="col-sm-8">
                    <input class='form-control' type="password" name="password2">
                </div>
            </div>
            <button class='btn btn-default' type="submit">Zarejestruj się</button>
        </form>
    </div>

</div>
</body>
</html>

