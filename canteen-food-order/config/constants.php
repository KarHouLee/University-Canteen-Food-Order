<?php  
       // Start session
       session_start();



       // Create Constraints to Store Non Repeating Values 
        define('SITEURL', 'http://localhost/canteen-food-order/');
        define('LOCALHOST', 'localhost');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'canteen-food-order');

        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());//Database Connection
        $db_select = mysqli_select_db($conn, 'canteen-food-order') or die(mysqli_error());// Selecting Database

?>