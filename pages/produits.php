<br><div class="w3-container">
	<div id="navFilter" class="w3-container w3-bar w3-justify w3-black">
		<p style="font-size: 20px; margin:15px"><b>Choisissez les catégories que vous souhaitez voir</b></p>
		<button class="w3-bar-item w3-black w3-hover-blue" class="btn" onclick="filterSelection('all')"> Toutes les catégories </button>
		<button class="w3-bar-item w3-black w3-hover-red" class="btn" onclick="filterSelection('Keter')"> Keter </button>
		<button class="w3-bar-item w3-black w3-hover-orange" class="btn" onclick="filterSelection('Euclide')"> Euclide </button>		
		<button class="w3-bar-item w3-black w3-hover-green" class="btn" onclick="filterSelection('Safe')"> Safe </button>		
	</div>

<?php
$namefile = "base.txt";
$sizeFile = filesize($namefile);
$file = fopen($namefile,"r");
if($sizeFile!=0) {
	echo "
	<br>
	<div class='w3-justify'>
	<b>
        Afin de p&eacute;r&eacute;niser notre site ainsi que dans un souci de fonctionnement permanent, <br>
        la Fondation nous autorise, au moment de la transaction sur le site marchand,
        de pr&eacute;lever une commission de 5%.<br><br>
    </b>
    Sachez que la catégorie de l'anomalie ne reflète pas sa dangerosité, mais sa capacité à être confinée. <br>
    <strong><u>Exemple <i>(tout bête bien sûr)</i> :</u></strong><br />
    Imaginez une baguette de pain tuant n'importe qui la touchant mais qui ne peut pas bouger.
    Elle est dangereuse car elle tue. <br />
	Cependant, pour la confiner, un simple coffre-fort dans un bureau suffit et le tour est réglé. 
	Elle sera classée comme <strong><code>Safe</code></strong>.<br>
    En revanche, si elle fut animée, il aurait fallu  l'enfermer dans un coffre-fort blindé, dans une salle hermetique avec un vide intégral. <br>
	L'anomalie aurait classée comme <strong><code>Keter</code></strong> car la difficulté de confinement est bien plus sévère.
	</div><br>
	<div class='container'>
	";
	$i = 0;
	$id = 0;
	while(!feof($file)) {
		$data = fgets($file);
		list($name_prod, $cat, $price, $saler, $pic) = explode("|", $data);
		echo "
		<div class='filterDiv $cat'>
			<div class='w3-center w3-card w3-col' style='width:30%'>
				<div class='w3-container'>
				<header>
					<p style='font-size:20px'> <u><b>Catégorie :</b></u> $cat </p></header>
					<p>
						<u><b>Nom :</b></u> <a href='http://fondationscp.wikidot.com/$name_prod' target='_blank'>$name_prod </a>
					</p>
					<div id='picprod'>
						<img src='pictures/prod/$pic' width='auto' height='100px' align='middle' style='vertical-align:middle'> <br>
					</div>
					<br>
					<footer>
						<div>
							<div class='w3-half w3-center' style='font-size:9px'>
								<u><b>Vendeur :</b></u><br /> $saler 
							</div>
							<div class='w3-half w3-center' style='font-size:9px'>
								<u><b>Prix : </b></u> <br /> $price €  <br>
							</div>
						</div><br><br>				
						<form class='w3-container w3-center' action='index.php' method='get'>
							<button class='w3-button w3-round-small w3-black w3-hover-blue' name='id-modifproduits' value='$i' onclick='alertMod()'> Modifier </button>
						</form><br>
						<form class='w3-container w3-center' action='?page=produits' method='post'>							
							<button class='w3-button w3-round-small w3-black w3-hover-red' name='sup' value='$i' type='submit' > Supprimer</button>
						</form><br>
					</footer>
				</div>
			</div>
		</div>
		";
		$i++;		
	}
	if(isset($_POST['sup'])) {
		$var = $_POST['sup'];
		$study = (int) $var;							/* Cast de la valeur $_POST en integer pour parcourir le tableau */
		$ptr = fopen($namefile, "r");					/* Ouverture du fichier en lecture simple en partant du début */
		$contenu = fread($ptr, filesize($namefile));	/* Lit jusqu'à l'octet final défini par la taille du fichier 'filesize' */
		fclose($ptr);									/* On a plus besoin du pointeur */
		$contenu = explode("\n", $contenu);				/* Eclatement du fichier dans un tableau. Chaque index étant un produit avec ces caracteristiques (nom, prix, photo etc...*/		
		unset($contenu[$study]);						/* Suppression de l'élément demandé */		
		$contenu = array_values($contenu);				/* Ré-indexation de l'array */
		/* Reconstruction du tableau pour le nouvel affichage des produits */
		$contenu = implode("\n", $contenu);				/* Rassemble les éléments d'un tableau en un str en respectant l'espace entre chaque produit (\n). */
		$ptr = fopen($namefile, "w");					/* Ouverture du fichier en lecture simple en partant du début et en le vidant entierement */
		fwrite($ptr, $contenu);							/* Ecrit le contenu de l'array */
		fclose($ptr);									/* Fermeture du fichier */
		echo '<meta http-equiv="refresh" content="0; url=?page=produits">'; /* Refresh de la page */
	}
	echo"</div>";
}

else
	echo "<p class='w3-center'> 
	Nous sommes désolés mais aucun produit n'est disponible actuellement. <br>
	Veuillez réessayer ultéreurement.
	</p>";
?>
<script>
function alertMod() {
	alert("Dès que vous cliquerez sur 'OK', vous devez vous engager à modifier le produit en question. Si jamais vous vous désistez en cours de modification, le produit sera considéré comme supprimé. VCLS n'est pas responsable de vos erreurs.");
}
</script>