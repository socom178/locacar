<head>
    <link rel="stylesheet" href="./update_personnal_infos.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body{
            background-color: rgb(255, 255, 255);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'montserrat';
            margin-top: 15vh;
        }
        label{
            font-size: 18px;
            border-bottom: 1px solid rgb(124, 124, 124);
        }
        .table{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: rgb(255, 255, 255);
            padding: 10px;
            margin-top: 10vh;
            border-radius: 25px;
            gap: 1vh;
            width: 40%;
            box-shadow: 0px 0px 5px 0.2px rgb(100, 100, 100);
        }
        .tablee{
            width: 90%;
        }

        .boxid{
            margin: 0;
            width: 90%;
            background-color: rgb(236, 236, 236);
            /*box-shadow: 0 0 3px 0.5px #e4e4e4;*/
            border-radius: 10px;
            padding: 5px;
            transition: all 0.3s ease-out;
        }
        .boxid:hover{
            padding: 6px;
            transform: translateY(-15px); 
        /* Ajouter une ombre prononcée */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            transition: all 0.5s ease;
            cursor: pointer;
        }
        .boxid p{
            margin-top: 0vh;
            margin-left: 2.5%;
            font-size: 15px;
            font-family: 'montserrat';
            color: #4d3800;
            font-weight: bold;
        }
        .boxidd{
            display: flex;
            padding: 0px;
            margin-top: -2vh;
            width: 95%;
            margin-left: 2.5%;
            background-color: rgb(236, 236, 236);
        }
        .boxiidd{
            display: flex;
            flex-direction: column;
            padding: 8px;
            margin-top: 0vh;
            
        }
        .boxidd p {
            margin: 0;
            padding:0 !important;
            font-size: 14px;
            font-family: 'montserrat';
            color: rgb(0, 0, 0);
            font-weight: 300;
            background-color: rgb(236, 236, 236);
        }
        .idd{
            width: 90%;
        }
        .photo{
            height: 15vh;
            width: 7vw;
            border-radius: 50%;
        }
        .pen{
            font-size: 1.2rem !important;   
            color: #000 !important;
            transition: color 0.3s;
        }
    </style>
</head>
<body>
    <?php
    
    $compteid=36;
	$db=new PDO('mysql:host=127.0.0.1;dbname=locacar','root','');
	
    if(isset($_GET['task']) && $_GET['task'] == 'modif'){
        // On reprend la donnée brute reçue pour la renvoyer à la page suivante
        $datapasser = $_GET['data'];
        $attribupasser = $_GET['attribu'];
        // On prépare l'URL avec deux paramètres distincts
        $url = 'modification.php?data=' . urlencode($datapasser) . '&attribu=' . urlencode($attribupasser);

        header('Location: ' . $url);
        exit(); 
    }elseif(isset($_POST['Enrg'])){

        $nouvelle_valeur = $_POST['val'];
        $nom_affichage = $_POST['attribu'];

        // Correspondance entre le nom affiché et le nom de la colonne en BDD
        $mapping = [
            'PHOTO' => 'photo_profil',
            'NOM' => 'nom',
            'PRENOM' => 'prenom',
            'telephone' => 'telephone',
            'UTILISATEUR' => 'user_name',
            'LANGUE' => 'langue',
            'NAISSANCE' => 'date_naissance',
            'MAIL' => 'email',
            'LOCALISATION' =>'localisation',
            'SIEGE' =>'siege_sociale',
            'IFU' =>'numero_ifu',
            'REGISTRE' =>'registre_commerce',
            'RAISON' =>'raison_sociale',
            'COMPTE' =>'numero_compte',
            'ADRESSE' =>'adresse_postale',

        ];

        if(isset($mapping[$nom_affichage])){
            $colonneSQL = $mapping[$nom_affichage];
            $champs_utilisateur = [
                'nom', 'prenom', 'telephone', 'user_name', 
                'langue', 'date_naissance', 'email'
            ];

            $champs_proprietaire = [
                'photo_profil','localisation', 'siege_sociale', 'numero_ifu', 
                'registre_commerce', 'raison_sociale', 
                'numero_compte', 'adresse_postale'
            ];

            if (in_array($colonneSQL, $champs_utilisateur)) {
                $sql = "UPDATE utilisateur SET $colonneSQL = ? WHERE id_user = ?";
                $requete = $db->prepare($sql);
                $requete->execute([$nouvelle_valeur, $compteid]);

                echo "<script>alert('Modification réussie !');</script>";
            }

            // 3. Si la colonne appartient à la table PROPRIETAIRE
            if (in_array($colonneSQL, $champs_proprietaire)) {
                $sql = "UPDATE proprietaire SET $colonneSQL = ? WHERE utilisateur_id = ?";
                $requete = $db->prepare($sql);
                $requete->execute([$nouvelle_valeur, $compteid]);

                echo "<script>alert('Modification réussie !');</script>";
            }

                        
        }
    }elseif(isset($_POST['photo'])) {
        $file = $_FILES['val'];

        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileError = $file['error'];

        // 1. Extraire l'extension (ex: jpg, png)
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExt, $allowed)) {
            if ($fileError === 0) {
                // 2. Créer un nom unique pour éviter d'écraser une image existante
                $fileNameNew = "photo_" . uniqid('', true) . "." . $fileExt;
                $fileDestination = 'uploads/' . $fileNameNew;

                // 3. Déplacer le fichier du dossier temporaire vers ton dossier final
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    
                    // 4. Enregistrer le NOM du fichier dans ta base de données
                    $sql = "UPDATE proprietaire SET photo_profil = ? WHERE utilisateur_id = ?";
                    $req = $db->prepare($sql);
                    $req->execute([$fileNameNew, $compteid]);

                    echo "Image enregistrée avec succès !";
                } else {
                    echo "Erreur lors du déplacement du fichier.";
                }
            }
        } else {
            echo "Format d'image non autorisé.";
        }
    }
