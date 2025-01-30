<?php
    session_start();

    $servername = "localhost";
    $Username = "root";
    $Password = "";
    $database = "todo_list";

    $conn = mysqli_connect($servername, $Username, $Password, $database);

    if(!$conn){
        echo "Error connecting to database<br>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignIn</title>
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
    <form method="post" action="signup.php">
        <h3>Sign In</h3>
        Username: <input type="text" name="username" id="">
        Email: <input type="email" name="email" id="">
        Password: <input type="password" name="password" id="">
        Confirm Password: <input type="password" name="confirm_password">
        <input type="submit" value="Sign In" name="signin">
        Already have an account? <a href="login.php">Click Here!</a>
    </form>
</body>
</html>

<?php 
    if(isset($_POST["signin"])){
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirm_password"];
        
        if(empty($username)){
            echo "Username is empty<br>";
        }elseif(empty($email)){
            echo "Email is empty<br>";
        }elseif(empty($password)){
            echo "Password is empty<br>";
        }elseif(empty($confirmPassword)){
            echo "Confirm Password is empty<br>";
        }elseif($confirmPassword != $password){
            echo "Password does not match<br>";
        }else{
            $sql = "INSERT INTO `userdetails` (`user_name`, `email`, `password`) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
            if(mysqli_stmt_execute($stmt)){
                // echo "User is created successfully<br>";
                header("Location: login.php");
            }
            else{
                echo "Error occurred while creating user<br>";
            }
        }
    }
?>