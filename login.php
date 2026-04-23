
<?php
session_start();
require_once "config/Database.php";

$database = new Database();
$db = $database->connect();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Wrong username or password";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

<div class="container">

    <div class="row justify-content-center">

        <div class="col-xl-6 col-lg-6 col-md-8">

            <div class="card shadow-lg my-5">
                <div class="card-body p-5">

                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                    </div>

                    <form method="POST">
                        <div class="form-group mb-3">
                            <input type="text" name="username" class="form-control"
                                   placeholder="Username">
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" name="password" class="form-control"
                                   placeholder="Password">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Login
                        </button>
                    </form>

                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>

<p style="color:red; text-align:center;">
    <?php if (!empty($error)) echo $error; ?>
</p>