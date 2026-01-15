function pslzmeRedirection() {
	const noPslzmeCookiebannerPages = ["pslzme-decline.html"];
	const currentLocation = window.location.pathname;

	// DONT redirect when the user visits one of the pages included inside the noPslzmeCookiebannerPages array.
	if (!noPslzmeCookiebannerPages.includes(currentLocation)) {
		const userCameFromPslzmeLink = queryParamsSet();

		if (userCameFromPslzmeLink.isSet === true) {
			const actualTargetPage = window.location.pathname.replace("/", "");

			//before anything else, check if the query is locked because someone has inserted the name wrongly for three times.
			checkQueryIsLocked(userCameFromPslzmeLink).then((queryLocked) => {
				if (queryLocked) {
					handleRedirectionToLockedPage(actualTargetPage);
					return;
				} else {
					// query is not locked. Proceed to redirect to the acception page when the params are set, the cookie is still undefined and the acception page itself is not opened at the moment.
					handleRedirectionToAcceptionPage(userCameFromPslzmeLink, actualTargetPage);
					return;
				}
			});
		}
	}
}

function handleRedirectionToLockedPage(actualTargetPage) {
	// the query is locked -> redirect to the QueryDeclined page.
	window.location.href = window.location.origin + "/pslzme-decline.html?pslzme-follow=" + actualTargetPage;
	return;
}

function handleRedirectionToAcceptionPage(userCameFromPslzmeLink, actualTargetPage) {
	const consentCookie = getCookie("consent_cookie");
	let consentCookieAccepted = true;

	if (consentCookie === undefined) {
		consentCookieAccepted = false;
	}

	// This checks if the user used another/new pslzme link instead of the one he may have accepted before
	if (consentCookie !== undefined) {
		const decodedCookie = JSON.parse(consentCookie);
		if (decodedCookie.queryTime !== userCameFromPslzmeLink.params.timestamp) {
			consentCookieAccepted = false;
		}
	}

	if (userCameFromPslzmeLink.isSet === true && consentCookieAccepted === false && !userCameFromPslzmeLink.params.hasOwnProperty("acceptionParam")) {
		const queryParamsString = window.location.search.substring(1);
		const plszmeAcceptionParam = "?plszme-follow=" + actualTargetPage + "&" + queryParamsString;

		window.location.href = window.location.origin + "/pslzme-accept.html" + plszmeAcceptionParam;
	}
}

function checkQueryIsLocked(urlParams) {
	// send a request to check wether the current query link is locked or not.
	const requestData = {
		timestamp: urlParams.params.timestamp,
	};

	const requestObject = {
		data: JSON.stringify(requestData),
		request: "query-lock-check",
	};

	return new Promise(function (resolve) {
		handleAPIRequest(requestObject).then((response) => {
			resolve(response.queryIsLocked);
		});
	});
}
