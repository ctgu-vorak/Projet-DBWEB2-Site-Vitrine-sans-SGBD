<?php
if(isset($_GET['page'])) {
    include("pages/foradd.html");
}
?>

<!--Séparation des blocs php pour traitement-->
<?php
    $namefile='base.txt';
    $sizeFile = filesize($namefile);    /* Taille fichier */
    $base = fopen($namefile,"a+");  /* Ouverture du fichier en écriture en plaçant le curseur à la fin */
    /********************************************************************************/
    /********************************************************************************/
    if(isset($_POST['anomalie'])) {     /* Est-ce que le nom est inscrit dans l'input ? */
        $anomalie=$_POST['anomalie'];
        $checkName=fopen($namefile,"r");    /* Ouverture de la base de données texte dans l'optique d'une vérification du nom (en lecture seulement) */
        if($sizeFile!=0) {  /* Si la base n'est pas vide */
            while(!feof($checkName)) {  /* Lecture du fichier */
		        $donnees = fgets($checkName);   /* Chaque ligne est stockée dans l'optique de la vérification */
		        list($nameproduit, $cat, $prix, $vendeur, $image) = explode("|", $donnees); /* Eclatement de la ligne */
                if($nameproduit == $anomalie) {     /* Si le nom entré est identique à un des noms présents */
                    fclose($checkName); 
                    echo "<script>alert('Produit déjà existant sur le site. Veuillez recommencer !')</script>";  /* Fin de lecture et annonce au client */
                    echo '<meta http-equiv="refresh" content="0; url=?page=modifproduits">';    /* Refresh de la page */ 
                } 
            }
        }
        fclose($checkName);     /* Fermeture si rien n'est détecté */
        if( (isset($_POST['categorie'])) && (isset($_POST['prix'])) && (isset($_POST['pseudo'])) ) {
            $cat=$_POST['categorie'];  $prix=$_POST['prix']; $pseudo=$_POST['pseudo'];
            if ((isset($_FILES['image']) && $_FILES['image']['error'] == 0)) {  /* Image renseignée et envoyée sur server ? */
                $file = $_FILES['image'];   /* Nom de l'image après reception sur serveur */
	            $fold = 'pictures/prod/';   /* Chemin vers serveur */
	            $newnamefile = uniqid();    /* Nouveau nom de l'image afin d'en assurer une unicite sur le server */
	            $file_log = pathinfo($_FILES['image']['name']);     /* Stockage des infos sur le chemin */
                $extension_upload = $file_log['extension']; 
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');   /* Extensions d'image autorisées */
                if($_FILES['image']['size'] <= 8388608) { /* Controle de la taille de l'image (8 Mo ou 8388608 Octets max) */
		            if (in_array($extension_upload, $extensions_autorisees)) {
			            move_uploaded_file($_FILES['image']['tmp_name'], $fold.$newnamefile.'.'.$extension_upload);     /* S'assure que le fichier est un fichier téléchargé par POST. Si le fichier est valide, il est déplacé jusqu'au dossier d'image. */	
			            $endFile=$newnamefile.'.'.$extension_upload;    /* Nom final de l'image sur le serveur */
                        $prod = $anomalie."|".$cat."|".$prix."|".$pseudo."|".$endFile;   /* Concaténation pour écriture */
                        if($sizeFile == 0) {    /* Si la base est vide */
                            fputs($base,$prod); fclose($base);  /* Ecriture puis fermeture */
                            echo "<script>alert('Article publié. Bonne continuation sur notre site !')</script>";   /* Alerte utilisateur */
                            echo '<meta http-equiv="refresh" content="0; url=?page=produits">';     /* Refresh de la page */ 
                        }
                        else {  /* Si la base contient déjà des articles */                         
                            fputs($base,"\n"); fputs($base,$prod); fclose($base);   /* Saut de ligne, écriture puis fermeture */
                            echo "<script>alert('Article publié. Bonne continuation sur notre site !')</script>";   /* Alerte utilisateur */
                            echo '<meta http-equiv="refresh" content="0; url=?page=produits">';     /* Refresh de la page */
                        } 
		            }
                    else {fclose($base);}
                }
                else {fclose($base); }
            }
            else {fclose($base);}                  
        }
        else {fclose($base);}
    }
    else {fclose($base);}
    
?>