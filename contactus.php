<?php
@include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    header('location:login_form.php');
    exit();
}

$user_name = $_SESSION['user_name']; // User-specific content
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="contactus.css">
</head>

<body>

    <!-- Sidebar Toggle Button (Hidden by Default) -->
    <button class="toggle-btn" id="openSidebar" onclick="toggleSidebar()" style="display: none;">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar (Default Open) -->
    <div class="sidebar" id="sidebar">
        <!-- Close Button -->
        <button class="close-btn" onclick="toggleSidebar()">
            <i class="fas fa-times"></i> 
        </button>

        <div class="sidebar-header">
               <h3>OPIÑA LAW OFFICE</h3>
            <img src="justice.png" alt="Logo">
            
        </div>

        <a href="user_page.php"><i class="fas fa-home"></i> Home</a>
        <a href="calendar.php"><i class="fas fa-calendar-alt"></i> Calendar</a>
        <a href="history.php"><i class="fas fa-history"></i> History</a>
        <a href="cases.php"><i class="fas fa-briefcase"></i> Cases</a>
        <a href="contact.php"><i class="fas fa-envelope"></i> Contact Us</a>
        <a href="aboutus.php"><i class="fas fa-info-circle"></i> About Us</a>
        <a href="location.php"><i class="fas fa-map-marker-alt"></i> Location</a>
        <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
        
    </div>

    <div class="content-area">
    <div class="topbar">
            <h2 class="admin-welcome">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
            <div class="topbar-right">
                <input type="text" class="search-bar" placeholder="Search...">
                <i class="fas fa-bell"></i>
                <i class="fas fa-envelope"></i>
                <i class="fas fa-user-circle"></i>
            </div>
        </div>
    </div>

    <script>
    function toggleSidebar() {
        let sidebar = document.getElementById("sidebar");
        let openBtn = document.getElementById("openSidebar");

        sidebar.classList.toggle("open");

        if (sidebar.classList.contains("open")) {
            openBtn.style.display = "none";
        } else {
            openBtn.style.display = "block";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("openSidebar").style.display = "none";
    });
    </script>

    <script>
    function toggleSidebar() {
        let sidebar = document.getElementById("sidebar");
        let openBtn = document.getElementById("openSidebar");

        sidebar.classList.toggle("closed");

        if (sidebar.classList.contains("closed")) {
            openBtn.style.display = "block";
        } else {
            openBtn.style.display = "none";
        }
    }
    </script>


</body>
</html>
