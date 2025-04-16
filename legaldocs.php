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
    <title>Legal Documents</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <link rel="stylesheet" href="dashboard.css"> -->
     <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    display: flex;
    height: 100vh;
    background: #f5f5f5;
}


.sidebar.closed {
    left: -250px; 
}


.sidebar a {
    display: flex;
    align-items: center;  
    padding: 12px 20px;
    color: #ddd;
    text-decoration: none;
    margin-bottom: 8px;
    border-radius: 5px;
    text-align: left; 
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.sidebar a i {
    color: maroon; 
    margin-right: 10px;
}

.sidebar a:hover {
    background-color: #6c3f27;
}


.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100%;
    background: rgb(43, 24, 13);
    color: white;
    padding: 10px 20px;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}


.sidebar a {
    display: flex;
    align-items: center; 
    padding: 12px 20px;
    color: #ddd;
    text-decoration: none;
    margin-bottom: 8px;
    border-radius: 5px;
    text-align: left;  
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.sidebar a i {
    width: 25px; 
    text-align: center;
    flex-shrink: 0;
    margin-right: 10px;
}

.sidebar a span {
    flex-grow: 1; 
}


.sidebar a:hover {
    background-color: #6c3f27;
}

.logout-btn {
    display: block;
    text-align: center;
    padding: 15px 0;
    color: #ddd;
    text-decoration: none;
    font-size: 16px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    margin-top: auto;
    align-self: center; 
}

.logout-btn span {
    display: inline-block; 
    margin-right: 7px;
}

.logout-btn:hover {
    color: white;
}

.sidebar-header {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    margin-top: 30px;
}

.sidebar-header img {
    width: 60px;
    height: auto;
    margin-right: 10px;
}

.sidebar-header h3 {
    font-family: Georgia, 'Times New Roman', Times, serif;
    color: white;
    font-size: 35px;
    text-align: center;
    margin: 0;
}


.close-btn {
    position: absolute;
    top: 10px; 
    right: 15px;
    background: none;
    border: none;
    font-size: 24px;
    color: white;
    cursor: pointer;
}


.close-btn:hover {
    color: #ffcc00;
}

.toggle-btn {
    position: fixed;
    top: 25px;
    left: 20px;
    background: transparent;
    color: rgb(43, 24, 13);
    padding: 5px 10px;
    font-size: 22px;
    border: none;
    cursor: pointer;
    transition: color 0.3s;
    z-index: 1000;
    display: none; 
}

.toggle-btn:hover {
    color: rgb(94, 79, 62);
}

.toggle-btn i {
    font-size: 22px;
}

.sidebar:not(.closed) ~ .toggle-btn {
    display: none;
}

/* Content Area */
.content-area {
    margin-left: 250px;
    padding: 40px;
    transition: margin-left 0.3s ease;
    width: 100%;
}

.sidebar.closed + .content-area {
    margin-left: 50px;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background: white;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    margin-bottom: 20px;
    margin-top: -20px;
}


.admin-welcome {
    font-size: 20px;
    color: rgb(43, 24, 13);
}

.topbar-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.search-bar {
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.topbar i {
    font-size: 20px;
    cursor: pointer;
    color: rgb(43, 24, 13);
}

.topbar i:hover {
    color: rgb(94, 79, 62);
}


.sidebar-widgets {
    width: 290px;
    position: absolute;
    right: 20px;
    top: 110px;
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}

.sidebar-widgets {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px; 
}

.weather-widget,
.news-widget {
    width: 100%;
    max-width: 300px;
    padding: 15px;
    background: white;
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    text-align: left;
}

.weather-widget h3,
.news-widget h3 {
    font-size: 16px;
    color: #333;
    text-align: center;
    border-bottom: 2px solid #ffcc00;
    padding-bottom: 5px;
    margin-bottom: 10px;
}

.weather-search {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.weather-search input {
    padding: 8px;
    width: 70%;
    border: 1px solid #ccc;
    border-radius: 20px;
    font-size: 13px;
    outline: none;
    text-align: center;
}

.weather-search button {
    background: #ffcc00;
    border: none;
    padding: 8px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s, transform 0.2s;
}

.weather-search button:hover {
    background: #e6b800;
    transform: scale(1.05);
}

#news ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

#news ul li {
    margin-bottom: 8px;
    font-size: 14px;
}

#news ul li a {
    text-decoration: none;
    color: #e6b800;
    font-weight: bold;
    transition: color 0.3s;
}

#news ul li a:hover {
    color:rgb(36, 119, 3);
    text-decoration: underline;
}

