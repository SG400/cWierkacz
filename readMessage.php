<?php
require_once __DIR__ . "/src/connection.php";
require_once __DIR__ . "/src/functions.php";
require_once __DIR__ . "/src/header.php";

if (isset($_SESSION['loggedUserId']) === false) {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['messageId']) && !empty($_GET['messageId'])) {
        $message = new Message();
        $message->loadMessageDB($db_conn, $_GET['messageId']);

        if ($message->getReceiverId() == $_SESSION['loggedUserId']) {
            $message->setIsRead();
            $result = $message->saveMessageToDB($db_conn);
        } else {
            echo "Error";
        }
    }
}
?>

<div class="container">
    <div id='message' class="col-lg-6">
        <?php
        if ($message) {
            $loginId = $message->getSenderId();
            $login = getUserLogin($db_conn, $loginId);
            $text = $message->getMessageText();
            $date = $message->getDate();
            echo "<h3>Od:  <b>$login</b></h3>
                      <h4>Data: $date</h4>
                      <h4>Treść:</h4>
                      <p>$text</p>";
        }
        $db_conn->close();
        $db_conn = null;
        ?>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</body>
</html>
