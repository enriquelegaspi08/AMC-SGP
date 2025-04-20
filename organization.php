<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMC STUDENT COUNCIL (CSC)</title>    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/org.css">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="section-title text-center">
            <h1>ORGANIZATIONAL CHART</h1>
            <h2>COLLEGE STUDENT COUNCIL</h2>
            <div class="line"></div>
        </div>

        <!-- Section for Organizational Chart -->
        <div class="main-card row justify-content-center">
            <!-- President Card -->
            <div class="card col-12 col-md-3">
                <div class="img">
                    <img src="CSC OFFICERS/verano.jpeg" alt="Laila B. Verano">
                </div>
                <div class="details">
                    <div class="name">LAILA B. VERANO</div>
                    <div class="job">PRESIDENT</div>
                </div>
            </div>

            <!-- Vice President Card -->
            <div class="card col-12 col-md-3">
                <div class="img">
                    <img src="CSC OFFICERS/abunda.jpg" alt="Shakaira Monique Abunda">
                </div>
                <div class="details">
                    <div class="name">SHAKAIRA MONIQUE ABUNDA</div>
                    <div class="job">VICE PRESIDENT</div>
                </div>
            </div>

            <!-- Executive Secretary Card -->
            <div class="card col-12 col-md-3">
                <div class="img">
                    <img src="CSC OFFICERS/villanueva.jpeg" alt="Laurence Villanueva">
                </div>
                <div class="details">
                    <div class="name">LAURENCE VILLANUEVA</div>
                    <div class="job">EXECUTIVE SECRETARY</div>
                </div>
            </div>
        </div>  

        <!-- Navigation dots -->
        <div class="button text-center mt-4">
            <label for="one" class="one active"></label>
            <label for="two" class="two"></label>
        </div>    

        <div class="container">
            <div class="main-card row justify-content-center">
                <!-- P.I.O. Card -->
                <div class="card col-12 col-md-3">
                    <div class="img">
                        <img src="CSC OFFICERS/christine M..jpg" alt="Christine T. Mahinay">
                    </div>
                    <div class="details">
                        <div class="name">CHRISTINE T. MAHINAY</div>
                        <div class="job">P.I.O</div>
                    </div>
                </div>

                <!-- Business Manager Card 1 -->
                <div class="card col-12 col-md-3">
                    <div class="img">
                        <img src="CSC OFFICERS/joana paula.jpg" alt="Joana Paula Bello">
                    </div>
                    <div class="details">
                        <div class="name">JOANA PAULA BELLO</div>
                        <div class="job">BUSINESS MANAGER</div>
                    </div>
                </div>

                <!-- Business Manager Card 2 -->
                <div class="card col-12 col-md-3">
                    <div class="img">
                        <img src="#" alt="John David T. Sese">
                    </div>
                    <div class="details">
                        <div class="name">JOHN DAVID T. SESE</div>
                        <div class="job">BUSINESS MANAGER</div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>