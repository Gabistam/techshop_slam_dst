<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechShop - Votre boutique high-tech</title>
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
        <section class="hero">
            <h2>Bienvenue sur TechShop</h2>
            <p>Découvrez notre sélection de produits high-tech aux meilleurs prix !</p>
        </section>

        <section class="featured-products">
            <h3>Produits à la une</h3>
            <div class="products-grid">
                <div class="product-card">
                    <img src="https://shop.mobileklinik.ca/cdn/shop/files/iphone11promax-grey.png?v=1744073647"
                        alt="Smartphone">
                    <div class="product-info">
                        <h4>Smartphone Pro Max</h4>
                        <p class="price">899€</p>
                        <button class="btn btn-primary">Voir détails</button>
                    </div>
                </div>

                <div class="product-card">
                    <img src="https://i.dell.com/is/image/DellContent/content/dam/ss2/product-images/dell-client-products/notebooks/dell-premium/da16250/media-gallery/laptop-dell-da16250t-gy-gallery-3.psd?fmt=png-alpha&pscan=auto&scl=1&hei=804&wid=1015&qlt=100,1&resMode=sharp2&size=1015,804&chrss=full"
                        alt="Laptop">
                    <div class="product-info">
                        <h4>Laptop Gaming RTX</h4>
                        <p class="price">1299€</p>
                        <button class="btn btn-primary">Voir détails</button>
                    </div>
                </div>

                <div class="product-card">
                    <img src="https://edifier-online.ca/cdn/shop/files/edifier-w820nbplus-black-1_69a069cd-370b-4a7c-8e14-338032f2687f.png?v=1704701210&width=3840"
                        alt="Casque">
                    <div class="product-info">
                        <h4>Casque Audio Wireless</h4>
                        <p class="price">199€</p>
                        <button class="btn btn-primary">Voir détails</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="about">
            <h3>À propos de TechShop</h3>
            <p>TechShop est votre partenaire de confiance pour tous vos achats high-tech.
                Depuis 2020, nous proposons une large gamme de produits électroniques
                avec un service client exceptionnel.</p>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2024 TechShop. Tous droits réservés.</p>
            <p>Contact: contact@techshop.fr | 01 23 45 67 89</p>
        </div>
    </footer>
</body>

</html>