<?php
class Database {
    public $host = "localhost";
    public $dbname = "techshop_slam_dst";
    public $username = "root";
    public $password = "";
    public $connection;
    public $lastQuery = "";

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Erreur de connexion base de données : " . $e->getMessage());
        }
    }

    public function query($sql) {
        $this->lastQuery = $sql;

        try {
            return $this->connection->query($sql);
        } catch(PDOException $e) {
            echo "Erreur SQL dans " . __CLASS__ . "::" . __FUNCTION__ . " : " . $e->getMessage();
            echo "<br>Requête problématique : " . $sql;
            return false;
        }
    }

    public function prepare($sql, $params = []) {
        $this->lastQuery = $sql;

        try {
            $stmt = $this->connection->prepare($sql);

            if (!empty($params)) {
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value, PDO::PARAM_STR);
                }
            }

            $stmt->execute();
            return $stmt;
        } catch(PDOException $e) {
            echo "Erreur préparation requête : " . $e->getMessage();
            return false;
        }
    }

    public function escape($data) {
        return addslashes(trim($data));
    }

    public function getDebugInfo() {
        return [
            'host' => $this->host,
            'database' => $this->dbname,
            'user' => $this->username,
            'password' => $this->password,
            'last_query' => $this->lastQuery,
            'connection_status' => $this->connection ? 'Connecté' : 'Déconnecté'
        ];
    }

    public function getLastQuery() {
        return $this->lastQuery;
    }

    public function __destruct() {
        $this->connection = null;
    }
}
?>