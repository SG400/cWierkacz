<?php

function getUserLogin(mysqli $conn, $id) {

    $user = new User();
    $user->loadFromDB($conn, $id);
    $login = $user->getLogin();


    if($login == true) {
        return $login;
    }
    return false;
}

function showAllTweets() {
    //wypełnić i wstawić w index.php i showUser.php, bo się powtarza duuuużo kodu
}