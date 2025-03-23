<?php
include '../shared/db_config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>GoodCar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f5f5f5;
        }

        .hero {
            position: relative;
            height: 100vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
        }

        #background-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .overlay {
            position: relative;
            z-index: 1;
            background: rgba(0, 0, 0, 0.5);
            /* Adds a dark overlay for better text visibility */
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }


        .hero h1 span {
            display: inline-block;
            animation: fadeIn 1s forwards;
            opacity: 2;
            color: darkblue;
            font-style: bold;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .hero .btn {
            padding: 12px 25px;
            font-size: 1rem;
            border-radius: 25px;
            transition: background-color 0.3s ease;
        }

        .hero .btn:hover {
            background-color: #0056b3;
        }

        .services,
        .featured-cars,
        .testimonials {
            padding: 60px 0;
        }

        .services h2,
        .featured-cars h2,
        .testimonials h2 {
            text-align: center;
            margin-bottom: 40px;
            font-weight: bold;
            color: #333;
        }

        .footer {
            background: #2a5298;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }

        .footer a {
            color: white;
            text-decoration: none;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card img {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #1e90ff;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .testimonials p {
            font-style: italic;
            color: #555;
        }

        .testimonials strong {
            display: block;
            margin-top: 10px;
            color: #333;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">GoodCar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#featured">Featured Cars</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Background Video -->
    <section class="hero">
        <video autoplay muted loop id="background-video">
            <source src="videoplayback.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="overlay">
            <div class="container text-center">
                <h1 id="animated-text"></h1>
                <script>
                    const text = "Find Your Perfect Ride";
                    const target = document.getElementById("animated-text");

                    function animateText() {
                        target.innerHTML = "";
                        text.split("").forEach((char, i) => {
                            const span = document.createElement("span");
                            span.textContent = char;
                            span.style.animationDelay = `${i * 0.1}s`;
                            target.appendChild(span);
                        });
                        setTimeout(() => {
                            target.innerHTML = "";
                            animateText();
                        }, (text.length * 100) + 2000);
                    }

                    animateText();
                </script>
                <p>Explore a wide range of cars for every occasion. Affordable, reliable, and convenient.</p>
                <a href="signup.php" class="btn btn-light">Sign Up to Get Started</a>
            </div>
        </div>
    </section>


    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <h2>Why Choose Us?</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="card p-4">
                        <h4>Wide Selection of Cars</h4>
                        <p>Choose from sedans, SUVs, hatchbacks, and more.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4">
                        <h4>Competitive Prices</h4>
                        <p>Affordable pricing for every type of vehicle.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4">
                        <h4>Easy Booking Process</h4>
                        <p>Book your car in just a few clicks.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Cars Section -->
    <section id="featured" class="featured-cars">
        <div class="container">
            <h2>Featured Cars</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="amaze.png" class="card-img-top" alt="Sedan">
                        <div class="card-body">
                            <h5 class="card-title">Sedan</h5>
                            <p class="card-text">Rs 40/hour</p>
                            <a href="dashboard.php" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="helevate.jpg" class="card-img-top" alt="SUV">
                        <div class="card-body">
                            <h5 class="card-title">SUV</h5>
                            <p class="card-text">Rs 60/hr</p>
                            <a href="dashboard.php" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="alto.jpg" class="card-img-top" alt="Hatchback">
                        <div class="card-body">
                            <h5 class="card-title">Hatchback</h5>
                            <p class="card-text">Rs 30/hr</p>
                            <a href="dashboard.php" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <h2>What Our Customers Say</h2>
            <div class="row">
                <div class="col-md-6">
                    <p>"Excellent service! The car was in perfect condition, and the booking process was seamless."</p>
                    <strong>- Prateek Mangalgi</strong>
                </div>
                <div class="col-md-6">
                    <p>"Affordable prices and a wide variety of cars to choose from. Highly recommend!"</p>
                    <strong>- Pritam Palai</strong>
                </div>
                <div class="col-md-6">
                    <p>"Gives you the freedom of self-drive! With the cheapest rental car solutions, Good Cars has the
                        best offers, cheapest prices and a wide range of cars to choose from."</p>
                    <strong>- Abhiram Karanth</strong>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <p>&copy; 2024 Good Cars. All rights reserved.</p>
        <p>Address: DSATM, BANGALORE</p>
        <p>Phone: +9198765432</p>
        <p>Email: contact@carrental.com</p>
        <p>
            <a href="https://facebook.com" target="_blank">Facebook</a> |
            <a href="https://twitter.com" target="_blank">Twitter</a> |
            <a href="https://instagram.com" target="_blank">Instagram</a>
        </p>
        <p><a href="terms.php" class="text-white">Terms & Conditions</a></p>
    </footer>
</body>

</html>