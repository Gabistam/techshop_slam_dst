<?php
session_start();

require_once 'classes/Database.php';
require_once 'classes/User.php';

$error = "";
$success = "";

$database = new Database();
$user = new User($database);

if (isset($_GET['debug']) && $_GET['debug'] == '1') {
    echo "<div class='debug-info'>";
    echo "<h4>🐛 Debug - Informations Database (SENSIBLES!)</h4>";
    echo "<pre>" . print_r($database->getDebugInfo(), true) . "</pre>";
    echo "</div>";
}

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->authenticate($email, $password)) {
        $user->startSession();

        $success = "Connexion réussie ! Redirection...";

        if ($user->isAdmin()) {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Email ou mot de passe incorrect";

        if (isset($_GET['debug'])) {
            $error .= "<br><small>Dernière requête SQL : " . $database->getLastQuery() . "</small>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - TechShop</title>
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
        <div class="login-form">
            <h2>Connexion</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
            
            <div class="login-info">
                <p><strong>Comptes de test :</strong></p>
                <p>• Admin: admin@techshop.fr / admin123</p>
                <p>• User: user@techshop.fr / user123</p>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2024 TechShop. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="assets/js/validation.js"></script>
</body>
</html>