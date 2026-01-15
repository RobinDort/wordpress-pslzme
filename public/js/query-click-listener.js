function pslzmeQueryClickListener() {
	const queryParams = queryParamsSet();

	if (queryParams.isSet === true) {
		// Attach a click event listener to the document
		document.addEventListener("click", function (event) {
			// Check if the clicked element matches the selector
			const eventTarget = event.target;

			// cookiebar gets closed -> no need to pass the pslzme queries
			if (eventTarget.classList.contains("pslzme-cookiebar-close-btn")) return;

			if (eventTarget.tagName === "A" || eventTarget.tagName === "IMG" || eventTarget.tagName === "CANVAS" || eventTarget.tagName === "BUTTON") {
				// Check if the anchor has target = _blank. In this case the function does not need to pass the pslzme queries.
				const linkElement = eventTarget.closest("a");
				if (linkElement && linkElement.target === "_blank") {
					return;
				}
				event.preventDefault();

				if (isSameDomain(linkElement.href)) {
					window.location.href =
						linkElement.href +
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
				} else {
					// remove click listener
					event.target.removeEventListener("click", arguments.callee);
				}
			}
		});
	}
}

function isSameDomain(url) {
	const currentDomain = window.location.hostname;
	const clickedDomain = new URL(url).hostname;
	return currentDomain === clickedDomain;
}
