<?php
// Start the PHP block at the top of the file
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = ""; // default password is empty for XAMPP
$dbname = "user"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error reporting

// Initialize message variable
$message = '';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['form_type'] == 'signin') {
        // Sign In
        $name = $_POST['name'];
        $password = $_POST['password'];

        // Validate credentials (Use prepared statements for security)
        $stmt = $conn->prepare("SELECT * FROM register WHERE uname = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $user['hpassword'])) {
                $message = "Login successful!"; // Set success message
            } else {
                $message = "Invalid password."; // Set failure message
            }
        } else {
            $message = "No user found."; // Set user not found message
        }
        $stmt->close();
    } elseif ($_POST['form_type'] == 'signup') {
        // Sign Up
        $signup_name = $_POST['signup_name'];
        $signup_email = $_POST['signup_email'];
        $signup_password = $_POST['signup_password'];
        $confirm_password = $_POST['confirm_password'];

        // Check if passwords match
        if ($signup_password !== $confirm_password) {
            $message = "Passwords do not match. Please try again.";
        } else {
            // Check if email already exists
            $stmt = $conn->prepare("SELECT * FROM register WHERE email = ?");
            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }
            $stmt->bind_param("s", $signup_email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $message = "Email already registered. Please use a different email.";
            } else {
                // Hash the password
                $hashed_password = password_hash($signup_password, PASSWORD_DEFAULT);
                
                // Insert user into database
                $stmt = $conn->prepare("INSERT INTO register (uname, email, hpassword) VALUES (?, ?, ?)");
                if ($stmt === false) {
                    die("Error preparing statement: " . $conn->error);
                }
                $stmt->bind_param("sss", $signup_name, $signup_email, $hashed_password);
                if ($stmt->execute()) {
                    $message = "Registration successful!";
                } else {
                    $message = "Error: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in & Sign up Form</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">

                    <!-- Sign In Form -->
                    <form action="" autocomplete="off" class="sign-in-form" method="POST">
                        <input type="hidden" name="form_type" value="signin">
                        <div class="logo">
                            <img src="C:\Users\anurag\OneDrive\Pictures\Screenshots\logo1.png" alt="ThriftKonnect" />
                            <h4>ThriftKonnect</h4>
                        </div>

                        <div class="heading">
                            <h2>Wardrobe Refresh?</h2>
                            <h6>Not registered yet?</h6>
                            <a href="#" class="toggle">Sign up</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" name="name" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Name</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" name="password" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Password</label>
                                <span class="toggle-password">
                                    <img src="C:\Users\anurag\OneDrive\Desktop\sign in 2\eye.png" alt="Show" class="eye-icon" id="eye-close"/>
                                    <img src="C:\Users\anurag\OneDrive\Desktop\sign in 2\visible.png" alt="Hide" class="eye-icon" id="eye-open" style="display: none;" />
                                </span>
                            </div>

                            <input type="submit" value="Sign In" class="sign-btn" />

                            <p class="text">
                                Forgotten your password or your login details? <a href="#">Get help</a> signing in
                            </p>

                            <!-- Display the message here -->
                            <?php if ($message): ?>
                                <p class="alert"><?php echo $message; ?></p>
                            <?php endif; ?>
                        </div>
                    </form>

                    <!-- Sign Up Form -->
                    <form action="" autocomplete="off" class="sign-up-form" method="POST">
                        <input type="hidden" name="form_type" value="signup">
                        <div class="logo">
                            <img src="C:\Users\anurag\OneDrive\Pictures\Screenshots\logo1.png" alt="ThriftKonnect" />
                            <h4>ThriftKonnect</h4>
                        </div>

                        <div class="heading">
                            <h2>Join the Fam</h2>
                            <h6>Already have an account?</h6>
                            <a href="#" class="toggle">Sign in</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" name="signup_name" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Name</label>
                            </div>

                            <div class="input-wrap">
                                <input type="email" name="signup_email" class="input-field" autocomplete="off" required />
                                <label>Email</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" name="signup_password" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Password</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" name="confirm_password" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Confirm Password</label>
                            </div>

                            <input type="submit" value="Sign Up" class="sign-btn" />

                            <p class="text">
                                By signing up, I agree to the <a href="#">Terms of Services</a> and <a href="#">Privacy Policy</a>.
                            </p>

                            <!-- Display the message here -->
                            <?php if ($message): ?>
                                <p class="alert"><?php echo $message; ?></p>
                            <?php endif; ?>
                        </div>
                    </form>

                </div>

                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="C:\Users\anurag\OneDrive\Desktop\f4f7a6f32033681e6a07c2844d27df37.jpg" class="image img-1 show" alt="" />
                        <img src="C:\Users\anurag\OneDrive\Desktop\20ffd40a7564dcf11f1fb352a55c7616.jpg" class="image img-2" alt="" />
                        <img src="C:\Users\anurag\OneDrive\Desktop\6d86111a388bf219f76d83d904b7073a.jpg" class="image img-3" alt="" />
                        <img src="C:\Users\anurag\OneDrive\Desktop\37188b1b1438875c69a2ab0b7d0b86cb.jpg" class="image img-4" alt="" />
                        <img src="C:\Users\anurag\Downloads\download (5).jpg" class="image img-5" alt="" />
                    </div>

                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h2>Create your own courses</h2>
                                <h2>Customize as you like</h2>
                                <h2>Invite students to your class</h2>
                            </div>
                        </div>

                        <div class="bullets">
                            <span class="active" data-value="1"></span>
                            <span data-value="2"></span>
                            <span data-value="3"></span>
                            <span data-value="4"></span>
                            <span data-value="5"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
