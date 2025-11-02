# 🛒 TechShop - Application E-commerce

Application web de boutique e-commerce high-tech développée en PHP avec architecture orientée objet.

---

## 📋 Prérequis

- **Serveur web** : Apache/Nginx ou PHP built-in server
- **PHP** : Version 7.4 ou supérieure
- **Base de données** : MySQL 5.7+ ou MariaDB 10.3+
- **Environnement recommandé** : XAMPP, WAMP, MAMP ou serveur local équivalent

---

## 🚀 Installation

### 1. Téléchargement du projet

```bash
# Cloner le projet dans votre dossier web
git clone [repository-url] techshop_slam_dst
cd techshop_slam_dst
```

Ou télécharger et extraire l'archive ZIP dans :
- **XAMPP** : `C:\xampp\htdocs\techshop_slam_dst\`
- **WAMP** : `C:\wamp64\www\techshop_slam_dst\`
- **MAMP** : `/Applications/MAMP/htdocs/techshop_slam_dst/`

### 2. Configuration de la base de données

#### Option A : Via phpMyAdmin
1. Ouvrir phpMyAdmin (`http://localhost/phpmyadmin`)
2. Créer une nouvelle base de données nommée `techshop_slam_dst`
3. Importer le fichier `database.sql` via l'onglet "Importer"

#### Option B : En ligne de commande
```bash
mysql -u root -p < database.sql
```

### 3. Configuration de la connexion

Les paramètres de connexion à la base de données sont définis dans `/classes/Database.php` :

```php
public $host = "localhost";
public $dbname = "techshop_slam_dst";
public $username = "root";
public $password = "";
```

Modifier ces valeurs si votre configuration est différente.

---

## ▶️ Démarrage de l'application

### Option 1 : Serveur PHP intégré (Développement)

```bash
# Se placer dans le dossier du projet
cd /path/to/techshop_slam_dst

# Démarrer le serveur sur le port 8000
php -S localhost:8000
```

Accès : `http://localhost:8000`

### Option 2 : XAMPP/WAMP/MAMP

1. Placer le projet dans le dossier approprié (`htdocs/` ou `www/`)
2. Démarrer Apache et MySQL depuis le panneau de contrôle
3. Accéder à : `http://localhost/techshop_slam_dst/`

---

## 🔐 Comptes de test

L'application est livrée avec des comptes de démonstration :

| Email | Mot de passe | Rôle |
|-------|--------------|------|
| `admin@techshop.fr` | `admin123` | Administrateur |
| `user@techshop.fr` | `user123` | Utilisateur standard |
| `demo@techshop.fr` | `demo123` | Utilisateur standard |
| `test@example.com` | `password` | Utilisateur standard |

---

## 📁 Structure du projet

```
techshop_slam_dst/
├── index.php              # Page d'accueil
├── login.php              # Page d'authentification
├── admin.php              # Panneau d'administration
├── search.php             # Page de recherche de produits
├── logout.php             # Déconnexion
├── database.sql           # Script SQL d'initialisation
├── classes/               # Classes PHP (Architecture POO)
│   ├── Database.php       # Gestion de la connexion à la BDD
│   ├── User.php           # Gestion des utilisateurs
│   └── ProductManager.php # Gestion des produits
├── assets/
│   ├── css/
│   │   └── style.css      # Feuille de styles
│   ├── js/
│   │   └── validation.js  # Validation côté client
│   └── img/               # Images des produits
└── README.md
```

---

## 🎨 Fonctionnalités

### Pour tous les visiteurs
- Navigation dans le catalogue de produits
- Recherche de produits par nom ou description
- Consultation des détails et prix

### Pour les utilisateurs connectés
- Accès à l'espace membre
- Historique des actions

### Pour les administrateurs
- Panneau d'administration
- Gestion des utilisateurs
- Statistiques et données sensibles

---

## 🔧 Dépannage

### Problème : Page blanche

**Solution :**
- Vérifier que PHP est bien installé : `php -v`
- Vérifier les logs d'erreur Apache
- Activer l'affichage des erreurs dans `php.ini` :
  ```ini
  display_errors = On
  error_reporting = E_ALL
  ```

### Problème : Erreur de connexion à la base de données

**Solutions possibles :**
- Vérifier que MySQL est démarré
- Vérifier les identifiants dans `classes/Database.php`
- Vérifier que la base `techshop_slam_dst` existe
- Confirmer que le fichier `database.sql` a été importé correctement

---

## 🌐 Accès aux différentes pages

- **Accueil** : `http://localhost:8000/index.php`
- **Recherche** : `http://localhost:8000/search.php`
- **Connexion** : `http://localhost:8000/login.php`
- **Administration** : `http://localhost:8000/admin.php` (nécessite connexion)

---

## ⚠️ Avertissement

Cette application est développée dans un **cadre pédagogique uniquement**.

**Ne pas utiliser en production**. Cette application est destinée à des fins d'apprentissage et de formation et ne doit être déployée que dans un environnement de développement local sécurisé.

---

## 📧 Support

Pour toute question technique concernant l'installation ou la configuration, veuillez contacter l'équipe pédagogique.

---

**Version** : 1.0
**Date** : Novembre 2025
**Framework** : Aucun (PHP natif + POO)
**Licence** : Usage pédagogique uniquement
