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

        $msg = "Sesión iniciada correctamente";
        header("Location: ../index.php?msg=$msg")?>;
        <form id="form" action="consultas/obtener_tipo_usuario.php" method="post">
            <input type="hidden" name="username" value="<?php echo $_SESSION['username'] ?>">
        </form>
        <script>
            document.getElementByID("form").sumbit();
        </script>
<?php
    }
?>

