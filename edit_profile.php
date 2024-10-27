<?php
session_start();
include 'config/config.php'; // Verbind met je database

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Aannemen dat je de gebruikers-ID hebt opgeslagen in de sessie
$user_id = $_SESSION['user_id'];

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
    $password = $user['password'] ?? '';
    $country = $user['country'] ?? '';
    $street = $user['street'] ?? '';
    $email = $user['email'] ?? '';
    $adres = $user['adres'] ?? '';
    $about = $user['about'] ?? '';
    $city = $user['city'] ?? '';
    $state_province = $user['state_province'] ?? '';
    $zip_postal_code = $user['zip_postal_code'] ?? '';
} else {
    // Als de gebruiker niet gevonden is, stel standaard waarden in
    $username = $email = $country = $street = $adres = $city = $state_province = $zip_postal_code = '';
}

?>
<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>


<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <?php
                                if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1) {
                                    echo ('<a href="/admin_dashboard" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Admin-Dashboard</a>
                                    <a href="/dashboard" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">User-Dashboard</a>
                                ');
                                } else {
                                    echo ('<a href="/dashboard" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Dashboard</a>
                                ');
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="md:hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                    <?php
                    if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1) {
                        echo ('<a href="/admin_dashboard" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Admin-Dashboard</a>
                                    <a href="/dashboard" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">User-Dashboard</a>
                                ');
                    } else {
                        echo ('<a href="/dashboard" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Dashboard</a>
                                ');
                    }
                    ?>
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
                <!--
                  This example requires some changes to your config:

                  ```
                  // tailwind.config.js
                  module.exports = {
                    // ...
                    plugins: [
                      // ...
                      require('@tailwindcss/forms'),
                    ],
                  }
                  ```
                -->

                <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-12">
                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-4">
                                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                                    <div class="mt-2">
                                        <input type="text" name="username" id="username" autocomplete="username" class="block w-full pl-3 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($username); ?>" autocomplete="username" placeholder="<?php echo htmlspecialchars($username); ?>">
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <label for="about" class="block text-sm font-medium leading-6 text-gray-900">About</label>
                                    <div class="mt-2">
                                        <textarea id="about" name="about" rows="3" class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($about); ?>" autocomplete="about" placeholder="Tell us something about your Company."></textarea>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">Photo</label>
                                    <div class="mt-2 flex items-center gap-x-3">
                                        <svg class="h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                                        </svg>
                                        <label for="profile_photo" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 cursor-pointer">
                                            Change
                                            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="sr-only">
                                        </label>
                                    </div>
                                </div>


                                <div class="col-span-full">
                                    <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Cover photo</label>
                                    <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                        <div class="text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                                <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                                    <span>Upload a file</span>
                                                    <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="col-span-full">
                                    <label for="profile-photo" class="block text-sm font-medium leading-6 text-gray-900">Profile Photo</label>
                                    <input type="file" name="profile_photo" id="profile-photo" accept="image/*" class="mt-2">
                                </div>

                                <div class="col-span-full">
                                    <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Cover Photo</label>
                                    <input type="file" name="cover_photo" id="cover-photo" accept="image/*" class="mt-2">
                                </div> -->
                            </div>
                        </div>

                        <div class="border-b border-gray-900/10 pb-12">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">First Name</label>
                                    <input type="text" name="first_name" id="first-name" class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($first_name); ?>" autocomplete="first_name" placeholder="<?php echo htmlspecialchars($first_name ?: ''); ?>">
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Last Name</label>
                                    <input type="text" name="last_name" id="last-name" class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" value="<?php echo htmlspecialchars($last_name); ?>" autocomplete="last_name" placeholder="<?php echo htmlspecialchars($last_name ?: ''); ?>">
                                </div>

                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium leading-6 text-gray-900" for="email">E-mail:</label>
                                    <input class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" autocomplete="email" placeholder="<?php echo htmlspecialchars($email ?: ''); ?>">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium leading-6 text-gray-900" for="password">Wachtwoord:</label>
                                    <input class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="password" id="password" name="password" placeholder="Voer nieuw wachtwoord in (laat leeg om te behouden)">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium leading-6 text-gray-900" for="country">Land:</label>
                                    <input class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="text" id="country" name="country" value="<?php echo htmlspecialchars($country); ?>" autocomplete="country" placeholder="<?php echo htmlspecialchars($country ?: ''); ?>">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium leading-6 text-gray-900" for="street">Straat:</label>
                                    <input class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="text" id="street" name="street" value="<?php echo htmlspecialchars($street); ?>" autocomplete="street" placeholder="<?php echo htmlspecialchars($street ?: ''); ?>">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium leading-6 text-gray-900" for="address">Huisnummer:</label>
                                    <input class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="text" id="address" name="address" value="<?php echo htmlspecialchars($adres); ?>" autocomplete="adres" placeholder="<?php echo htmlspecialchars($adres ?: ''); ?>">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium leading-6 text-gray-900" for="city">Stad:</label>
                                    <input class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>" autocomplete="city" placeholder="<?php echo htmlspecialchars($city ?: ''); ?>">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium leading-6 text-gray-900" for="state_province">Staat / Provincie:</label>
                                    <input class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="text" id="state_province" name="state_province" value="<?php echo htmlspecialchars($state_province); ?>" autocomplete="username" placeholder="<?php echo htmlspecialchars($state_province ?: ''); ?>">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium leading-6 text-gray-900" for="zip_postal_code">Postcode:</label>
                                    <input class="pl-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="text" id="zip_postal_code" name="zip_postal_code" value="<?php echo htmlspecialchars($zip_postal_code); ?>" autocomplete="zip_postal_code" placeholder="<?php echo htmlspecialchars($zip_postal_code ?: ''); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-between items-center">
                            <!-- Delete Profile button (links) -->
                            <button type="button" onclick="confirmDelete()" class="rounded-md bg-red-600 px-3 py-2 text-white">
                                Delete Profile
                            </button>

                            <div class="flex gap-3 ml-auto">
                                <!-- Cancel button (rechts, naast Save) -->
                                <button type="button" onclick="window.location.href='dashboard.php'" class="rounded-md bg-gray-600 px-3 py-2 text-white">
                                    Cancel
                                </button>

                                <!-- Save button (helemaal rechts) -->
                                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-white">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <script>
                    function confirmDelete() {
                        if (confirm('Are you sure you want to delete your profile? This action cannot be undone.')) {
                            window.location.href = 'delete_profile.php';
                        }
                    }
                </script>



            </div>
        </main>
    </div>

</body>

</html>