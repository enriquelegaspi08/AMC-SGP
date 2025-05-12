<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMC STUDENT COUNCIL (CSC)</title>
    <link rel="stylesheet" href="styles/home.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Success Message Alert -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <!-- Header -->
    <header class="text-center py-3">
        <h1 class="mb-0">AMC STUDENT COUNCIL (CSC)</h1>
    </header>

    <!-- Welcome Section -->
    <section class="text-center bg-light py-2" id="greeting">
        <div class="content">
            <img src="LOGO/AMC LOGO.png" class="img-fluid mb-3" alt="AMC Logo" width="180">
            <h1 class="display-5">WELCOME AMCian's!</h1>
        </div>
    </section>

    <!-- About Us -->
    <section id="services" class="py-1">
        <div class="container text-center">
            <h2>About Us</h2>
            <hr class="w-25 mx-auto">
            <div class="row">
                <div class="col-md-4 mb-3 about-card">
                    <img src="ABOUT US/MISSION.png" class="img-fluid mb-2" alt="">
                    <h5>MISSION</h5>
                </div>
                <div class="col-md-4 mb-3 about-card">
                    <img src="ABOUT US/SA & SOG.png" class="img-fluid mb-2" alt="">
                    <h5>STUDENT AFFAIRS AND SERVICES ORGANIZATIONAL STRUCTURE</h5>
                </div>
                <div class="col-md-4 mb-3 about-card">
                    <img src="ABOUT US/VISION.png" class="img-fluid mb-2" alt="">
                    <h5>VISION</h5>
                </div>
            </div>
        </div>
    </section>

    <!-- Activities Slider -->
    <section id="questions" class="py-1 bg-light">
        <div class="container-fluid text-center">
            <h2>ACTIVITIES</h2>
            <h4>COLLEGE STUDENT COUNCIL</h4>
            <hr class="w-25 mx-auto mb-4">
            <div id="activityCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="SERVICES/cheerdance.jpg" class="d-block w-100" alt="Cheerdance">
                    </div>
                    <div class="carousel-item">
                        <img src="SERVICES/parade.jpg" class="d-block w-100" alt="Parade">
                    </div>
                    <div class="carousel-item">
                        <img src="SERVICES/parade1.jpg" class="d-block w-100" alt="Parade 1">
                    </div>
                    <div class="carousel-item">
                        <img src="SERVICES/csc parade.jpg" class="d-block w-100" alt="CSC Parade">
                    </div>
                    <div class="carousel-item">
                        <img src="SERVICES/sportsfest.jpg" class="d-block w-100" alt="Sportsfest">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#activityCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#activityCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Chatbot Toggle Button -->
    <button class="btn btn-primary position-fixed bottom-0 end-0 m-4" id="chatToggle" style="z-index: 9999; font-size: 24px; color: blue;">
        💬
    </button>

    <!-- Chatbot Box -->
    <div id="chatbotBox" class="card shadow position-fixed" style="width: 300px; bottom: 80px; right: 20px; z-index: 9998; display: none;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>CSC Bot</span>
            <button type="button" class="btn-close btn-close-white btn-sm" id="closeChat"></button>
        </div>
        <div class="card-body" style="max-height: 300px; overflow-y: auto;" id="chatMessages">
            <div class="text-muted text-center mb-2">How can I help you today?</div>
        </div>
        <div class="card-footer p-2">
            <form id="chatForm">
                <div class="input-group">
                    <input type="text" class="form-control" id="chatInput" placeholder="Type a message..." autocomplete="off">
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto close alert after 5 seconds
        setTimeout(function() {
            var alertElement = document.querySelector('.alert');
            if (alertElement) {
                var alert = bootstrap.Alert.getOrCreateInstance(alertElement);
                alert.close();
            }
        }, 2000);
    </script>

    <script>
        document.getElementById('chatToggle').addEventListener('click', function() {
            const chatBox = document.getElementById('chatbotBox');
            chatBox.style.display = (chatBox.style.display === 'none' || chatBox.style.display === '') ? 'block' : 'none';
        });

        document.getElementById('closeChat').addEventListener('click', function() {
            document.getElementById('chatbotBox').style.display = 'none';
        });

        document.getElementById('chatForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            if (message === '') return;

            const chatMessages = document.getElementById('chatMessages');
            chatMessages.innerHTML += `<div class="mb-2"><strong>You:</strong> ${message}</div>`;

            fetch('chatbot.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'message=' + encodeURIComponent(message)
                })
                .then(res => res.json())
                .then(data => {
                    chatMessages.innerHTML += `<div class="mb-2"><strong>AMC Bot:</strong> ${data.reply}</div>`;
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                });

            input.value = '';
        });
    </script>

</body>

</html>