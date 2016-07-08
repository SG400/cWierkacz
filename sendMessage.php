<?php
require_once __DIR__ . "/src/connection.php";
require_once __DIR__ . "/src/functions.php";
require_once __DIR__ . "/src/header.php";

if (isset($_SESSION['loggedUserId']) === false) {
    header("Location: login.php");
}


?>

<div class='container'>

    <?php

    $receiverName = getUserLogin($db_conn, $_GET['UserId']);

    echo "<div class=''>
                        <h3>Wyślij wiadomość do użytkownika <b>$receiverName</b></h3>
                        <div class=''>
                            <form action='sendMessage.php?UserId={$_GET['UserId']}' class=\"form-horizontal\" role=\"form\" method='post'>
                                <label><h4>Treść wiadomości:</h4> <textarea name='messageText' class=\"form-control\" rows='10' cols='50' maxlength='255'></textarea></label><br>
                                <button type='submit' class='btn btn-default'>Wyślij</button>
                            </form>
                        </div>
                     </div>";

    if (isset($_POST['messageText']) && !empty($_POST['messageText'])) {

        $newMessage = new Message();

        $newMessage->setSenderId($_SESSION['loggedUserId']);

        $newMessage->setReceiverId($_GET['UserId']);
        $newMessage->setMessageText($_POST['messageText']);
        $newMessage->setDate(date("Y-m-d-H-i-s"));
        $newMessageResult = $newMessage->saveMessageToDB($db_conn);

        if ($newMessageResult == true) {
            echo "<h2>Wiadomość została wysłana!</h2>";
        } else {
            echo "<h2>Wiadomość nie została wysłana!</h2>";
        }
    }
    $db_conn->close();
    $db_conn = null;
    ?>
</div>
</body>
</html>
