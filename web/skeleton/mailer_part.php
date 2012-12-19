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

$destinataire = "##EMAIL##";

// APPEL DE LA CLASS MAIL*
require_once dirname(__FILE__).'/../../vendor/swiftmailer/swiftmailer/lib/swift_required.php';
function swiftmailer_configurator() {
    Swift_DependencyContainer::getInstance();
    Swift_Preferences::getInstance();
}
Swift::init('swiftmailer_configurator');
// Create the Transport
// Mail
$transport = Swift_MailTransport::newInstance();
// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

$sujet = "Contact à partir du site ##SITENAME##";
$body = "********** CLIENT(E) **********\n\n";
$body .= "$titre $prenom $nom .\n";
$body .= "$adresse - $cp - $ville.\n";
if ($tel != "") {  $body .= "Téléphone : $tel \n"; }
if ($courriel != "") { $body .= "Courriel : $courriel \n"; }
$body .= "\n\n";
$body .= "*********** DEMANDE ***********\n\n";
$body .= "$message .\n";
$body .= "\n\n";
$body .= "****** FIN DU TRAITEMENT  *****\n\n";
$body .= "\n\n";

$mailmessage = new Swift_Message();
$mailmessage->setCharSet("UTF-8");
$mailmessage->setFrom( array($courriel=>$nom) );
$mailmessage->setTo($destinataire);
$mailmessage->setReplyTo($courriel);
$mailmessage->setSubject($sujet);
$mailmessage->setBody(null);
$mailmessage->addPart($body,'text/html','UTF-8');

if ( !$mailer->send($mailmessage, $failures) ) { //Teste le return code de la fonction
    echo "Erreurs lors de l'envoi du message :"; print_r( $failures );
} else {
    echo 'Votre demande a été envoyée avec succès et sera traitée dans les plus brefs délais.<br /><br /><br />';
}
?>

<form action="contact.php" method="POST">    
    <?php
    foreach ($_POST as $key => $element) {
	print "<input type='hidden' name='$key' value='$element' />";
    }
    ?>
    <input type="submit" value="Retour au formulaire" id="bouton-envoyer" />
</form>	