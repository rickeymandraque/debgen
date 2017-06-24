<?php

class User {
    public function createHash($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    public function loginUser($username, $password)
    {
        try {
            $stmt = $this->db->prepare('SELECT uid, password, username FROM users WHERE username = ?');
            $stmt->bindParam('1', $username);
            $stmt->execute();

            $row = $stmt->fetch();
        } catch (PDOException $e) {
            $$e->getMessage();
        }

        if (isset($row['password'])) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['userid'] = $row['uid'];
                $_SESSION['username'] = $row['username'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}