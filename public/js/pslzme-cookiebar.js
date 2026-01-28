function controlPslzmeCookiebar() {
	// check if the user used the pslzme link.
	const queryParamsAreSet = queryParamsSet();
	if (queryParamsAreSet.isSet === true) {
		// user came from the normal website link
		const consentCookie = getCookie("consent_cookie");
		if (consentCookie !== undefined) {
			switchCloseBtnVisibility(true);
		} else {
			switchCloseBtnVisibility(false);
		}

		if (queryParamsAreSet.isSet === true && queryParamsAreSet.params.hasOwnProperty("acceptionParam")) {
			checkConsent(queryParamsAreSet, consentCookie);
		}
	}
}

function checkConsent(queryParams, consentCookie) {
	// show cookie banner when cookie is not set
	if (consentCookie === undefined) {
		showVisibility();
	}

	// cookie is already set. Check the query timestamp.
	if (consentCookie !== undefined) {
		const cookiesDiffer = compareUpdatedQueryTimestampWithCookie(consentCookie, queryParams);
		if (cookiesDiffer) {
			// the url query has changed and the new cookie does not apply for the the query link.
			// the cookie needs to be deleted and the user needs to accept the banner for the new link.
			document.cookie = "consent_cookie" + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			showVisibility();
		}
	}
}

function compareUpdatedQueryTimestampWithCookie(alreadySetConsentCookie, queryParams) {
	const decodedCookie = JSON.parse(alreadySetConsentCookie);

	// compare the cookie timestamp with the one from the url
	if (decodedCookie.queryTime !== queryParams.params.timestamp) {
		return true;
	} else {
		return false;
	}
}

function switchCloseBtnVisibility(cookieIsSet) {
	const closeBtn = document.querySelector(".pslzme-cookiebar-close-btn");
	if (!closeBtn) return;

	if (cookieIsSet === false) {
		// hide the close btn
		closeBtn.style.display = "none";
	} else {
		// the cookie belongs to an already accepted link. Show the close btn.
		closeBtn.style.display = "inline-block";
	}
}

function showVisibility() {
	const cookiebar = document.getElementById("pslzme-cookiebar");
	cookiebar.style.display = "flex";
	cookiebar.style.justifyContent = "center";
	cookiebar.style.alignItems = "center";
}

function hideVisibility() {
	const cookiebar = document.getElementById("pslzme-cookiebar");
	cookiebar.style.display = "none";
}

function saveConsentCookie(cookieAccepted) {
	const queryAttributes = queryParamsSet();
	const queryTimestamp = queryAttributes.params.timestamp;

	const cookieValue = {
		accepted: cookieAccepted,
		queryTime: queryTimestamp,
	};

	var expirationDate = new Date();
	expirationDate.setTime(expirationDate.getTime() + 1 * 60 * 60 * 1000); // One hour from now
	var expires = "expires=" + expirationDate.toUTCString();

	document.cookie = "consent_cookie=" + JSON.stringify(cookieValue) + ";" + expires + ";secure;sameSite=Lax";
}
