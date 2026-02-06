function pslzmeRedirection() {
	const noPslzmeCookiebannerPages = ["pslzme-decline.html"];
	const currentLocation = window.location.pathname;

	// DONT redirect when the user visits one of the pages included inside the noPslzmeCookiebannerPages array or the cookie is already set.
	if (noPslzmeCookiebannerPages.includes(currentLocation)) return;
	const userCameFromPslzmeLink = queryParamsSet();

	if (userCameFromPslzmeLink.isSet === true) {
		const actualTargetPage = window.location.pathname.replace("/", "");
		const consentCookie = getCookie("consent_cookie");
		if (!consentCookie) {
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
		} else {
			const decodedCookie = JSON.parse(consentCookie);
			if (decodedCookie.accepted === true && decodedCookie.queryTime === userCameFromPslzmeLink.params.timestamp) return;

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
	if (window.location.search.includes("pslzme-follow")) {
		return; // already redirected once, stop
	}

	// Build redirect URL to accept page
	const queryParamsString = window.location.search.substring(1); // preserve any extra params
	const acceptRedirectUrl =
		pslzmeData.accept_url + "?pslzme-follow=" + encodeURIComponent(actualTargetPage) + (queryParamsString ? "&" + queryParamsString : "");

	// Redirect to accept page
	window.location.href = acceptRedirectUrl;
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
			if (Array.isArray(response) && response.length > 0) {
				resolve(response[0].queryIsLocked);
			} else {
				resolve(null); // or reject(new Error("Invalid response"))
			}
		});
	});
}
