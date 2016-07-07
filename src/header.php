<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/justified-nav.css" rel="stylesheet">
</head>
<body>
<div class="container">


    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><span class="label label-success">ćWierkacz</span></a>
            </div>

            <ul class="nav navbar-nav">

                <?php
                if (isset($_SESSION['loggedUserId'])) {

                    $loggedUser = getUserLogin($db_conn, $_SESSION['loggedUserId']);

                    echo "<li class=\"active\"><a href=\"index.php\">Strona główna</a></li>";

                    $newMessageCount = Message::getNewMessages($db_conn, $_SESSION['loggedUserId']);

                    if ($newMessageCount > 0) {
                        $messageMenuText = "Twoje wiadomości " . "<span class='badge'>".$newMessageCount."</span>";
                    } else {
                        $messageMenuText = "Twoje wiadomości";
                    }

                    echo "<li><a href=\"showAllMessages.php\">$messageMenuText</a></li> ";
                    echo "<li><a href=\"showAllUsers.php\">Pokaż użytkowników</a></li> ";
                    echo "<li><a href=\"editUser.php\">Zmień swoje dane</a></li> ";
                    echo("</ul>");

                    echo("<ul class=\"nav navbar-nav navbar-right\">");
                        echo "<li><a href=\"logout.php\">Wyloguj się</a></li>";
                        echo "<li><span class=\"label label-success\">$loggedUser</span></li>";
                    echo("</ul>");
                } else {
                    echo "<li class=\"active\"><a href=\"index.php\">Strona główna</a></li>";
                    echo("</ul>");

                    echo("<ul class=\"nav navbar-nav navbar-right\">");
                        echo "<li><a href=\"login.php\">Logowanie</a></li>";
                        echo "<li><a href=\"register.php\">Rejestracja</a></li>";
                    echo("</ul>");
                }
                ?>
            </ul>
        </div>
    </nav>
</div><!--masthead-->

