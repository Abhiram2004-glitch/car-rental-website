<?php
include '../shared/db_config.php';
include 'admin-navbar.php'; // Include the admin navbar

// Handling form submissions for adding, deleting, and editing cars
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_car'])) {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price_per_hour = $_POST['price_per_hour'];
        $address = $_POST['address'];
        $transmission = $_POST['transmission'];
        $mileage = $_POST['mileage'];
        $seats = $_POST['seats'];

        // Handling the image upload
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        // Insert the new car into the database
        $query = "INSERT INTO cars (name, category, price_per_hour, image_path, address, transmission, mileage, seats) 
                  VALUES ('$name', '$category', '$price_per_hour', '$image', '$address', '$transmission', '$mileage', '$seats')";
        $conn->query($query);
    } elseif (isset($_POST['delete_car'])) {
        // Delete car from the database
        $car_id = $_POST['car_id'];
        $query = "DELETE FROM cars WHERE car_id = '$car_id'";
        $conn->query($query);
    } elseif (isset($_POST['edit_car'])) {
        // Edit car details
        $car_id = $_POST['car_id'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price_per_hour = $_POST['price_per_hour'];
        $address = $_POST['address'];
        $transmission = $_POST['transmission'];
        $mileage = $_POST['mileage'];
        $seats = $_POST['seats'];

        // Handle image upload (optional, only if a new image is provided)
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $target = "uploads/" . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            $query = "UPDATE cars SET name='$name', category='$category', price_per_hour='$price_per_hour', image_path='$image', 
                      address='$address', transmission='$transmission', mileage='$mileage', seats='$seats' WHERE car_id='$car_id'";
        } else {
            $query = "UPDATE cars SET name='$name', category='$category', price_per_hour='$price_per_hour', address='$address', 
                      transmission='$transmission', mileage='$mileage', seats='$seats' WHERE car_id='$car_id'";
        }

        $conn->query($query);
    }
}

// Fetching the existing cars from the database
$result = $conn->query("SELECT * FROM cars");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #141e30, #243b55);
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .form-container {
            margin-bottom: 40px;
        }

        .form-container h3 {
            color: #243b55;
            margin-bottom: 20px;
        }

        .btn-custom {
            background-color: #2a5298;
            color: white;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #1e3c72;
        }

        .car-card {
            background: #f9f9f9;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .car-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .car-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .car-card-details {
            padding: 15px;
            color: #333; 
        }

        .car-card-details h5 {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .car-card-details p {
            margin-bottom: 5px;
            color: #555;
        }

        .modal-content {
            border-radius: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center text-primary mb-5">Manage Cars</h2>

        <!-- Add Car Form -->
        <div class="form-container">
            <h3>Add a New Car</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Car Name" required>
                </div>
                <div class="mb-3">
                    <select name="category" class="form-select" required>
                        <option value="SUV">SUV</option>
                        <option value="Hatchback">Hatchback</option>
                        <option value="Sedan">Sedan</option>
                        <option value="MPV">MPV</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="number" name="price_per_hour" class="form-control" placeholder="Price Per Hour"
                        required>
                </div>
                <div class="mb-3">
                    <input type="text" name="address" class="form-control" placeholder="Address of the Car" required>
                </div>
                <div class="mb-3">
                    <select name="transmission" class="form-select" required>
                        <option value="Manual">Manual</option>
                        <option value="Automatic">Automatic</option>
                        <option value="Manual">EV</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="number" name="mileage" class="form-control" placeholder="Mileage (km/l)">
                    <small class="form-text text-muted">Optional</small>
                </div>
                <div class="mb-3">
                    <input type="number" name="seats" class="form-control" placeholder="Number of Seats" required>
                </div>
                <div class="mb-3">
                    <input type="file" name="image" class="form-control" required>
                </div>
                <button type="submit" name="add_car" class="btn btn-custom w-100">Add Car</button>
            </form>
        </div>

        <!-- Existing Cars -->
        <h3>Existing Cars</h3>
        <div class="row">
            <?php while ($car = $result->fetch_assoc()) { ?>
                <div class="col-md-4 mb-4">
                    <div class="car-card">
                        <img src="uploads/<?= htmlspecialchars($car['image_path']) ?>"
                            alt="<?= htmlspecialchars($car['name']) ?>">
                        <div class="car-card-details">
                            <h5><?= htmlspecialchars($car['name']) ?> (<?= htmlspecialchars($car['category']) ?>)</h5>
                            <p>Price per Hour: Rs <?= htmlspecialchars($car['price_per_hour']) ?></p>
                            <p>Address: <?= htmlspecialchars($car['address']) ?></p>
                            <p>Transmission: <?= htmlspecialchars($car['transmission']) ?></p>
                            <p>Mileage: <?= htmlspecialchars($car['mileage']) ?> km/l</p>
                            <p>Seats: <?= htmlspecialchars($car['seats']) ?>-Seater</p>
                            <div class="d-flex justify-content-between mt-3">
                                <form method="POST">
                                    <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">
                                    <button type="submit" name="delete_car" class="btn btn-danger">Remove</button>
                                </form>
                                <button class="btn btn-custom" data-bs-toggle="modal"
                                    data-bs-target="#editCarModal<?= $car['car_id'] ?>">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editCarModal<?= $car['car_id'] ?>" tabindex="-1"
                    aria-labelledby="editCarModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCarModalLabel">Edit Car Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="car_id" value="<?= $car['car_id'] ?>">

                                    <div class="mb-3">
                                        <label for="carName" class="form-label">Car Name</label>
                                        <input type="text" id="carName" name="name" class="form-control"
                                            value="<?= htmlspecialchars($car['name']) ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="carCategory" class="form-label">Category</label>
                                        <select id="carCategory" name="category" class="form-select" required>
                                            <option value="SUV" <?= $car['category'] == 'SUV' ? 'selected' : '' ?>>SUV</option>
                                            <option value="Hatchback" <?= $car['category'] == 'Hatchback' ? 'selected' : '' ?>>
                                                Hatchback</option>
                                            <option value="Sedan" <?= $car['category'] == 'Sedan' ? 'selected' : '' ?>>Sedan
                                            </option>
                                            <option value="MPV" <?= $car['category'] == 'MPV' ? 'selected' : '' ?>>MPV</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pricePerHour" class="form-label">Price Per Hour</label>
                                        <input type="number" id="pricePerHour" name="price_per_hour" class="form-control"
                                            value="<?= $car['price_per_hour'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="carAddress" class="form-label">Address</label>
                                        <input type="text" id="carAddress" name="address" class="form-control"
                                            value="<?= $car['address'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="transmissionType" class="form-label">Transmission Type</label>
                                        <select id="transmissionType" name="transmission" class="form-select" required>
                                            <option value="Manual" <?= $car['transmission'] == 'Manual' ? 'selected' : '' ?>>
                                                Manual</option>
                                            <option value="Automatic" <?= $car['transmission'] == 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                                            <option value="EV" <?= $car['transmission'] == 'EV' ? 'selected' : '' ?>>EV</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="carMileage" class="form-label">Mileage (km/l)</label>
                                        <input type="number" id="carMileage" name="mileage" class="form-control"
                                            value="<?= $car['mileage'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="carSeats" class="form-label">Number of Seats</label>
                                        <input type="number" id="carSeats" name="seats" class="form-control"
                                            value="<?= $car['seats'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="carImage" class="form-label">Image</label>
                                        <input type="file" id="carImage" name="image" class="form-control">
                                    </div>

                                    <button type="submit" name="edit_car" class="btn btn-custom w-100">Update Car</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>