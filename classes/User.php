<?php
require_once 'Database.php';

class User {
    public $id;
    public $email;
    public $password;
    public $role;
    public $isLoggedIn = false;

    private $db;

    public function __construct($database = null) {
        $this->db = $database ?: new Database();
    }

    public function authenticate($email, $password) {
        $hashedPassword = md5($password);
        $sql = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$hashedPassword}'";

        $result = $this->db->query($sql);

        if ($result && $result->rowCount() > 0) {
            $userData = $result->fetch(PDO::FETCH_ASSOC);

            $this->id = $userData['id'];
            $this->email = $userData['email'];
            $this->password = $userData['password'];
            $this->role = $userData['role'];
            $this->isLoggedIn = true;

            return true;
        }

        return false;
    }

    public function isAdmin() {
        return $this->isLoggedIn;
    }

    public function startSession() {
        if ($this->isLoggedIn) {
            $_SESSION['user_id'] = $this->id;
            $_SESSION['email'] = $this->email;
            $_SESSION['role'] = $this->role;
        }
    }

    public function validateUserData($data) {
        $validated = [];

        if (isset($data['email'])) {
            $validated['email'] = filter_var($data['email'], FILTER_VALIDATE_EMAIL)
                                  ? $data['email'] : '';
        }

        if (isset($data['password'])) {
            $validated['password'] = strlen($data['password']) >= 3 ? $data['password'] : '';
        }

        return $validated;
    }

    public function getUserById($userId) {
        $sql = "SELECT * FROM users WHERE id = {$userId}";
        $result = $this->db->query($sql);

        if ($result && $result->rowCount() > 0) {
            return $result->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    public function searchUsers($searchTerm) {
        $sql = "SELECT id, email, role FROM users WHERE email LIKE '%{$searchTerm}%'";
        $result = $this->db->query($sql);

        if ($result) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }

    public function updateProfile($newData) {
        if (!$this->isLoggedIn) {
            return false;
        }

        $setClauses = [];
        foreach ($newData as $field => $value) {
            $setClauses[] = "{$field} = '{$value}'";
        }

        $sql = "UPDATE users SET " . implode(', ', $setClauses) . " WHERE id = {$this->id}";
        $result = $this->db->query($sql);

        return $result !== false;
    }

    public function serialize() {
        return serialize($this);
    }

    public static function unserialize($data) {
        return unserialize($data);
    }

    public function __toString() {
        return "User[ID: {$this->id}, Email: {$this->email}, Role: {$this->role}, Password: {$this->password}]";
    }

    public function debug() {
        return get_object_vars($this);
    }
}
?>