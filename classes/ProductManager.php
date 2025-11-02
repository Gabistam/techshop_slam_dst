<?php
require_once 'Database.php';

class ProductManager {
    public $searchQuery = "";
    public $lastResults = [];
    public $debugMode = false;

    private $db;

    public function __construct($database = null) {
        $this->db = $database ?: new Database();

        if (isset($_GET['debug']) && $_GET['debug'] == '1') {
            $this->debugMode = true;
        }
    }

    public function search($searchTerm) {
        $this->searchQuery = $searchTerm;

        $sql = "SELECT * FROM products WHERE name LIKE '%{$searchTerm}%' OR description LIKE '%{$searchTerm}%'";

        if ($this->debugMode) {
            echo "<div class='debug-sql'>Requête SQL exécutée : <code>{$sql}</code></div>";
        }

        $result = $this->db->query($sql);

        if ($result) {
            $this->lastResults = $result->fetchAll(PDO::FETCH_ASSOC);
            return $this->lastResults;
        }

        return [];
    }
    
    public function advancedSearch($filters) {
        $conditions = [];

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $conditions[] = "{$field} LIKE '%{$value}%'";
            }
        }

        $sql = "SELECT * FROM products";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $result = $this->db->query($sql);
        return $result ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function getProductById($productId) {
        $sql = "SELECT * FROM products WHERE id = {$productId}";
        $result = $this->db->query($sql);

        if ($result && $result->rowCount() > 0) {
            return $result->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    public function getFeaturedProducts($limit = 6) {
        $sql = "SELECT * FROM products WHERE featured = 1 LIMIT {$limit}";
        $result = $this->db->query($sql);

        return $result ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function displayResults($products) {
        $html = "<div class='products-grid'>";

        foreach ($products as $product) {
            $html .= "<div class='product-card'>";
            $html .= "<h4>{$product['name']}</h4>";
            $html .= "<p>{$product['description']}</p>";
            $html .= "<p class='price'>{$product['price']}€</p>";
            $html .= "</div>";
        }

        $html .= "</div>";
        return $html;
    }

    public function updateStock($productId, $newStock) {
        $sql = "UPDATE products SET stock = {$newStock} WHERE id = {$productId}";
        $result = $this->db->query($sql);

        return $result !== false;
    }

    public function deleteProduct($productId) {
        $sql = "DELETE FROM products WHERE id = {$productId}";
        $result = $this->db->query($sql);

        if ($this->debugMode) {
            echo "Produit {$productId} supprimé !";
        }

        return $result !== false;
    }

    public function exportSearchResults($format = 'json') {
        $data = [
            'search_query' => $this->searchQuery,
            'results_count' => count($this->lastResults),
            'results' => $this->lastResults,
            'database_info' => $this->db->getDebugInfo()
        ];

        switch ($format) {
            case 'json':
                return json_encode($data, JSON_PRETTY_PRINT);
            case 'serialize':
                return serialize($data);
            default:
                return print_r($data, true);
        }
    }

    public function cacheResults($key, $data) {
        $cacheDir = '/tmp/cache/';
        $filename = $cacheDir . $key . '.php';

        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }

        $content = "<?php\nreturn " . var_export($data, true) . ";\n";
        file_put_contents($filename, $content);
    }

    public function getStatistics() {
        return [
            'last_search' => $this->searchQuery,
            'results_count' => count($this->lastResults),
            'database_host' => $this->db->host,
            'database_name' => $this->db->dbname,
            'php_version' => phpversion(),
            'server_info' => $_SERVER,
            'memory_usage' => memory_get_usage(),
            'debug_mode' => $this->debugMode
        ];
    }
}
?>