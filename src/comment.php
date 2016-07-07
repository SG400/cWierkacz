<?php

class Comment
{

    public static function getAllComments(mysqli $db_conn, $post_id)
    {

        $sql = "SELECT *
                FROM Comments
                WHERE post_id=$post_id
                ORDER BY creation_date DESC";

        $toReturn = [];

        $result = $db_conn->query($sql);

        if ($result != false) {
            foreach ($result as $row) {
                $comment = new Comment();
                $comment->id = $row['id'];
                $comment->user_id = $row['user_id'];
                $comment->post_id = $row['post_id'];
                $comment->text = $row['comment_text'];
                $comment->date = $row['creation_date'];
                $toReturn[] = $comment;
            }
        }

        return $toReturn;
    }

    private $id;
    private $user_id;
    private $post_id;
    private $date;
    private $text;

    public function __construct()
    {
        $this->id = -1;
        $this->user_id = null;
        $this->post_id = null;
        $this->date = null;
        $this->text = null;
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

    public function getPostId()
    {
        return $this->post_id;
    }

    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }


    public function loadFromDB(mysqli $db_conn, $id)
    {
        $sql = "SELECT *
                FROM Comments
                WHERE post_id=$id";

        $result = $db_conn->query($sql);

        if ($result != false) {
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->user_id = $row['user_id'];
                $this->post_id = $row['post_id'];
                $this->date = $row['creation_date'];
                $this->text = $row['comment_text'];

                return true;
            }
        }
    }

    public function saveCommentToDB(mysqli $db_conn)
    {
        if ($this->id == -1) {
            $sql = "INSERT INTO Comments (post_id, user_id, comment_text, creation_date)
                    VALUES ('{$this->post_id}', '{$this->user_id}', '{$this->text}', '{$this->date}')";

            $result = $db_conn->query($sql);

            if ($result == TRUE) {
                $this->id = $db_conn->insert_id;
                return true;
            }
            return false;
        } else {
            $sql = "UPDATE Comments
                    SET comment_text = '{$this->text}'
                    WHERE id={$this->id}";
            $result = $db_conn->query($sql);
            return $result;
        }
    }


}