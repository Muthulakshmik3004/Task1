<?php
session_start(); 

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Handle signout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset(); // Clear session variables
    session_destroy();
    header("Location: login.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>collections</title>
<link rel="stylesheet" href="home.css">

</head>

<body>
    <div class="top">
    <nav class="navbar navbar-left">
        <ul class="nav-links">
            <li><a class="active" href="home.php"> Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="category.html">Category</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
    </nav>
    <nav class="navbar navbar-right">
        <ul class="nav-btn">
            <li><a href="uploadfile.html" class="btn upload-btn">Upload</a></li>
            <li><a href="home.php?action=logout" class="btn signout-btn">Signout</a></li>
        </ul>
    </nav>
    </div> 
    <h1 class="one">Digital Art work </h1>
    <!--Flex  container-->
<div class="image">
    <div class="gallery">
                  
            <img src="digital-art/12.jpg" alt="Art Image 1">
            <img src="digital-art/2.jpg" alt="Art Image 2">
            <img src="digital-art/3.jpg" alt="Art Image 3">
            <img src="digital-art/13.jpg" alt="Art Image 4">
            <img src="digital-art/8.jpg" alt="Art Image 5">
            <img src="digital-art/6.jpg" alt="Art Image 6">
            <img src="digital-art/19.jpg" alt="Art Image 7">
            <img src="digital-art/9.jpg" alt="Art Image 8">
            <img src="digital-art/15.jpg" alt="Art Image 9">
            <img src="digital-art/11.jpg" alt="Art Image 10">
         
    </div>
    </div> 
    <div class="more">
    <a href="larger.html" class="more-btn">More Images</a>
    </div>
</div>

    <h1 class="one"> Recents Digital</h1>
<div class="image1">
    <div class="container">
        <img src="digital-art/1.jpg"height="330" width="490">
        <img src="digital-art/20.jpg"height="290" width="430">
        
        <img src="digital-art/18.jpg" height="250" width="390">
</div>
<script>
    // Add a simple console log to verify script is loaded
console.log("Image Gallery Loaded");

// Optional: Dynamically highlight hovered images
document.querySelectorAll('.gallery img').forEach(img => {
    img.addEventListener('mouseover', () => {
        img.style.boxShadow = "0px 8px 15px rgba(0, 0, 0, 0.3)";
    });
    img.addEventListener('mouseout', () => {
        img.style.boxShadow = "0px 4px 6px rgba(0, 0, 0, 0.1)";
    });
});
</script>
      
</body>

</html>