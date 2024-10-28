<?php
session_start();
include 'config/config.php'; // Verbind met je database

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Haal de evenementen op uit de database
$query = "SELECT * FROM events";
$stmt = $pdo->prepare($query);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Haal de ongelezen berichten op voor de gebruiker
$user_id = $_SESSION['user_id'];
$message_query = "SELECT id, messages FROM messages WHERE user_id = :user_id AND is_read = 0";
$message_stmt = $pdo->prepare($message_query);
$message_stmt->execute(['user_id' => $user_id]);
$messages = $message_stmt->fetchAll(PDO::FETCH_ASSOC);

$user_id = $_SESSION['user_id'];
$reservations_query = "SELECT stand_id, company_name, statuses FROM reservations WHERE user_id = :user_id";
$reservations_stmt = $pdo->prepare($reservations_query);
$reservations_stmt->execute(['user_id' => $user_id]);
$reservation = $reservations_stmt->fetchAll(PDO::FETCH_ASSOC);

// Query om het aantal ongelezen berichten op te halen
$unreadQuery = "SELECT COUNT(*) as unread_count FROM messages WHERE is_read = 0";
$stmt = $pdo->query($unreadQuery);
$unreadCount = $stmt->fetchColumn();

/// Haal de gebruikersgegevens op
$query = "SELECT * FROM users WHERE id = :user_id"; // Voeg de extra velden toe
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Verkrijg de waarden uit de database, of stel ze in als lege strings
    $username = $user['username'] ?? '';
    // Haal de profielfoto en coverfoto op uit de database
    $profile_photo = $user['profile_photo'] ?? 'assets/img/default/default-profile.png'; // Vul hier een standaard afbeelding in als placeholder
    $cover_photo = $user['cover_photo'] ?? 'assets/img/default/default-profile.jpg'; // Vul hier een standaard afbeelding in als placeholder
    $first_name = $user['first_name'] ?? '';
    $last_name = $user['last_name'] ?? '';
    $email = $user['email'] ?? '';
    $country = $user['country'] ?? '';
    $street = $user['street'] ?? '';
    $adres = $user['adres'] ?? '';
    $city = $user['city'] ?? '';
    $state_province = $user['state_province'] ?? '';
    $zip_postal_code = $user['zip_postal_code'] ?? '';
} else {
    // Als de gebruiker niet gevonden is, stel standaard waarden in
    $username = $email = $country = $street = $adres = $city = $state_province = $zip_postal_code = '';
}

file_put_contents('debug.log', $user['cover_photo'] . PHP_EOL, FILE_APPEND);

?>

