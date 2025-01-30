<?php
ob_start();
session_start();

$servername = "localhost";
$Username = "root";
$Password = "";
$database = "todo_list";

$conn = mysqli_connect($servername, $Username, $Password, $database);
if (!$conn) {
    echo "Error connecting to database<br>";
}

$Serailnumber = $_SESSION["serialnumber"];
// $username = $_SESSION["username"];
// $email = $_SESSION["email"];

if (isset($_POST["submit"])) {
    $task = $_POST["task"];
    $userid = $Serailnumber;
    $sql = "INSERT INTO `todolist` (`item_name`, `user_id`) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $task, $userid);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php");
    } else {
        echo "Error occured while adding task<br>";
    }
}

if (isset($_GET["delete"])) {
    $serailnumber = $_GET["serialnumber"];
    $sql = "DELETE FROM `todolist` WHERE `serial_number` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $serailnumber);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error in deletion of the task<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO-DO LIST</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h3 {
            color: white;
            margin-bottom: 20px;
        }

        form {
            color: white;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 10rem;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 300px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        table {
            width: 70%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-button {
            padding: 5px 10px;
            background-color: #dc3545;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }

        .action-button:hover {
            background-color: #c82333;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h3>TO-DO APP</h3>
    <form action="dashboard.php" method="post">
        Enter the task: <input type="text" name="task" id="">
        <input type="submit" value="+" name="submit">
    </form>
    <table border="1" width="70%">
        <tr style="text-align: center;">
            <td>Serial Number</td>
            <td>Task</td>
            <td>Action</td>
        </tr>

        <tr style="text-align: center;">
            <?php
            $index = 1;
            $sql = "SELECT * FROM `todolist` WHERE `user_id` = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $Serailnumber);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                while ($rows = mysqli_fetch_assoc($result)) {
                    echo "<tr style='text-align: center;'>
                            <td>{$index}</td>
                            <td>{$rows['item_name']}</td>
                            <td>
                                <form action='dashboard.php' method='get'>
                                    <input type='hidden' name='serialnumber' value='{$rows['serial_number']}'>
                                    <input type='submit' value='-' name='delete'>
                                </form>
                            </td>
                        </tr>";
                    $index = $index + 1;
                }
            }
            ?>
        </tr>
    </table>
</body>

</html>

<?php

?>