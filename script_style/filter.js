/*******************************************/
/* Filtres - Extrait du site https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_filter_elements */
/*******************************************/
filterSelection("all")
function filterSelection(c) {
	var x, i;
	x = document.getElementsByClassName("filterDiv");	/* Elements � chercher */
	if (c == "all") c = "";		/* Si le bouton selectionn� est all ou "Toutes Cat�gories" */
	for (i = 0; i < x.length; i++) {	/* Parcours de tous les �l�ments de x -> donc filterDiv */
		removeProd(x[i], "show");	/* Supression des �l�ments en fonction du clic bouton */
		if (x[i].className.indexOf(c) > -1) addProd(x[i], "show"); /* Ajout des �l�ments en fonction du clic bouton */
	}
}

function addProd(element, name) {
	var i, arr1, arr2; 
	arr1 = element.className.split(" ");	/* S�paration des �l�ments */
	arr2 = name.split(" ");		/* S�parateur choisi */
	for (i = 0; i < arr2.length; i++) {
		if (arr1.indexOf(arr2[i]) == -1) { element.className += " " + arr2[i]; }
	} /* Si l'�l�ment n'est pas dans le tableau, on lui rajoute le s�parateur plus l'index i */
}

function removeProd(element, name) {
	var i, arr1, arr2;
	arr1 = element.className.split(" ");	/* S�paration des �l�ments */
	arr2 = name.split(" ");		/* S�parateur choisi */
	for (i = 0; i < arr2.length; i++) {
		while (arr1.indexOf(arr2[i]) > -1) {
			arr1.splice(arr1.indexOf(arr2[i]), 1); /* On supprime l'�l�ment d'arr1 en pos 1*/
		}
	}
	element.className = arr1.join(" "); /*Relie �l�ments de arr1 via le s�parateur */
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