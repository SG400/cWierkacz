<?php

require_once __DIR__ . "/src/connection.php";
require_once __DIR__ . "/src/functions.php";
require_once __DIR__ . "/src/header.php";

if (isset($_SESSION['loggedUserId']) === false) {
    header("Location: login.php");
}

?>

<div class='container'>
    <h1>Twoje wiadomości:</h1>
    <br>

    <?php

    $getAllMesaggesResult = Message::getAllMessages($db_conn, 'receiver_id', $_SESSION['loggedUserId']);

    if (count($getAllMesaggesResult) > 0) {

        echo "<table class='table table-striped'>";
        echo "<th>Wiadomość</th><th>Wysyłający</th><th>Data</th><th>Przeczytaj</th>";

        foreach ($getAllMesaggesResult as $messageRow) {

            $receivedMessage = $messageRow->getMessageText();
            $messageid = $messageRow->getId();
            $loginId = $messageRow->getSenderId();
            $login = getUserLogin($db_conn, $loginId);
            $messageDate = $messageRow->getDate();
            $messageRead = $messageRow->checkMessage();

            if ($messageRead == 'new') {
                echo "<tr class='lead'>";
            } else {
                echo "<tr class=''>";
            }

            echo "<td>" . substr($receivedMessage, 0, 50) . "...</td>
                              <td>$login</td>
                              <td>$messageDate</td>
                              <td><a href='readMessage.php?messageId=$messageid'>Przeczytaj</a></td></tr>";
        }
        echo "</table>";

        echo("<br>");
        echo("<button type='submit' class='btn btn-default'><a href=\"showAllMessages.php?messageType=sent\">Wysłane wiadomości</a></button>");

    } else {
        echo "<p>Nie masz żadnych wiadomości</p>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (!empty($_GET['messageType'])) {

            $getAllSentMessagesResult = Message::getAllMessages($db_conn, 'sender_id', $_SESSION['loggedUserId']);

            if (count($getAllSentMessagesResult) > 0) {

                echo("<br>");
                echo("<h1>Wysłane wiadomości:</h1>");
                echo("<br>");
                echo "<table class='table table-striped'>";
                echo "<th>Wiadomość</th><th>Adresat</th><th>Data</th><th>Przeczytaj</th>";

                foreach ($getAllSentMessagesResult as $messageRow) {

                    $sentMessage = $messageRow->getMessageText();
                    $messageid = $messageRow->getId();
                    $loginId = $messageRow->getReceiverId();
                    $login = getUserLogin($db_conn, $loginId);
                    $messageDate = $messageRow->getDate();
                    $messageRead = $messageRow->checkMessage();

                    if ($messageRead == 'new') {
                        echo "<tr class='lead'>";
                    } else {
                        echo "<tr class=''>";
                    }

                    echo "<td>" . substr($sentMessage, 0, 50) . "...</td>
                              <td>$login</td>
                              <td>$messageDate</td>
                              <td><a href='readMessage.php?messageId=$messageid'>Przeczytaj</a></td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Nie wysłałeś żadnych wiadomości</p>";
            }
        }
    }


    $db_conn->close();
    $db_conn = null;
    ?>


</div>

</body>
</html>
