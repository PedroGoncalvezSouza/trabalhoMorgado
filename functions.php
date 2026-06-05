<?php
	function validarSessao() {

	require_once __DIR__ . '/classes/SegurancaHeaders.php';		
	SegurancaHeaders::configSessionSecurity(); 

	    session_start();
	    if (!isset($_SESSION['usuario'])) {
	        header('Location: login.php');
	        exit;
	    }
	}
?>