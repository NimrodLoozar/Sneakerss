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

$sql = "SELECT r.id, r.company_name, s.stand_number, p.plain_name, r.statuses FROM reservations r
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
  <link href="assets/css/animate.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
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
    <header id="bannerFAQ" class="scrollto clearfix" data-enllax-ratio=".5">
      <div id="headerFAQ" class="nav-collapse">
        <div class="">
          <div class="">
            <!--Logo-->
            <div id="logo">
              <!--Logo that is shown on the banner-->
              <a href="/">
                <svg class="img-fluid" viewBox="0 0 410 54" version="1.1" xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink">
                  <g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Logo_Black" transform="translate(-115.000000, -138.000000)" fill="#fff">
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
                  <a href="/" class="links">Home</a>
                  <ul class="dropdown">
                    <li><a href="/#about">About</a></li>
                    <li><a href="/#services">Services</a></li>
                    <li><a href="/#testimonials">Testimonials</a></li>
                    <li><a href="/#clients">Clients</a></li>
                    <li><a href="/#sneaker">Exclusive</a></li>
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
                  <a href="#" class="active links">FAQ</a>
                </li>
                <li>
                  <a href="/pre-order-waitlist" class="links">Pre-order nu!</a>
                </li>
              </ul>
              <div id="progress-bar"></div>
            </nav>
            <!--End of Main Navigation-->

            <div id="nav-trigger"><span></span></div>
            <nav id="nav-mobileFAQ"></nav>

          </div>
        </div>
      </div><!--End of Header-->

      <!--Banner Content-->
      <div id="banner-content" class="row clearfix">

        <div class="col-38">

          <div class="section-headingFAQ">
            <h1>Welkom bij de FAQ Page</h1>
            <h2>Jouw ultieme sneakerbestemming</h2>
            <!-- <p>Meeste gestelde vragen hier te vinden , zo niet kunt u altijd nog bellen naar
              (Telefoonnummer) of
              Eventueel een mailtje sturen naar *ons Mail* </p> -->
          </div>
        </div>
      </div><!--End of Row-->
    </header>
  </div>
  <div class="video">
    <video class="myVideo" src="assets/img/banner-images/SNEAKERNESS-Main-Teaser-HP_comp.mp4" loop autoplay
      muted></video>
  </div>





  <!--Main Content Area-->
  <main id="content">
    <!--Introduction-->
    <section class="introductionFAQ scrollto">
      <div class="absolute clearfix">
        <div class="col-3">
          <div class="faq-container wow fadeInUp" data-wow-delay="0.2s">
            <h1>FAQ Zoeken</h1>
            <input type="text" id="searchInput" placeholder="Zoek in de FAQ..." />
            <button id="searchButton" onclick="searchFAQ()">Zoek</button>
            <div id="resultSection">
              <div id="error-message" class="no-results" style="display: none;">Geen resultaten gevonden.</div>

              <section class="faq-section">
                <div class="container">
                  <!-- <h2></h2> -->
                  <div class="faq">
                    <!-- FAQ 1-10 -->
                    <div class="faq-item hidden">
                      <h3>Wat is de levertijd van mijn sneakers?<span class="arrow">&#10095;</span></h3>
                      <p>
                        De levertijd is doorgaans 2-5 werkdagen, afhankelijk van je locatie en beschikbaarheid van
                        het
                        product.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Welke betaalmethodes accepteren jullie?<span class="arrow">&#10095;</span></h3>
                      <p>Wij accepteren iDeal, creditcard, PayPal en Klarna voor achteraf betalen.</p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Hoe kan ik mijn bestelling retourneren?<span class="arrow">&#10095;</span></h3>
                      <p>Retourneren kan binnen 30 dagen, mits de sneakers ongedragen en in de originele verpakking
                        zijn.</p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Hebben jullie een fysieke winkel?<span class="arrow">&#10095;</span></h3>
                      <p>We zijn volledig online, maar bieden snelle verzending en eenvoudig retourneren.</p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Bieden jullie ook maatwerk sneakers aan?<span class="arrow">&#10095;</span></h3>
                      <p>
                        Ja, we bieden maatwerkopties voor geselecteerde modellen. Bekijk onze maatwerkpagina voor
                        meer
                        informatie.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Hoe kan ik mijn bestelling volgen?<span class="arrow">&#10095;</span></h3>
                      <p>
                        Nadat je bestelling is verzonden, ontvang je een track & trace-code via e-mail om je pakket
                        te
                        volgen.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Krijg ik een bevestiging van mijn bestelling?<span class="arrow">&#10095;</span></h3>
                      <p>Ja, je ontvangt een bevestigingsmail zodra je bestelling is geplaatst.</p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Kan ik mijn bestelling nog wijzigen na het plaatsen?<span class="arrow">&#10095;</span></h3>
                      <p>
                        Je kunt je bestelling binnen 1 uur na plaatsing wijzigen. Neem contact op met onze
                        klantenservice
                        voor hulp.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Wat moet ik doen als ik de verkeerde maat heb besteld?<span class="arrow">&#10095;</span>
                      </h3>
                      <p>
                        Als je de verkeerde maat hebt besteld, kun je de sneakers retourneren en de juiste maat
                        bestellen.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Verzenden jullie internationaal?<span class="arrow">&#10095;</span></h3>
                      <p>Ja, we verzenden wereldwijd. De verzendkosten en levertijden variëren per land.</p>
                    </div>

                    <!-- FAQ 11-20 -->
                    <div class="faq-item hidden">
                      <h3>Wat zijn de verzendkosten?<span class="arrow">&#10095;</span></h3>
                      <p>
                        Verzending binnen Nederland is gratis. Voor internationale bestellingen worden de kosten
                        berekend bij
                        het afrekenen.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Kan ik mijn sneakers retourneren als ze niet passen?<span class="arrow">&#10095;</span></h3>
                      <p>Ja, je kunt de sneakers binnen 30 dagen retourneren als ze niet passen.</p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Hoe lang duurt het voordat mijn retour is verwerkt?<span class="arrow">&#10095;</span></h3>
                      <p>Het verwerken van een retour duurt meestal 5-7 werkdagen nadat we het pakket hebben
                        ontvangen.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Krijg ik mijn geld terug als ik retourneer?<span class="arrow">&#10095;</span></h3>
                      <p>Ja, je krijgt een volledige terugbetaling binnen 7 dagen nadat je retour is verwerkt.</p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Kan ik sneakers reserveren?<span class="arrow">&#10095;</span></h3>
                      <p>
                        We bieden geen reserveringen aan, maar je kunt je aanmelden voor een notificatie als een
                        model
                        weer
                        op voorraad is.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Bieden jullie cadeaubonnen aan?<span class="arrow">&#10095;</span></h3>
                      <p>Ja, we bieden digitale cadeaubonnen aan die je online kunt gebruiken.</p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Hoe kan ik contact opnemen met de klantenservice?<span class="arrow">&#10095;</span></h3>
                      <p>Je kunt ons bereiken via e-mail of de live chat op onze website.</p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Hoe weet ik welke maat ik moet kiezen?<span class="arrow">&#10095;</span></h3>
                      <p>Gebruik onze maattabel op de productpagina om de juiste maat te vinden.</p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Hoe onderhoud ik mijn sneakers?<span class="arrow">&#10095;</span></h3>
                      <p>
                        Bekijk onze onderhoudsgids op de website voor tips over het schoonmaken en verzorgen van je
                        sneakers.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Zijn jullie sneakers duurzaam geproduceerd?<span class="arrow">&#10095;</span></h3>
                      <p>
                        We werken samen met merken die duurzame productiemethoden hanteren. Bekijk de productdetails
                        voor
                        meer informatie.
                      </p>
                    </div>

                    <!-- FAQ 21-30 -->
                    <div class="faq-item hidden">
                      <h3>Kunnen jullie maatwerk sneakers repareren?<span class="arrow">&#10095;</span></h3>
                      <p>Ja, we bieden een reparatieservice voor maatwerk sneakers. Neem contact op voor meer
                        informatie.</p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Zijn alle sneakers op voorraad?<span class="arrow">&#10095;</span></h3>
                      <p>
                        Onze voorraad wordt regelmatig bijgewerkt. Als een model niet op voorraad is, kun je een
                        notificatie
                        aanvragen.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Hoe kan ik een account aanmaken?<span class="arrow">&#10095;</span></h3>
                      <p>Je kunt een account aanmaken door je te registreren via de aanmeldpagina op onze website.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Hebben jullie een loyaliteitsprogramma?<span class="arrow">&#10095;</span></h3>
                      <p>
                        Ja, we bieden een loyaliteitsprogramma waarbij je punten kunt sparen voor korting op
                        toekomstige
                        aankopen.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Hoe kan ik mijn accountgegevens wijzigen?<span class="arrow">&#10095;</span></h3>
                      <p>Log in op je account en ga naar "Accountinstellingen" om je gegevens te wijzigen.</p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Wat moet ik doen als mijn sneakers beschadigd aankomen?<span class="arrow">&#10095;</span>
                      </h3>
                      <p>
                        Neem binnen 48 uur na ontvangst contact met ons op met foto’s van de beschadiging voor een
                        snelle
                        oplossing.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Kan ik sneakers pre-orderen?<span class="arrow">&#10095;</span></h3>
                      <p>
                        Ja, we bieden pre-orders aan voor geselecteerde sneakers. Je kunt de verwachte levertijd
                        zien
                        op
                        de
                        productpagina.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Wat zijn de voordelen van een account bij Sneakerss?<span class="arrow">&#10095;</span></h3>
                      <p>Met een account kun je je bestellingen volgen, eerdere aankopen bekijken en sneller
                        afrekenen.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>Hoe weet ik of mijn betaling is gelukt?<span class="arrow">&#10095;</span></h3>
                      <p>
                        Na een succesvolle betaling ontvang je een bevestigingsmail. Controleer je spamfolder als je
                        niets
                        ontvangt.
                      </p>
                    </div>
                    <div class="faq-item hidden">
                      <h3>
                        Kunnen jullie aanpassingen doen op reeds gemaakte bestellingen?
                        <span class="arrow">&#10095;</span>
                      </h3>
                      <p>
                        Bestellingen kunnen binnen 1 uur na plaatsing worden aangepast. Neem contact op met de
                        klantenservice.
                      </p>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>

          <section class="clearfix row">
            <p>Staat je vraag niet tussen de lijst?
              <br>
              <a href="/index.html" class="button">Neem contact met ons op</a>
            </p>
          </section>
        </div>
      </div>
    </section>
  </main>

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

  <!-- Include JavaScript resources -->
  <script src="assets/Js/countdown.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="assets/Js/faq_search.js"></script>
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
</body>

</html>