<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard</title>
    <!-- <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        h2 {
            color: #555;
            margin-top: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        form {
            display: inline;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }

        .message {
            background-color: #e7f3fe;
            border-left: 5px solid #2196F3;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style> -->

</head>

<body class="h-full">

    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <!-- <div class="flex-shrink-0">
                            <img class="h-8 w-8" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                        </div> -->
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->

                                <?php
                                if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1) {
                                    echo ('<a href="/admin_dashboard" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Admin-Dashboard</a>
                                    <a href="/dashboard" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 bg-gray-900">User-Dashboard</a>
                                <a href="/" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Home</a>');
                                } else {
                                    echo ('<a href="/dashboard" class="bg-gray-900 rounded-md px-3 py-2 text-sm font-medium text-gray-300">Dashboard</a>
                                <a href="/" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Home</a>');
                                }
                                ?>
                                <!-- <a href="/admin_dashboard" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Admin-Dashboard</a> -->

                                <!-- <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Calendar</a> -->
                                <!-- <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Reports</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <!-- Belletje met dropdown-menu -->
                        <div class="relative">
                            <!-- Belletje met meldingen teller -->
                            <button type="button" id="notification-button" type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <span class="sr-only">View notifications</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                </svg>
                                <?php if ($unreadCount > 0): ?>
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-semibold leading-none text-red-100 bg-red-600 rounded-full"><?php echo $unreadCount; ?></span>
                                <?php endif; ?>
                            </button>



                            <!-- Dropdown menu voor meldingen -->
                            <div id="notification-dropdown" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="notification-button" tabindex="-1">
                                <h2 class="text-sm font-bold px-4 py-2">Meldingen</h2>
                                <div id="notification-items">
                                    <?php if (empty($messages)): ?>
                                        <p class="block px-4 py-2 text-sm text-gray-700">Geen nieuwe meldingen.</p>
                                    <?php else: ?>
                                        <ul class="mb-4">
                                            <?php foreach ($messages as $message): ?>
                                                <li class="block px-4 py-2 text-sm text-gray-700 <?php if (!$message['is_read'] = 0) echo 'font-bold'; ?>">
                                                    <?php echo htmlspecialchars($message['messages']); ?>
                                                    <form action="mark_message_read.php" method="POST" style="display:inline;">
                                                        <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                                        <button type="submit" class="text-blue-500 hover:underline">Markeer als gelezen</button>
                                                    </form>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <a href="all_messages.php" class="block px-4 py-2 text-sm text-blue-500 hover:underline text-center">Bekijk alle berichten</a>
                                </div>
                            </div>


                        </div>

                        <!-- Profielfoto met dropdown-menu -->
                        <!-- User menu -->
                        <div class="relative">
                            <button type="button" id="user-menu-button" class="relative flex items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Profile Photo">
                            </button>

                            <!-- Dropdown menu -->
                            <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-48 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700">Your Profile</a>
                                <a href="/edit_profile" class="block px-4 py-2 text-sm text-gray-700">Settings</a>
                                <a href="/logout" class="block px-4 py-2 text-sm text-gray-700">Sign out</a>
                            </div>
                        </div>

                        <!-- Drawer -->|
                        <div id="profile-drawer" class="hidden fixed inset-0 z-10 flex items-center justify-end bg-gray-500 bg-opacity-75">
                            <div class="relative w-screen max-w-md h-full bg-white shadow-xl transform transition ease-in-out duration-500 bg-red-600">
                                <!-- Cover Foto -->
                                <div class="relative h-48 bg-cover bg-center" style="background-image: url('<?php echo $user['cover_photo'] ? htmlspecialchars($user['cover_photo']) : 'assets/default/default-cover.jpg'; ?>'); background-size: cover; background-repeat: no-repeat;">

                                    <!-- Profielfoto en Naam -->
                                    <div class="absolute bottom-0 left-4 transform translate-y-1/2">
                                        <img src="<?php echo htmlspecialchars($user['profile_photo']); ?>" class="h-24 w-24 rounded-full border-4 border-white">
                                    </div>
                                </div>

                                <!-- Inhoud van het profiel -->
                                <div class="p-6 mt-12 relative overflow-hidden">
                                    <!-- <div class="absolute inset-0">
                                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/221808/sky.jpg" class="object-cover w-full h-full opacity-60" alt="Animated Background" />
                                    </div> -->
                                    <div class="relative z-10 text-center">
                                        <h1 class="text-xl font-semibold">
                                            <?php
                                            echo htmlspecialchars($user['first_name']);
                                            if (!empty($user['last_name'])) {
                                                echo ' ' . htmlspecialchars($user['last_name']);
                                            }
                                            ?>
                                        </h1>
                                        <p class="text-sm text-gray-600">@<?php echo htmlspecialchars($user['username']); ?></p>
                                        <!-- <div class="message absolute right-4 bottom-2 text-white font-serif text-lg opacity-0 fade-in" style="animation: fadeIn 1.5s forwards; animation-delay: 0.5s;">
                                            All your dreams can come true<br>if you have the courage to pursue them
                                        </div> -->
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600">Bio</p>
                                        <p class="text-gray-800 h-40 bg-gray-100 rounded-xl pl-4"><?php echo htmlspecialchars($user['about'] ?? ''); ?></p>
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600">Country</p>
                                        <p class="text-gray-800 h-6 bg-gray-100 rounded-xl pl-4"><?php echo htmlspecialchars($user['country'] ?? ''); ?></p>
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-600">Street</p>
                                            <p class="text-gray-800 h-6 bg-gray-100 rounded-xl pl-4"><?php echo htmlspecialchars($user['street'] ?? ''); ?></p>
                                        </div>
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-600">Huisnummer</p>
                                            <p class="text-gray-800 h-6 bg-gray-100 rounded-xl pl-4"><?php echo htmlspecialchars($user['adres'] ?? ''); ?></p>
                                        </div>
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-600">City</p>
                                            <p class="text-gray-800 h-6 bg-gray-100 rounded-xl pl-4"><?php echo htmlspecialchars($user['city'] ?? ''); ?></p>
                                        </div>
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-600">State/Province</p>
                                            <p class="text-gray-800 h-6 bg-gray-100 rounded-xl pl-4"><?php echo htmlspecialchars($user['state_province'] ?? ''); ?></p>
                                        </div>
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-600">Zip/Postal-code</p>
                                            <p class="text-gray-800 h-6 bg-gray-100 rounded-xl pl-4"><?php echo htmlspecialchars($user['zip_postal_code'] ?? ''); ?></p>
                                        </div>

                                        <div class="mt-4 flex items-baseline space-x-4">
                                            <a href="/edit_profile" class="rounded-md px-3 py-2 text-sm font-medium text-white bg-indigo-500 hover:bg-gray-400 hover:text-black">Edit</a>
                                            <!-- Meer profielinformatie hier -->
                                        </div>
                                    </div>

                                    <!-- <style>
                                    @keyframes fadeIn {
                                        0% {
                                            opacity: 0;
                                        }

                                        100% {
                                            opacity: 1;
                                        }
                                    }
                                </style> -->


                                    <!-- Sluitknop -->
                                    <button id="close-drawer" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>


                        </div>

                        <script>
                            // Toon de drawer
                            document.getElementById("dropdown-menu").querySelector("a").addEventListener("click", function(event) {
                                event.preventDefault();
                                document.getElementById("profile-drawer").classList.remove("hidden");
                            });

                            // Sluit de drawer
                            document.getElementById("close-drawer").addEventListener("click", function() {
                                document.getElementById("profile-drawer").classList.add("hidden");
                            });

                            document.addEventListener('DOMContentLoaded', function() {
                                // Instellingen voor het meldingen dropdown-menu
                                const notificationButton = document.getElementById('notification-button');
                                const notificationDropdown = document.getElementById('notification-dropdown');

                                notificationButton.addEventListener('click', function(event) {
                                    event.stopPropagation();
                                    notificationDropdown.classList.toggle('hidden');
                                });

                                // Sluit het meldingen dropdown-menu bij een klik buiten het menu
                                document.addEventListener('click', function(event) {
                                    if (!notificationDropdown.contains(event.target) && !notificationButton.contains(event.target)) {
                                        notificationDropdown.classList.add('hidden');
                                    }
                                });


                                // Selecteer de profielknop en het dropdown-menu voor de gebruiker
                                const profileButton = document.getElementById('user-menu-button');
                                const profileDropdown = document.getElementById('dropdown-menu');

                                // Toon of verberg het profiel dropdown-menu bij een klik op de profielknop
                                profileButton.addEventListener('click', function(event) {
                                    event.stopPropagation();
                                    profileDropdown.classList.toggle('hidden');
                                });

                                // Sluit het profiel dropdown-menu bij een klik buiten het menu
                                document.addEventListener('click', function(event) {
                                    if (!profileDropdown.contains(event.target) && !profileButton.contains(event.target)) {
                                        profileDropdown.classList.add('hidden');
                                    }
                                });
                            });
                        </script>


                        <div class="-mr-2 flex md:hidden">
                            <!-- Mobile menu button -->
                            <button type="button" class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
                                <span class="absolute -inset-0.5"></span>
                                <span class="sr-only">Open main menu</span>
                                <!-- Menu open: "hidden", Menu closed: "block" -->
                                <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                                <!-- Menu open: "block", Menu closed: "hidden" -->
                                <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu, show/hide based on menu state. -->
                <div class="md:hidden" id="mobile-menu">
                    <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <a href="#" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white" aria-current="page">Dashboard</a>
                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Team</a>
                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Projects</a>
                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Calendar</a>
                        <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Reports</a>
                    </div>
                    <div class="border-t border-gray-700 pb-3 pt-4">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Profile Photo" class="rounded-full h-12 w-12" alt="">
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium leading-none text-white">Tom Cook</div>
                                <div class="text-sm font-medium leading-none text-gray-400">tom@example.com</div>
                            </div>
                            <button type="button" class="relative ml-auto flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">View notifications</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-3 space-y-1 px-2">
                            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Your Profile</a>
                            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Settings</a>
                            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Sign out</a>
                        </div>
                    </div>
                </div>
        </nav>

        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Dashboard</h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 rounded-2xl mb-4 shadow-lg">
                    <div class="grid">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900 mb-4 text-center">Beschikbare Evenementen</h2>
                        <ul class="flex justify-center space-x-4">
                            <?php foreach ($events as $event): ?>
                                <li class="bg-gray-300 p-4 rounded-2xl shadow-lg flex flex-col items-center text-center w-60">
                                    <!-- Controleer het evenement-ID en voeg de juiste afbeelding toe met vaste hoogte en breedte -->
                                    <?php if ($event['id'] == 1): ?>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/60/Rotterdam_van_nelle_fabriek.jpg" alt="Van Nelle Fabriek" class="w-full h-40 object-cover rounded-md mb-3">
                                    <?php elseif ($event['id'] == 2): ?>
                                        <img src="https://kep.cdn.indexvas.hu/welove-media/dc/2022-09-millenaris-g-dron-217.exact1980w.jpg" alt="Milenáris Budapest" class="w-full h-40 object-cover rounded-md mb-3">
                                    <?php endif; ?>

                                    <!-- Evenement naam en datum -->
                                    <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($event['name']); ?></p>
                                    <p class="text-gray-600 mb-3">Datum: <?php echo htmlspecialchars($event['start_date']); ?></p>

                                    <!-- Link om een stand te huren -->
                                    <a href="reserve_stand.php?event_id=<?php echo $event['id']; ?>" class="text-blue-500 hover:text-blue-700 font-medium">Stand huren</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl mb-4 shadow-lg">
                    <div class="flex grid">
                        <ul>
                            <?php foreach ($reservation as $reservations): ?>
                                <li>
                                    <?php echo htmlspecialchars($reservations['company_name']); ?>
                                    <?php echo htmlspecialchars($reservations['stand_id']); ?>
                                    <?php echo htmlspecialchars($reservations['statuses']); ?>
                                    <form action="mark_message_read.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="reservations_id" value="<?php echo $reservations['stand_id']; ?>">
                                        <!-- <button type="submit">Markeer als gelezen</button> -->
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
        </main>
</body>

</html>