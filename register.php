<?php
include 'config.php'; // database connection

$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $year_block = trim($_POST['year_block']);
    $stud_id = $_POST['stud_id'] ?? '';
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $major = $_POST['major'] ?? '';

    // Basic validation
    if (empty($fullname) || empty($username) || empty($email) || empty($year_block) || empty($stud_id) || empty($password) || empty($confirm_password) || empty($major)) {
        $errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if username or email already exists
    if (empty($errors)) {
        $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $username, $email);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $errors[] = "Username or Email already exists.";
        }
        $check->close();
    }

    // Insert user if no errors
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, year_block, stud_id, password, major) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $fullname, $username, $email, $year_block, $stud_id, $hashedPassword, $major);

        if ($stmt->execute()) {
            $success = "Registration successful! You can now <a href='login.php'>login</a>.";
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AMC STUDENT COUNCIL (CSC)</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f1f1f1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            background: #023e8a;
            color: white;
            max-width: 900px;
            width: 90%;
            margin: 20px auto;
            margin-bottom: 10px;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
        }

        .title::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            height: 4px;
            width: 60px;
            background: linear-gradient(135deg, rgb(6, 56, 81), rgb(92, 186, 233));
        }

        form .user-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .input-box {
            flex: 1 1 calc(50% - 20px);
        }

        .input-box .details {
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
        }

        .input-box input:focus {
            border-color: rgb(92, 186, 233);
            outline: none;
        }

        .course-details {
            margin-top: 15px;
            text-align: center;
        }

        .course-details .course-title {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .course-details .category {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 20px; /* spacing between items */
            flex-wrap: nowrap;
            overflow-x: auto; /* allows scroll on small screens if needed */
            -webkit-overflow-scrolling: touch; /* smooth scrolling on iOS */
        }
        .course-details .category label {
            white-space: nowrap; /* keeps label text in one line */
        }

        .category label {
            display: flex;
            align-items: center;
            font-size: 18px;
        }

        .category .dot {
            height: 18px;
            width: 18px;
            border-radius: 50%;
            margin-right: 10px;
            border: 5px solid transparent;
            background: rgb(12, 86, 123);
            transition: all 0.3s ease;
        }

        #dot-1:checked~.category label .one,
        #dot-2:checked~.category label .two,
        #dot-3:checked~.category label .three {
            border-color: rgb(92, 186, 233);
        }

        input[type="radio"] {
            display: none;
        }

        .button input {
            margin-top: 15px;
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, rgb(6, 56, 81), rgb(92, 186, 233));
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        .button input:hover {
            background: linear-gradient(-135deg, rgb(6, 56, 81), rgb(92, 186, 233));
        }

        .switch-form {
            margin-top: 10px;
            text-align: center;
            font-size: 16px;
        }

        .switch-form a {
            color: rgb(92, 186, 233);
            text-decoration: none;
            margin-left: 5px;
        }

        .CSCLogo img {
            height: 60px;
            margin-bottom: 20px;
        }

        .designer {
            opacity: 0.7;
            text-transform: uppercase;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .input-box {
                flex: 1 1 100%;
            }

            .category {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <section class="container">
        <div class="title">Registration</div>

        <!-- Success Message -->
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo $error; ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="row col-12 col-md-6 user-details">
                <div class="input-box">
                    <span class="details">Student ID</span>
                    <input type="text" name="stud_id" placeholder="Enter student ID" required />
                </div>
            </div>
            <div class="row user-details">
                <div class="input-box">
                    <span class="details">Full Name</span>
                    <input type="text" name="fullname" placeholder="Lastname, First Name, Middle Initial" required />
                </div>
                <div class="input-box">
                    <span class="details">Username</span>
                    <input type="text" name="username" placeholder="Enter your username" required />
                </div>
                <div class="input-box">
                    <span class="details">Email</span>
                    <input type="email" name="email" placeholder="your@email.com" required />
                </div>
                <div class="input-box">
                    <span class="details">Year level-Block</span>
                    <input type="text" name="year_block" placeholder="Example: 1-A" required />
                </div>
            </div>
            <div class=" row user-details">
                <div class="input-box">
                    <span class="details">Password</span>
                    <input type="password" name="password" placeholder="Enter your password" required />
                </div>
                <div class="input-box">
                    <span class="details">Confirm Password</span>
                    <input type="password" name="confirm_password" placeholder="Confirm your password" required />
                </div>
            </div>

            <div class="course-details">
                <span class="course-title">MAJOR</span>

                <!-- Use the same name for all radio buttons -->
                <input type="radio" name="major" id="dot-1" value="CHS" required />
                <input type="radio" name="major" id="dot-2" value="CCT" />
                <input type="radio" name="major" id="dot-3" value="ENTREP" />

                <div class="category">
                    <label for="dot-1">
                        <span class="dot one"></span>
                        <span>CHS</span>
                    </label>
                    <label for="dot-2">
                        <span class="dot two"></span>
                        <span>CCT</span>
                    </label>
                    <label for="dot-3">
                        <span class="dot three"></span>
                        <span>ENTREP</span>
                    </label>
                </div>
            </div>

            <div class="button">
                <input type="submit" value="Register" />
            </div>

            <div class="switch-form">
                Already have an account? <a href="login.php">Log in</a>
            </div>
        </form>
    </section>

    <?php include 'footer.php'; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>