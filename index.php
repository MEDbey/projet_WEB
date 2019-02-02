<?php
	if(isset($_GET['controle']) & isset($_GET['action']) & isset($_GET['id'])){
		$controle = $_GET['controle'];
		require ('./controller/' . $controle . '.php');
		$cont = new $controle();
		$action= $_GET['action'];
		$id=$_GET['id'];
		$cont->{$action}($id); 
	}
	elseif (isset($_GET['controle']) & isset($_GET['action'])) {
		$controle = $_GET['controle'];
		require ('./controller/' . $controle . '.php');
		$cont = new $controle();
		$action= $_GET['action'];
		$cont->{$action}(); 
	}
	else {
	require("vue/layout/edt.php");
	}
?>