.document-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr); 
    gap: 10px;
    margin-top: 20px;
    padding: 10px;
    width: 100%;
}

.document-box {
    background: #ddd;
    padding: 15px;
    text-align: center;
    border: 2px solid #600;
    font-weight: bold;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100px;
}
.highlight {
    border-color: 2px solid #600;
}
.document-box button {
    margin-top: 10px;
    padding: 8px 12px;
    border: none;
    background-color: #600;
    color: white;
    cursor: pointer;
    font-size: 14px;
    border-radius: 5px;
}
.document-box button:hover {
    background-color: #800;
}

@media (max-width: 1024px) {
    .sidebar {
        width: 100%;
        left: -100%;
    }
    
    .sidebar.open {
        left: 0;
    }
    
    .sidebar.closed + .content-area {
        margin-left: 0;
        width: 100%;
    }
    
    .toggle-btn {
        display: block;
        top: 15px;
        left: 15px;
        z-index: 1100;
    }
    }
    
    @media (max-width: 768px) {
    .sidebar {
        width: 80%;
        left: -80%;
    }
    
    .sidebar.open {
        left: 0;
    }
    
    .content-area {
        margin-left: 0;
        width: 100%;
        padding: 20px;
    }
    
    .topbar {
        flex-direction: column;
        text-align: center;
        gap: 10px;
        padding: 15px;
    }
    
    .topbar-right {
        gap: 10px;
        justify-content: center;
    }
    }
    
    @media (max-width: 480px) {
    .sidebar {
        width: 100%;
        left: -100%;
    }
    
    .sidebar.open {
        left: 0;
    }
    
    .sidebar-header img {
        width: 30px;
    }
    
    .sidebar-header h3 {
        font-size: 18px;
    }
    
    .content-area {
        padding: 15px;
    }
    
    .admin-welcome {
        font-size: 18px;
    }
    
    .search-bar {
        width: 100%;
    }
    
    .topbar i {
        font-size: 18px;
    }
}

.welcome-logo img {
    width: 220px;  /* adjust size here */
    height: auto;
    display: block;
    margin-bottom: -50px;
    margin-top: -50px;
    margin-left: 400px;
}
    </style>
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
        <a href="legaldocs.php"><i class="fas fa-calendar-alt"></i> Legals Document</a>
        <a href="history.php"><i class="fas fa-history"></i> History</a>
        <a href="cases.php"><i class="fas fa-briefcase"></i> Cases</a>
        <a href="contactus.php"><i class="fas fa-envelope"></i> Contact Us</a>
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
        <div class="welcome-logo">
            <img src="logo2.png" alt="Welcome Logo">
        </div>
    


            <div class="document-container">
                <div class="document-box"><a href="example.php"><button>Generate Affidavit of Loss</button></a></div>
                <div class="document-box"><a href="example.php"><button>Generate Deed of Sale</button></a></div>
                <div class="document-box"><a href="example.php"><button>Generate Sworn Affidavit of Solo Parent</button></a></div>
                <div class="document-box highlight"><a href="example.php"><button>Generate Sworn Affidavit of Mother</button></a></div>
                <div class="document-box highlight"><a href="example.php"><button>Generate Sworn Affidavit of Father</button></a></div>
                <div class="document-box highlight"><a href="example.php"><button>Generate Sworn Statement of Mother</button></a></div>
                <div class="document-box"><a href="example.php"><button>Generate Sworn Statement of Father</button></a></div>
                <div class="document-box"><a href="example.php"><button>Generate Joint Affidavit of Two Disinterested Persons</button></a></div>
                <div class="document-box"><a href="example.php"><button>Generate Agreement</button></a></div>
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
