<?php
// Fouten weergeven voor debugging
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config/config.php'; // Zorg ervoor dat je je databaseverbinding hebt

// Ophalen van goedgekeurde reserveringen
// $query = "SELECT * FROM reservations WHERE statuses = 'approved'";
// $stmt = $pdo->prepare($query);
// $stmt->execute();
// $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT r.id, r.company_name, s.stand_number, p.plain_name, r.statuses, r.about
        FROM reservations r
        JOIN stands s ON r.stand_id = s.id
        JOIN plains p ON s.plain_id = p.id
        WHERE r.statuses = 'approved'";
$stmt = $pdo->query($sql);
$reservations = $stmt->fetchAll();



// Haal zichtbaarheid op van alle secties in één keer
$sql = "SELECT section_name, is_visible FROM sections";
$stmt = $pdo->query($sql);
$visibility = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // Maakt een array zoals ['about' => 1, 'experience' => 0]

// Functie om zichtbaarheid van een sectie te controleren
function isSectionVisible($section)
{
    global $visibility;
    return isset($visibility[$section]) && $visibility[$section];
}
?>

<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <title>Sneakerss - 2024</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" href="assets/img/favicon.ico" title="Favicon" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/namari-color.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
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
    <!--End of Preloader-->
    <div class="page-border" data-wow-duration="0.7s" data-wow-delay="0.2s">
        <div class="top-border wow fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;"></div>
        <div class="right-border wow fadeInRight animated" style="visibility: visible; animation-name: fadeInRight;">
        </div>
        <div class="bottom-border wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;"></div>
        <div class="left-border wow fadeInLeft animated" style="visibility: visible; animation-name: fadeInLeft;"></div>
    </div>
    <div id="wrapper">
        <header id="banner" class="scrollto clearfix" data-enllax-ratio=".5">
            <div id="header" class="nav-collapse">
                <div class="">
                    <div class="">
                        <!--Logo-->
                        <div id="logo">
                            <!--Logo that is shown on the banner-->
                            <a href="/">
                                <svg class="img-fluid" viewBox="0 0 410 54" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="Logo_Black" transform="translate(-115.000000, -138.000000)"
                                            fill="#000000">
                                            <g>
                                                <g transform="translate(115.000000, 137.000000)">
                                                    <g>
                                                        <polyline id="Fill-1"
                                                            points="207.60809 52.431038 178.851721 52.431038 178.853129 1.72991442 207.60809 1.73134884 207.60809 14.5335762 191.668773 14.5321418 191.668773 19.8423766 204.001579 19.8423766 204.001579 32.6431695 191.668773 32.6431695 191.668773 39.6273762 207.60809 39.6273762 207.60809 52.431038">
                                                        </polyline>
                                                        <polyline id="Fill-2"
                                                            points="177.352527 52.4281691 162.284573 52.4281691 154.166403 36.1015639 153.576579 37.0325046 153.575171 52.4281691 140.123249 52.4281691 140.127472 1.72847999 153.51464 1.72991442 153.51464 14.72292 161.638441 1.72991442 176.213703 1.73134884 162.709696 23.2964677 177.352527 52.4281691">
                                                        </polyline>
                                                        <polyline id="Fill-4"
                                                            points="314.135319 52.4238658 285.37895 52.4224314 285.380358 1.7227423 314.138135 1.72561115 314.138135 14.5249696 298.196002 14.5264041 298.196002 19.83377 310.530215 19.83377 310.530215 32.6374318 298.196002 32.6374318 298.196002 39.6202041 314.138135 39.6216385 314.135319 52.4238658">
                                                        </polyline>
                                                        <path
                                                            d="M333.60654,53.0707907 C323.946945,53.0693563 317.402577,47.2326882 316.52136,37.8386504 L316.238414,34.8507468 L329.995805,34.8507468 L330.312537,37.2089386 C330.734845,40.3488911 332.236854,40.7806525 333.795171,40.7820869 C335.627988,40.7820869 336.557066,39.9228674 336.558474,38.2245103 C336.558474,37.061193 336.092527,35.4704177 332.460677,33.4708317 L323.932868,28.8362102 C320.688134,27.1048614 317.39413,22.4931907 317.39413,16.1186139 C317.39413,6.98277229 323.780837,1.07868627 333.669886,1.08012069 C337.686037,1.08155512 341.437541,2.38831468 344.240259,4.7665884 C347.378009,7.43318119 349.262911,11.3161649 349.680996,15.9995567 L349.948457,18.9759849 L336.396589,18.9759849 L336.130535,16.5489408 C335.78565,13.3673901 334.082341,13.3673901 333.353155,13.3688245 C332.636639,13.3673901 330.971337,13.5925945 330.971337,15.668205 C330.971337,16.8573418 331.630138,17.9360281 332.737993,18.5556989 L339.410462,22.1489291 C345.029975,25.1798654 350.072335,28.6597762 350.072335,37.8386504 C350.069519,47.0906803 343.606797,53.0679219 333.60654,53.0707907"
                                                            id="Fill-6"></path>
                                                        <path
                                                            d="M370.075664,53.0736596 C360.420292,53.0707907 353.873108,47.2341226 352.989076,37.8386504 L352.708945,34.8521813 L366.467744,34.8521813 L366.780252,37.2103731 C367.208191,40.3488911 368.708793,40.7820869 370.265702,40.7835213 C372.09852,40.7820869 373.029005,39.9243018 373.029005,38.2245103 C373.029005,37.0626275 372.563059,35.4718521 368.932616,33.4722661 L360.406215,28.8362102 C357.158665,27.1048614 353.864662,22.4931907 353.864662,16.1200483 C353.864662,6.98420671 360.252776,1.08155512 370.143233,1.08155512 C374.156568,1.08298954 377.910887,2.3897491 380.71079,4.76802282 C383.849947,7.43461561 385.729219,11.3190337 386.151527,15.9995567 L386.421804,18.9759849 L372.864305,18.9759849 L372.602474,16.5518097 C372.256181,13.3688245 370.552872,13.3702589 369.823686,13.3702589 C369.108578,13.3688245 367.440461,13.594029 367.441868,15.6696394 C367.441868,16.8587762 368.102077,17.9374625 369.209932,18.5585678 L375.880993,22.1489291 C381.499099,25.1827343 386.542866,28.6612106 386.542866,37.8386504 C386.542866,47.0906803 380.080143,53.0722251 370.075664,53.0736596"
                                                            id="Fill-7"></path>
                                                        <polyline id="Fill-8"
                                                            points="282.739524 52.4224314 270.30255 52.4195626 260.918863 31.289074 260.917455 52.4195626 248.101811 52.420997 248.104626 1.72130788 261.626933 1.7227423 269.92388 20.7331534 269.925288 1.72417672 282.740932 1.72417672 282.739524 52.4224314">
                                                        </polyline>
                                                        <path
                                                            d="M17.3639031,53.0664875 C12.9367061,53.0664875 9.02190961,51.7927196 6.04463721,49.3785853 C2.73092599,46.693345 0.736223861,42.7013452 0.278723374,37.8357816 L0,34.8493124 L13.7545762,34.8493124 L14.072715,37.2060698 C14.4936154,40.3460222 15.9956247,40.7792181 17.5553495,40.7806525 C19.3867591,40.7777836 20.3172447,39.9185641 20.3186524,38.2230759 C20.3186524,37.0583242 19.8498904,35.4675488 16.2208557,33.4693973 L7.69445435,28.8333414 C4.44690474,27.1005581 1.15290123,22.4888874 1.15290123,16.1171794 C1.15430892,6.97990345 7.54383111,1.07868627 17.4300647,1.07725185 C21.4462152,1.07725185 25.1991268,2.38831468 27.9990298,4.76371955 C31.138187,7.43174676 33.0202736,11.313296 33.4411741,15.9966879 L33.7086359,18.9731161 L20.1553599,18.9702472 L19.8907135,16.546072 C19.5430131,13.3645212 17.8411113,13.3645212 17.1133336,13.3630868 C16.3968175,13.3645212 14.730108,13.5897257 14.7287003,15.6653361 C14.7287003,16.8516041 15.3889087,17.9302904 16.4897253,18.5513957 L23.1692324,22.1474947 C28.7887461,25.1798654 33.8296976,28.6583417 33.8311053,37.8343472 C33.8311053,47.0892458 27.3655676,53.0664875 17.3639031,53.0664875"
                                                            id="Fill-9"></path>
                                                        <polyline id="Fill-12"
                                                            points="86.5633153 39.6202041 86.5633153 32.6359974 98.8975285 32.6374318 98.8975285 19.8366389 86.5633153 19.8366389 86.5633153 14.5264041 102.502632 14.5278385 102.50404 1.72704557 73.7476709 1.72561115 73.7448555 52.4224314 94.8095856 52.4224314 101.147023 39.6202041 86.5633153 39.6202041">
                                                        </polyline>
                                                        <polyline id="Fill-13"
                                                            points="71.1068373 52.420997 58.6684548 52.4224314 49.2861756 31.289074 49.2861756 52.4224314 36.4691235 52.4224314 36.4705312 1.72417672 49.9942456 1.72417672 58.2897852 20.7360222 58.2911929 1.72417672 71.108245 1.72561115 71.1068373 52.420997">
                                                        </polyline>
                                                        <path
                                                            d="M223.762785,21.5823319 L225.764525,21.5837664 C228.717867,21.5837664 229.666652,20.6155307 229.663837,17.6061107 L229.663837,16.6235308 C229.449868,15.1790666 228.585544,14.0200527 225.637833,14.0186182 L223.762785,14.0200527 L223.762785,21.5823319 Z M246.145116,52.431038 L231.568447,52.431038 L223.978162,33.8667325 L223.823315,33.8696013 L223.823315,52.431038 L210.247516,52.431038 L210.247516,1.72991442 L225.321102,1.73134884 C236.709345,1.73278326 243.241044,7.51924658 243.241044,17.6075452 C243.241044,23.7784339 241.146395,28.1921542 237.009183,30.7698127 L246.145116,52.431038 Z"
                                                            id="Fill-3"></path>
                                                        <path
                                                            d="M124.006563,29.6954297 L121.538876,29.6954297 L124.006563,23.9735155 L124.006563,29.6954297 Z M122.738231,1.72704557 L97.6474963,52.4238658 L97.6474963,52.4267347 L111.023403,52.4267347 L116.129108,42.5019604 L124.006563,42.5019604 L124.006563,52.4267347 L137.281116,52.4267347 L137.282523,1.72704557 L122.738231,1.72704557 Z"
                                                            id="Fill-11"></path>
                                                        <path
                                                            d="M394.351343,4.93871919 L393.333581,4.93871919 L393.333581,6.5696584 L394.351343,6.5696584 C394.894713,6.5696584 395.248044,6.32150318 395.248044,5.73912735 C395.248044,5.20121864 394.839813,4.93871919 394.351343,4.93871919 Z M395.233967,9.37539024 L394.36542,7.42744349 L393.347658,7.42744349 L393.347658,9.37539024 L392.438287,9.37539024 L392.438287,4.08093409 L394.351343,4.08093409 C395.340952,4.08093409 396.19683,4.6618755 396.19683,5.73912735 C396.19683,6.43051935 395.898399,6.98420671 395.260713,7.27396021 L396.223576,9.37539024 L395.233967,9.37539024 Z M394.134558,2.61638797 C391.733033,2.61638797 390.146562,4.39937605 390.146562,6.81781362 C390.146562,9.23768561 391.733033,11.0063295 394.134558,11.0063295 C396.536084,11.0063295 398.123963,9.22334138 398.123963,6.80490381 C398.123963,4.38503182 396.536084,2.61638797 394.134558,2.61638797 Z M394.134558,11.8913686 C391.326209,11.8913686 389.237192,9.65223393 389.237192,6.81781362 C389.237192,3.98482774 391.326209,1.73134884 394.134558,1.73134884 C396.942908,1.73134884 399.030517,3.97048351 399.030517,6.80490381 C399.030517,9.63788969 396.942908,11.8913686 394.134558,11.8913686 Z"
                                                            id="Fill-14"></path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </div>
                        <!--End of Logo-->
                        <aside class="row">
                            <!--Social Icons in Header-->
                            <ul class="social-icons">
                                <li>
                                    <a target="_blank" title="Facebook" href="https://www.facebook.com/username">
                                        <i class="fa fa-facebook fa-1x"></i><span>Facebook</span>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" title="Google" href="http://google.com">
                                        <i class="fa fa-google fa-1x"></i><span>Google</span>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" title="Twitter" href="http://www.twitter.com/username">
                                        <i class="fa fa-twitter fa-1x"></i><span>Twitter</span>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" title="Instagram" href="http://www.instagram.com/username">
                                        <i class="fa fa-instagram fa-1x"></i><span>Instagram</span>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" title="behance" href="http://www.behance.net">
                                        <i class="fa fa-behance fa-1x"></i><span>Behance</span>
                                    </a>
                                </li>
                            </ul>
                            <?php
                            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1) {
                                echo ('<ul class="interface-icons">
                                    <li><a href="/admin_dashboard.php">Admin dash</a></li>
                                    </ul>');
                            } elseif (isset($_SESSION['user_id']) && $_SESSION['is_admin'] === 0) {
                                echo ('<ul class="interface-icons">
                                    <li><a href="/dashboard.php">Dashboard</a></li>
                                    </ul>');
                            } else {
                                echo ('<ul class="offline interface-icons">
                                <li>
                                    <a href="/register">Register</a>
                                </li>
                                <li>
                                    <a href="/login">Login</a>
                                </li>
                            </ul>');
                            }
                            ?>
                            <!--End of Social Icons in Header-->
                        </aside>


                        <!--Main Navigation-->
                        <nav id="nav-main">
                            <ul>
                                <li>
                                    <a href="/" class="links active">Home</a>
                                    <ul class="dropdown">
                                        <li><a href="/#about">About</a></li>
                                        <li><a href="/#services">Services</a></li>
                                        <li><a href="/#testimonials">Testimonials</a></li>
                                        <li><a href="/#clients">Clients</a></li>
                                        <li><a href="/#vendor-list">Aanwezige</a></li>
                                        <li><a href="/#exclusive">Exclusive</a></li>
                                        <li><a href="/#pricing">Pricing</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="/agenda" class="links">Agenda</a>
                                </li>
                                <li>
                                    <a href="/informatieStands" class="links">Info Stands</a>
                                </li>
                                <li>
                                    <a href="/FAQ" class="links">FAQ</a>
                                </li>
                                <li>
                                    <a href="/pre-order-waitlist" class="links">Pre-order nu!</a>
                                </li>
                            </ul>
                            <div id="progress-bar"></div>
                        </nav>
                        <!--End of Main Navigation-->

                        <div id="nav-trigger"><span></span></div>
                        <nav id="nav-mobile"></nav>

                    </div>
                </div>
            </div><!--End of Header-->

            <!--Banner Content-->
            <div id="banner-content" class="row clearfix">

                <div class="col-38">

                    <div class="section-heading">
                        <h1>Welkom bij Sneakerness</h1>
                        <h2>Jouw ultieme sneakerbestemming</h2>
                        <p>Ontdek de nieuwste en meest exclusieve sneakers, ontmoet andere sneakerliefhebbers en geniet
                            van unieke evenementen. Mis het niet!</p>
                    </div>
                </div>

            </div><!--End of Row-->
        </header>
    </div>
    <!--Banner-->
    <div class="slideshow-container-1">
        <div class="absolute banner-text"></div>
        <img class="mySlides-1" src="assets/img/sneakers/sneakers_landscape (3).jpg" />
        <img class="mySlides-1" src="assets/img/sneakers/sneakers_landscape (4).jpg" />
        <img class="mySlides-1" src="assets/img/sneakers/sneakers_landscape (7).jpg" />
    </div>


    <!--Main Content Area-->
    <main id="content">
        <!--Introduction-->
        <?php
        // Haal zichtbaarheid op van 'about' sectie
        //$sql = "SELECT is_visible FROM sections WHERE section_name = 'about'";
        //$stmt = $pdo->query($sql);
        //$aboutVisible = $stmt->fetchColumn();
        ?>

        <?php if (isSectionVisible('about')): ?>
            <section id="about" class="introduction scrollto">
                <div class="row clearfix">
                    <div class="col">
                        <div class="section-heading">

                            <div class="text-with-image scrollto wow fadeInUp" data-wow-delay="0.1s"">
                            <span>
                                <h3>OVER ONS</h3>
                    
                                <h2 class=" section-title">Wat is Sneakerness?</h2>
                                <p>Bij Sneakerness brengen we sneakerliefhebbers van over de hele wereld samen.
                                    Onze passie voor sneakers laat ons evenementen creëren die de essentie van de
                                    cultuur van kicks brengen.
                                    Ervaar wat veel meer is dan alleen een schoen.
                                    Komen jij en jouw vrienden ook langs? Boek een ticket hier op onze site! </p>
                                </span>
                                <img id="imgRight" class="what-is-sneakerness" src="assets/img/gallery-images/jordan.jpg">
                            </div>

                        </div>

                        <div class="section-heading">

                            <div class="text-with-image scrollto wow fadeInLeft" data-wow-delay="0.1s"">
                                <img class=" what-is-sneakerness"
                                src="assets/img/gallery-images/evenement-img (3).png">
                                <span id="imgLeft">
                                    <h3>Experience</h3>
                                    <h2 class="section-title">Maak deel uit van een wereldwijde gemeenschap van
                                        enthousiastelingen.</h2>
                                    <p>Sneakerness brengt schoenenfanaten samen die hun passie vieren. Een unieke mix van 's
                                        werelds toonaangevende merken en winkels biedt meer dan alleen een kijkje in de
                                        sneakercultuur. Ontdek exclusieve prototypes, koop zeldzame exemplaren of laat je
                                        inspireren door geweldige vintage ontwerpen. Ruil in voor jeugdherinneringen,
                                        ontmoet je eerste echte liefde opnieuw en zie hoe die ene fantasie van een schoen
                                        waar je al die jaren naar op zoek bent voor je ogen werkelijkheid wordt... Of kom
                                        gewoon eens langs om te zien waar het allemaal om draait. En misschien besef je het
                                        eerder vroeg dan laat: misschien ben je zelf altijd al een sneakerhead geweest.</p>


                                </span>
                            </div>
                        </div>

                        <div class="section-heading">
                            <div class="text-with-image scrollto wow fadeInRight" data-wow-delay="0.1s"">
                                    <span>
                                        <h3>Onze gemeenschap</h3>
                                        <h2 class=" section-title">Sneakerness brengt samen wat bij elkaar hoort</h2>
                                <p>Sneakerness is een samenzijn voor een diverse groep mensen uit verschillende
                                    gemeenschappen – maar ze delen allemaal dezelfde passie. Uit deze passie is
                                    Sneakerness ontstaan: vrienden die samenkomen om een ​​platform op te zetten voor
                                    degenen die geen genoeg kunnen krijgen van sneakers en de cultuur die daarbij hoort.
                                    Een cultuur die zo breed en divers mogelijk is: het verbindt particuliere verkopers
                                    en merken, atleten en artiesten, muzikanten en ontwerpers, dansers en dj's,
                                    chef-koks en entertainers. Levend in het tijdperk van netwerken realiseren we ons
                                    dat deze mensen en hun talenten met elkaar verbonden zijn – en het enige dat nodig
                                    is om van hun individuele scènes iets groters te maken, is een kans om ze allemaal
                                    samen te brengen. Dit is de visie waarin we vanaf dag één hebben geloofd – en dat
                                    doen we nog steeds.</p>
                                </span>
                                <img id="imgRight" class="what-is-sneakerness"
                                    src="assets/img/gallery-images/evenement-img (5).png">
                            </div>
                        </div>
                    </div>
            </section>
        <?php else: ?>
            <p class="verbouwing"><strong>De 'About' sectie is momenteel in verbouwing.</strong></p>
        <?php endif; ?>

        <div class="hVideo">
            <video class="myHVideo" src="assets/img/banner-images/SNEAKERNESS-Main-Teaser-HP_comp.mp4" loop autoplay
                muted></video>
        </div>

        <?php if (isSectionVisible('services')): ?>
            <!--Content Section-->
            <section id="services" class="scrollto clearfix">

                <div class="row no-padding-bottom clearfix">
                    <!--Content of the Right Side-->
                    <div class="col-9">
                        <div class="section-heading scrollto wow fadeInUp" data-wow-delay="0.1s">
                            <h3>SERVICES</h3>
                            <h2 class="section-title">Onze Diensten</h2>
                            <p class="section-subtitle">Bij Sneakerness bieden we een breed scale aan diensten om
                                jouw
                                sneakerervaring onvergetelijk te maken.</p>
                            <p>Van exclusieve releases tot live customization, we hebben alles wat je nodig hebt om
                                je
                                sneakercollectie naar een hoger niveau te tillen.</p>
                            <p>Kom langs en ervaar het zelf!</p>

                            <div class="row">


                                <!--Icon Block-->
                                <div class="col-6 icon-block icon-top wow fadeInUp" data-wow-delay="0.1s">
                                    <!--Icon-->
                                    <div class="icon">
                                        <img class="fa fa-rocket fa-2x" src="assets/img/icons/exclusive.png" alt="">
                                    </div>
                                    <!--Icon Block Description-->
                                    <div class="icon-block-description">
                                        <h4>Exclusieve Releases</h4>
                                        <p>Ontdek de nieuwste en meest exclusieve sneakerreleases van topmerken,
                                            alleen
                                            verkrijgbaar tijdens Sneakerness.</p>
                                    </div>
                                </div>
                                <!--End of Icon Block-->

                                <!--Icon Block-->
                                <div class="col-6 icon-block icon-top wow fadeInUp" data-wow-delay="0.3s">
                                    <!--Icon-->
                                    <div class="icon">
                                        <img class="fa fa-rocket fa-2x" src="assets/img/icons/community.png" alt="">
                                    </div>
                                    <!--Icon Block Description-->
                                    <div class="icon-block-description">
                                        <h4>Sneaker Community</h4>
                                        <p>Verbind je met sneakerheads van over de hele wereld, deel verhalen en
                                            bewonder
                                            elkaars unieke collecties.</p>
                                    </div>
                                </div>
                                <!--End of Icon Block-->

                                <!--Icon Block-->
                                <div class="col-6 icon-block icon-top wow fadeInUp" data-wow-delay="0.5s">
                                    <!--Icon-->
                                    <div class="icon">
                                        <img class="fa fa-rocket fa-2x" src="assets/img/icons/speed-limit.png" alt="">
                                    </div>
                                    <!--Icon Block Description-->
                                    <div class="icon-block-description">
                                        <h4>Limited Editions</h4>
                                        <p>Vind zeldzame en unieke sneakers die je nergens anders kunt krijgen. De
                                            perfecte kans
                                            om je collectie uit te breiden met bijzondere paren.</p>
                                    </div>
                                </div>
                                <!--End of Icon Block-->

                                <!--Icon Block-->
                                <div class="col-6 icon-block icon-top wow fadeInUp" data-wow-delay="0.7s">
                                    <!--Icon-->
                                    <div class="icon">
                                        <img class="fa fa-rocket fa-2x" src="assets/img/icons/live.png" alt="">
                                    </div>
                                    <!--Icon Block Description-->
                                    <div class="icon-block-description">
                                        <h4>Live Customization</h4>
                                        <p>Ervaar live sneaker customizing door de beste artiesten en ontwerp je
                                            eigen unieke
                                            paar tijdens het event.</p>
                                    </div>
                                </div>
                                <!--End of Icon Block-->


                            </div>

                        </div>
                    </div>
                </div>

            </section>
            <!--End of Introduction-->
        <?php else: ?>
            <p class="verbouwing"><strong>De 'Services' sectie is momenteel in verbouwing.</strong></p>
        <?php endif; ?>

        <?php if (isSectionVisible('gallery')): ?>
            <!--Gallery-->
            <aside id="gallery" class="row text-center scrollto clearfix" data-featherlight-gallery
                data-featherlight-filter="a">

                <a href="assets/img/sneakers/sneaker (1)-small.png" data-wow-delay="0.4s" data-featherlight="image"
                    class="col-2 wow fadeIn"><img src=" assets/img/sneakers/sneaker (1)-small.png" data-wow-delay="0.4s"
                        alt="Landing Page" /></a>
                <a href="assets/img/sneakers/sneaker (2)-small.png" data-wow-delay="0.6s" data-featherlight="image"
                    class="col-2 wow fadeIn"><img src=" assets/img/sneakers/sneaker (2)-small.png" data-wow-delay="0.6s"
                        alt="Landing Page" /></a>
                <a href="assets/img/sneakers/sneaker (8)-small.png" data-wow-delay="0.8s" data-featherlight="image"
                    class="col-2 wow fadeIn"><img src=" assets/img/sneakers/sneaker (8)-small.png" data-wow-delay="0.8s"
                        alt="Landing Page" /></a>
                <a href="assets/img/sneakers/sneaker (4)-small.png" data-wow-delay="1.0s" data-featherlight="image"
                    class="col-2 wow fadeIn"><img src=" assets/img/sneakers/sneaker (4)-small.png" data-wow-delay="1.0s"
                        alt="Landing Page" /></a>
                <a href="assets/img/sneakers/sneaker (5)-small.png" data-wow-delay="1.2s" data-featherlight="image"
                    class="col-2 wow fadeIn"><img src=" assets/img/sneakers/sneaker (5)-small.png" data-wow-delay="1.2s"
                        alt="Landing Page" /></a>
                <a href="assets/img/sneakers/sneaker (6)-small.png" data-wow-delay="1.4s" data-featherlight="image"
                    class="col-2 wow fadeIn"><img src=" assets/img/sneakers/sneaker (6)-small.png" data-wow-delay="1.4s"
                        alt="Landing Page" /></a>

                <a href="assets/img/sneakers/ssneaker-new (2).png" data-wow-delay="1.8s" data-featherlight="image"
                    class="col-2 wow fadeIn"><img src="assets/img/sneakers/ssneaker-new (2)-small.png" data-wow-delay="0.4s"
                        alt="Landing Page" /></a>
                <a href="assets/img/sneakers/ssneaker-new (3).png" data-wow-delay="2.0s" data-featherlight="image"
                    class="col-2 wow fadeIn"><img src="assets/img/sneakers/ssneaker-new (3)-small.png" data-wow-delay="0.6s"
                        alt="Landing Page" /></a>
                <a href="assets/img/sneakers/ssneaker-new (7).png" data-wow-delay="2.2s" data-featherlight="image"
                    class="col-2 wow fadeIn"><img src="assets/img/sneakers/sneaker (13)-small.png" data-wow-delay="0.8s"
                        alt="Landing Page" /></a>
                <a href="assets/img/sneakers/ssneaker-new (5).png" data-wow-delay="2.4s" data-featherlight="image"
                    class="col-2 wow fadeIn"><img src="assets/img/sneakers/ssneaker-new (5)-small.png" data-wow-delay="1.0s"
                        alt="Landing Page" /></a>
                <a href="assets/img/sneakers/ssneaker-new (8).png" data-wow-delay="2.6s" data-featherlight="image"
                    class="col-2 wow fadeIn"><img src="assets/img/sneakers/sneaker (11)-small.png" data-wow-delay="1.2s"
                        alt="Landing Page" /></a>
                <a href="assets/img/sneakers/ssneaker-new (9).png" data-wow-delay="2.8s" data-featherlight="image"
                    class="col-2 wow fadeIn"><img src="assets/img/sneakers/ssneaker-new (9)-small.png" data-wow-delay="1.4s"
                        alt="Landing Page" /></a>
            </aside>
            <!--End of Gallery-->
        <?php else: ?>
            <p class="verbouwing"><strong>De 'Gallery' sectie is momenteel in verbouwing.</strong></p>
        <?php endif; ?>

        <?php if (isSectionVisible('banner-content')): ?>
            <div id="banner-content" class="row clearfix">
                <div class="col-38">

                    <div class="nieuwsletter wow fadeInLeft scrollto text-center" data-wow-delay="0.4s">
                        <h1><strong>Nieuwtjes</strong></h1>
                    </div>
                    <div class="wow fadeInLeft scrollto" data-wow-delay="0.4s">
                        <h2> <strong>Ben jij klaar voor hét sneaker evenement van het jaar?</strong> </h2>
                        <p> Op 28 oktober
                            verzamelen sneakerheads uit het hele land zich om de nieuwste releases,
                            zeldzame parels en limited editions te ontdekken. Van exclusieve pop-up
                            shops tot live customizing sessies en meet & greets met bekende sneaker
                            designers – dit event wil je niet missen!
                        </p>
                    </div>
                    <div class="nieuwsletter wow fadeInLeft scrollto" data-wow-delay="0.4s">
                        <h1><strong>Wat kun je verwachten?</strong></h1>
                        <p>
                            🎤 Live DJ-sets om de vibe compleet te maken <br>
                            🎨 Customization workshops door top-artiesten <br>
                            🏆 Sneaker Battles – wie heeft de beste kicks? <br>
                            🎁 Giveaways en exclusieve deals voor alle bezoekers <br> </p>
                        </p>
                        Locatie: Nellefabriek, Rotterdam <br>
                        Tijd: 12:00 – 18:00 uur <br> <br>

                        Zorg dat je erbij bent! Tickets zijn beperkt, dus mis je kans niet. <br> <br>

                        👟 Keep it fresh, keep it exclusive! 👟 <br> <br>
                        </p>

                        <a href="/subscribe"><button>Blijf op de hoogte</button></a>
                    </div>
                </div>
                <div class="col-61">

                    <div class="wow fadeInRight scrollto" data-wow-delay="0.4s">

                        <h2><strong>Nieuwste Sneaker Releases Onthuld</strong></h2>

                        <p> Dit is jouw kans om als eerste de nieuwste sneaker releases te zien!
                            Van high-performance sportmodellen tot streetwear-iconen, we hebben
                            samenwerkingen met merken als Nike, Adidas, en Yeezy. Ontdek limited edition
                            sneakers die nergens anders verkrijgbaar zijn – exclusief beschikbaar op ons evenement!
                        </p>

                    </div>
                    <div class="nieuwsletter wow fadeInRight scrollto" data-wow-delay="0.4s">

                        <h1><strong>👀 Sneak Peek:</strong></h1>
                        <p>
                            <strong>Nike Air Max 97 'Midnight Edition'</strong> – een elegante, donkere kleurstelling met
                            reflecterende details. <br>
                            <strong>Adidas Ultraboost 'Neon Wave'</strong> – perfecte balans tussen comfort en stijl. <br>
                            <strong>Yeezy Boost 350 V3</strong> – de nieuwste iteratie, strakker dan ooit tevoren! <br> <br>
                            Kom langs bij de release-stands en bemachtig je paar voordat ze uitverkocht zijn!
                        <p>

                    </div>
                    <div class="wow fadeInRight scrollto" data-wow-delay="0.4s">

                        <h1><strong>Sneakerheads Marketplace </strong></h1>
                        <p>Op zoek naar die ene zeldzame sneaker? Bezoek de Sneakerheads Marketplace,
                            waar je kunt kopen, verkopen en ruilen met andere liefhebbers. Van klassieke
                            modellen tot de nieuwste grails, hier vind je alles wat je sneakerhart begeert.
                        </p>

                        <p>
                            <strong>Zorg ervoor dat je je favoriete sneakers meeneemt – je weet nooit wat je
                                tegenkomt!</strong>
                        </p>

                        <img class="nieuwsletter wow fadeInRight scrollto" src="/assets/img/sneakers/sneaker (5)-small.png"
                            alt="" data-wow-delay="0.4s">
                    </div>
                </div>
            </div>
            <!--End Nieuws ashutosh-->
        <?php else: ?>
            <p class="verbouwing"><strong>De 'Nieuwtjes' sectie is momenteel in verbouwing.</strong></p>
        <?php endif; ?>

        <div class="slideshow-container-2">
            <div class="banner-text">
                <img class="mySlides-2"
                    src="https://i0.wp.com/billypenn.com/wp-content/uploads/2023/02/sneakercon-conventionctr-8-scaled.jpg?resize=1024%2C684&ssl=1" />
                <img class="mySlides-2"
                    src="https://i0.wp.com/billypenn.com/wp-content/uploads/2023/02/sneakercon-conventionctr-9-scaled.jpg?resize=1024%2C683&ssl=1" />
                <img class="mySlides-2"
                    src="https://i0.wp.com/billypenn.com/wp-content/uploads/2023/02/sneakercon-conventionctr-3-scaled.jpg?resize=1024%2C683&ssl=1" />
                <img class="mySlides-2"
                    src="https://i0.wp.com/billypenn.com/wp-content/uploads/2023/02/sneakercon-conventionctr-5-scaled.jpg?resize=1024%2C683&ssl=1" />
                <img class="mySlides-2"
                    src="https://i0.wp.com/billypenn.com/wp-content/uploads/2023/02/sneakercon-conventionctr-2-scaled.jpg?resize=1024%2C683&ssl=1" />
                <img class="mySlides-2"
                    src="https://i0.wp.com/billypenn.com/wp-content/uploads/2023/02/sneakercon-conventionctr-4-scaled.jpg?resize=1024%2C683&ssl=1" />
                <img class="mySlides-2"
                    src="https://i0.wp.com/billypenn.com/wp-content/uploads/2023/02/sneakercon-conventionctr-7-scaled.jpg?resize=1024%2C683&ssl=1" />
                <img class="mySlides-2"
                    src="https://i0.wp.com/billypenn.com/wp-content/uploads/2023/02/sneakercon-conventionctr-11-scaled.jpg?resize=1024%2C683&ssl=1" />
            </div>
        </div>

        <?php if (isSectionVisible('testimonials')): ?>
            <!--Testimonials-->
            <aside id="testimonials" class="scrollto text-center scrollto wow fadeInRight" data-wow-delay="0.1s"
                data-enllax-ratio=".2">
                <div class="section-heading">
                    <h3>RECENCIES</h3>
                    <h2 class="section-title">Wat onze klanten hebben ervaart</h2>
                </div>
                <div class="testimonial-slider">
                    <button class="prev" onclick="prevSlide()">❮</button>
                    <div class="testimonial-wrapper">
                        <div class="testimonial-slides">
                            <!--User Testimonial-->
                            <blockquote class="testimonial classic">
                                <img loading="lazy" src="assets/img/user-images/user-1.jpg" alt="User" />
                                <q><strong>Een droom voor sneakerfans!</strong></q>
                                <q>Sneakerness® had alles: zeldzame kicks, een geweldige sfeer, en vriendelijke verkopers.
                                    Ik vond unieke sneakers en de customizers waren een leuke verrassing. Volgend jaar ben
                                    ik er weer bij!</q>
                                <footer>John Doe - Sneakerhead</footer>
                            </blockquote>
                            <!-- End of Testimonial-->

                            <!--User Testimonial-->
                            <blockquote class="testimonial classic">
                                <img loading="lazy" src="assets/img/user-images/user-2.jpg" alt="User" />
                                <q><strong>Leuk, maar prijzig!</strong> Het was indrukwekkend voor verzamelaars, maar als
                                    nieuwkomer voelde het soms overweldigend. De prijzen voor vroege toegang zijn hoog, en
                                    ik miste wat variatie in de stands. Een leuke ervaring, maar misschien niet voor
                                    herhaling vatbaar.</q>
                                <footer>Roslyn Doe - Sneakerhead</footer>
                            </blockquote>
                            <!-- End of Testimonial-->

                            <!--User Testimonial-->
                            <blockquote class="testimonial classic">
                                <img loading="lazy" src="assets/img/user-images/user-3.jpg" alt="User" />
                                <q><strong>Eerste beste!</strong></q>
                                <q>Als standhouder was dit mijn eerste keer bij Sneakerness®, en het was een succes! Goed
                                    georganiseerd en ik heb veel nieuwe klanten ontmoet. Soms was het druk bij de ingang,
                                    maar verder een geweldige ervaring. Ik kom zeker terug!</q>
                                <footer>Trevor Doe - Ondernemer</footer>
                            </blockquote>
                            <!-- End of Testimonial-->

                            <!--User Testimonial-->
                            <blockquote class="testimonial classic">
                                <img loading="lazy" src="assets/img/user-images/user-1.jpg" alt="User" />
                                <q><strong>De muziek was fantastisch!</strong> Ik kwam voor de sneakers, maar de DJ’s
                                    maakten het evenement echt bijzonder. De combinatie van muziek en sneakers zorgde voor
                                    een geweldige sfeer. Een aanrader, ook als je geen sneakerhead bent!</q>
                                <footer>Henny Doe - Sneakerliefhebber</footer>
                            </blockquote>
                            <!-- End of Testimonial-->

                            <!--User Testimonial-->
                            <blockquote class="testimonial classic">
                                <img loading="lazy" src="assets/img/user-images/user-2.jpg" alt="User" />
                                <q>Een geweldige gezinsdag! De kindvriendelijke activiteiten waren top, en de sfeer was
                                    relaxed. Ondanks de drukte was het nooit te chaotisch. De toegang is aan de hoge kant
                                    voor gezinnen, maar het was zeker de moeite waard!</q>
                                <footer>Boa Doe - Sneakerhead</footer>
                            </blockquote>
                            <!-- End of Testimonial-->

                            <!--User Testimonial-->
                            <blockquote class="testimonial classic">
                                <img loading="lazy" src="assets/img/user-images/user-3.jpg" alt="User" />
                                <q>Een geweldige gezinsdag! De kindvriendelijke activiteiten waren top, en de sfeer was
                                    relaxed. Ondanks de drukte was het nooit te chaotisch. De toegang is aan de hoge kant
                                    voor gezinnen, maar het was zeker de moeite waard!</q>
                                <footer>Ryan Doe - Sneakerhead</footer>
                            </blockquote>
                            <!-- End of Testimonial-->

                        </div>
                    </div>
                    <button class="next" onclick="nextSlide()">❯</button>
                </div>
            </aside>
            <!--End of Testimonials-->
        <?php else: ?>
            <p class="verbouwing"><strong>De 'testimonials' sectie is momenteel in verbouwing.</strong></p>
        <?php endif; ?>

        <?php if (isSectionVisible('clients')): ?>
            <!--Clients-->
            <section id="clients" class="scrollto clearfix wow fadeInUp" data-wow-delay="0.1s">
                <div class=" row clearfix">
                    <div class="col-9">
                        <div class="section-heading">
                            <h3>CLIENTS</h3>
                            <h2 class="section-title">Onze Partners</h2>
                            <p class="section-subtitle">
                                We zijn trots om samen te werken met enkele van de grootste namen in de
                                sneakerindustrie. Onze partners helpen ons om van Sneakerness een onvergetelijke
                                ervaring te maken.
                            </p>
                        </div>

                    </div>
                    <div class="scrollto clearfix">
                        <ul class="row">
                            <a href="https://www.puma.com" target="_blank" data-wow-delay="0.2s" class="col-3 wow fadeIn">
                                <img
                                    src="https://sneakerbaron.nl/wp-content/themes/the-baron/assets/images/brands/black/puma.svg" />
                                <div class="client-overlay"><span>Puma</span></div>
                            </a>
                            <a href="https://www.adidas.com" target="_blank" data-wow-delay="0.4s" class="col-3 wow fadeIn">
                                <img
                                    src="https://sneakerbaron.nl/wp-content/themes/the-baron/assets/images/brands/black/adidas.svg" />
                                <div class="client-overlay"><span>Adidas</span></div>
                            </a>
                            <a href="https://www.fila.com" target="_blank" data-wow-delay="0.6s" class="col-3 wow fadeIn">
                                <img
                                    src="https://sneakerbaron.nl/wp-content/themes/the-baron/assets/images/brands/black/fila.svg" />
                                <div class="client-overlay"><span>Fila</span></div>
                            </a>
                            <a href="https://www.nike.com" target="_blank" data-wow-delay="0.8s" class="col-3 wow fadeIn">
                                <img
                                    src="https://sneakerbaron.nl/wp-content/themes/the-baron/assets/images/brands/black/nike.svg" />
                                <div class="client-overlay"><span>Nike</span></div>
                            </a>
                            <a href="https://www.alexandermcqueen.com" target="_blank" data-wow-delay="0.2s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/alexander-mcqueen.svg" alt="Company" />
                                <div class="client-overlay"><span>alexander-mcqueen</span></div>
                            </a>
                            <a href="https://www.arkkcopenhagen.com" target="_blank" data-wow-delay="0.4s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/arkk.svg" alt="Company" />
                                <div class="client-overlay"><span>arkk</span></div>
                            </a>
                            <a href="https://www.asics.com" target="_blank" data-wow-delay="0.6s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/asics.svg" alt="Company" />
                                <div class="client-overlay"><span>asics</span></div>
                            </a>
                            <a href="https://www.autry-usa.com" target="_blank" data-wow-delay="0.8s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/autry.svg" alt="Company" />
                                <div class="client-overlay"><span>autry</span></div>
                            </a>
                            <a href="https://www.balenciaga.com" target="_blank" data-wow-delay="0.2s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/balenciaga.svg" alt="Company" />
                                <div class="client-overlay"><span>balenciaga</span></div>
                            </a>
                            <a href="https://www.birkenstock.com" target="_blank" data-wow-delay="0.4s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/birkenstock.svg" alt="Company" />
                                <div class="client-overlay"><span>birkenstock</span></div>
                            </a>
                            <a href="https://www.buffalo-boots.com" target="_blank" data-wow-delay="0.6s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/buffalo.svg" alt="Company" />
                                <div class="client-overlay"><span>buffalo</span></div>
                            </a>
                            <a href="https://www.comme-des-garcons.com" target="_blank" data-wow-delay="0.8s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/comme-des-garcons.svg" alt="Company" />
                                <div class="client-overlay"><span>comme-des-garcons</span></div>
                            </a>
                            <a href="https://www.converse.com" target="_blank" data-wow-delay="0.2s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/converse.svg" alt="Company" />
                                <div class="client-overlay"><span>converse</span></div>
                            </a>
                            <a href="https://www.crocs.com" target="_blank" data-wow-delay="0.4s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/crocs.svg" alt="Company" />
                                <div class="client-overlay"><span>crocs</span></div>
                            </a>
                            <a href="https://www.diadora.com" target="_blank" data-wow-delay="0.6s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/diadora.svg" alt="Company" />
                                <div class="client-overlay"><span>diadora</span></div>
                            </a>
                            <a href="https://www.etq-amsterdam.com" target="_blank" data-wow-delay="0.8s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/etq.svg" alt="Company" />
                                <div class="client-overlay"><span>etq</span></div>
                            </a>
                            <a href="https://www.fillingpieces.com" target="_blank" data-wow-delay="0.2s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/filling-pieces.svg" alt="Company" />
                                <div class="client-overlay"><span>filling-pieces</span></div>
                            </a>
                            <a href="https://www.gucci.com" target="_blank" data-wow-delay="0.4s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/gucci.svg" alt="Company" />
                                <div class="client-overlay"><span>gucci</span></div>
                            </a>
                            <a href="https://www.hi-tec.com" target="_blank" data-wow-delay="0.6s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/hi-tec.svg" alt="Company" />
                                <div class="client-overlay"><span>hi-tec</span></div>
                            </a>
                            <a href="https://www.hoka.com" target="_blank" data-wow-delay="0.8s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/hoka.svg" alt="Company" />
                                <div class="client-overlay"><span>hoka</span></div>
                            </a>
                            <a href="https://www.hummel.net" target="_blank" data-wow-delay="0.2s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/hummel.svg" alt="Company" />
                                <div class="client-overlay"><span>hummel</span></div>
                            </a>
                            <a href="https://www.nike.com/jordan" target="_blank" data-wow-delay="0.4s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/jordan.svg" alt="Company" />
                                <div class="client-overlay"><span>jordan</span></div>
                            </a>
                            <a href="https://www.kangaroos.com" target="_blank" data-wow-delay="0.6s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/kangaroos.svg" alt="Company" />
                                <div class="client-overlay"><span>kangaroos</span></div>
                            </a>
                            <a href="https://www.karhu.com" target="_blank" data-wow-delay="0.8s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/karhu.svg" alt="Company" />
                                <div class="client-overlay"><span>karhu</span></div>
                            </a>
                            <a href="https://www.lacoste.com" target="_blank" data-wow-delay="0.2s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/lacoste.svg" alt="Company" />
                                <div class="client-overlay"><span>lacoste</span></div>
                            </a>
                            <a href="https://www.mizuno.com" target="_blank" data-wow-delay="0.4s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/mizuno.svg" alt="Company" />
                                <div class="client-overlay"><span>mizuno</span></div>
                            </a>
                            <a href="https://www.newbalance.com" target="_blank" data-wow-delay="0.6s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/new-balance.svg" alt="Company" />
                                <div class="client-overlay"><span>new-balance</span></div>
                            </a>
                            <a href="https://www.nubikk.com" target="_blank" data-wow-delay="0.8s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/nubikk.svg" alt="Company" />
                                <div class="client-overlay"><span>nubikk</span></div>
                            </a>
                            <a href="https://www.off---white.com" target="_blank" data-wow-delay="0.2s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/off-white.svg" alt="Company" />
                                <div class="client-overlay"><span>off-white</span></div>
                            </a>
                            <a href="https://www.onitsukatiger.com" target="_blank" data-wow-delay="0.4s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/onitsuka-tiger.svg" alt="Company" />
                                <div class="client-overlay"><span>onitsuka-tiger</span></div>
                            </a>
                            <a href="https://www.reebok.com" target="_blank" data-wow-delay="0.6s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/reebok.svg" alt="Company" />
                                <div class="client-overlay"><span>reebok</span></div>
                            </a>
                            <a href="https://www.on-running.com" target="_blank" data-wow-delay="0.8s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/run-on-clouds.svg" alt="Company" />
                                <div class="client-overlay"><span>run-on-clouds</span></div>
                            </a>
                            <a href="https://www.salomon.com" target="_blank" data-wow-delay="0.2s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/salomon.svg" alt="Company" />
                                <div class="client-overlay"><span>salomon</span></div>
                            </a>
                            <a href="https://www.saucony.com" target="_blank" data-wow-delay="0.4s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/saucony.svg" alt="Company" />
                                <div class="client-overlay"><span>saucony</span></div>
                            </a>
                            <a href="https://www.superga-usa.com" target="_blank" data-wow-delay="0.6s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/superga.svg" alt="Company" />
                                <div class="client-overlay"><span>superga</span></div>
                            </a>
                            <a href="https://www.timberland.com" target="_blank" data-wow-delay="0.8s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/timberland.svg" alt="Company" />
                                <div class="client-overlay"><span>timberland</span></div>
                            </a>
                            <a href="https://www.tommy.com" target="_blank" data-wow-delay="0.2s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/tommy-hilfiger.svg" alt="Company" />
                                <div class="client-overlay"><span>tommy-hilfiger</span></div>
                            </a>
                            <a href="https://www.ugg.com" target="_blank" data-wow-delay="0.4s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/ugg.svg" alt="Company" />
                                <div class="client-overlay"><span>ugg</span></div>
                            </a>
                            <a href="https://www.vans.com" target="_blank" data-wow-delay="0.6s" class="col-3 wow fadeIn">
                                <img src="assets/img/icons/vans.svg" alt="Company" />
                                <div class="client-overlay"><span>vans</span></div>
                            </a>
                            <a href="https://www.veja-store.com" target="_blank" data-wow-delay="0.8s"
                                class="col-3 wow fadeIn">
                                <img src="assets/img/icons/veja.svg" alt="Company" />
                                <div class="client-overlay"><span>veja</span></div>
                            </a>
                        </ul>
                    </div>

                    <!--Registratie lijst-->
                    <section id="vendor-list" class="flex borderbox clearfix scrollto wow fadeInUp" data-wow-delay=".4s">
                        <div class="row">
                            <div class="section-heading col-9">
                                <h3>Geregistreerde Verkopers</h3>
                                <h2 class="section-title">Wie is er allemaal aanwezig?</h2>
                                <p class="section-subtitle">
                                    Ontdek de merken die de sneakerindustrie hebben gevormd, allemaal te vinden hier.
                                </p>
                            </div>

                            <div class="vendor-list col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="exclusive">
                                                    <h2>Nike <span class="partner-check">✔️ Sneakerness Partner</span></h2>
                                                    <p><strong>Trivia:</strong> Iconisch sport- en sneakermerk bekend om
                                                        innovatie.
                                                    </p>
                                                    <p><strong>Locatie:</strong> Stand A, West, Zuid & Oost</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="exclusive">
                                                    <h2>Adidas <span class="partner-check">✔️ Sneakerness Partner</span>
                                                    </h2>
                                                    <p><strong>Trivia:</strong> Leidend in sport- en streetwear met
                                                        baanbrekende
                                                        ontwerpen.
                                                    </p>
                                                    <p><strong>Locatie:</strong> Stand A+, Noord, West & Zuid</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="exclusive">
                                                    <h2>Puma <span class="partner-check">✔️ Sneakerness Partner</span></h2>
                                                    <p><strong>Trivia:</strong> Combineert mode en sport voor een
                                                        onderscheidende
                                                        stijl.
                                                    </p>
                                                    <p><strong>Locatie:</strong> Stand A++, Zuid & Oost</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="exclusive">
                                                    <h2>Off-White <span class="partner-check">✔️ Sneakerness Partner</span>
                                                    </h2>
                                                    <p><strong>Trivia:</strong> Combineert streetwear met luxe mode in
                                                        sneakerontwerpen.
                                                    </p>
                                                    <p><strong>Locatie:</strong> Stand AAA, Noord & Zuid</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="vendor-item col-3">
                                                <h2>Reebok</h2>
                                                <p><strong>Trivia:</strong> Innovatieve sneakers met een rijke geschiedenis
                                                    in
                                                    fitness.
                                                </p>
                                                <p><strong>Locatie:</strong> Stand AA, Oost</p>
                                            </div>
                                            <div class="vendor-item col-3">
                                                <h2>New Balance</h2>
                                                <p><strong>Trivia:</strong> Bekend om comfort en kwaliteit in
                                                    hardloopschoenen.
                                                </p>
                                                <p><strong>Locatie:</strong> Stand AA+, West</p>
                                            </div>
                                            <div class="vendor-item col-3">
                                                <h2>Converse</h2>
                                                <p><strong>Trivia:</strong> Iconisch merk met tijdloze sneakers, vooral de
                                                    Chuck
                                                    Taylor.
                                                </p>
                                                <p><strong>Locatie:</strong> Stand AA++, Zuid</p>
                                            </div>
                                            <div class="vendor-item col-3">
                                                <h2>Vans</h2>
                                                <p><strong>Trivia:</strong> Populair onder skateboarders en geliefd om hun
                                                    casual
                                                    stijl.
                                                </p>
                                                <p><strong>Locatie:</strong> Stand AA++, Oost</p>
                                            </div>
                                            <?php foreach ($reservations as $res): ?>
                                                <div class="vendor-item col-3">
                                                    <h2><?php echo htmlspecialchars($res['company_name'] ?? ''); ?></h2>

                                                    <!-- Vervang de placeholder tekst met de 'about' informatie -->
                                                    <p><strong>Over:</strong> <?php echo htmlspecialchars($res['about'] ?? ''); ?></p>

                                                    <p><strong>Locatie:</strong> Stand <?php echo htmlspecialchars($res['stand_number'] ?? ''); ?>, <?php echo htmlspecialchars($res['plain_name'] ?? ''); ?></p>
                                                </div>
                                            <?php endforeach; ?>


                                        </div>
                                    </div>
                                </div>
                                <!-- Meer verkopers met aankoop van een ticket -->
                            </div>
                        </div>
                    </section>

                    <div id="error-message" class="error-message" style="display: none;">
                        Lijst van verkopers niet beschikbaar, probeer later opnieuw.
                    </div>

                    <script>
                        const vendorsAvailable = true; // Verander deze waarde naar 'false' om de foutmelding te testen

                        if (!vendorsAvailable) {
                            document.getElementById('vendor-list').style.display = 'none';
                            document.getElementById('error-message').style.display = 'block';
                        }
                    </script>
                </div>
            </section>
            <!-- End of Clients-->

        <?php else: ?>
            <p class="verbouwing"><strong>De 'Clients' sectie is momenteel in verbouwing.</strong></p>
        <?php endif; ?>

        <?php if (isSectionVisible('sneaker')): ?>

            <section id="exclusive-sneakers" class="exclusive-sneakers-section">
                <div class="exclusive-sneakers-container">
                    <!-- <header class="exclusive-sneakers-heading text-center">
            <h3 class="exclusive-collabs">COLLABS</h3>
            <h2 class="exclusive-section-title">Exclusieve Sneakers</h2>
            <p class="exclusive-section-subtitle">
                Ontdek onze unieke selectie van exclusieve sneakers, alleen verkrijgbaar bij Sneakerness. Laat je inspireren door stijl en innovatie.
            </p>
        </header> -->

                    <div class="exclusive-sneaker-grid">
                        <div class="exclusive-sneaker-item">
                            <figure>
                                <img src="assets/img/sneakers/exclusieve/1000_F_710340762_jxdKEAHkmLfDe6WpIzxSnAiTAoPTXIKo.png" alt="Exclusieve Sneaker - Urban Mirage" loading="lazy">
                                <figcaption>
                                    <h4>Urban Mirage</h4>
                                    <p>Een meesterwerk van design, vervaardigd uit innovatieve materialen voor ongeëvenaard comfort en stijl.</p>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="exclusive-sneaker-item">
                            <figure>
                                <img src="assets/img/sneakers/exclusieve/futuristic-nike-sneaker-red-color-digital-art-3d-render_948904-115.png" alt="Exclusieve Sneaker - Futuristic Wave" loading="lazy">
                                <figcaption>
                                    <h4>Futuristic Wave</h4>
                                    <p>Een gedurfde creatie die stijl en functionaliteit perfect combineert, een must-have voor elke sneakerliefhebber.</p>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="exclusive-sneaker-item">
                            <figure>
                                <img src="assets/img/sneakers/exclusieve/image.png" alt="Exclusieve Sneaker - Artisanal Luxe" loading="lazy">
                                <figcaption>
                                    <h4>Artisanal Luxe</h4>
                                    <p>Dit kunstwerk tilt elke outfit naar een hoger niveau met zijn verfijnde ontwerp en unieke uitstraling.</p>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="exclusive-sneaker-item">
                            <figure>
                                <img src="assets/img/sneakers/exclusieve/image2.png" alt="Exclusieve Sneaker - Everyday Elegance" loading="lazy">
                                <figcaption>
                                    <h4>Everyday Elegance</h4>
                                    <p>Deze sneaker combineert comfort met een opvallend ontwerp, perfect voor dagelijks gebruik.</p>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="exclusive-sneaker-item">
                            <figure>
                                <img src="assets/img/sneakers/exclusieve/image5.png" alt="Exclusieve Sneaker - Bold Statement" loading="lazy">
                                <figcaption>
                                    <h4>Bold Statement</h4>
                                    <p>Met zijn gedurfde kleuren en unieke stijl is deze sneaker een echte blikvanger.</p>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="exclusive-sneaker-item">
                            <figure>
                                <img src="assets/img/sneakers/exclusieve/image10.png" alt="Exclusieve Sneaker - Modern Fusion" loading="lazy">
                                <figcaption>
                                    <h4>Modern Fusion</h4>
                                    <p>Deze sneaker biedt een perfecte mix van stijl en functionaliteit, ontworpen voor de moderne consument.</p>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="exclusive-sneaker-item">
                            <figure>
                                <img src="assets/img/sneakers/exclusieve/image3.png" alt="Exclusieve Sneaker - Refined Detail" loading="lazy">
                                <figcaption>
                                    <h4>Refined Detail</h4>
                                    <p>Een verfijnde sneaker met aandacht voor detail, perfect voor elke gelegenheid.</p>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="exclusive-sneaker-item">
                            <figure>
                                <img src="assets/img/sneakers/exclusieve/image4.png" alt="Exclusieve Sneaker - Timeless Classic" loading="lazy">
                                <figcaption>
                                    <h4>Timeless Classic</h4>
                                    <p>Een tijdloze sneaker die nooit uit de mode raakt, met een luxueuze afwerking.</p>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="exclusive-sneaker-item">
                            <figure>
                                <img src="assets/img/sneakers/exclusieve/image9.png" alt="Exclusieve Sneaker - Collector's Dream" loading="lazy">
                                <figcaption>
                                    <h4>Collector's Dream</h4>
                                    <p>Met zijn unieke design en kleurenpalet is deze sneaker een must-have voor elke verzamelaar.</p>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
            </section>




        <?php else: ?>
            <p class="verbouwing"><strong>De 'Clients' sectie is momenteel in verbouwing.</strong></p>
        <?php endif; ?>
        <?php if (isSectionVisible('exclusive')): ?>
            <!-- Exclusive Underground Sneakers Section -->
            <section id="exclusive" class="row scrollto clearfix exclusive-underground wow fadeInUp" data-wow-delay="0.1s">
                <div class="row">
                    <div class=" col-12">
                        <h2>Exclusive Underground Sneakers</h2>
                        <p>
                            Deze sectie bevat de meest exclusieve en zeldzame sneakers die je nergens anders zult vinden bij
                            onze
                            vrienden bij GOAT.
                        </p>
                    </div>
                    <div class="col-12 clearfix">
                        <div class="row jc-center sneaker-grid">
                            <div class="col-3 sneaker-item wow fadeInUp">
                                <div class="sneaker-img">
                                    <img
                                        src="https://image.goat.com/transform/v1/attachments/product_template_pictures/images/078/080/262/original/12130_00.png.png?action=crop&width=300" />
                                </div>
                                <p><strong>Air Yeezy 2</strong></p>
                                <a href="https://www.goat.com/en-nl/sneakers/silhouette/air-yeezy-2"
                                    target="_blank">Link</a>
                            </div>
                            <div class="col-3 sneaker-item wow fadeInUp">
                                <div class="sneaker-img">
                                    <img
                                        src="https://image.goat.com/transform/v1/attachments/product_template_pictures/images/100/186/767/original/712868_00.png.png?action=crop&width=400" />
                                </div>
                                <p><strong>Reebok Question Mid 'Ask Allen'</strong></p>
                                <a href="https://www.goat.com/en-nl/search?query=Reebok%20Question%20Mid"
                                    target="_blank">Link</a>
                            </div>
                            <div class="col-3 sneaker-item wow fadeInUp">
                                <div class="sneaker-img">
                                    <img
                                        src="https://image.goat.com/transform/v1/attachments/product_template_additional_pictures/images/100/698/465/original/1305520_01.jpg.jpeg?action=crop&width=500" />
                                </div>
                                <p><strong>Air Jordan 17 Retro Low SP 'All Star - Lightning' 2024</strong></p>
                                <a href="https://www.goat.com/en-nl/sneakers/air-jordan-17-retro-low-sp-all-star-lightning-2024-fj0395-100"
                                    target="_blank">Link</a>
                            </div>
                            <div class="col-3 sneaker-item wow fadeInUp">
                                <div class="sneaker-img">
                                    <img
                                        src="https://image.goat.com/transform/v1/attachments/product_template_additional_pictures/images/092/006/203/original/1209354_01.jpg.jpeg?action=crop&width=500" />
                                </div>
                                <p><strong>Yeezy 500 'Bone White' 2023</strong></p>
                                <a href="https://www.goat.com/en-nl/search?query=Yeezy%20500" target="_blank">Link</a>
                            </div>
                            <div class="col-3 sneaker-item wow fadeInUp">
                                <div class="sneaker-img">
                                    <img
                                        src="https://image.goat.com/transform/v1/attachments/product_template_additional_pictures/images/089/598/804/original/1213730_01.jpg.jpeg?action=crop&width=500" />
                                </div>
                                <p><strong>Yeezy 500 'Utility Black' 2023</strong></p>
                                <a href="https://www.goat.com/en-nl/sneakers/yeezy-500-utility-black-2023-f36640-23"
                                    target="_blank">Link</a>
                            </div>
                            <div class="col-3 sneaker-item wow fadeInUp">
                                <div class="sneaker-img">
                                    <img
                                        src="https://image.goat.com/transform/v1/attachments/product_template_additional_pictures/images/102/386/154/original/1438317_01.jpg.jpeg?action=crop&width=600" />
                                </div>
                                <p><strong>Air Foamposite One 'Royal' 2024</strong></p>
                                <a href="https://www.goat.com/en-nl/sneakers/air-foamposite-one-royal-2024-fq8181-511"
                                    target="_blank">Link</a>
                            </div>
                            <div class="col-3 sneaker-item wow fadeInUp">
                                <div class="sneaker-img">
                                    <img
                                        src="https://image.goat.com/transform/v1/attachments/product_template_additional_pictures/images/102/529/460/original/1368684_01.jpg.jpeg?action=crop&width=600" />
                                </div>
                                <p><strong>Comme des Garçons Homme Plus x Air Foamposite One SP 'Cat Eye'</strong></p>
                                <a href="https://www.goat.com/en-nl/sneakers/comme-des-garcons-homme-plus-x-air-foamposite-one-sp-black-white-dj7952-002"
                                    target="_blank">Link</a>
                            </div>
                            <div class="col-3 sneaker-item wow fadeInUp">
                                <div class="sneaker-img">
                                    <img
                                        src="https://image.goat.com/transform/v1/attachments/product_template_additional_pictures/images/103/423/438/original/1397939_01.jpg.jpeg?action=crop&width=600" />
                                </div>
                                <p><strong>Air Foamposite One 'DMV Cherry Blossom'</strong></p>
                                <a href="https://www.goat.com/en-nl/sneakers/air-foamposite-one-dmv-fz9902-900"
                                    target="_blank">Link</a>
                            </div>
                            <div class="col-3 sneaker-item wow fadeInUp">
                                <div class="sneaker-img">
                                    <img
                                        src="https://image.goat.com/transform/v1/attachments/product_template_pictures/images/099/923/869/original/469553_00.png.png?action=crop&width=400" />
                                </div>
                                <p><strong>Puma Clyde Court</strong></p>
                                <a href="https://www.goat.com/en-nl/search?query=Puma%20Clyde%20Court:"
                                    target="_blank">Link</a>
                            </div>
                            <div class="col-3 sneaker-item wow fadeInUp">
                                <div class="sneaker-img">
                                    <img
                                        src="https://image.goat.com/transform/v1/attachments/product_template_additional_pictures/images/083/401/929/original/14741_01.jpg.jpeg?action=crop&width=500" />
                                </div>
                                <p><strong>Air Jordan 1 Retro High OG 'Chicago'</strong></p>
                                <a href="https://www.goat.com/en-nl/sneakers/air-jordan-1-retro-high-og-chicago-555088-101"
                                    target="_blank">Link</a>
                            </div>
                            <div class="col-3 sneaker-item wow fadeInUp">
                                <div class="sneaker-img">
                                    <img
                                        src="https://image.goat.com/transform/v1/attachments/product_template_additional_pictures/images/101/381/354/original/687698_01.jpg.jpeg?action=crop&width=500" />
                                </div>
                                <p><strong>Travis Scott x Air Jordan 6 'British Khaki'</strong></p>
                                <a href="https://www.goat.com/en-nl/sneakers/travis-scott-x-air-jordan-6-retro-british-khaki-dh0690-200"
                                    target="_blank">Link</a>
                            </div>
                            <div class="col-3 sneaker-item wow fadeInUp">
                                <div class="sneaker-img">
                                    <img
                                        src="https://image.goat.com/transform/v1/attachments/product_template_additional_pictures/images/080/458/084/original/569208_01.jpg.jpeg?action=crop&width=500" />
                                </div>
                                <p><strong>Dior x Air Jordan 1 High</strong></p>
                                <a href="https://www.goat.com/en-nl/sneakers/dior-x-air-jordan-1-high-dior-aj1-low"
                                    target="_blank">Link</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php else: ?>
            <p class="verbouwing"><strong>De 'Exclusive' sectie is momenteel in verbouwing.</strong></p>
        <?php endif; ?>

        <?php if (isSectionVisible('podium')): ?>
            <!-- Special Podium Section for Nike Mag 'Back To The Future' -->
            <section id="podium" class="row scrollto clearfix podium-section jc-center wow fadeInUp">
                <div class="clearfix podium-item wow fadeInUp">
                    <img
                        src="https://www.sneakerjagers.com/_next/image?url=https%3A%2F%2Fstatic.sneakerjagers.com%2Fnews%2Fnl%2F2022%2F07%2FOntwerp-zonder-titel-99.png&w=1080&q=100" />
                    <p><strong>Nike Mag 'Back To The Future'</strong></p>
                    <a href="https://www.goat.com/en-nl/sneakers/air-mag-back-to-the-future-417744-001"
                        target="_blank">Link</a>
                    <a href="https://www.sneakerjagers.com/n/het-verhaal-achter-de-peperdure-nike-air-mag/187769?srsltid=AfmBOop54jlDX4PitOJmmqzRzgs_sMNxoNS-UomFQQlAFdfYr524nSqX"
                        target="_blank">Learn
                        more</a>
                </div>
            </section>
            <br>
        <?php else: ?>
            <p class="verbouwing"><strong>De 'Podium' sectie is momenteel in verbouwing.</strong></p>
        <?php endif; ?>

        <?php if (isSectionVisible('stand-map-section')): ?>
            <section id="stand-map-section" class="row scrollto clearfix no-padding-bottom wow fadeInUp"
                data-wow-delay="0.1s">
                <h1>Standplattegrond</h1>
                <div id=" stand-map" class="map-container">
                    <img src="assets/img/sneaker-exit-august-2024.jpg" alt="Plattegrond van het evenement" id="map-image">
                    <!-- Dynamische verkoper-markers worden hier toegevoegd -->
                </div>
            </section>
            <br>
            <br>
        <?php else: ?>
            <p class="verbouwing"><strong>De 'Stand Map' sectie is momenteel in verbouwing.</strong></p>
        <?php endif; ?>

        <?php if (isSectionVisible('pricing')): ?>
            <!--Pricing-->
            <section id="pricing" class="secondary-color text-center scrollto clearfix">
                <div class="row clearfix">

                    <div class="col-12 section-heading">
                        <h3>JOUW SNEAKER PASS</h3>
                        <h2 class="section-title">Kies het juiste pakket voor jouw</h2>
                        <p>
                            Entree tot Sneakerness is alleen mogelijk met een geldige Sneaker Pass.
                            Kies het pakket dat het beste bij jou past bij de evenementenbalie.
                        </p>

                    </div>

                    <!--Prijsblok Student-->
                    <div class="pricing-block featured col-3 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="pricing-block-content">
                            <h3>Student Sneakerhead</h3>
                            <p class="pricing-sub">Voor studenten</p>
                            <div class="pricing">
                                <div class="price"><span> €</span>14,99</div>
                                <p>Voor studenten met echte sneakers</p>
                            </div>
                            <ul class="ticket-exclusives">
                                <li>5 Exclusieve releases per jaar</li>
                                <li>Korting op sneaker-evenementen</li>
                                <li>Toegang tot online sneaker-workshops</li>
                                <li>1 Jaar gratis updates</li>
                            </ul>
                            <a href="/login" class="button"> Koop kaartje</a>
                        </div>
                    </div>
                    <!--Einde Prijsblok-->

                    <!--Prijsblok-->
                    <div class="pricing-block col-3 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="pricing-block-content">
                            <h3>Basis Sneakerhead</h3>
                            <p class="pricing-sub">Het starterspakket</p>
                            <div class="pricing">
                                <div class="price"><span> €</span>19,99</div>
                                <p>Krijg toegang tot exclusieve sneakerreleases en communityfuncties</p>
                            </div>
                            <ul class="ticket-exclusives">
                                <li>3 Exclusieve sneakerreleases</li>
                                <li>Toegang tot online forums</li>
                                <li>1 Jaar gratis updates</li>
                                <li>Basis klantenondersteuning</li>
                            </ul>
                            <a href="/login" class="button"> Koop kaartje</a>
                        </div>
                    </div>
                    <!--Einde Prijsblok-->

                    <!--Prijsblok-->
                    <div class="pricing-block col-3 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="pricing-block-content">
                            <h3>Advanced Sneakerhead</h3>
                            <p class="pricing-sub">Meest gekozen pakket</p>
                            <div class="pricing">
                                <div class="price"><span> €</span>29,99</div>
                                <p>Diepgaande toegang tot releases en events</p>
                            </div>
                            <ul class="ticket-exclusives">
                                <li>10 Exclusieve sneakerreleases</li>
                                <li>Toegang tot alle online forums en live chats</li>
                                <li>2 Jaar gratis updates</li>
                                <li>Premium klantenondersteuning</li>
                            </ul>
                            <a href="/login" class="button"> Koop kaartje</a>
                        </div>
                    </div>
                    <!--Einde Prijsblok-->

                    <!--Prijsblok-->
                    <div class="pricing-block col-3 wow fadeInUp" data-wow-delay="0.8s">
                        <div class="pricing-block-content">
                            <h3>Pro Sneakerhead</h3>
                            <p class="pricing-sub">Voor de echte verzamelaars</p>
                            <div class="pricing">
                                <div class="price"><span> €</span>49,99</div>
                                <p>Volledige toegang tot alle exclusieve sneaker- en VIP-events</p>
                            </div>
                            <ul class="ticket-exclusives">
                                <li>Onbeperkte sneakerreleases</li>
                                <li>VIP-toegang tot evenementen</li>
                                <li>Levenslang gratis updates</li>
                                <li>24/7 VIP klantenondersteuning</li>
                            </ul>
                            <a href="/login" class="button"> Koop kaartje</a>
                        </div>
                    </div>
                    <!--Einde Prijsblok-->

                    <!-- Prijsblok Familie-->
                    <!-- <div class="pricing-block col-3 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="pricing-block-content" style="margin-bottom: 10%;">
                            <h3>Familie Sneakerhead</h3>
                            <p class="pricing-sub">Voor de hele familie</p>
                            <div class="pricing">
                                <div class="price"><span> €</span>59,99</div>
                                <p>Toegang tot releases en evenementen voor het hele gezinsleden</p>
                            </div>
                            <ul class="ticket-exclusives">
                                <li>15 Exclusieve releases per jaar</li>
                                <li>Toegang tot family events</li>
                                <li>Workshops voor alle leeftijden</li>
                                <li>2 Jaar gratis ondersteuning & updates</li>
                            </ul>
                            <a href="#" class="button"> RESERVEER NU</a>
                        </div>
                    </div> -->
                    <!--Einde Prijsblok-->

                    <!--Prijsblok-->
                    <!-- <div class="pricing-block col-3 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="pricing-block-content">
                            <h3>Business Sneakerhead</h3>
                            <p class="pricing-sub">Voor bedrijven en teams</p>
                            <div class="pricing">
                                <div class="price"><span> €</span>99,99</div>
                                <p>Complete toegang en ondersteuning voor zakelijke klanten</p>
                            </div>
                            <ul class="ticket-exclusives">
                                <li>Onbeperkte releases voor de team</li>
                                <li>Exclusieve netwerk- en VIP-events</li>
                                <li>Zakelijke accountmanager</li>
                                <li>24/7 klantenondersteuning</li>
                            </ul>
                            <a href="#" class="button"> RESERVEER NU</a>
                        </div>
                    </div> -->
                    <!--Einde Prijsblok-->

                    <!--Prijsblok Camera Crew/Interviewer-->
                    <!-- <div class="pricing-block col-3 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="pricing-block-content">
                            <h3>Journalist Pass</h3>
                            <p class="pricing-sub">Voor media- en contentteams</p>
                            <div class="pricing">
                                <div class="price"><span> €</span>199,99</div>
                                <p>Professionele toegang voor interviews en opnames tijdens evenementen</p>
                            </div>
                            <ul class="ticket-exclusives">
                                <li>Toegang tot perszones</li>
                                <li>VIP-toegang tot exclusieve releases</li>
                                <li>Speciale interviewsessies</li>
                                <li>1 Jaar gratis updates</li>
                            </ul>
                            <a href="#" class="button"> RESERVEER NU</a>
                        </div>
                    </div> -->
                    <!--Einde Prijsblok-->

                    <!--Prijsblok Horeca Stands-->
                    <!-- <div class="pricing-block col-3 wow fadeInUp" data-wow-delay="0.8s">
                        <div class="pricing-block-content">
                            <h3>Horeca Stand Pass</h3>
                            <p class="pricing-sub">Voor horecaondernemingen</p>
                            <div class="pricing">
                                <div class="price"><span> €</span>299,99</div>
                                <p>Zakelijke toegang voor food & beverage stands</p>
                            </div>
                            <ul class="ticket-exclusives">
                                <li>Toegang tot alle verkoopzones</li>
                                <li>VIP-locaties voor stand(s)</li>
                                <li>Promotie in evenementenkanaal</li>
                                <li>3 Jaar gratis ondersteuning & updates</li>
                            </ul>
                            <a href="#" class="button"> RESERVEER NU</a>
                        </div>
                    </div> -->
                    <!--Einde Prijsblok -->

                </div>
            </section>
            <br>
        <?php else: ?>
            <p class="verbouwing"><strong>De 'Pricing' sectie is momenteel in verbouwing.</strong></p>
        <?php endif; ?>

        <!-- Voeg hier extra secties toe op dezelfde manier -->

    </main>
    <!--End Main Content Area-->

    <!--contact form-->
    <section class="contact wow fadeInUp">
        <br>
        <div class="flex-direction">
            <br>
            <h3 class="contact-title">Heb je vragen? Neem contact met ons op!</h3>
            <form action="create.php" method="post" class="contact-form">
                <label for="firstname">Voornaam:</label><br>
                <input type="text" id="firstname" name="firstname" placeholder="Vul hier je voornaam in" required><br>
                <label for="lastname">Achternaam:</label><br>
                <input type="text" id="lastname" name="lastname" placeholder="Vul hier je achternaam in" required><br>
                <label for="phonenumber">Telefoonnummer:</label><br>
                <input type="tel" id="phonenumber" name="phonenumber" placeholder="BV. 0612345678" required><br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" placeholder="BV. naam@voorbeeld.nl" required><br>
                <label for="question">Stel hier je vraag:</label><br>
                <textarea id="question" name="question" placeholder="BV. waar kan ik me aanmelden voor ...?" rows="4"
                    cols="50" required></textarea><br>
                <input type="submit" value="Verzenden">
            </form>
        </div>
    </section>
    <!-- <section class="clearfix row">
        <p>
            Staat je vraag niet tussen de lijst?
            <a href="../ContactP/contact.php" class="button">
                Neem contact met ons op
            </a>
        </p>
    </section> -->


    <!--End of contact form-->

    <section class="countdown-pre-container wow fadeInRight" data-wow-delay=".9s">
        <div class="col-12 countdown-container flex">
            <div class="countdown row">
                <div class="col-3">
                    <div class="">
                        <span id="days"></span>
                        <p>D</p>
                    </div>
                </div>
                <div class="col-3">
                    <div class="">
                        <span id="hours"></span>
                        <p>Hr</p>
                    </div>
                </div>
                <div class="col-3">
                    <div class="">
                        <span id="minutes"></span>
                        <p>Min.</p>
                    </div>
                </div>
                <div class="col-3">
                    <div class="">
                        <span id="seconds"></span>
                        <p>Sec.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Footer-->
    <footer id="landing-footer" class="padding landing-footer jc-center clearfix">

        <div class="col-6">
            <p id="copyright">Made with love by<a href="/"> Team Nimród</a>
            </p>
        </div>
        <div class="media-icons col-6">
            <!--Social Icons in Footer-->
            <ul class="social-icons">
                <li>
                    <a target="_blank" title="Facebook" href="https://www.facebook.com/username">
                        <i class="fa fa-facebook fa-1x"></i><span>Facebook</span>
                    </a>
                </li>
                <li>
                    <a target="_blank" title="Google" href="http://google.com">
                        <i class="fa fa-google fa-1x"></i><span>Google</span>
                    </a>
                </li>
                <li>
                    <a target="_blank" title="Twitter" href="http://www.twitter.com/username">
                        <i class="fa fa-twitter fa-1x"></i><span>Twitter</span>
                    </a>
                </li>
                <li>
                    <a target="_blank" title="Instagram" href="http://www.instagram.com/username">
                        <i class="fa fa-instagram fa-1x"></i><span>Instagram</span>
                    </a>
                </li>
                <li>
                    <a target="_blank" title="behance" href="http://www.behance.net">
                        <i class="fa fa-behance fa-1x"></i><span>Behance</span>
                    </a>
                </li>
            </ul>
        </div>
        <!--End of Social Icons in Footer-->

    </footer>
    <!--End of Footer-->

    </div>

    <!-- Include JavaScript resources -->
    <script src="assets/js/jquery.1.8.3.min.js"></script>
    <script src="assets/Js/banner_slideshow.js"></script>
    <script src="assets/js/featherlight.min.js"></script>
    <script src="assets/js/featherlight.gallery.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/Js/Standindeling.js"></script>
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
    <script src="assets/Js/ExclusieveSneakers.js"></script>
    <script src="assets/Js/Wat_is_Sneakerness.js"></script>
    <script src="assets/Js/countdown.js"></script>

</body>

</html>