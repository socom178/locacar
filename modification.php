<head>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body{
            display:flex;
            justify-content:center;
        }
        form{
            margin-top: 10vh;
            width: 30%;
            height:20vh;
            border-radius:15px;
            padding:10px;
            box-shadow: 0px 0px 5px 0.2px rgb(100, 100, 100);
            
            justify-content:center;
            align-items:center;
        }
        label{
            font-size:16px;
            color: #a07500;
            font-weight:bold;
            text-align:center;
            font-family:'montserrat';
            width: 50%;
            margin-left:25%;
        }
        .input{
            margin-top:1vh;
            width: 80%;
            margin-left:10%;
            padding:6px;
            font-size:15px;
            border:1px solid #bbbbbb;
            font-family:'montserrat';
            border-radius:6px;
        }
        .inputbtn{
            margin-top:0vh;
            width: 30%;
            margin-left:13%;
            padding:6px;
            font-size:15px;
            border:none;
            background-color: #b8b8b8;
            font-family:'montserrat';
            color:black;
            border-radius:6px;
        }
        .inputbtn:hover{
            transition:all 0.3s ease;
            background-color: #be7c00;
        }
    </style>
</head>
<body>
    <?php
        $data = isset($_GET['data']) ? htmlspecialchars($_GET['data']) : "";
        $attribu = isset($_GET['attribu']) ? htmlspecialchars($_GET['attribu']) : "";
    ?>
    <form action="update_personnal_infos.php" method="POST" enctype="multipart/form-data">
        <?php
            echo '<label for="val">'.$attribu.' à modifier :</label> <br />';
            if($attribu=="LANGUE"){
                echo '<select name="langue" id="">';
                echo '<option value="français">Français</option>';
                echo '<option value="anglais">Anglais</option>' ;
                echo '</select><br/>';
            }elseif($attribu=="PASSWORD"){
                header('Location: change.php');
            }elseif($attribu=="PHOTO"){
                echo '<input type="file" name="val" id="file_input" class="input"><br /><br />';
                echo '<input type="hidden" name="attribu" value="'.$attribu.'">';
                echo '<input type="submit" value="Enregistrer" name="photo" class="inputbtn">';
                // Correction ici : on échappe les guillemets pour le onclick
                echo '<button type="button" onclick="window.location.href=\'update_personnal_infos.php\'" class="inputbtn">Annuler</button>';
            
            }else{
                echo '<input type="text" name="val" value="'.$data.'" id="" class="input"><br /><br />';
                echo '<input type="hidden" name="attribu" value="'.$attribu.'"><br />';
                echo '<input type="submit" value="Enregistrer" name="Enrg"  class="inputbtn">';
                echo '<button type="button" onclick="window.location.href=\'update_personnal_infos.php\'" class="inputbtn">Annuler</button>';
            
            }
        ?>    
    </form>
</body>
