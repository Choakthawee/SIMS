<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = htmlspecialchars(trim($_POST["id"]));
        $en_name = htmlspecialchars(trim($_POST["en_name"]));
        $en_surname = htmlspecialchars(trim($_POST["en_surname"]));
        $th_name = htmlspecialchars(trim($_POST["th_name"]));
        $th_surname = htmlspecialchars(trim($_POST["th_surname"]));
        $major_code = htmlspecialchars(trim($_POST["major_code"]));
        $email = htmlspecialchars(trim($_POST["email"]));

        // ตรวจสอบรูปแบบอีเมล
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "รูปแบบอีเมลไม่ถูกต้อง<a href='student.php'>Back</a>";
        } else {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "students";

            // create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if (!$conn) {
                die("Connection failed " . mysqli_connect_error());
            }
            
            $sql = "INSERT INTO `std_info` (`id`, `en_name`, `en_surname`, `th_name`, `th_surname`, `major_code`, `email`) VALUES ('$id', '$en_name', '$en_surname', '$th_name', '$th_surname', '$major_code', '$email')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "Insert Record<br>";
                echo "id " . $id . "<br>";
                echo "Successfully!<br>";
                echo "<a href='student.php'>Back</a>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }
?>