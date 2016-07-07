<?php
require_once __DIR__ . "/src/connection.php";
require_once __DIR__ . "/src/functions.php";
require_once __DIR__ . "/src/header.php";


?>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loggedUser = User::LogIN($db_conn, $_POST['login'], $_POST['password']);
    if ($loggedUser != null) {
        $_SESSION['loggedUserId'] = $loggedUser->getId();
        header("Location: index.php");
    } else {
        echo "Nie udalo sie zalogowac";
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
                <label class='col-md-1 control-label'>Login:</label>
                <div class="col-sm-8">
                    <input class='form-control' id="focusedInput" type="text" name="login" placeholder="Login"></label>
                </div>
            </div>
            <div class='form-group'>
                <label class='col-md-1 control-label'>Hasło:</label>
                <div class="col-sm-8">
                    <input class='form-control' type="password" name="password">
                </div>
            </div>
            <button class='btn btn-default' type="submit">Wejdź</button>
        </form>
    </div>
</div>


</body>
</html>
