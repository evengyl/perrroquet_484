<?

class Model_annonces
{
	public function __construct()
	{
		$this->id = new NormalType("id");
		$this->title = new NormalType("title");
		$this->sub_title = new NormalType("sub_title");
		$this->id_utilisateurs = new NormalType("id_utilisateurs");
		$this->id_type_vacances = new NormalType("id_type_vacances");
		$this->pays_name_human = new OneToOneType("pays", "name_human", "id_pays");
		

		$this->active = new NormalType("active");
		$this->user_validate = new NormalType("user_validate");
		$this->admin_validate = new NormalType("admin_validate");
		$this->create_date = new NormalType("create_date");
		$this->vues = new NormalType("vues");


		$this->habitat_name_human = new OneToOneType("habitat", "name_human", "id_habitat");
		$this->habitat_name_sql = new OneToOneType("habitat", "name_sql", "id_habitat");
		$this->habitat_img = new OneToOneType("habitat", "img", "id_habitat");
		$this->habitat_text = new OneToOneType("habitat", "text", "id_habitat");

		$this->sport = new ManyToManyType("sport", "id", "id");
		$this->activity = new ManyToManyType("activity", "id", "id");
		$this->text_sql_to_human = new ManyToManyType("text_sql_to_human", "", "");

		$this->address = new ManyToManyType("annonce_address", "id", $second_where = "id");
		$this->commoditer_announces = new OneToManyType("commoditer_announces", "id");

		$this->private_message = new ManyToManyType($table = "private_message", $link_a_to_b = "id_utilisateurs", $second_where = "id_annonce");
		
		$this->date_annonces = new ManyToManyType($table = "date_annonces", $link_a_to_b = "id_utilisateurs", $second_where = "id_annonce");

		$this->price = new OneToManyType("range_price_announce", "id");

		$this->id_user = new OneToOneType("utilisateurs", "id", "id_utilisateurs");
		$this->user_name = new OneToOneType("utilisateurs", "name", "id_utilisateurs");
		$this->user_last_name = new OneToOneType("utilisateurs", "last_name", "id_utilisateurs");

	}
}