<?

Class my_account extends base_module
{
	public $_app;

	public function __construct(&$_app)
	{		
		$this->_app = $_app;	
		$this->_app->module_name = __CLASS__;
		
		parent::__construct($this->_app);

		//le form est déclarer autre part mais je peux quand même l'utiliser ici le POST car il font partie de la même page de module
		$this->set_infos_user();

		//je récupère les infos de l'user en cours
		$this->get_infos_user();

		if(isset($_POST['return_post_account_pass_change']))
			$this->change_infos($_POST);

		$this->get_html_tpl =  $this->assign_var('_app', $this->_app)->assign_var('infos_user', $this->_app->user)->render_tpl();
	}

	public function get_infos_user()
	{
		//on vas chercher toute les infos de l'utilisateur avec son login id
		$sql_user = new stdClass();
		$sql_user->table = ['login', "utilisateurs"];
		$sql_user->where = ["id = ".$this->_app->user->id];
		$res_sql = $this->_app->sql->select($sql_user);
		$this->_app->user = $res_sql[0];
		
		//on va compter le nombre d'annonce que l'utilisateur a si il est au bon level
		if($this->_app->user->user_type == 2)
		{
			$sql_nb_annonce = new stdClass();
			$sql_nb_annonce->table = ['annonces'];
			$sql_nb_annonce->var = "COUNT(id) as nb";
			$sql_nb_annonce->where = ["id_proprio = ".$this->_app->user->id_utilisateurs];
			$res_sql_nb = $this->_app->sql->select($sql_nb_annonce);
			$this->_app->user->nb_annonces = $res_sql_nb[0]->nb;

			$sql_vues = new stdClass();
			$sql_vues->table = ['annonces'];
			$sql_vues->var = ["vues"];
			$sql_vues->where = ["id_proprio = ".$this->_app->user->id_utilisateurs, "AND", "vues > 0"];
			$res_sql_nb_vues = $this->_app->sql->select($sql_vues);
				affiche_pre($res_sql_nb_vues);

			//$this->_app->user->nb_vues = $res_sql_nb[0]->nb;

		}
		else if($this->_app->user->user_type == 1){
			$this->_app->user->nb_annonces = "Vous n'êtes pas annonceurs VIP";	
		}
		else if($this->_app->user->user_type == 0){
			$this->_app->user->nb_annonces = "Vous ne pouvez pas créer d'annonce";
		}

		$this->parse_user_infos();


	}

	public function parse_user_infos()
	{
		$array_user_type = [0 => "Utilisateur Standard", 1 => "Annonceurs Gratuit", 2 => "Annonceurs V.I.P"];

		$this->_app->user->user_type_name = $array_user_type[$this->_app->user->user_type];

		
	}

	public function set_infos_user()
	{

	}


	public function change_infos($post)
	{

		if($post['return_post_account_pass_change'] == 18041997)
		{
		    if(isset($post["password-new_1"]) && isset($post["password-new_2"]))
		    {
		    	if($post['password-new_1'] != "" && $post['password-new_2'] != "")
		    	{
			    	$password = $this->check_post_login($post['password-new_1']);
			    	$password_verification = $this->check_post_login($post['password-new_2']);

			    	if($password == '0' || $password_verification == '0')
			    	{
			    		$_SESSION['error'] = "!! Attention votre mot de passe est trop court !!";
			    		return 0;
			    	}
			    	else if($password != $password_verification)
			    	{
			    		$_SESSION['error'] = "Les mots de passe ne correspondent pas.";
			    		return 0;
			    	}
			    	else
			    	{
			    		$req_sql = new stdClass;
						$req_sql->table = "login";
						$req_sql->ctx = new stdClass;
						$req_sql->ctx->password_no_hash = $password;
						$req_sql->ctx->password = $password = password_hash($password, PASSWORD_DEFAULT);
						$req_sql->where = "login = '".$this->user->user_infos->login."'";
						$res_sql = $this->user->update($req_sql);

						if(!$res_sql)
						{
							$subject = "Attention le joueur : ".$this->user->user_infos->login." a voulu changer son mot de passe mais il y a eu un probleme dans la requete.";
							mail(Config::$mail, "Message d'erreur du site Diy N Game.", $subject);
							$_SESSION['error'] = 'Une erreur est survenue, l\'administration en est directement informée merci de patienter vous serez contacté.';
						}
						else
						{
							$_SESSION['error'] = 'Votre mot de passe à bien été changé.';	
						}
			    	}	
		    	}
		    	else
		    	{
		    		$_SESSION['error'] = 'Formulaire mal rempli';
		        	return 0;
		    	}
		    }
		    else
		    {
		        $_SESSION['error'] = 'Formulaire mal rempli';
		        return 0;
		    }
		}
		else
		{
			$_SESSION['error'] = "Attention, Le clients à tenter un priratage";
			return 0;
		}
	}
}