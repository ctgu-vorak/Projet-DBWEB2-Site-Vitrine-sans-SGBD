/*******************************************/
/* Filtres - Extrait du site https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_filter_elements */
/*******************************************/
filterSelection("all")
function filterSelection(c) {
	var x, i;
	x = document.getElementsByClassName("filterDiv");	/* Elements à chercher */
	if (c == "all") c = "";		/* Si le bouton selectionné est all ou "Toutes Catégories" */
	for (i = 0; i < x.length; i++) {	/* Parcours de tous les éléments de x -> donc filterDiv */
		removeProd(x[i], "show");	/* Supression des éléments en fonction du clic bouton */
		if (x[i].className.indexOf(c) > -1) addProd(x[i], "show"); /* Ajout des éléments en fonction du clic bouton */
	}
}

function addProd(element, name) {
	var i, arr1, arr2; 
	arr1 = element.className.split(" ");	/* Séparation des éléments */
	arr2 = name.split(" ");		/* Séparateur choisi */
	for (i = 0; i < arr2.length; i++) {
		if (arr1.indexOf(arr2[i]) == -1) { element.className += " " + arr2[i]; }
	} /* Si l'élément n'est pas dans le tableau, on lui rajoute le séparateur plus l'index i */
}

function removeProd(element, name) {
	var i, arr1, arr2;
	arr1 = element.className.split(" ");	/* Séparation des éléments */
	arr2 = name.split(" ");		/* Séparateur choisi */
	for (i = 0; i < arr2.length; i++) {
		while (arr1.indexOf(arr2[i]) > -1) {
			arr1.splice(arr1.indexOf(arr2[i]), 1); /* On supprime l'élément d'arr1 en pos 1*/
		}
	}
	element.className = arr1.join(" "); /*Relie éléments de arr1 via le séparateur */
}

var btnContainer = document.getElementById("navFilter");
var btns = btnContainer.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
	btns[i].addEventListener("click", function () {
		var current = document.getElementsByClassName("active");
		current[0].className = current[0].className.replace(" active", "");
		this.className += " active";
	});
}	