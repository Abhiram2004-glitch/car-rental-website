
<?php
include '../user/navbar.php'; // Include the user navbar
include '../shared/db_config.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Updated query to order by the latest booking
$query = "SELECT b.*, c.name AS car_name, c.category, c.price_per_hour 
          FROM bookings b 
          JOIN cars c ON b.car_id = c.car_id 
          WHERE b.user_id = '{$_SESSION['user_id']}'
          ORDER BY b.created_at DESC"; // Assuming 'created_at' column exists

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Booking History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #141e30, #243b55);
            color: white;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .table th, .table td {
            text-align: center;
        }
        .table {
            background-color: white;
            color: black;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #2a5298;
            color: white;
        }
        .table td {
            background-color: #f8f9fa;
        }
        .table-hover tbody tr:hover {
            background-color: #ddd;
        }
        .no-bookings {
            color: #ccc;
            font-size: 18px;
            text-align: center;
        }
        h2 {
            text-align: center;
            color: #fff;
        }
        .back-btn {
            margin-top: 20px;
            background-color: #2a5298;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }
        .back-btn:hover {
            background-color: #1e3c72;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Your Booking History</h2>
    
    <?php if ($result->num_rows > 0) { ?>
        <table class="table table-hover mt-4">
            <thead>
                <tr>
                    <th>Car</th>
                    <th>Category</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($booking = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $booking['car_name'] ?></td>
                        <td><?= $booking['category'] ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($booking['start_time'])) ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($booking['end_time'])) ?></td>
                        <td><?= $booking['status'] ?></td>
                        <td>
                            <?php
                            if ($booking['status'] === 'Approved') {
                                $hours = (strtotime($booking['end_time']) - strtotime($booking['start_time'])) / 3600;
                                echo "Rs" . number_format($hours * $booking['price_per_hour'], 2);
                            } else {
                                echo "-";
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="no-bookings">No booking history found.</p>
    <?php } ?>
    
    <a href="dashboard.php"><button class="back-btn">Back to Dashboard</button></a>
</div>
</body>
</html>
