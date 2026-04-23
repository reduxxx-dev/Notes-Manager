<?php
session_start();
require_once "config/Database.php";

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$database = new Database();
$db = $database->connect();

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $check = $db->prepare("SELECT id FROM users WHERE username = :username");
        $check->bindParam(':username', $username);
        $check->execute();

        if ($check->fetch(PDO::FETCH_ASSOC)) {
            $error = "Username already exists";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                $success = "Registration successful. You can now log in.";
            } else {
                $error = "Registration failed";
            }
        }
    } else {
        $error = "Please fill in all fields";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-8">
            <div class="card shadow-lg my-5">
                <div class="card-body p-5">

                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Register</h1>
                    </div>

                    <form method="POST">
                        <div class="form-group mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Register
                        </button>
                    </form>

                    <?php if (!empty($error)) : ?>
                        <p class="text-danger text-center mt-3 mb-0"><?php echo $error; ?></p>
                    <?php endif; ?>

                    <?php if (!empty($success)) : ?>
                        <p class="text-success text-center mt-3 mb-0"><?php echo $success; ?></p>
                    <?php endif; ?>

                    <div class="text-center mt-3">
                        <a href="login.php">Already have an account? Login</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>