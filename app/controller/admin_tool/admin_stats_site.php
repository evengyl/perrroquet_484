<?php 

Class admin_stats_site extends base_module
{
	public function __construct(&$_app)
	{		
		parent::__construct($_app);

		$this->render_tpl();
	}
}
