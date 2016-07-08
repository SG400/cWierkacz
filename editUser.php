<?php

require_once __DIR__ . "/src/connection.php";
require_once __DIR__ . "/src/functions.php";
require_once __DIR__ . "/src/header.php";

if (isset($_SESSION['loggedUserId']) === false) {
    header("Location: login.php");
}

if (!empty($_POST['description'])) {
    $userToUpdate = new User();
    $userToUpdate->loadFromDB($db_conn, $_SESSION['loggedUserId']);
    $userToUpdate->setDescription($_POST['description']);
    $userToUpdate->saveToDB($db_conn);
    header("Location: showUser.php?idToShow={$_SESSION['loggedUserId']}");

}

if ((!empty($_POST['password1'])) && $_POST['password1'] === $_POST['password2']) {
    $userToUpdate = new User();
    $userToUpdate->loadFromDB($db_conn, $_SESSION['loggedUserId']);
    $userToUpdate->setHashedPassword($_POST['password1'], $_POST['password2']);
    $userToUpdate->saveToDB($db_conn);
    header("Location: showUser.php?idToShow={$_SESSION['loggedUserId']}");
}

echo "<div class='container'>";
echo "<h2>Zmień swoje dane:</h2>";
echo "<form action='#' method='post' class=\"form-horizontal\" role=\"form\">";
echo "<label>Opis: <input class=\"form-control\" type='text' name='description'></label><br>";
echo "<label>Nowe hasło:<input class=\"form-control\" type='text' name='password1'></label><br>";
echo "<label>Powtórz nowe hasło:<input class=\"form-control\" type='text' name='password2'></label><br>";
echo "<button type='submit' class='btn btn-default'>Zmień dane</button>";
echo "</form>";
echo "</div>";


?>