<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System</title>
    <style>
        /* styles.css */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #0C0910;
            line-height: 1.6;
            background-color: #f9f9f9;
        }

        .header {
            background: #0C0910;
            color: #fff;
            padding: 1rem 0;
        }

        .header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            font-size: 2rem;
            font-weight: bold;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 1rem;
            transition: color 0.3s ease;
        }

        .navbar a:hover {
            color: #ffcc00;
        }

        .navbar .btn {
            background: #ffcc00;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        .navbar .btn:hover {
            background: #ff9900;
        }

        .hero {
            background: url(imag_6-removebg-preview_enhanced.png) no-repeat center center/cover;
            color: #fff;
            text-align: center;
            padding: 5rem 1rem;
            position: relative;
            height: 400px;
        }

        .hero-content h2 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .hero-content p {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .hero-content .btn {
            background: #ffcc00;
            color: #fff;
            padding: 0.8rem 1.8rem;
            border-radius: 5px;
            font-size: 1rem;
            text-decoration: none;
        }

        .hero-content .btn:hover {
            background: #ff9900;
        }

        .about, .rules, .contact, .why-us {
            padding: 2rem;
            padding-top: 0.5rem; 
            text-align: center;
            background: #fff;
            margin: 2rem 0;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .about h2, .rules h2, .contact h2, .why-us h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            margin-top: 0.5rem;
        }

        .about p, .rules ul, .contact p {
            font-size: 1rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .rules ul {
            list-style: none;
            padding: 0;
        }

        .rules ul li {
            margin: 0.5rem 0;
            padding: 0.5rem;
            background: #0C0910;
            color: #fff;
            border-radius: 5px;
        }

        .why-us .container {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
        }

        .why-us-box {
            background: #0C0910;
            color: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 30%;
        }

        .why-us-box h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }

        .why-us-box p {
            font-size: 1rem;
        }

        .rules-images {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .rules-img {
            width: 400px;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin: 0 1rem;
        }

        .about-img, .contact-img {
            width: 100%;
            max-width: 600px;
            margin-top: 1rem;
            border-radius: 10px;
        }

        .contact form {
            margin-top: 1rem;
        }

        .contact input, .contact textarea {
            width: 100%;
            padding: 0.8rem;
            margin: 0.5rem 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .contact .btn {
            background: fff;
            color: #fff;
            padding: 0.7rem 1.5rem;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            border: none;
        }

        .contact .btn:hover {
            background: #004c99;
        }

        .footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
        }

    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="logo">Online Voting System</h1>
            <nav class="navbar">
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#whyus">Why Us</a>
                <a href="#rules">Rules</a>
                <a href="#contact">Contact</a>
                <a href="login.php" class="btn">Login</a>
            </nav>
        </div>
    </header>

    <section class="hero" id="home">
        <div class="hero-content">
            <h2>Welcome to the Online Voting System</h2>
            <p>Your voice matters! Vote securely and easily.</p>
            <a href="#rules" class="btn">Learn the Rules</a>
        </div>
    </section>

    <section class="about" id="about">
        <div class="container">
            <h2>About Us</h2>
            <p>Welcome to the Online Voting System! We aim to provide a fair and secure platform where every voice is counted and every vote matters. Our advanced system ensures transparency and reliability, making your voting experience stress-free.</p>
            <img src="imag7.png" alt="About Us" class="about-img" height="500" width="100">
        </div>
    </section>

    <section class="why-us" id="why-us">
        <div class="container">
            <h2>Why Us?</h2>
            <div class="why-us-box">
                <h3>100% Secure</h3>
                <p>Right2Vote's online voting system has many layers of security making the platform 100% secure. Security features include encryption, authentication based on OTP, Aadhaar, Biometric. Features like voter selfie, double authentication, audit trail, voter receipt and much more.</p>
            </div>
            <div class="why-us-box">
                <h3>Easy to Use</h3>
                <p>Right2Vote's mobile election system is very user friendly and voting can be done anytime and from anywhere within seconds. Voting can be done via mobile browser, website, android app or iOS app. Check the demo video here.</p>
            </div>
            <div class="why-us-box">
                <h3>Feature Rich</h3>
                <p>Right2Vote's online election software is very customizable and has more than 1600 different types of election configuration possible. Optional features include secret ballot, audit trail, Voter selfie, voter receipt, IP restriction, geo tagging, geo fencing, result multi-lock, Single preference vote and many more.</p>
            </div>
        </div>
    </section>

    <section class="rules" id="rules">
        <div class="container">
            <h2>Rules of Voting</h2>
            <ul>
                <li>Every voter must be registered before the voting period begins.</li>
                <li>Each person can vote only once.</li>
                <li>Ensure your details are accurate before submitting your vote.</li>
                <li>Votes submitted after the deadline will not be counted.</li>
            </ul>
            <div class="rules-images">
                <img src="img8_enhanced.png-removebg-preview.png" alt="Voting Rules Image 1" class="rules-img">
                <img src="img9.png.jpg" alt="Voting Rules Image 2" class="rules-img">
            </div>
        </div>
    </section>

    <section class="contact" id="contact">
        <h2>Contact Us</h2>
        <p>Email: vinodkumarshahapur@gmail.com</p>
        <p>Phone: +91-9731324057 </p>
        <p>Address: Presidency University,<br> Benagluru</p>
    </section>

    <footer class="footer">
        <p>&copy; 2024 Online Voting System. All Rights Reserved.<br>vinodkumarshahapur@gmail.com </p>
    </footer>
</body>
</html>
