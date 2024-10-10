<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneakers Agenda</title>
    <link rel="stylesheet" href="assets/css/pre-order-waitlist.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <!-- Namari Color CSS -->
        <link rel="stylesheet" href="assets/css/namari-color.css">
    <!-- Animate CSS-->
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="wrapper">
    <header>
            <div class="logo">Sneakerness</div>
            <nav>
                <ul>
                    <li>
                        <a href="/index.html">Home</a>
                        <ul class="dropdown">
                            <li><a href="/index.html#about">About</a></li>
                            <li><a href="/index.html#services">Services</a></li>
                            <li><a href="/index.html#testimonials">Testimonials</a></li>
                            <li><a href="/index.html#clients">Clients</a></li>
                            <li><a href="/index.html#sneaker">Exclusive</a></li>
                            <li><a href="/index.html#pricing">Pricing</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="agenda.html">Agenda</a>
                    </li>
                    <li>
                        <a href="/FAQ.html">FAQ</a>
                    </li>
                    <li><a href="#" class="active">Pre-order nu!</a></li>
                </ul>
            </nav>
            <aside>
                <ul class="social-icons">
                    <li>
                        <a target="_blank" title="Facebook" href="https://www.facebook.com/username">
                            <i class="fa fa-facebook fa-1x"></i><span></span>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" title="Google+" href="http://google.com/+username">
                            <i class="fa fa-google-plus fa-1x"></i><span></span>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" title="Twitter" href="http://www.twitter.com/username">
                            <i class="fa fa-twitter fa-1x"></i><span></span>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" title="Instagram" href="http://www.instagram.com/username">
                            <i class="fa fa-instagram fa-1x"></i><span></span>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" title="behance" href="http://www.behance.net">
                            <i class="fa fa-behance fa-1x"></i><span></span>
                        </a>
                    </li>
                </ul>
            </aside>
        </header>
        <div class="button-container">
            <h2>Wil jij op de lijst staan? Pre-order nu!</h2>
            <button class="pre-order-button">
                Pre-order nu!
            </button>
        </div>
        <?php
        // Configuratiebestand inladen
        include 'config/config.php';

        // Query om alle gebruikers op te halen waar PreOrder true is
        $sql = "SELECT username FROM user WHERE PreOrder = 1";
        $sqlCount = "SELECT COUNT(*) as total_preorders FROM user WHERE PreOrder = 1";

        try {
            // Uitvoeren van de query om de gebruikers op te halen
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $usernames = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Uitvoeren van de query om het aantal pre-orders op te halen
            $stmtCount = $pdo->prepare($sqlCount);
            $stmtCount->execute();
            $countResult = $stmtCount->fetch(PDO::FETCH_ASSOC);
            $totalPreorders = $countResult['total_preorders'];
        } catch (PDOException $e) {
            die("Fout bij het ophalen van gegevens: " . $e->getMessage());
        }
        ?>
        <h2>Aantal Pre-orders</h2>
        <div class="pre-order-number">
            <p>
                <?php echo htmlspecialchars($totalPreorders); ?>
            </p>
        </div>
        <h2>Onze beste gasten die een pre-order hebben.</h2>
        <div class="pre-orders">
            <ul>
                <?php foreach ($usernames as $user): ?>
                    <li><?php echo htmlspecialchars($user['username']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <footer>
        <div>
            <h3>
                Meer van ons
            </h3>
            <ul>
                <li><a href="FAQ.html">FAQ</a></li>
                <li><a href="about.html">Over Ons</a></li>
            </ul>
        </div>
        <div>
            <h3>
                Volg Ons
            </h3>
            <ul>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">YouTube</a></li>
            </ul>
        </div>
        <div>
            <p>Sneakerness®</p>
        </div>
    </footer>
    
    <script src="assets/js/jquery.1.8.3.min.js"></script>
    <script src="assets/Js/banner_slideshow.js"></script>
    <script src="assets/js/featherlight.min.js"></script>
    <script src="assets/js/featherlight.gallery.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="Standindeling.js"></script>
    <script src="assets/Js/recentie_slide.js"></script>
    <script src="assets/js/jquery.enllax.min.js"></script>
    <script src="assets/js/jquery.scrollUp.min.js"></script>
    <script src="assets/js/jquery.easing.min.js"></script>
    <script src="assets/js/jquery.stickyNavbar.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/images-loaded.min.js"></script>
    <script src="assets/js/lightbox.min.js"></script>
    <script src="assets/js/site.js"></script>
    <script src="assets/Js/progressBar.js"></script>
    <script src="ExclusieveSneakers.js"></script>
    <script src="assets/Js/Wat_is_Sneakerness.js"></script>
</body>

</html>