<?
Class admin extends base_module
{
	public $level = 0;
	public $error;

	public function __construct(&$_app)
	{		
		parent::__construct($_app);

		$this->_app->navigation->set_breadcrumb("Option d'administration");

		
		if(($this->level = $this->check_level_user(isset($_SESSION['pseudo'])?$_SESSION['pseudo']:0)) == 3)
		{
				
			if(isset($_GET['action']))
			{
				switch ($_GET['action'])
				{
					case "edit_config_app":
						$this->use_module('admin_edit_config_app');
					break;

					case "eval":
						$this->use_module('admin_eval');
					break;

					case "pull_bsd":
						$this->use_module('admin_pull_bsd');
					break;

					case "go_to_vip_view":
						$this->set_status(2);
					break;

					case "go_to_no_vip_view":
						$this->set_status(1);
					break;

					case "go_to_client_view":
						$this->set_status(0);
					break;
				}
			}
			$this->use_module('admin_stats_site');
			$this->use_module('admin_verify_status_vip');
			$this->render_tpl(); //on affiche l'administration
		}
		else{
			//go page de connexion
			$this->error = "Vous n'avez pas accès à cette page.</br>Seul l'administration peux y accéder";
			$this->assign_var("error", $this->error)
				->use_module('login')
				->render_tpl();
		}
	}

	

	public function set_status($user_type)
	{
		$sql = new stdClass();
		$sql->table = "utilisateurs";
		$sql->ctx = new stdClass();
		$sql->ctx->user_type = $user_type;
		$sql->where = "id = ".$this->_app->user->id_utilisateurs;

		$this->_app->sql->update($sql);

	}


	public function check_level_user($login)
	{
		if($login)
		{
			$req_sql = new stdClass();
			$req_sql->table = ['login'];
			$req_sql->var = ["level"];
			$req_sql->where = ["login = $1", [$login]];
			$res_sql = $this->_app->sql->select($req_sql);
			return $res_sql[0]->level;
		}
		else
			return 0;
		
	}
}


