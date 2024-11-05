<?php
// Zorg ervoor dat de sessie wordt gestart en dat het evenement wordt opgehaald (zie eerdere code voor validatie en ophalen van het evenement)
session_start();
include 'config/config.php';

// Zorg ervoor dat alleen admins toegang hebben
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit();
}

$event_id = $_GET['event_id'] ?? null;

if (!$event_id) {
    header('Location: events.php');
    exit();
}

$query = "SELECT * FROM events WHERE id = :event_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['event_id' => $event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    header('Location: events.php');
    exit();
}

// Verwerken van het formulier voor het bewerken van het evenement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    // $cover_photo = $_FILES['cover_photo']['name'] ?? $event['cover_photo'];

    // // Sla de nieuwe coverfoto op als deze is geüpload
    // if ($_FILES['cover_photo']['name']) {
    //     $target_dir = "uploads/";
    //     $target_file = $target_dir . basename($_FILES["cover_photo"]["name"]);
    //     move_uploaded_file($_FILES["cover_photo"]["tmp_name"], $target_file);
    // }

    // Update het evenement in de database
    $update_query = "UPDATE events SET name = :name, start_date = :start_date, end_date = :end_date WHERE id = :event_id";
    $stmt = $pdo->prepare($update_query);
    $stmt->execute([
        'name' => $name,
        'start_date' => $start_date,
        'end_date' => $end_date,
        // 'cover_photo' => $cover_photo,
        'event_id' => $event_id
    ]);

    // Redirect naar de evenementenlijst na het bijwerken
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evenement Bewerken</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Main content -->
    <div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-xl shadow-md">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Evenement Bewerken</h2>

        <!-- Event Edit Form -->
        <form action="edit_event.php?event_id=<?php echo $event['id']; ?>" method="POST" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Event Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Naam van het evenement</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event['name']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <!-- Start Date -->
                <div class="mb-4">
                    <label for="start_date" class="block text-gray-700 font-medium mb-2">Startdatum</label>
                    <input type="date" id="start_date" name="start_date" value="<?php echo $event['start_date']; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <!-- End Date -->
                <div class="mb-4">
                    <label for="end_date" class="block text-gray-700 font-medium mb-2">Einddatum</label>
                    <input type="date" id="end_date" name="end_date" value="<?php echo $event['end_date']; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <!-- Cover Photo -->
                <!-- <div class="mb-4">
                    <label for="cover_photo" class="block text-gray-700 font-medium mb-2">Omslagfoto</label>
                    <input type="file" id="cover_photo" name="cover_photo" class="w-full text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php if ($event['cover_photo']): ?>
                        <p class="mt-2 text-gray-500">Huidige foto: <img src="uploads/<?php echo $event['cover_photo']; ?>" alt="Cover Foto" class="w-32 h-32 object-cover mt-2 rounded-lg"></p>
                    <?php endif; ?>
                </div> -->
            </div>

            <!-- Submit Button -->
            <div class="mt-6 text-right">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Evenement bijwerken</button>
            </div>
        </form>
    </div>

</body>

</html>