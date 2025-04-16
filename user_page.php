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
    <link rel="stylesheet" href="dashboard.css">
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
        <div class="container">
            <div class="welcome-box">
                <p>This is your user dashboard. You can view and manage your files here.</p>
            </div>
        </div>
    </div>

    <div class="sidebar-widgets">
    <div class="weather-widget">
        <h3>🌤️ Weather Updates</h3>
        <div class="weather-search">
            <input type="text" id="cityInput" placeholder="Enter city..." />
            <button onclick="fetchWeather()"><i class="fas fa-search"></i></button>
        </div>
        <div id="weather">
            <p>Loading weather...</p>
        </div>
    </div>

    <div class="news-widget">
        <h3>📰 Latest News</h3>
        <div id="news">
            <p>Fetching news...</p>
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

<script>
    async function fetchWeather() {
        const apiKey = 'd003e00fa1875766c93f10700487869e'; // Your OpenWeather API Key
        let city = document.getElementById('cityInput').value.trim() || 'San Pablo';
        const url = `https://api.openweathermap.org/data/2.5/weather?q=${city},PH&appid=${apiKey}&units=metric&lang=fil`;

        try {
            const response = await fetch(url);
            const data = await response.json();

            if (response.ok) {
                document.getElementById('weather').innerHTML = `
                <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333; text-align: center; margin-bottom: 10px; ">
                    <strong style="font-size: 15px; color: #000;">${data.weather[0].description}</strong>
                </p>
                <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
                    🌡️ Temperature: ${data.main.temp}°C
                </p>
                <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
                    💨 Wind: ${data.wind.speed} km/h
                </p>
                <p style="font-family: Arial, sans-serif; font-size: 15px; color: #333;">
                    📍 Location: ${data.name}
                </p>
            `;
            } else {
                document.getElementById('weather').innerHTML = `<p>❌ ${data.message}</p>`;
            }
        } catch (error) {
            console.error('Error fetching weather:', error);
            document.getElementById('weather').innerHTML = '<p>❌ cannot fetch .</p>';
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        fetchWeather();
    });
</script>

<script>
async function fetchNews() {
    const apiKey = 'pub_75792af4e05b0aef13eb79b55cf548e309c50';  // Your NewsData.io API Key
    const url = `https://newsdata.io/api/1/news?country=ph&apikey=pub_75792af4e05b0aef13eb79b55cf548e309c50`;

    try {
        const response = await fetch(url);
        const data = await response.json();

        console.log("News API Response:", data);  // Debugging: Check response in console

        if (data.results && data.results.length > 0) {
            let newsHTML = '<ul>';
            data.results.slice(0, 5).forEach(article => {
                newsHTML += `<li><a href="${article.link}" target="_blank">${article.title}</a></li>`;
            });
            newsHTML += '</ul>';

            document.getElementById('news').innerHTML = newsHTML;
        } else {
            document.getElementById('news').innerHTML = `<p>❌ No news available.</p>`;
        }
    } catch (error) {
        console.error('Error fetching news:', error);
        document.getElementById('news').innerHTML = '<p>❌ Unable to fetch news.</p>';
    }
}

document.addEventListener("DOMContentLoaded", function () {
    fetchNews();
});

</script>


</body>
</html>
