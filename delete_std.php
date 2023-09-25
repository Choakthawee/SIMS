<?php
    $id = $_POST["id"];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "students";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed " . mysqli_connect_error());
    }

    // Prepare the DELETE query
    $sql = "DELETE FROM `std_info` WHERE `id` = '$id'";
    
    // Execute the DELETE query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Delete data successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
?>
