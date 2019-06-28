<?php 

Class module_404 extends base_module
{

	public function __construct(&$_app, $exeption = "", $error_code = "")
	{		
		parent::__construct($_app);

		if($_app->var_module)
		{
			if(is_int($_app->var_module[0]))
				$error_code = $_app->var_module[0];		
		}


		$this->assign_var("error_message", $exeption)
			->assign_var('error_code', $error_code)
			->use_other_template("404")
			->render_tpl();
	}
}
