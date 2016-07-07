<?php

require_once __DIR__ . "/src/connection.php";
require_once __DIR__ . "/src/functions.php";
require_once __DIR__ . "/src/header.php";
?>

<div class='container'>

    <?php

    if (isset($_SESSION['loggedUserId'])) {

        if (!empty($_POST['postText'])) {
            $newPostText = $_POST['postText'];

            $newTwit = new Tweet();
            $newTwit->setUserId($_SESSION['loggedUserId']);
            $newTwit->setText($newPostText);
            $newTwit->setDate(date("Y-m-d-H-i-s"));
            $newTwit->saveTweetToDB($db_conn);
        }

        if (!empty($_POST['commentText'])) {
            $newCommentText = $_POST['commentText'];
            $postId = $_POST['twitId'];

            $newComment = new Comment();
            $newComment->setPostId($postId);
            $newComment->setUserId($_SESSION['loggedUserId']);
            $newComment->setText($newCommentText);
            $newComment->setDate(date("Y-m-d-H-i-s"));
            $newComment->saveCommentToDB($db_conn);

        }


        $loggedUser = new User();
        $loggedUser->loadFromDB($db_conn, $_SESSION['loggedUserId']);
        $userLogin = getUserLogin($db_conn, $_SESSION['loggedUserId']);

        echo("
        <div class='row'>
            <div class=\"col-lg-6\">
              <h2>Witaj, $userLogin</h2>
              <form action=\"#\" method=\"post\" class=\"form-horizontal\" role=\"form\">
                    <textarea class=\"form-control\" rows=\"5\" name=\"postText\" maxlength='140'></textarea>
                    <button type=\"submit\" class='btn btn-default'>Dodaj twita</button>
              </form>
            </div> <!--col1-->
        </div><!--row11-->
        </div><!--container-->");


        $getAllTweetsResult = Tweet::getAllTweets($db_conn, $_SESSION['loggedUserId'], 'all');


        if (count($getAllTweetsResult) > 0) {

            echo("<div class='container'>");
            echo "<table class='table'>";


            $counter=0;

            foreach ($getAllTweetsResult as $twitRow) {

                $counter++;
                $twitText = $twitRow->getpostText();
                $twitId = $twitRow->getId();
                $loginId = $twitRow->getUserId();
                $login = getUserLogin($db_conn, $loginId);
                $twitDate = $twitRow->getDate();


                echo "<tr><td><h4><strong>Wysyłający</strong></h4></td><td><h4><strong>Twit</strong></h4></td><td><h4><strong>Data</strong></h4></td></tr>";
                echo "<tr class='alert-success'>
                               <td>$login</td>
                               <td>$twitText</td>
                              <td>$twitDate</td>
                              </tr>";


                $getAllCommentsResult = Comment::getAllComments($db_conn, $twitId);

                if ($getAllCommentsResult > 0) {

                    echo("<tr><td></td><td>");

                    echo("<div class='col-md-10'>");
                    echo("<form action=\"#\" method=\"post\" class=\"form-horizontal\" role=\"form\">
                                    <input type=\"hidden\" name=\"twitId\" value=\"$twitId\" />
                                    <textarea class=\"form-control\" rows=\"2\" name=\"commentText\" maxlength='120'></textarea>
                                    <button type=\"submit\" class='btn btn-default'>Dodaj komentarz</button>
                                    </form>");
                    echo("</div>");
                    echo("</td>");


                    echo("<tr><td></td><td>");
                    echo("<div class='col-md-6'>");
                    echo("<button data-toggle='collapse' data-target='#commentTable" .$counter."' class='btn btn-default btn-sm'>Zwiń/rozwiń komentarze</button>");
                    echo("<div id='commentTable".$counter."' class='collapse'>");

                   echo("<table class='table` table-condensed table-hover'><th></th><th>Komentarz</th><th>Komentujący</th><th>Data</th>");

                    foreach ($getAllCommentsResult as $commentRow) {
                        $commentId = $commentRow->getId();
                        $commentText = $commentRow->getText();
                        $commentUserId = $commentRow->getUserId();
                        $commentUser = getUserLogin($db_conn, $commentUserId);
                        $commentDate = $commentRow->getDate();
                        echo "<tr><td></td><td>$commentText</td><td>$commentUser</td><td>$commentDate</td></tr>";

                    }

                    //echo("<td>");
                    echo("</table>");
                    echo("</div>");
                    echo("</div>");
                    echo("</td></tr>");

                }

                //echo "<th>Twit</th><th>Wysyłający</th><th>Data</th>";

            }


            echo "</table>";
            //echo "</div>";
            echo("<br>");

        } else {
            echo "<p>Nie ma żadnych twitów</p>";
        }


    } else {
        echo "<div class='container'>
        <h1>Witaj!</h1>
        <p>Jeżeli jesteś u nas po raz pierwszy skorzystaj z darmowej rejestracji</p>
        <p>Jeżeli jesteś już zarejestrowany - zaloguj się</p>
        </div>";


    }

    echo('</div>');
    $db_conn->close();
    $db_conn = null;


    ?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-2.0.3.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-2.0.3.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>

    </body>
    </html>

