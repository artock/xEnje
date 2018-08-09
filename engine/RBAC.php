<?php

class RBAC {

	public static function get_role($username){
		$user = R::findOne('users','user = ?',[$username]);

	    return isset($user) && !empty($user) ? $user["role"] : false;
	}

	public static function load_proper_view($role, $view){
		return $role."-".$view;
	}

	public static function accept_view($role, $view, $acl){
		return in_array($view, $acl[$role]);
	}

	public static function check_view_convention($role, $view){
		$role_set = RBAC::scrap_role($view);

		if($role_set === "user")
			return true;

		return $role_set == $role;
	}

	public static function get_roles(){
		$roles = R::getAll('SELECT role from users WHERE LENGTH(role) > 1 GROUP BY role ');

		$_roles = array();

		foreach ($roles as $role) {
			$_roles[] = $role["role"];
		}

		return $_roles;
	}

	public static function scrap_role($view){
		$roles = RBAC::get_roles();

		foreach ($roles as $role) {

		$view_restriction = strpos($view, $role);

		if($view_restriction !== false)
			return $role;
	    }

	    return "user";
	}

}

?>
