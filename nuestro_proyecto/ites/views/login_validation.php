<?php
	ob_start();
	session_start();
?>

<?php
    $msg = '';
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']))
    {
        $rut = $_POST['username'];
        $user_password = $_POST['password'];
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        // aqui tiene que ir una funcion que retorne el tipo de usuario que ingreso a la base de datos
        // $_SESSION['tipo'] = ;

        $msg = "Sesión iniciada correctamente";
        header("Location: ../index.php?msg=$msg");
    }
?>