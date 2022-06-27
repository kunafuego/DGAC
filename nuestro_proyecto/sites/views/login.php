<?php
	session_start();
?>

<?php include('../templates/header.html'); ?>

<body class="login-body">
    <link rel="stylesheet" href="../styles/style.css">
    <div class="containerlogin">
        <img src="../assets/login_background.jpg">
        <div class="containerlogin2">
            <label class="title"> Login </label>
            <br><br><br><br>
            <?php echo (!isset($_SESSION['username'])) ?>
            <form class="form" role="form" action="login_validation.php" method="post">
                <label class="label"> Ingrese sus datos </label>
                <input type="text" name="username" placeholder="nombre de usuario" required autofocus>
                <input type="password" name="password" placeholder="contraseña" required>
                <input type="submit" name="login" class='button3'>
            </form>
        </div>
    </div>

</body>