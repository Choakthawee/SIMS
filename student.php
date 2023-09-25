<?php
    error_reporting(E_ALL);
    ini_set('display_errors','1');
    ini_set('display_startup_errors','1');

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "students";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $sql = "SELECT * FROM `std_info`";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai&family=Kanit&family=Noto+Sans+Thai+Looped:wght@300&family=Sarabun:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
    <style>

        body {
            display: flex;
            flex-direction: column;
            font-family: 'IBM Plex Sans Thai', sans-serif;
            margin-right:100px;
            margin-left:100px
        }

        .insert-button {
            position: relative;
            background: #E59C2D;
            border-color: #E59C2D;
            color: #fff;
            overflow: hidden;
            &::before {
                width: 0;
                height: 4.5px;
                position: absolute;
                bottom: 0;
                left: 0;
                background-color: #1FD561;
                transition: all 0.35s;
                content: "";
                z-index: 2;
            }
            &::after {
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0;
                left: 0;
                border-radius: 5px;
                background-color: #1FD561;
                transform: translate(0, -100%);
                transition: all 0.35s;
                content: attr(data-hover);
                z-index: 1;
            }
            &:hover {
                &::before {
                width: 100%;
                }
                &::after {
                transform: translate(0, 0);
                }
            }
        }

        .click-btn {
            display: flex;
            width: 120px;
            height: 40px;
            justify-content: center;
            align-items: center;
            margin: 0.5rem;
            line-height: 35px;
            border: 1px solid;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            color: white;
            text-decoration: none;
            transition: all 0.35s;
            box-sizing: border-box;
        }


        table {
            border-collapse: collapse;
            border: 1px solid #bdc3c7;
            box-shadow: 2px 2px 12px rgba(0,0,0,0.2), -1px -1px 8px rgba(0,0,0,0.2);
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
            background-color: #fff;
        }

        .delete-button, .edit-button {
            background-color: red;
            color: white;
            border: 0px;
            padding: 5px 10px;
            cursor: pointer;
            font-family: 'IBM Plex Sans Thai', sans-serif;
            border-radius:10px;
            box-shadow: 2px 2px 12px rgba(0,0,0,0.2), -1px -1px 8px rgba(0,0,0,0.2);
        }

        .header-table {
            background-color: #28B463;
            color: white;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".delete-button").click(function() {
                var id = $(this).data("id");
                if (confirm("คุณต้องการลบรายการนี้ใช่หรือไม่?")) {
                    $.ajax({
                        url: "delete_std.php",
                        method: "POST",
                        data: { id: id },
                        success: function(response) {
                            // หลังจากการลบสำเร็จ รีเฟรชหน้าเพื่อแสดงข้อมูลใหม่
                            location.reload();
                        },
                        error: function() {
                            alert("เกิดข้อผิดพลาดในการลบรายการ");
                        }
                    });
                }
            });
            $(".edit-button").click(function() {
                var id = $(this).data("id");
                if (confirm("คุณต้องการแก้ไขรายการนี้ใช่หรือไม่?")) {
                    window.location.href = "update_std_form.html?id=" + id;
                }
            });
        });
    </script>
</head>
<body>
    <div style = 'margin-top:100px'></div>
    <?php
        if ($result && mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th class='header-table'>ID</th>";
            echo "<th class='header-table'>ชื่อ(อังกฤษ)</th>";
            echo "<th class='header-table'>นามสกุล(อังกฤษ)</th>";
            echo "<th class='header-table'>ชื่อ(ไทย)</th>";
            echo "<th class='header-table'>นามสกุล(ไทย)</th>";
            echo "<th class='header-table'>สาขา</th>";
            echo "<th class='header-table'>อีเมล</th>";
            echo "<th class='header-table'>ลบ</th>";
            echo "<th class='header-table'>แก้ไข</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["en_name"] . "</td>";
                echo "<td>" . $row["en_surname"] . "</td>";
                echo "<td>" . $row["th_name"] . "</td>";
                echo "<td>" . $row["th_surname"] . "</td>";
                echo "<td>" . $row["major_code"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td><button class='delete-button' data-id='" . $row["id"] . "'>ลบ</button></td>";
                echo "<td><button class='edit-button' data-id='" . $row["id"] . "'>แก้ไข</button></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    ?>

    <a href="insert_std_form.html" class = 'click-btn insert-button' data-hover='เพิ่มข้อมูล' >เพิ่มข้อมูล</a>
</body>
</html>

<?php
    mysqli_close($conn);
?>
