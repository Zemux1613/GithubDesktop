<?php

if (isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
}

if (isset($_SESSION['username'])) {
    header("Location: index.php?view=repos");
    die();
} else { ?>
    <form method="post" action="index.php?view=loginPage">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Enter your username" required>
        <input type="submit" value="Save">
    </form>
<?php }
