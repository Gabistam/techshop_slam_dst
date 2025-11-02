<?php
session_start();

require_once 'classes/Database.php';
require_once 'classes/ProductManager.php';

$search_term = "";
$results = [];
$error = "";

$database = new Database();
$productManager = new ProductManager($database);

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $search_term = $_GET['q'];

    try {
        $results = $productManager->search($search_term);

        if (isset($_GET['show_query'])) {
            echo "<div class='alert alert-info'>Requête stockée dans l'objet : " . $productManager->searchQuery . "</div>";
        }

    } catch(Exception $e) {
        $error = "Erreur de recherche POO : " . $e->getMessage();
    }
}

if (empty($search_term)) {
    $results = $productManager->getFeaturedProducts(6);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche - TechShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="nav-brand">
                <h1>🛒 TechShop</h1>
            </div>
            <div class="nav-links">
                <a href="index.php">Accueil</a>
                <a href="search.php">Recherche</a>
                <a href="login.php">Connexion</a>
                <a href="admin.php">Admin</a>
            </div>
        </nav>
    </header>

    <main class="container">
        <div class="search-section">
            <h2>🔍 Recherche de produits</h2>

            <form method="GET" action="search.php" class="search-form">
                <div class="search-input-group">
                    <input type="text" name="q" value="<?php echo $search_term; ?>"
                        placeholder="Rechercher un produit..." class="search-input">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>

            <?php if ($search_term): ?>
            <div class="search-info">
                <p>Résultats pour : <strong><?php echo $search_term; ?></strong></p>
                <p><?php echo count($results); ?> produit(s) trouvé(s)</p>
            </div>
            <?php endif; ?>

            <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo $error; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="results-section">
            <?php if (empty($search_term)): ?>
            <h3>⭐ Produits populaires</h3>
            <?php else: ?>
            <h3>📦 Résultats de recherche</h3>
            <?php endif; ?>

            <div class="products-grid">
                <?php if (!empty($results)): ?>
                <?php foreach ($results as $product): ?>
                <div class="product-card">
                    <img src="<?php echo $product['image_url'] ?? 'assets/img/laptop.avif'; ?>"
                        alt="<?php echo $product['name']; ?>">
                    <div class="product-info">
                        <h4><?php echo $product['name']; ?></h4>
                        <p class="product-description"><?php echo $product['description']; ?></p>
                        <p class="price"><?php echo $product['price']; ?>€</p>
                        <p class="stock">Stock: <?php echo $product['stock']; ?> unités</p>
                        <button class="btn btn-primary">Ajouter au panier</button>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="no-results">
                    <p>😔 Aucun produit trouvé</p>
                    <?php if ($search_term): ?>
                    <p>Votre recherche "<em><?php echo $search_term; ?></em>" n'a donné aucun résultat.</p>
                    <?php endif; ?>
                    <p>Essayez avec d'autres mots-clés !</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="search-suggestions">
            <h3>💡 Suggestions de recherche</h3>
            <div class="suggestions-list">
                <a href="search.php?q=smartphone" class="suggestion-tag">Smartphone</a>
                <a href="search.php?q=laptop" class="suggestion-tag">Laptop</a>
                <a href="search.php?q=casque" class="suggestion-tag">Casque</a>
                <a href="search.php?q=tablette" class="suggestion-tag">Tablette</a>
                <a href="search.php?q=gaming" class="suggestion-tag">Gaming</a>
            </div>

        </div>

        <?php if (isset($_GET['debug']) && $_GET['debug'] == '1'): ?>
        <div class="debug-info">
            <h4>🐛 Debug POO - Informations ProductManager</h4>
            <p><strong>Propriétés publiques exposées :</strong></p>
            <ul>
                <li>searchQuery: <?php echo $productManager->searchQuery; ?></li>
                <li>debugMode: <?php echo $productManager->debugMode ? 'true' : 'false'; ?></li>
                <li>Nombre de résultats: <?php echo count($productManager->lastResults); ?></li>
            </ul>
            <p><strong>Statistiques :</strong></p>
            <pre><?php print_r($productManager->getStatistics()); ?></pre>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['debug_old']) && $_GET['debug_old'] == '1'): ?>
        <div class="debug-info">
            <h4>🐛 Informations de debug</h4>
            <p><strong>Requête SQL exécutée :</strong></p>
            <code><?php echo $database->getLastQuery(); ?></code>
            <p><strong>Terme de recherche brut :</strong> <?php echo var_export($_GET['q'] ?? null, true); ?></p>
        </div>
        <?php endif; ?>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2024 TechShop. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="assets/js/validation.js"></script>
</body>

</html>