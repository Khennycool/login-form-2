<?php
session_start();

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

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    // Retrieve user data from the database
    $sql = "SELECT * FROM usersdata WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "<script>alert('Login successful');</script>";
        } else {
            echo "<script>alert('Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style.css">
  <title>LOGIN</title>
</head>
<body>
<div class="container">
    <div class="form-box">
      <h1>REGISTRATION</h1>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="input-group">

          <div class="input-field">
          <i class="fa-solid fa-envelope"></i>
          <input type="email" name="email" placeholder="Your Email" required>
          </div>


          <div class="input-field">
          <i class="fa-solid fa-lock"></i>
          <input type="password" name="password" placeholder="Your Password" required>
          </div>
        </div>
        <div class="btn-field">
            <button type="submit">LOGIN</button>
          </div>

          <p>Don't Have an Account <a href="signupform.php">Register Here</a></p>

      </form>
    </div>


  </div>
  
</body>
</html>