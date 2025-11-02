<?php
session_start();

require_once 'classes/Database.php';
require_once 'classes/User.php';

$database = new Database();
$user = new User($database);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$currentUser = $user->getUserById($_SESSION['user_id']);
if ($currentUser) {
    $user->id = $currentUser['id'];
    $user->email = $currentUser['email'];
    $user->role = $currentUser['role'];
    $user->isLoggedIn = true;
}

if (!$user->isAdmin()) {
    header("Location: index.php?error=access_denied");
    exit();
}

$users_query = "SELECT id, email, role, created_at FROM users ORDER BY created_at DESC";
$users_result = $database->query($users_query);
$users = $users_result->fetchAll();

$stats_query = "SELECT COUNT(*) as total_users FROM users";
$stats_result = $database->query($stats_query);
$stats = $stats_result->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - TechShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-brand">
                <h1>🛒 TechShop - Admin</h1>
            </div>
            <div class="nav-links">
                <a href="index.php">Accueil</a>
                <a href="search.php">Recherche</a>
                <span>Connecté: <?php echo $_SESSION['email']; ?></span>
                <a href="logout.php">Déconnexion</a>
            </div>
        </nav>
    </header>

    <main class="container">
        <div class="admin-dashboard">
            <h2>🔧 Panneau d'administration</h2>
            
            <div class="warning-banner">
                <p>⚠️ <strong>Zone sensible</strong> - Accès réservé aux administrateurs uniquement</p>
            </div>
            
            <div class="stats-section">
                <h3>📊 Statistiques</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h4>Utilisateurs inscrits</h4>
                        <p class="stat-number"><?php echo $stats['total_users']; ?></p>
                    </div>
                    <div class="stat-card">
                        <h4>Ventes du mois</h4>
                        <p class="stat-number">42</p>
                    </div>
                    <div class="stat-card">
                        <h4>Chiffre d'affaires</h4>
                        <p class="stat-number">15 780€</p>
                    </div>
                </div>
            </div>
            
            <div class="users-section">
                <h3>👥 Gestion des utilisateurs</h3>
                <div class="table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Date d'inscription</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td>
                                    <span class="role-badge role-<?php echo $user['role']; ?>">
                                        <?php echo ucfirst($user['role']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <button class="btn btn-small btn-edit">Modifier</button>
                                    <button class="btn btn-small btn-danger">Supprimer</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="actions-section">
                <h3>🔧 Actions administrateur</h3>
                <div class="admin-actions">
                    <button class="btn btn-secondary">Exporter données</button>
                    <button class="btn btn-secondary">Sauvegarder BDD</button>
                    <button class="btn btn-warning">Vider cache</button>
                    <button class="btn btn-danger">Maintenance</button>
                </div>
            </div>
            
            <div class="sensitive-info">
                <h3>🔒 Informations sensibles</h3>
                <p><strong>Serveur :</strong> Ubuntu 20.04 LTS</p>
                <p><strong>Base de données :</strong> MySQL 8.0</p>
                <p><strong>PHP Version :</strong> 8.1.2</p>
                <p><strong>Dernière sauvegarde :</strong> 15/11/2024 03:30</p>

                <?php if (isset($_GET['debug_poo'])): ?>
                    <div class="poo-debug" style="margin-top: 1rem; padding: 1rem; background: #f8d7da; border-radius: 5px;">
                        <h4>🐛 Debug POO</h4>
                        <p><strong>Objet User courant :</strong></p>
                        <pre><?php echo $user; ?></pre>

                        <p><strong>Debug complet User :</strong></p>
                        <pre><?php print_r($user->debug()); ?></pre>

                        <p><strong>Informations Database :</strong></p>
                        <pre><?php print_r($database->getDebugInfo()); ?></pre>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2024 TechShop. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>