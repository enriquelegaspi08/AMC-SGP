<?php
session_start();
include 'config.php'; // Make sure this file connects to your database

$feedback_sent = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    $stud_id = isset($_SESSION['stud_id']) ? intval($_SESSION['stud_id']) : null;

    if (!empty($name) && !empty($email) && !empty($message) && $stud_id !== null) {
        $stmt = $conn->prepare("INSERT INTO feedbacks (stud_id, name, email, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $stud_id, $name, $email, $message);

        if ($stmt->execute()) {
            $feedback_sent = true;
        }

        $stmt->close();
    } else {
        $error = "Please make sure all fields are filled in and you are logged in.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
        }

        .container {
            background: #fff;
            padding: 30px 30px;
            margin-top: 30px;
            margin-bottom: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .right-side .topic-text {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .right-side p {
            font-size: 16px;
            margin-bottom: 30px;
            color: #555;
            text-align: justify;
        }

        .input-box {
            margin-bottom: 15px;
        }

        .input-box input,
        .input-box textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            resize: none;
        }

        .input-box textarea {
            height: 120px;
        }

        .button {
            background: #2e86de;
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        .left-side {
            color: #444;
            padding-top: 8px;
        }

        .left-side .details {
            margin-bottom: 30px;
        }

        .left-side .details i {
            font-size: 22px;
            color: #2e86de;
            margin-right: 12px;
        }

        .left-side .topic {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 5px;
        }

        .left-side .text-one {
            font-size: 14px;
        }

        @media (max-width: 767px) {
            .container {
                padding: 30px 15px;
            }
        }
    </style>
</head>

<body>
    <?php include 'navbar.php';?>

    <div class="container">
        <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'admin'): ?>
            <div class="mb-3 text-end">
                <a href="view_feedbacks.php" class="btn btn-success">View Feedbacks</a>
            </div>
        <?php endif; ?>

        <?php if ($feedback_sent): ?>
            <div class="alert alert-success">Feedback successfully sent!</div>
        <?php else:?>
            <div class="alert alert-success">Feedback not sent! Please log in to allow the student council to respond to your concerns!</div>
        <?php endif; ?>

        <div class="row gy-4">
            <div class="col-md-8 order-1 order-md-2 right-side">
                <div class="topic-text">Send us a message</div>
                <p>If you have any recommendation to enhance operations, transparency, and student relations of
                    the College Student Council or any types of queries related to the Student Council, you can
                    send us a message from here. It's our pleasure to hear your opinions.</p>
                <form action="feedback.php" method="POST">
                    <div class="input-box">
                        <input type="text" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="input-box">
                        <input type="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-box message-box">
                        <textarea name="message" placeholder="Enter your message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Now</button>
                </form>
            </div>

            <!-- Left Side (Contact Info) -->
            <div class="col-md-4 order-2 order-md-1 left-side border-md-end pe-md-4">
                <div class="details mb-4 d-flex align-items-start">
                    <i class="fa fa-map-marker-alt"></i>
                    <div>
                        <div class="topic">ADDRESS</div>
                        <div class="text-one">Lubigan hills, Ambolong, Aroroy, Masbate</div>
                    </div>
                </div>
                <div class="details mb-4 d-flex align-items-start">
                    <i class="fa fa-envelope"></i>
                    <div>
                        <div class="topic">EMAIL</div>
                        <div class="text-one">amcstudentcouncil@gmail.com</div>
                    </div>
                </div>
                <div class="details d-flex align-items-start">
                    <i class="fa-brands fa-facebook"></i>
                    <div>
                        <div class="topic">FACEBOOK</div>
                        <div class="text-one">AMC Student Council</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php';?>

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>