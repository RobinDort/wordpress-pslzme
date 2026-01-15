const addVisibleClassesToPslzmeElement = (element) => {
	element.style.visibility = "visible";

	element.classList.remove("pslzme-slide-out-right");
	element.classList.add("pslzme-slide-in-right");
};

const addHiddenClassesToPslzmeElement = (element) => {
	element.classList.remove("pslzme-slide-in-right");
	element.classList.add("pslzme-slide-out-right");
};

const addCookieCallerClickListener = () => {
	const $caller = $("#pslzme-cookie-caller");
	if (!$caller || $caller.length === 0) return;

	$caller.click(function () {
		$("#pslzme-cookiebar").css({
			display: "flex",
			"align-items": "center",
			"justify-content": "center",
		});
	});
};

const controlPslzmeCookieCaller = () => {
	let html = document.querySelector("html");
	const pslzmeCookieCaller = document.getElementById("pslzme-cookie-caller");

	const queriesAreSet = queryParamsSet();

	// Add listener so the cookiebar can be displayed when clicking on the caller.
	addCookieCallerClickListener();

	// Add another listener to scroll behavior to display the caller when the user browses the page.
	window.addEventListener("scroll", function (event) {
		if (html.scrollTop >= 110) {
			if (queriesAreSet.isSet === true) {
				addVisibleClassesToPslzmeElement(pslzmeCookieCaller);
			}
		} else if (html.scrollTop <= 110) {
			if (queriesAreSet.isSet === true) {
				addHiddenClassesToPslzmeElement(pslzmeCookieCaller);
			}
		}
	});
};
