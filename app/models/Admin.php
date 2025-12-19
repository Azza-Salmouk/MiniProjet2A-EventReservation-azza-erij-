<?php

class Admin {

    public static function login($username, $password) {
        $stmt = db()->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password_hash'])) {
            return $admin;
        }
        return false;
    }
}
