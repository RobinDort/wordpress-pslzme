function pslzmeQueryClickListener() {
	const queryParams = queryParamsSet();

	if (queryParams.isSet === true) {
		// Define the click listener as a named function
		const clickHandler = function (event) {
			const eventTarget = event.target;

			// Find the closest link (anchor) or button up the tree
			const clickable = eventTarget.closest("a, button, canvas, img");

			// If nothing clickable was clicked, ignore
			if (!clickable) return;

			if (clickable.tagName === "A" && clickable.target === "_blank") return;

			if (clickable.classList.contains("pslzme-cookiebar-close-btn") || clickable.classList.contains("pslzme-cookiebar-save-btn")) return;

			event.preventDefault();

			// Remove listener if external link
			if (clickable.tagName === "A" && !isSameDomain(clickable.href)) {
				document.removeEventListener("click", clickHandler);
			}

			// Determine the target URL
			let targetUrl = null;

			if (clickable.tagName === "A") {
				targetUrl = clickable.href;
			} else if (clickable.tagName === "BUTTON" && clickable.dataset.href) {
				targetUrl = clickable.dataset.href; // optional: buttons can store URL in data-href
			} else if ((clickable.tagName === "IMG" || clickable.tagName === "CANVAS") && clickable.closest("a")) {
				// Image or canvas inside a link
				targetUrl = clickable.closest("a").href;
			}

			if (!targetUrl) return; // nothing to redirect to

			const url = new URL(targetUrl);

			// Redirect to the new URL with query parameters
			window.location.href =
				url.toString() +
				"?q1=" +
				queryParams.params.linkCreator +
				"&q2=" +
				queryParams.params.title +
				"&q3=" +
				queryParams.params.firstname +
				"&q4=" +
				queryParams.params.lastname +
				"&q5=" +
				queryParams.params.company +
				"&q6=" +
				queryParams.params.gender +
				"&q7=" +
				queryParams.params.position +
				"&q8=" +
				queryParams.params.curl +
				"&q9=" +
				queryParams.params.fc +
				"&q10=" +
				queryParams.params.timestamp +
				"&q11=" +
				queryParams.params.companyGender +
				"&q12=" +
				queryParams.params.address +
				"&q13=" +
				queryParams.params.housenumber +
				"&q14=" +
				queryParams.params.postcode +
				"&q15=" +
				queryParams.params.place +
				"&q16=" +
				queryParams.params.country;
		};

		// Attach the listener
		document.addEventListener("click", clickHandler);
	}
}

function isSameDomain(url) {
	const currentDomain = window.location.hostname;
	const clickedDomain = new URL(url).hostname;
	return currentDomain === clickedDomain;
}
