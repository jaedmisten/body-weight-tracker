<?php
echo '<pre>';
print_r($_SERVER);
echo '</pre>';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<p>POSTED</p>";

    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}

