function handleCookie(accepted, queryLocked = false) {
	// first reset the inserted input from the name restriction.
	const firstInput = $("#name-verifiyer input:eq(0)");
	const secondInput = $("#name-verifiyer input:eq(1)");
	const thirdInput = $("#name-verifiyer input:eq(2)");

	firstInput.value = "";
	secondInput.value = "";
	thirdInput.value = "";

	//only works with IMPORT url-query-data-filter.js!! -> js file must be imported before the use of this function
	const urlParams = queryParamsSet();

	if (urlParams !== undefined) {
		if (urlParams.isSet === true) {
			let convertedCookieAccepted = 0;
			let convertedQueryLocked = 0;

			if (accepted) {
				convertedCookieAccepted = 1;
			}

			if (queryLocked) {
				convertedQueryLocked = 1;
			}

			const requestData = {
				linkCreator: decodeURIComponent(urlParams.params.linkCreator).replaceAll(" ", "+"),
				title: decodeURIComponent(urlParams.params.title).replaceAll(" ", "+"),
				firstname: decodeURIComponent(urlParams.params.firstname).replaceAll(" ", "+"),
				lastname: decodeURIComponent(urlParams.params.lastname).replaceAll(" ", "+"),
				company: decodeURIComponent(urlParams.params.company).replaceAll(" ", "+"),
				companyGender: decodeURIComponent(urlParams.params.companyGender).replaceAll(" ", "+"),
				gender: decodeURIComponent(urlParams.params.gender).replaceAll(" ", "+"),
				address: decodeURIComponent(urlParams.params.address).replaceAll(" ", "+"),
				housenumber: decodeURIComponent(urlParams.params.housenumber).replaceAll(" ", "+"),
				postcode: decodeURIComponent(urlParams.params.postcode).replaceAll(" ", "+"),
				place: decodeURIComponent(urlParams.params.place).replaceAll(" ", "+"),
				country: decodeURIComponent(urlParams.params.country).replaceAll(" ", "+"),
				position: decodeURIComponent(urlParams.params.position).replaceAll(" ", "+"),
				curl: decodeURIComponent(urlParams.params.curl).replaceAll(" ", "+"),
				fc: decodeURIComponent(urlParams.params.fc).replaceAll(" ", "+"),
				timestamp: urlParams.params.timestamp,
				cookieAccepted: convertedCookieAccepted,
				queryIsLocked: convertedQueryLocked,
			};

			const requestObject = {
				data: JSON.stringify(requestData),
				request: "query-acception",
			};

			handleAPIRequest(requestObject).then(() => {
				const noQueryFollowPage = urlParams.params.acceptionParam;

				// user does not want to be personalized. The "no" answer has been saved to the database.
				// Now we need to redirect to the normal website.
				if (accepted === false) {
					handleCookieDeclined(noQueryFollowPage);
				} else if (accepted === true) {
					handleCookieAccepted(noQueryFollowPage, requestData);
				}
			});
		}
	}
}

function handleCookieDeclined(noQueryFollowPage) {
	//delete the cookie -> user has accepted the cookie before and now declined it.
	document.cookie = "consent_cookie" + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

	// redirect to the page he wanted to navigate to but without the plszme params.
	// first check if he is currently on the acception page
	if (noQueryFollowPage === null || noQueryFollowPage === undefined) {
		// user is not on the acception page and propably opened the cookiebanner with the cookie handler again.
		// redirect to the same page but without the queries
		window.location.href = window.location.origin + window.location.pathname;
	} else {
		// user is on acception page
		window.location.href = window.location.origin + "/" + noQueryFollowPage;
	}
}

function handleCookieAccepted(noQueryFollowPage, requestData) {
	// link to the actual page he wanted to navigate to. At the moment to check for consent, the user
	// got redirected to the plsmze-acception.html page.
	const paramQuery =
		"?q1=" +
		requestData.linkCreator +
		"&q2=" +
		requestData.title +
		"&q3=" +
		requestData.firstname +
		"&q4=" +
		requestData.lastname +
		"&q5=" +
		requestData.company +
		"&q6=" +
		requestData.gender +
		"&q7=" +
		requestData.position +
		"&q8=" +
		requestData.curl +
		"&q9=" +
		requestData.fc +
		"&q10=" +
		requestData.timestamp +
		"&q11=" +
		requestData.companyGender +
		"&q12=" +
		requestData.address +
		"&q13=" +
		requestData.housenumber +
		"&q14=" +
		requestData.postcode +
		"&q15=" +
		requestData.place +
		"&q16=" +
		requestData.country;

	// check if the user is on the acception page
	if (noQueryFollowPage === null || noQueryFollowPage === undefined) {
		// user is on another page and accepted the queries
		window.location.href = window.location.origin + window.location.pathname + paramQuery;
	} else {
		// user is on acception page
		window.location.href = window.location.origin + "/" + noQueryFollowPage + paramQuery;
	}
}
