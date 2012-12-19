<script type="text/javascript" >
    jQuery(document).ready(function(){
	/////// CAPTCHA  /////
	jQuery("#captreload").click(function(){
	    jQuery("#captcha").attr("src", "capt.php?"+new Date().getTime());
	});
	jQuery("#ok").hide(); 

	jQuery("#code").keyup(function () {
	    var code = jQuery(this).val();			
	    var result = 
		jQuery.ajax({
		type: "POST",
		url: "./valid.php",
		data: "code="+code,
		success: function(msg){
		    if(msg == "true"){
			jQuery("#ok").show();
			jQuery("#send").removeAttr("disabled");
		    }else{
			jQuery("#ok").hide();
			jQuery("#send").attr("disabled","disabled");
		    }
		}							   
	    });			
	}).keyup();
    });
</script>

<?php
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
$courriel = isset($_POST['courriel']) ? $_POST['courriel'] : '';
$tel = isset($_POST['tel']) ? $_POST['tel'] : '';
$adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
$cp = isset($_POST['cp']) ? $_POST['cp'] : '';
$ville = isset($_POST['ville']) ? $_POST['ville'] : '';
$titre = isset($_POST['titre']) ? $_POST['titre'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';
?>

<h1>Pour tout renseignement, devis, n'hésitez pas, contactez-nous ...</h1>

<form action="mailer.php" method="post" id="courrier" onsubmit="return valideForm()">
    <fieldset>
        <legend>Les champs suivis d'une * sont obligatoires</legend>
        <p> 
            Mme
            <input type="radio" name="titre" value="Madame" />
            Mlle
            <input type="radio" name="titre" value="Mademoiselle" />
            M.
            <input type="radio" name="titre" value="Monsieur" />
        </p>
        <table border="0" cellpadding="0" cellspacing="0" class="sans-bord" >
            <tr>
                <td>Nom : </td>
                <td><input name="nom" id="nom" type="text" value="<?php echo $nom ?>" size="40" maxlength="70" tabindex="4"/>*</td>
            </tr>
            <tr>
                <td>Prénom : </td>
                <td><input name="prenom" id="prenom" type="text" value="<?php echo $prenom ?>" size="40" maxlength="70" tabindex="5"/></td>	
            </tr>
            <tr>
                <td>Courriel : </td>
                <td><input name="courriel" id="courriel" type="text" value="<?php echo $courriel ?>" size="40" maxlength="70" tabindex="6" />*</td>
            </tr>   
            <tr>
                <td>Téléphone :</td>
                <td><input name="tel" id="tel" type="text" value="<?php echo $tel ?>" size="40" maxlength="70" tabindex="7" />*</td>
            </tr>      
            <tr>
                <td>Adresse :</td>
                <td><input name="adresse" id="adresse" type="text" value="<?php echo $adresse ?>" size="40" maxlength="70" tabindex="8" /></td>
            </tr>   
            <tr>
                <td>Code postal :</td>
                <td><input name="cp" id="cp" type="text" value="<?php echo $cp ?>" size="40" maxlength="70" tabindex="9" /></td>
            </tr>   
            <tr>
                <td>Ville : </td>
                <td><input name="ville" id="ville" type="text" value="<?php echo $ville ?>" size="40" maxlength="70" tabindex="10" /></td>
            </tr>   

        </table>       
    </fieldset>
    <fieldset>
        <legend>Votre demande</legend>
        <table border="0" cellpadding="0" cellspacing="0" class="sans-bord" >
            <tr>
                <td>&nbsp;</td>
                <td><textarea id="message" name="message" cols="44" rows="10" class="champ" tabindex="11" ><?php echo $message ?></textarea></td>
	    </tr>                
        </table>       
    </fieldset>
    <div id="affiche-masque-captcha">
        <p class="center"><img src="capt.php" id="captcha" class="captcha" alt="Captcha"/><a id="captreload"><img src='images/reload.png' alt='Modifier' /></a></p>
        <p class="center">Avant de valider votre demande, veuillez recopier le code ci-dessus<br />Si vous avez des difficultés à lire le code, renouvellez ce dernier en cliquant le bouton<br /><br /><input type="text" name="code" id="code" /><span id="ok"><img src='images/tick.png' alt='Code valide' /></span></p>
    </div>
    <p class="center">
        <input name="button"  type="submit" class="texte" id="send" value="Envoyer" disabled="disabled" />
    </p>
</form>
