<?php

class Tweet
{

    public static function getAllTweets(mysqli $db_conn, $user_id, $all)
    {

        if ($all == 'all') {
            $sql = "SELECT *
                    FROM Posts
                    ORDER BY creation_date DESC";
        } elseif ($all == 'user') {
            $sql = "SELECT *
                    FROM Posts
                    WHERE user_id={$user_id}
                    ORDER BY creation_date DESC";
        }

        $toReturn = [];

        $result = $db_conn->query($sql);
        if ($result != false) {
            foreach ($result as $row) {
                $tweet = new Tweet();
                $tweet->id = $row['id'];
                $tweet->user_id = $row['user_id'];
                $tweet->postText = $row['post_text'];
                $tweet->date = $row['creation_date'];
                $toReturn[] = $tweet;
            }
        }

        return $toReturn;
    }

    private $id;
    private $user_id;
    private $postText;
    private $date;

    public function __construct()
    {
        $this->id = -1;
        $this->user_id = null;
        $this->postText = "";
        $this->date = null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getpostText()
    {
        return $this->postText;
    }

    public function setText($text)
    {
        $this->postText = $text;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function saveTweetToDB(mysqli $db_conn)
    {
        if ($this->id === -1) {
            $sql = "INSERT INTO Posts (user_id, post_text, creation_date)
                    VALUES ('{$this->user_id}', '{$this->postText}', '{$this->date}' )";
            $result = $db_conn->query($sql);

            if ($result == TRUE) {
                $this->id = $db_conn->insert_id;
                return true;
            }
            return false;
        } else {
            $sql = "UPDATE Posts
                    SET post_text = '{$this->postText}'
                    WHERE id={$this->id}";
            $result = $db_conn->query($sql);
            return $result;
        }
    }

    public function loadFromDB(mysqli $db_conn, $id)
    {
        $sql = "SELECT *
                FROM Posts
                WHERE id=$id";

        $result = $db_conn->query($sql);
        if ($result != false) {
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->postText = $row['post_text'];
                $this->user_id = $row['user_id'];
                $this->date = $row['creation_date'];

                return true;
            }
        }
    }

    public function getAllComments(mysqli $db_conn)
    {
        $comments = Comment::getAllComments($db_conn, $this->getId());

        return $comments;
    }

    public function showTweet()
    {
        $tweetText = $this->getpostText();
        return $tweetText;

    }


}
