<?php
include 'admin-navbar.php'; // Include the admin navbar
?>
<div class="container">
    <!-- Admin-specific content here -->
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: white;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .dashboard-title {
            font-weight: bold;
            font-size: 32px;
            margin-bottom: 30px;
        }
        .card {
            background: white;
            color: black;
            border-radius: 12px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            font-size: 20px;
            font-weight: 600;
        }
        .btn-custom {
            background-color: #2a5298;
            color: white;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-custom:hover {
            background-color: #1e3c72;
        }
        .row {
            gap: 20px;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h2 class="dashboard-title">Welcome to the Admin Dashboard</h2>
        <div class="row justify-content-center">
            <!-- Manage Cars -->
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h5 class="card-title">Manage Cars</h5>
                    <p class="card-text">Add, remove, and edit car details.</p>
                    <a href="manage_cars.php" class="btn btn-custom w-100">Go</a>
                </div>
            </div>
            <!-- Manage Booking Requests -->
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <h5 class="card-title">Manage Booking Requests</h5>
                    <p class="card-text">Approve or reject user booking requests.</p>
                    <a href="manage_requests.php" class="btn btn-custom w-100">Go</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
