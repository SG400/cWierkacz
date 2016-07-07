<?php

class Message
{

    //Static REPOSITORY methods:
    public static function getAllMessages(mysqli $db_conn, $sender_receiver, $user_id)
    {

        $sql = "SELECT *
                FROM Messages
                WHERE $sender_receiver = $user_id
                ORDER BY date DESC";

        $toReturn = [];

        $result = $db_conn->query($sql);
        if ($result != false) {
            foreach ($result as $row) {
                $message = new Message();
                $message->id = $row['id'];
                $message->sender_id = $row['sender_id'];
                $message->receiver_id = $row['receiver_id'];
                $message->message_text = $row['message_text'];
                $message->is_read = $row['is_read'];
                $message->date = $row['date'];

                $toReturn[] = $message;
            }
        }

        return $toReturn;
    }

    public static function getNewMessages(mysqli $db_conn, $receiver_id)
    {
        $sql = "SELECT *
                FROM Messages
                WHERE receiver_id = '{$receiver_id}'
                AND is_read = 1";

        $result = $db_conn->query($sql);

        $toReturn = 0;
        foreach ($result as $item) {
            $toReturn++;
        }

        return $toReturn;
    }

    private $id;
    private $sender_id;
    private $receiver_id;
    private $message_text;
    private $is_read;
    private $date;

    public function __construct()
    {
        $this->id = -1;
        $this->sender_id = null;
        $this->receiver_id = null;
        $this->message_text = null;
        $this->is_read = 1;
        $this->date = null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSenderId()
    {
        return $this->sender_id;
    }

    public function setSenderId($sender_id)
    {
        $this->sender_id = $sender_id;
    }

    public function getReceiverId()
    {
        return $this->receiver_id;
    }

    public function setReceiverId($receiver_id)
    {
        $this->receiver_id = $receiver_id;
    }

    public function getIsRead()
    {
        return $this->is_read;
    }

    public function setIsRead()
    {
        $this->is_read = 0;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getMessageText()
    {
        return $this->message_text;
    }

    public function setMessageText($message_text)
    {
        $this->message_text = $message_text;
    }

    public function saveMessageToDB(mysqli $db_conn)
    {
        if ($this->id === -1) {
            $sql = "INSERT INTO Messages (sender_id, receiver_id, message_text, is_read, date)
                    VALUES ('{$this->sender_id}', '{$this->receiver_id}', '{$this->message_text}', '{$this->is_read}', '{$this->date}' )";
            $result = $db_conn->query($sql);

            if ($result == TRUE) {
                $this->id = $db_conn->insert_id;
                return true;
            }
        } else {
            $sql = "UPDATE Messages
                    SET is_read = '{$this->is_read}'
                    WHERE id='{$this->id}'";
            $result = $db_conn->query($sql);
            return $result;
        }
        return false;
    }


    public function loadMessageDB(mysqli $db_conn, $id)
    {
        $sql = "SELECT *
                FROM Messages
                WHERE id=$id";

        $result = $db_conn->query($sql);

        if ($result != false) {
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->sender_id = $row['sender_id'];
                $this->receiver_id = $row['receiver_id'];
                $this->message_text = $row['message_text'];
                $this->is_read = $row['is_read'];
                $this->date = $row['date'];

                return true;
            }
        }
    }

    public function checkMessage()
    {
        if ($this->is_read == 1) {
            return 'new';
        } else {
            return 'read';
        }
    }

}