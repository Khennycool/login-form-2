<?php
$pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&+?])[A-Za-z\d#$@!%&+?]{8,30}$/';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $hobbies = $_POST['hobbies'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        echo "<script>alert('Password Mismatch')</script>";
    } elseif (!preg_match($pattern, $password)) {
        echo "<script>alert('Password must have:
        - Min 1 uppercase letter.
        - Min 1 lowercase letter.
        - Min 1 special character.
        - Min 1 number.
        - Min 8 characters.
        - Max 30 characters.')</script>";
    } else {
        // Hash the password
        $hashedpassword = password_hash($confirmPassword, PASSWORD_DEFAULT);

        // Prepare and bind SQL statement
        $sql = "INSERT INTO usersdata (firstName, lastName, phoneNumber, email, hobbies, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $firstName, $lastName, $phoneNumber, $email, $hobbies, $gender, $hashedpassword);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Registration Successful')</script>";
        } else {
            echo "<script>alert('Registration not Successful')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <script src="https://kit.fontawesome.com/3ed6f3b4d8.js" crossorigin="anonymous"></script>
    <title>REGISTRATION</title>
</head>

<body>
    <div class="container">
        <div class="form-box">
            <h1>REGISTRATION</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="input-group">

                    <div class="input-field">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="firstName" placeholder="Your firstName" required>
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="lastName" placeholder="Your lastName" required>
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-phone"></i>
                        <input type="phoneNumber" name="phoneNumber" placeholder="Your phoneNumber" required>
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" placeholder="Your Email" required>
                    </div>

                    <div class="input-field">
                        <select class="mySelect" name="hobbies" required>
                            <option value="">Select Your Hobbies</option>
                            <option value="Football">Football</option>
                            <option value="Reading">Reading</option>
                            <option value="Swimming">Swimming</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label for="gender">Gender</label>
                        <div class="gender">
                            <input type="radio" name="gender" id="female" value="female" required>
                            <label for="female">Female</label>
                            <input type="radio" name="gender" id="male" value="male" required>
                            <label for="male">Male</label>
                        </div>
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" placeholder="Your Password" required>
                    </div>

                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="confirmPassword" placeholder="Confirm Your Password" required>
                    </div>

                    <div class="btn-field">
                        <button type="submit">REGISTER</button>
                    </div>

                    <p>Already Registered <a href="loginform.php">Login Here</a></p>

                </div>
            </form>
        </div>
    </div>
</body>

</html>
