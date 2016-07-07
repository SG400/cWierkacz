<?php
require_once __DIR__ . "/src/connection.php";
require_once __DIR__ . "/src/functions.php";
require_once __DIR__ . "/src/header.php";

if (isset($_SESSION['loggedUserId']) === false) {
    header("Location:login.php");
}

$allTwitterUsers = User::GetAllUsers($db_conn);
$loggedUser = getUserLogin($db_conn, $_SESSION['loggedUserId']);

echo("<div class='container'>");
echo("<h1>Użytkownicy:</h1>");
echo("<br>");

echo "<table class='table table-striped'>";
echo "<th>Użytkownik</th><th></th>";

if (count($allTwitterUsers) > 0) {
    foreach ($allTwitterUsers as $user) {
        $idToShow = $user->getId();
        $loginToShow = $user->getLogin();

        echo "<tr>
            <td>$loginToShow</td><td>";

        if ($loggedUser == $loginToShow) {
            echo("<a href='showUser.php?idToShow={$idToShow}'><b>Podejrzyj siebie</b></a></td>");
        } else {
            echo("<a href='showUser.php?idToShow={$idToShow}'>Podejrzyj użytkownika</a></td>");
        }


        echo ("</tr>");




    }
}
echo("</div > ");
?>