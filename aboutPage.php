<?php
require_once 'includes/config.inc.php';
require_once 'includes/header.inc.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "includes/meta.inc.php";?>
    <link rel="stylesheet" href="css/aboutPage.css">
    <link rel="stylesheet" href="css/aboutPage.css">
    <title>About | Portfolio Project</title>
</head>
<body>
    <?php require_once "includes/header.inc.php";?>
    <link rel="stylesheet" href="css/header.css">
  
    <main class="about-container">
        <section class="about-header">
            <h1>About This Project</h1>
            <p class="subtitle">COMP 3512 — Portfolio Project</p>
        </section>

        <section class="about-card project-info">
            <h2>Project Overview</h2>
            <p>
                This project is part of the COMP 3512 Web 2: Web Application Development course at Mount Royal University. 
            </p>
        </section>

        <section class="about-card university-info">
            <h2>University</h2>
            <p><strong>Mount Royal University</strong><br>
        </section>

        <section class="about-card git-info">
            <h2>Git Repository</h2>
            <p>
                The source code for this project is hosted on GitHub:<br>
                <a href="https://github.com/yourusername/portfolio-project" target="_blank" class="git-link">
                    https://github.com/yourusername/portfolio-project
                </a>
            </p>
        </section>

        <section class="about-card authors-info">
            <h2>Group Members</h2>
            <ul>
                <li><strong>Diesel Thomas</strong></li>
                <li><strong>Kiera Dowell</strong></li>
            </ul>
        </section>
    </main>


</body>
</html>
