<?php
session_start();
include 'config.php'; // database connection

$successMessage = '';
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Check if the user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password using password_verify
        if (password_verify($password, $user["password"])) {
          // Regenerate session ID to prevent session fixation
          session_regenerate_id(true);
          
          $_SESSION["user_id"] = $user["id"];
          $_SESSION["username"] = $user["username"];
          $_SESSION["full_name"] = $user["full_name"];
          $_SESSION["account_type"] = $user["account_type"];
      
          // Set a success message in the session
          $successMessage = "Login successful! Welcome, " . $_SESSION['full_name'] . "! Redirecting...";
          
        } else {
            // Return a generic error to avoid revealing which part is wrong
            $errorMessage = "Invalid username or password.";
        }
    } else {
        $errorMessage = "Invalid username or password."; // Do not specify if username or password is incorrect
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AMC STUDENT COUNCIL (CSC) - Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        }

        body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        }

        .container {
        max-width: 900px;
        width: 90%;
        background: #023e8a;
        padding: 30px 40px;
        border-radius: 10px;
        margin: 50px auto;
        }

        .title {
        font-size: 28px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 20px;
        position: relative;
        }

        .title::before {
        content: '';
        position: absolute;
        left: 0;
        bottom: -6px;
        height: 4px;
        width: 40px;
        background: linear-gradient(135deg, rgb(6, 56, 81), rgb(92, 186, 233));
        }

        form .user-details {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        color: #fff;
        }

        .input-box {
        flex: 1 1 100%;
        }

        .details {
        font-weight: 500;
        margin-bottom: 5px;
        display: block;
        }

        .input-box input {
        width: 100%;
        height: 45px;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        transition: border 0.3s ease;
        }

        .input-box input:focus,
        .input-box input:valid {
        border-color: rgb(92, 186, 233);
        }

        .button {
        margin-top: 30px;
        }

        .button input {
        width: 100%;
        height: 45px;
        border: none;
        border-radius: 5px;
        background: linear-gradient(135deg, rgb(6, 56, 81), rgb(92, 186, 233));
        color: #fff;
        font-size: 20px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.3s ease;
        }

        .button input:hover {
        background: linear-gradient(-135deg, rgb(6, 56, 81), rgb(92, 186, 233));
        }

        .switch-form {
        text-align: center;
        margin-top: 20px;
        color: #fff;
        font-size: 18px;
        }

        .switch-form a {
        color: rgb(92, 186, 233);
        text-decoration: underline;
        }

        @media screen and (min-width: 600px) {
        .input-box {
            flex: 1 1 calc(50% - 20px);
        }
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="title">Log in</div>
        
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 3000); // Redirect after 3 seconds
            </script>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errorMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Username</span>
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>
                <div class="input-box">
                    <span class="details">Password</span>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
            </div>

            <div class="button">
                <input type="submit" value="Log in">
            </div>

            <div class="switch-form">
                <span>Don't have an account? <a href="register.php">Register</a></span>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>