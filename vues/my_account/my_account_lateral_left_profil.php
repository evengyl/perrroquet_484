<div style="text-align: center; text-transform: none; margin-top: -65px;">
	<div class="content-image-profil">
        <span><?
        if($_app->user->genre == "Monsieur")
            echo '<i class="fas fa-chess-king" style="color:#318cdd;"></i>';
        else if($_app->user->genre == "Madame" || $_app->user->genre == "Mademoiselle")
            echo '<i class="fas fa-chess-queen" style="color:#ff6ca3;"></i>';
        else
            echo '<i class="fas fa-chess-rook" style="color:#9c7ccf;"></i>';?>
    	</span>
    </div>
	<h4><?= ucfirst($_app->user->last_name)." ".ucfirst($_app->user->name) ?></h4>
    <h5><?= ucfirst($_app->user->login) ?></h5>
	<p class="text-muted" ><small>@Type D'utilisateur : <b><?= $_app->can_do_user->text_user_type ?></b></small></p>
</div>

<p class="text-muted">
	<small>@Adresse Email : <b><?= $_app->user->email ?></b></small>
</p>
<p class="text-muted">
    @Tel : <b><?= $_app->user->tel ?></b>
</p>
<p class="text-muted">
    @Adresse : <b><?= $_app->user->address_numero.", Rue ".ucfirst($_app->user->address_rue)." à ".$_app->user->zip_code." : ".ucfirst($_app->user->address_localite) ?></b>
</p>
<hr>
<div class="block_suivis"><?
    if($_app->can_do_user->view_infos_annonce)
    {?>
        <h4>
            <?= $_app->user->nb_annonces ?>&nbsp;&nbsp;<span class="glyphicon glyphicon-tags"></span><br>
            <small>Annonces crées</small><br>
            <small>Dont <?= $_app->user->nb_annonces_active ?> Active(s)</small>
        </h4><hr>
    
        <h4>
        	<?= $_app->user->nb_vues_total ?>&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open"></span><br>
        	<small>Vues sur le total de vos annonce, actives ou non</small>
        </h4><hr><?
    }?>
    <h4>
    	<?= $_app->user->total_private_message; ?>&nbsp;&nbsp;<span class="glyphicon glyphicon-comment"></span><br>
        <small>Message(s) au total</small><br>
        <small>Dont <?= ($_app->user->private_message_not_view != 0)?'<b style="color:red;">'.$_app->user->private_message_not_view.'</b>':''; ?> Non lu(s)</small>
    </h4><hr>
</div>
