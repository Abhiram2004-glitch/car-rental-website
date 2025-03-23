<?php
session_start();
include '../shared/db_config.php';
include '../user/navbar.php'; // Include the user navbar


// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch all cars from the database
$query = "SELECT * FROM cars";
$result = $conn->query($query);

// Handle booking request submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $car_id = $_POST['car_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Calculate total hours
    $start = new DateTime($start_time);
    $end = new DateTime($end_time);
    $hours = $start->diff($end)->h + ($start->diff($end)->days * 24);

    // Fetch the car price per hour
    $car_query = "SELECT price_per_hour FROM cars WHERE car_id = $car_id";
    $car_result = $conn->query($car_query);
    $car = $car_result->fetch_assoc();
    $price_per_hour = $car['price_per_hour'];

    // Calculate total price
    $total_price = $hours * $price_per_hour;

    // Insert booking request with price per hour and total price
    $booking_query = "INSERT INTO bookings (user_id, car_id, start_time, end_time, total_price, price_per_hour) 
                      VALUES ('{$_SESSION['user_id']}', '$car_id', '$start_time', '$end_time', '$total_price', '$price_per_hour')";
    if ($conn->query($booking_query)) {
        $_SESSION['booking_success'] = "Booking request sent successfully!";
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    } else {
        $_SESSION['booking_error'] = "Error: " . $conn->error;
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    }
}
?>
<div class="container">
    <!-- User dashboard content here -->
</div>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Explore Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to toggle visibility of the time selection form
        function toggleTimeSelection(car_id) {
            const timeSelection = document.getElementById('time-selection-' + car_id);
            timeSelection.style.display = timeSelection.style.display === 'none' ? 'block' : 'none';
        }
    </script>
    <style>
        body {
            background: linear-gradient(to right, #141e30, #243b55);
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }
        
        .car-card {
            background: white;
            color: black;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            height: 100%;
        }

        .car-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .car-image {
            max-width: 100%;
            border-radius: 10px;
            height: 200px;
            object-fit: cover;
        }

        .btn-custom {
            background-color: #2a5298;
            color: white;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #1e3c72;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-4">Explore Cars</h1>

        <!-- Success or Error Messages -->
        <?php if (isset($_SESSION['booking_success'])) { ?>
            <div class="alert alert-success text-center">
                <?= $_SESSION['booking_success']; ?>
            </div>
            <?php unset($_SESSION['booking_success']); // Clear the message ?>
        <?php } ?>

        <?php if (isset($_SESSION['booking_error'])) { ?>
            <div class="alert alert-danger text-center">
                <?= $_SESSION['booking_error']; ?>
            </div>
            <?php unset($_SESSION['booking_error']); // Clear the message ?>
        <?php } ?>



        <div class="row">
            <?php while ($car = $result->fetch_assoc()) { ?>
                <div class="col-md-4 mb-4">
                    <div class="car-card d-flex flex-column">
                        <img src="../admin/uploads/<?= $car['image_path'] ?>" class="car-image" alt="<?= $car['name'] ?>">
                        <h3 class="mt-3"><?= $car['name'] ?> (<?= $car['category'] ?>)</h3>
                        <p>Price per Hour: Rs <?= htmlspecialchars($car['price_per_hour']) ?></p>
                        <p>Address: <?= htmlspecialchars($car['address']) ?></p>
                        <p>Transmission: <?= htmlspecialchars($car['transmission']) ?></p>
                        <p>Mileage: <?= htmlspecialchars($car['mileage']) ?> km/l</p>
                        <p>Seats: <?= htmlspecialchars($car['seats']) ?>-Seater</p>
                        <button class="btn btn-custom mt-auto"
                            onclick="toggleTimeSelection(<?= $car['car_id'] ?>)">Select</button>

                        <!-- Time selection form, initially hidden -->
                        <div id="time-selection-<?= $car['car_id'] ?>" style="display: none; margin-top: 20px;">
                            <form method="POST">
                                <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">
                                <div class="mb-3">
                                    <label for="start_time_<?= $car['car_id'] ?>" class="form-label">Start Time:</label>
                                    <input type="datetime-local" id="start_time_<?= $car['car_id'] ?>" name="start_time"
                                        class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="end_time_<?= $car['car_id'] ?>" class="form-label">End Time:</label>
                                    <input type="datetime-local" id="end_time_<?= $car['car_id'] ?>" name="end_time"
                                        class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-custom w-100">Book Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>