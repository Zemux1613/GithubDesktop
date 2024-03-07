<?php
session_start();
$view = "loginPage";

if(isset($_GET['view'])) {
    $view = $_GET['view'];
} ?>
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <title>Github Desktop</title>
        <meta charset="UTF-8">
        <link href="assets/global.css" rel="stylesheet">
        <?php if (file_exists("assets/$view.css")) {
            echo '<link rel="stylesheet" href="assets/' . $view . '.css?' . time() . '">';
        } ?>
        <link href="https://github.githubassets.com/assets/pinned-octocat-093da3e6fa40.svg" rel="icon">
    </head>
    <body>
    <noscript>You require JavaScript.</noscript>
    <?php
        require_once ("views/$view.php");
        require_once ("views/footer.php");
    ?>
</body>
</html>


