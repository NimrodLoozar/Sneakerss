<?php
include 'config/config.php';

// Function to sanitize and validate input
function validate_input($data, $field)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    switch ($field) {
        case 'username':
            if (empty($data)) {
                return ['value' => '', 'error' => "Gebruikersnaam is verplicht."];
            } elseif (strlen($data) > 50) {
                return ['value' => $data, 'error' => "Gebruikersnaam mag niet langer zijn dan 50 karakters."];
            }
            return ['value' => $data, 'error' => ''];

        case 'email':
            if (empty($data)) {
                return ['value' => '', 'error' => "E-mail is verplicht."];
            } elseif (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
                return ['value' => $data, 'error' => "Ongeldig e-mailadres."];
            }
            return ['value' => $data, 'error' => ''];

        case 'password':
            if (empty($data)) {
                return ['value' => '', 'error' => "Wachtwoord is verplicht."];
            } elseif (strlen($data) < 8) {
                return ['value' => '', 'error' => "Wachtwoord moet minstens 8 karakters lang zijn."];
            }
            return ['value' => $data, 'error' => ''];

        case 'birthdate':
            if (empty($data)) {
                return ['value' => '', 'error' => "Geboortedatum is verplicht."];
            }
            $date = DateTime::createFromFormat('Y-m-d', $data);
            if (!$date || $date->format('Y-m-d') !== $data) {
                return ['value' => $data, 'error' => "Ongeldige datumnotatie. Gebruik YYYY-MM-DD."];
            }
            return ['value' => $data, 'error' => ''];

        default:
            return ['value' => $data, 'error' => ''];
    }
}

$errors = [];
$form_data = [
    'username' => '',
    'email' => '',
    'password' => '',
    'birthdate' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate each field
    $username = validate_input($_POST['username'] ?? '', 'username');
    $email = validate_input($_POST['email'] ?? '', 'email');
    $password = validate_input($_POST['password'] ?? '', 'password');
    $birthdate = validate_input($_POST['birthdate'] ?? '', 'birthdate');

    // Collect validated data and errors
    $form_data = [
        'username' => $username['value'],
        'email' => $email['value'],
        'password' => $password['value'],
        'birthdate' => $birthdate['value']
    ];

    $errors = array_filter([
        'username' => $username['error'],
        'email' => $email['error'],
        'password' => $password['error'],
        'birthdate' => $birthdate['error']
    ]);

    // If no errors, process the form
    if (empty($errors)) {
        try {
            // Hash the password before storing
            $hashed_password = password_hash($form_data['password'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO user (Username, Email, Password, PreOrder, date)
                    VALUES (:username, :email, :password, 1, :birthdate)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':username' => $form_data['username'],
                ':email' => $form_data['email'],
                ':password' => $hashed_password,
                ':birthdate' => $form_data['birthdate']
            ]);
            $feedback = "Uw pre-order is geregistreerd. Bedankt voor uw interesse!";

            // Set a session variable for feedback
            session_start();
            $_SESSION['feedback'] = $feedback;

            // Redirect using JavaScript for a smoother transition
            echo "<script>setTimeout(function() { window.location.href = 'index.html'; }, 2500);</script>";
            exit;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            $errors['database'] = "Er is een fout opgetreden bij het verwerken van uw aanvraag. Probeer het later opnieuw.";
        }
    }
}

// HTML part starts here
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneakers Agenda - Pre-order</title>
    <link rel="stylesheet" href="assets/css/pre-order-waitlist.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Namari Color CSS -->
    <link rel="stylesheet" href="assets/css/namari-color.css">
    <!-- Animate CSS-->
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css">
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div id="status" class="la-ball-triangle-path">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
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

        <main id="content" role="main">
            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($feedback)): ?>
                <div class="success-message">
                    <p><?php echo htmlspecialchars($feedback); ?></p>
                </div>
            <?php endif; ?>

            <form class="pre-order-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div>
                    <label for="username">Gebruikersnaam:</label>
                    <input type="text" id="username" name="username" maxlength="50" required value="<?php echo htmlspecialchars($form_data['username']); ?>">
                </div>

                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" maxlength="255" required value="<?php echo htmlspecialchars($form_data['email']); ?>">
                </div>

                <div>
                    <label for="password">Wachtwoord:</label>
                    <input type="password" id="password" name="password" maxlength="255" required>
                </div>

                <div>
                    <label for="birthdate">Geboortedatum:</label>
                    <input type="date" id="birthdate" name="birthdate" required value="<?php echo htmlspecialchars($form_data['birthdate']); ?>">
                </div>

                <div>
                    <button type="submit">Pre-order nu!</button>
                </div>
            </form>
        </main>
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
    <script src="assets/Js/pre-order.js"></script>
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