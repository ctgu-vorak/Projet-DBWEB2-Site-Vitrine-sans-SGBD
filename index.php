<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>VCLS Recup.</title>
    <link rel="stylesheet" href="script_style/style.css" type="text/css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-grey.css" />
    <link rel="icon" href="pictures/forsite/VCLS.ico" />
    <script src="script_style/filter.js"></script>
</head>
<body>
    <noscript>
        Votre navigateur n'accepte pas le JavaScript. En conséquence, l'interactivité de la page est altérée. Veuillez changer de navigateur pour l'activer.
    </noscript>
    <div class="w3-mobile">
        <header class="w3-center w3-border">
            <div class="w3-container w3-theme-l2">
                <div id="leftheader">
                    <img id="leftHeadPic" src="pictures/forsite/vcls.png" title="VCLS Recup."><br />                   
                </div>
                    <a href="http://fondationscp.wikidot.com/" title="Fondation SCP" target="_blank">
                        <img id="rightHeadPic" src="pictures/forsite/SCP.png"><br />
                    </a>                
            </div>
        </header>
        <div class="w3-container">
            <div class="w3-col w3-padding-small" style="width:20%">
                <?php
                    echo "<p align='left'><b> Menu de navigation : </b></p>";
                    include("pages/selection.php");
                ?>
            </div>
            <div class="w3-col w3-padding-small" style="width:80%">
            <?php
                if (isset($_GET['page']))
	            {
                    if ($_GET['page'] == 'init') { include("pages/init.php"); }
                    if ($_GET['page'] == 'produits') { include("pages/produits.php"); }
                    if ($_GET['page'] == 'modifproduits') { include("pages/modifproduits.php"); }
                }
                elseif(isset($_GET['id-modifproduits'])) 
                {   
                    /* Ici on supprime le produit à modifier puis seulement après on fait la modification. */
                    $namefile = "base.txt";
		            $var = $_GET['id-modifproduits'];
		            $study = (int) $var;							/* Cast de la valeur $_POST en integer pour parcourir le tableau */
		            $ptr = fopen($namefile, "r");					/* Ouverture du fichier en lecture simple en partant du début */
		            $contenu = fread($ptr, filesize($namefile));	/* Lit jusqu'à l'octet final défini par la taille du fichier 'filesize' */
		            fclose($ptr);									/* On a plus besoin du pointeur */
		            $contenu = explode("\n", $contenu);				/* Eclatement du fichier dans un tableau. Chaque index étant un produit avec ces caracteristiques (nom, prix, photo etc...) */
		            unset($contenu[$study]);						/* Suppression de l'élément demandé */		
		            $contenu = array_values($contenu);				/* Ré-indexation de l'array */

		            /* Reconstruction du tableau pour le nouvel affichage des produits */
		            $contenu = implode("\n", $contenu);				/* Rassemble les éléments d'un tableau en un str en respectant l'espace entre chaque produit (\n). */
		            $ptr = fopen($namefile, "w");					/* Ouverture du fichier en lecture simple en partant du début et en le vidant entierement */
		            fwrite($ptr, $contenu);							/* Ecrit le contenu de l'array */
		            fclose($ptr);									/* Fermeture du fichier */
                    include("pages/formod.html");                   /* Ouverture du Formulaire de modification */
                }
                else { include("pages/init.php"); } //include("pages/formod.html");
            ?>
            </div>                   
        </div>
    </div>
</body>
<footer>
<?php
    include("pages/pied.html");
?>
</footer>
</html>