<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/media/icon.png">
</head>
<body>
    <div class="container">
        <div class="login-logo">
            <div>
                <img width="50px" height="50px" src="assets/media/icon.png" alt="">
            </div>
            <div>
                <b>Nugra </b>DEV
            </div>
        </div>
        <form action="index.php" method="POST">
            <h2>--</h2>
            <div class="container-login">
        <h1>Selama datang</h1>
        <a target="_blank" href="login/index.php">Login</a>
        <a target="_blank" href="login/register.php">Register</a>
        <a target="_blank" href="login/dashboard.php">Dashboard</a>
        <a target="_blank" href="password/index.php">Forgot Password</a>
    </div>
        </form>
    </div>
    <style>
                .container-login {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 300px;
        }

        h1 {
            color: #e74c3c; /* Warna merah */
            margin-bottom: 20px;
        }

        a {
            display: block;
            text-decoration: none;
            color: #fff;
            background-color: #e74c3c; /* Warna merah */
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #c0392b; /* Warna merah yang lebih gelap saat di-hover */
        }

        /* Tambahan CSS untuk tampilan responsif */
        @media (max-width: 400px) {
            .container-login {
                width: 90%;
            }
        }
    </style>
</body>
</html>
