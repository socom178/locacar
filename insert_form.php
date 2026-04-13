<?php


	$nom='';$prenom=''; $phone=''; $mail=''; $username=''; $pwd='';
	$db=new PDO('mysql:host=127.0.0.1;dbname=locacar','root','');
	if(isset($_POST['btn']) && $_POST['btn']=='enregistrer'){
		$db->beginTransaction();
        $db->query('insert into utilisateur(nom,prenom,telephone,email,user_name,password) values("'.$_POST['nom'].'","'.$_POST['prenom'].'","'.$_POST['phone'].'","'.$_POST['mail'].'","'.$_POST['username'].'","'.$_POST['pwd'].'")');
        $compteid = $db->lastInsertId();
        $db->query('insert into proprietaire(date_naissance,langue,photo_profil,adresse_postale,numero_compte,raison_sociale,registre_commerce,numero_ifu,siege_sociale,localisation,utilisateur_id) 
                values("'.$_POST['date_naissance'].'","'.$_POST['langue'].'","'.$_POST['photo_profil'].'","'.$_POST['adrp'].'","'.$_POST['numc'].'","'.$_POST['raisso'].'","'.$_POST['regcom'].'","'.$_POST['numifu'].'","'.$_POST['siegeso'].'","'.$_POST['loca'].'","'.$compteid.'")');
        $db->commit();
        echo "Enregistrement réussi !";
    }
?>
<form method="POST" action="insert_form.php">
	<fieldset>
        <legend>Informations d'ientification du gerant</legend>
        <input type="file" name="photo_profil" id=""><br /><br />
        <input type="text" name="nom" value="<?=$nom?>" placeholder="nom" /><br />
        <input type="text" name="prenom" value="<?=$prenom?>" placeholder="prenom" /><br />
        <input type="tel" name="phone" value="<?=$phone?>" placeholder="phone" /> <br>
        <input type="email" name="mail" value="<?=$mail?>" placeholder="mail" /><br />
        <input type="text" name="username" value="<?=$username?>" placeholder="username" /><br />
        <select name="langue" id="">
            <option value="français">Français</option>
            <option value="anglais">Anglais</option> 
        </select><br/>
        <input type="date" name="date_naissance" id="" placeholder="date de naissance"><br/>       
        <input type="password" value="<?=$pwd?>" name="pwd" id="" placeholder="password" /> <br/>

        
    </fieldset>
	
	<fieldset>
        <legend>Information d'identification de l'entreprise</legend>
        <input type="text" name="adrp" id="" placeholder="Adresse postale"><br />
        <input type="text" name="numc" id="" placeholder="Numero de compte"><br />
        <input type="text" name="raisso" id="" placeholder="raison sociale"><br />
        <input type="text" name="regcom" id="" placeholder="registre de commerce"><br />
        <input type="text" name="numifu" id="" placeholder="numero ifu"><br />
        <input type="text" name="siegeso" id="" placeholder="siege sociale"><br />
        <input type="text" name="loca" id="" placeholder="localisation"><br />                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      ²<
    </fieldset>
	
    <input type="submit" name="btn" value="enregistrer" />
</form>
