<?php

session_start();

define('ROOT', dirname(__FILE__));

foreach ($_POST as $key => $val) {
	$_POST['key'] = htmlspecialchars($val);
}

require(ROOT.'/engine/__autoload.php');

if($_GET["action"]){
	require_once("controllers/{$_GET['action']}.php");
}

if (isset($_GET["view"])) {

	if(isset($_SESSION['auth'])){
		if(isset($_SESSION['role'])){
			$role = $_SESSION['role'];
			RBAC::get_roles();
			if(!RBAC::check_view_convention($role,$_GET['view']))
				die("Потрібно авторизуватися!");
		}

	}

	if(!isset($_SESSION['auth']) && !RBAC::check_view_convention('user',$_GET['view'])){
		TMP::render_view("login");
		die();
	}

	TMP::render_view($_GET["view"]);

}else{
	TMP::render_view('main');
}

?>
