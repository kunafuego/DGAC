<?php
	session_start();
	$msg = $_GET['msg']
?>

<?php include('../templates/header.html'); ?>

<body>
	<h3> Ingrese nombre de usuario y contraseña </h3>
	<br>
    <div style="background-image: url('assets/images/login_background.jpg')">
        <form class="form" role="form" action="login_validation.php" method="post">
            <?php echo $msg; ?>
            <input type="text" name="username" placeholder="nombre de usuario" required autofocus>
            <input type="password" name="password" placeholder="contraseña" required>
            <button type="submit" name="login"> Iniciar sesión </button>
        </form>
    </div>  

</body>