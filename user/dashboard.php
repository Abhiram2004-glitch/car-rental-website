<?php
include '../user/navbar.php'; // Include the user navbar
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to login if not signed in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #141e30, #243b55);
            color: white;
            font-family: 'Roboto', sans-serif;
        }
        h2 {
            font-weight: bold;
            margin-bottom: 30px;
        }
        .card {
            background: #ffffff;
            color: #2a2a2a;
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #1e90ff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1rem;
            margin-bottom: 15px;
        }
        .container {
            max-width: 900px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Welcome to the User Dashboard</h2>
        <div class="row mt-4 g-4">
            <!-- Browse and Book Cars -->
            <div class="col-md-6">
                <div class="card text-center p-4">
                    <div class="card-body">
                        <h5 class="card-title">Browse Cars</h5>
                        <p class="card-text">View and book available cars from our extensive collection.</p>
                        <a href="explore_cars.php" class="btn btn-primary">Explore</a>
                    </div>
                </div>
            </div>
            <!-- View Booking Requests -->
            <div class="col-md-6">
                <div class="card text-center p-4">
                    <div class="card-body">
                        <h5 class="card-title">My Bookings</h5>
                        <p class="card-text">Check your booking history and monitor the status of your requests.</p>
                        <a href="booking_requests.php" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</body>
</html>
