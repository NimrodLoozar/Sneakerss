<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneakers Agenda</title>
    <link rel="stylesheet" href="assets/css/pre-order-waitlist.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
</head>

<body>
    <div id="wrapper">
        <header>
            <div class="logo">Sneakerness</div>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#gallery">Gallery</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#testimonials">Testimonials</a></li>
                    <li><a href="#clients">Clients</a></li>
                    <li><a href="#pricing" class="active">Agenda</a></li>
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
            <button class="pre-order-button">
                Pre-order nu!
            </button>
        </div>

        <h2>Onze beste gasten die een pre-order hebben.</h2>
        <?php
        // Configuratiebestand inladen
        include 'config/config.php';

        // Query om alle gebruikers op te halen waar PreOrder true is
        $sql = "SELECT username FROM user WHERE PreOrder = 1";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            // Alle resultaten ophalen
            $usernames = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Fout bij het ophalen van gegevens: " . $e->getMessage());
        }
        ?>
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
</body>

</html>