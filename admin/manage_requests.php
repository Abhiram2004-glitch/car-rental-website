<?php
include '../shared/db_config.php';
include 'admin-navbar.php';

$query = "SELECT b.*, u.username, c.name AS car_name 
          FROM bookings b 
          JOIN users u ON b.user_id = u.user_id 
          JOIN cars c ON b.car_id = c.car_id";
$result = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $conn->real_escape_string($_POST['booking_id']);
    $status = $conn->real_escape_string($_POST['status']);

    // Check if the current booking status is still 'Pending'
    $check_query = "SELECT status FROM bookings WHERE booking_id = '$booking_id'";
    $check_result = $conn->query($check_query);
    $current_status = $check_result->fetch_assoc()['status'];

    if ($current_status === 'Pending') {
        $query = "UPDATE bookings SET status = '$status' WHERE booking_id = '$booking_id'";
        if ($conn->query($query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        // Optional: Display a message or handle cases where the status is no longer 'Pending'
        echo "<script>alert('The booking status has already been updated.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Booking Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: white;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            color: white;
        }
        .table {
            background-color: white;
            color: black;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn {
            margin: 5px;
            padding: 8px 15px;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Booking Requests</h2>
    <?php if ($result->num_rows > 0) { ?>
        <table class="table table-hover mt-4">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Car</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($request = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $request['username'] ?></td>
                        <td><?= $request['car_name'] ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($request['start_time'])) ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($request['end_time'])) ?></td>
                        <td><?= $request['status'] ?></td>
                        <td>
                            <?php if ($request['status'] == 'Pending') { ?>
                                <form method="POST">
                                    <input type="hidden" name="booking_id" value="<?= $request['booking_id'] ?>">
                                    <button type="submit" name="status" value="Approved" class="btn btn-success">Approve</button>
                                    <button type="submit" name="status" value="Rejected" class="btn btn-danger">Reject</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No booking requests found.</p>
    <?php } ?>
</div>
</body>
</html>
