<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <body>
        <?php
            $_SESSION['favcolor'] = "green";
            $_SESSION['favanimal'] = "car";
            echo "Session variables are set."
        ?>
    </body>
</html>