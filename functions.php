<?php
	function validarSessao() {
	    session_start();
	    if (!isset($_SESSION['usuario'])) {
	        header('Location: login.php');
	        exit;
	    }
	}
?>