?>
 

<div class="table">
    <table class="tablee">
    <label for="">INFORMATIONS D'IDENTIFICATION</label>
    <br>
    <?php
        $req=$db->query('SELECT * FROM utilisateur , proprietaire WHERE id_user='.$compteid.' AND id_user=utilisateur_id ');
        while($dt=$req->fetch()){ 
            $data = $dt['photo_profil'].';'.$dt['nom'].';'.$dt['prenom'].';'.$dt['telephone'].';'.$dt['email'].';'.$dt['user_name'].';'.$dt['password'].';'.$dt['langue'].';'.$dt['date_naissance'];
            // On prépare le chemin complet
            $chemin_image = 'uploads/' . $dt['photo_profil'];

            // On vérifie si le fichier existe, sinon on met une image par défaut
            if (empty($dt['photo_profil']) || !file_exists($chemin_image)) {
                $chemin_image = 'images/default-profile.png'; // Une image de secours
            }
            echo '<div class="boxxid">';
                echo '<div class="boxiidd">';
                    echo '<img src="'.$chemin_image.'" alt="" class="photo">';
                    echo '<p><a href="update_personnal_infos.php?attribu=PHOTO&task=modif&data='.$dt['photo_profil'].'">modifier <i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';

            echo '<div class="boxid">';
                echo '<p>NOM</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['nom'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=NOM&task=modif&data='.$dt['nom'].'&attribu=NOM"><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';


            echo '<div class="boxid">';
                echo '<p>PRENOM</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['prenom'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=PRENOM&task=modif&data='.$dt['prenom'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';

            echo '<div class="boxid">';
                echo '<p>NUMERO DE TELEPHONE</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['telephone'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=telephone&task=modif&data='.$dt['telephone'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';

            echo '<div class="boxid">';
                echo '<p>E-MAIL</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['email'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=MAILtask=modif&data='.$dt['email'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';

            echo '<div class="boxid">';
                echo '<p>NOM DE UTILISATEUR</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['user_name'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=UTILISATEUR&task=modif&data='.$dt['user_name'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';

            echo '<div class="boxid">';
                echo '<p>MOT DE PASSE</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['password'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=PASSWORD&task=modif&data='.$dt['password'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';

            echo '<div class="boxid">';
                echo '<p>LANGUE</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['langue'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=LANGUE&task=modif&data='.$dt['langue'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';

            echo '<div class="boxid">';
                echo '<p>DATE DE NAISSANCE</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['date_naissance'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=NAISSANCE&task=modif&data='.$dt['date_naissance'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';
            
        }
    ?>
</table>
</div>


<div class="table">
    <table class="tablee">
    <label for="">INFORMATIONS DE L'ENTREPRISE</label>
    <br>
    <?php
        $req=$db->query('SELECT * FROM proprietaire WHERE utilisateur_id='.$compteid.' ');
        while($dt=$req->fetch()){ 
        $data = $dt['adresse_postale'].';'.$dt['numero_compte'].';'.$dt['raison_sociale'].';'.$dt['registre_commerce'].';'.$dt['numero_ifu'].';'.$dt['siege_sociale'].';'.$dt['localisation'];

            echo '<div class="boxid">';
            echo '<p>ADRESSE POSTALE</p>';  
            echo '<div class="boxidd">';
            echo '<p class="idd">'.$dt['adresse_postale'].'</p>';
            echo '<p><a href="update_personnal_infos.php?attribu=ADRESSE&task=modif&data='.$dt['adresse_postale'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';                echo '</div>';
            echo '</div>';


            echo '<div class="boxid">';
                echo '<p>NUMERO DE COMPTE</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['numero_compte'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=COMPTE&task=modif&data='.$dt['numero_compte'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';

            echo '<div class="boxid">';
                echo '<p>RAISON SOCIALE</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['raison_sociale'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=RAISON&task=modif&data='.$dt['raison_sociale'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';

            echo '<div class="boxid">';
                echo '<p>REGISTRE DE COMMERCE</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['registre_commerce'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=REGISTRE&task=modif&data='.$dt['registre_commerce'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';

            echo '<div class="boxid">';
                echo '<p>NUMERO IFU</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['numero_ifu'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=IFU&task=modif&data='.$dt['numero_ifu'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';

            echo '<div class="boxid">';
                echo '<p>SIEGE SOCIALE</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['siege_sociale'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=SIEGE&task=modif&data='.$dt['siege_sociale'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';

            echo '<div class="boxid">';
                echo '<p>LOCALISATION</p>';  
                echo '<div class="boxidd">';
                    echo '<p class="idd">'.$dt['localisation'].'</p>';
                    echo '<p><a href="update_personnal_infos.php?attribu=LOCALISATION&task=modif&data='.$dt['localisation'].'" ><i class="pen bi bi-pencil-square"></i></a></p>';
                echo '</div>';
            echo '</div>';
            
        }
    ?>
</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
