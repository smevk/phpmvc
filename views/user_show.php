<?php require_once "partials/header.php" ?>

<?php
foreach ($users as $user) {

    echo $user['name'];
}

?>

<?php require_once "partials/footer.php" ?>