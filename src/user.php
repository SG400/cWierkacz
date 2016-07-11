<?php

class User
{
    static public function GetAllUsers(mysqli $db_conn)
    {
        $sql = "SELECT *
                FROM Users";

        $result = $db_conn->query($sql);

        $toReturn = [];
        if ($result != false) {
            foreach ($result as $row) {
                $newUser = new User();
                $newUser->id = $row['id'];
                $newUser->login = $row['login'];
                $newUser->hashedPassword = $row['hashed_password'];
                $newUser->description = $row['user_description'];
                $newUser->isActive = $row['is_active'];

                $toReturn[] = $newUser;
            }
        }
        return $toReturn;
    }

    static public function LogIN(mysqli $db_conn, $login, $password)
    {
        $toReturn = null;

        $sql = "SELECT *
                FROM Users
                WHERE login='{$login}'";

        $result = $db_conn->query($sql);

        if ($result != false) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $loggedUser = new User();

                $loggedUser->id = $row['id'];
                $loggedUser->login = $row['login'];
                $loggedUser->hashedPassword = $row['hashed_password'];
                $loggedUser->description = $row['user_description'];
                $loggedUser->isActive = $row['is_active'];
                if ($loggedUser->verifyPassword($password)) {
                    $toReturn = $loggedUser;
                }
            }
        }
        return $toReturn;
    }

    private $id;
    private $login;
    private $hashedPassword;
    private $description;
    private $isActive;

    public function __construct()
    {
        $this->id = -1;
        $this->login = "";
        $this->hashedPassword = "";
        $this->description = "";
        $this->isActive = 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setHashedPassword($newPassword1, $newPassword2)
    {
        if ($newPassword1 != $newPassword2) {
            return false;
        }
        $hashedPassword = password_hash($newPassword1, PASSWORD_BCRYPT);
        $this->hashedPassword = $hashedPassword;
        return true;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function deactivateUser()
    {
        $this->isActive = 0;
    }

    public function activateUser()
    {
        $this->isActive = 1;
    }

    public function isUserActiv()
    {
        return ($this->isActive === 1);
    }

    public function saveToDB(mysqli $db_conn)
    {
        if ($this->id === -1) {
            $sql = "INSERT INTO Users (login, hashed_password, user_description, is_active)
                    VALUES ('{$this->login}', '{$this->hashedPassword}', '{$this->description}', '{$this->isActive}')";

            $result = $db_conn->query($sql);
            if ($result == TRUE) {
                $this->id = $db_conn->insert_id;
                return true;
            }
            return false;
        } else {
            $sql = "UPDATE Users
                    SET login='{$this->login}', hashed_password='{$this->hashedPassword}', user_description='{$this->description}',
                    is_active='{$this->isActive}'
                    WHERE id={$this->id}";

            $result = $db_conn->query($sql);
            return $result;
        }
    }

    public function loadFromDB(mysqli $db_conn, $id)
    {
        $sql = "SELECT *
                FROM Users
                WHERE id=$id";

        $result = $db_conn->query($sql);

        if ($result != false) {
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->login = $row['login'];
                $this->hashedPassword = $row['hashed_password'];
                $this->description = $row['user_description'];
                $this->isActive = $row['is_active'];

                return true;
            }
        }

    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->hashedPassword);
    }

    public function loadAllTweetFromDB(mysqli $db_conn)
    {
        $tweets = Tweet::getAllTweets($db_conn, $this->getId());
        return $tweets;
    }

}
