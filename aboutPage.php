<?php
/*
 * Assignment 1 - Portfolio Project
 * COMP 3512 - Web 2, Mount Royal University
 * Kiera Dowell and Diesel Thomas
 * Fall 2025
 *
 * Page Title: About Page
 * Page Description:
 * Provides information about our project.
 *
 */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "includes/meta.inc.php"; ?>
    <link rel="stylesheet" href="css/aboutPage.css">
</head>

<body>
    <?php require_once "includes/header.inc.php"; ?>

    <main class="about-container">
        <section class="about-header">
            <h1>About This Project</h1>
            <p>COMP 3512 — Portfolio Project</p>
            <p>Created by Kiera Dowell and Diesel Thomas</p>
        </section>

        <section class="about-card">
            <h2>Project Overview</h2>
            <p>
                This project is assignment #1 of COMP 3512: Web Application Development course (Web 2) at Mount Royal University.
                The site provides a way to view customer investment portfolios, and detailed information about companies they are invested in.
                There are also JSON API endpoints that can be used to request the same raw data from the database.
            </p>
        </section>

        <section class="about-card">
            <h2>Technologies</h2>
            <p>
                Apart from using HTML/CSS in the frontend, the backend is all PHP, and pulls from an SQLite database.
            </p>
        </section>

        <section class="about-card">
            <h2>Git Repository</h2>
            <p>
                The source code for this project is hosted on GitHub:<br>
                <a href="https://github.com/kd1012/comp3512Assign1/" target="_blank" class="git-link">
                    https://github.com/kd1012/comp3512Assign1/
                </a>
            </p>
        </section>

    </main>


</body>

</html>