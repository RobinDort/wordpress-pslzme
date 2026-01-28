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
	if (!pslzmeData.decline_url) {
		console.error("Decline URL is not defined in pslzmeData");
		return;
	}

	const redirectUrl = pslzmeData.decline_url + "?pslzme-follow=" + encodeURIComponent(actualTargetPage);
	window.location.href = redirectUrl;
}

function handleRedirectionToAcceptionPage(userCameFromPslzmeLink, actualTargetPage) {
	if (!userCameFromPslzmeLink.isSet) return;

	const consentCookie = getCookie("consent_cookie");
	let consentCookieAccepted = false;

	if (consentCookie) {
		try {
			const decodedCookie = JSON.parse(consentCookie);
			consentCookieAccepted = decodedCookie.queryTime === userCameFromPslzmeLink.params.timestamp;
		} catch (e) {
			console.warn("Invalid consent cookie, ignoring.");
		}
	}

	// Already on accept page? Then do nothing
	if (window.location.href.startsWith(pslzmeData.accept_url)) return;

	if (!consentCookieAccepted && !userCameFromPslzmeLink.params.hasOwnProperty("acceptionParam")) {
		const queryParamsString = window.location.search.substring(1);
		const redirectUrl = pslzmeData.accept_url + "?pslzme-follow=" + encodeURIComponent(actualTargetPage) + (queryParamsString ? "&" + queryParamsString : "");

		window.location.href = redirectUrl;
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
