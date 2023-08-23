
/**
 * Every time admin presses one tab
 * The previous active tab will disapear
 * and the new clicked tab will be viewd.
 * Also the new tab name will be shaded.
 *  */
window.addEventListener("load", function() {

	// store tabs variables
	var tabs = document.querySelectorAll("ul.nav-tabs > li");

	//add event listener for every tab.(Mouse listener->activated on click)
	for (i = 0; i < tabs.length; i++) {
		tabs[i].addEventListener("click", switchTab);
	}



	function switchTab(event) {
		event.preventDefault();

		/*Remove the shadow from the old opened tab tag(By removing this element from the active class) */
		document.querySelector("ul.nav-tabs li.active").classList.remove("active");

		/*Remove the previous opened tab from the main page */
		document.querySelector(".tab-pane.active").classList.remove("active");


		/*Get the clicked element: */
		var clickedTab = event.currentTarget;

		/*Get the id of the clicked tab */
		var anchor = event.target;
		var activePaneID = anchor.getAttribute("href");


		/*Add the shadow to the opened tab tag(By adding this element to the active class) */
		clickedTab.classList.add("active");

		/*Add the clicked tab to the active class so it will be showed. */
		document.querySelector(activePaneID).classList.add("active");

	}

});