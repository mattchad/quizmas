<?php 
class WebUser extends CWebUser
{
	public function checkAccess($operation, $params=array())
	{
		if (empty($this->id))
		{
			// Not identified => no rights
			return false;
		}
		
		$role = $this->getState("roles");
		//die($operation . " " . $role);
		
		if($operation == "admin" && $role >= User::ROLE_ADMIN)
		{
			return true;
		}
		else
		{
			return false;
		}
		
		/* if ($role === 'admin')
		{
			return true; // admin role has access to everything
		} */
		
		// allow access if the operation request is the current user's role
		//return ($operation === $role);
	}
}
?>