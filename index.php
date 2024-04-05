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

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fullName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $hobbies = $_POST['hobbies'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if( $password !== $confirmPassword){
        echo "<script>alert('Password Mismatch')</script>";
    }

// Check if the email or phone number has been used before
$check_query = "SELECT * FROM usersdata WHERE email='$email' OR phoneNumber='$phoneNumber'";
$check_result = $conn->query($check_query);
if ($check_result->num_rows > 0) {
    echo "<script>alert('Email or phone number has already been taken');</script>";
}

    elseif (!preg_match($pattern,$password)) {
        echo 'password must have Min 1 uppercase letter.
        Min 1 lowercase letter.
        Min 1 special character.
        Min 1 number.
        Min 8 characters.
        Max 30 characters.';
    }
    else{
        $hashedpassword=password_hash($confirmPassword, PASSWORD_DEFAULT);

        try{
            $sql = "INSERT INTO usersdata (firstName, lastName, phoneNumber, email, hobbies, gender, password) VALUES (?,?,?,?,?,?,?)";
            // INITIALIZED DB CONNECTION
            $stmt = mysqli_stmt_init($conn);
            $preparestmt = mysqli_stmt_prepare($stmt, $sql);

            if($preparestmt) {
                mysqli_stmt_bind_param($stmt, 'sssssss', $fullName, $lastName, $phoneNumber, $email, $hobbies, $gender, $hashedpassword);
                mysqli_stmt_execute($stmt);
                echo "<script>alert('Registration Successful')</script>";
            }
            else{
                echo "<script>alert('Registration not Successful')</script>";
            }
        }
        catch (\Throwable $err){
            echo 'error: ' .$err ->getMessage();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
     background: linear-gradient(rgba(8,0,58,0.7),rgba(8,0,58,0.7)), url('./asset/background.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      font-family: Arial, sans-serif;
      color: #fff;
    }
    .container {
      margin-top: 50px;
    }
    .form-container {
      background: #676767;
      padding: 25px;
      border-radius: 10px;

    }

    .form-container p{
      text-align: center;
      margin-top: 20px;
    }
    .form-container label {
      font-weight: bold;
    }
    .form-container .btn-primary {
      width: 100%;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="form-container">
        <h2 class="text-center mb-4">Registration Form</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" required>
          </div>
          <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" required>
          </div>
          <div class="form-group">
            <label for="phoneNumber">Phone Number</label>
            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <div class="form-group">
            <label for="hobbies">Hobbies</label>
            <select class="form-control" id="hobbies" name="hobbies" required>
              <option value="">Select Hobbies</option>
              <option value="dance">Football</option>
              <option value="swim">Swimming</option>
              <option value="read">Reading</option>
            
            </select>
          </div> 

          <div class="form-group">
            <label>Gender</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
              <label class="form-check-label" for="female">Female</label> <br>
              <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
              <label class="form-check-label" for="male">Male</label>
            </div>
          </div> 

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
          </div>
          <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <div>
    <div><p>Already Registered <a href="login.php">Login Here</a></p>
  </div>
  </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>


