<?php
session_start();

$servername = "localhost";
$Username = "root";
$Password = "";
$database = "todo_list";

$conn = mysqli_connect($servername, $Username, $Password, $database);
if (!$conn) {
    echo "Error connecting to database<br>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            padding: 20px;
        }

        form {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h3 {
            color: #1f2937;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 24px;
            text-align: center;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s ease;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            opacity: 0.9;
        }

        @media (max-width: 480px) {
            form {
                padding: 24px;
            }

            h3 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <form action="login.php" method="post">
        <h3>Login</h3>
        Username: <input type="text" name="username" id="">
        Email: <input type="email" name="email" id="">
        Password: <input type="password" name="password" id="">
        <input type="submit" value="Login" name="login">
        Do not have account? <a href="signup.php">Sign Up here</a>
    </form>
</body>

</html>

<?php
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($username) || empty($email) || empty($password)) {
        echo "Please enter all the fields<br>";
    } else {
        $sql = "SELECT * FROM `userdetails` WHERE `user_name` = ? AND `email` = ? AND `password` = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION["serialnumber"] = $row['serial_number'];
            $_SESSION["username"] = $row["user_name"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["password"] = $row["password"];

            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error occurred while authenticating user<br>";
        }
    }
}
?>