function verifyNameAndGreeting() {
	const queryData = queryParamsSet();

	if (queryData.isSet === true) {
		handleGreetingVerification(queryData.params);
		handleCustomerNameVerification(queryData.params);
	}
}

async function handleGreetingVerification(queryData) {
	const requestData = {
		firstContact: queryData.fc,
		linkCreator: queryData.linkCreator,
		timestamp: queryData.timestamp,
	};

	const requestObject = {
		data: JSON.stringify(requestData),
		request: "extract-greeting-data",
	};

	await extractGreetingDataRequest(requestObject);
}

function handleCustomerNameVerification(queryData) {
	const inputs = document.querySelectorAll("#name-verifiyer input");

	inputs.forEach((input, index) => {
		input.addEventListener("input", function () {
			if (input.value.length === 1) {
				if (index === inputs.length - 1) {
					inputs[index].blur();
				} else {
					inputs[index + 1].focus();
				}
			}
		});

		input.addEventListener("change", function () {
			compareName(queryData);
		});
	});
}

async function extractGreetingDataRequest(requestObject) {
	handleAPIRequest(requestObject).then((response) => {
		const firstContactSpan = document.getElementById("pslzme-cookiebar-first-contact");
		const linkCreatorSpan = document.getElementById("pslzme-cookiebar-link-creator");

		firstContactSpan.innerText = response.decryptedFirstContact;
		linkCreatorSpan.innerText = response.decryptedLinkCreator;
	});
}

async function compareName(queryData) {
	const firstInput = $("#name-verifiyer input:eq(0)");
	const secondInput = $("#name-verifiyer input:eq(1)");
	const thirdInput = $("#name-verifiyer input:eq(2)");
	const acceptBtn = $("#pslzme-cookiebar-accept-btn");

	if (!checkEmptyInput(firstInput[0].value) || !checkEmptyInput(secondInput[0].value) || !checkEmptyInput(thirdInput[0].value)) {
		switchInputClasses(firstInput, "success", "error");
		switchInputClasses(secondInput, "success", "error");
		switchInputClasses(thirdInput, "success", "error");

		acceptBtn.prop("disabled", true);
		acceptBtn.focus();
		return;
	}

	const requestData = {
		firstInput: firstInput.val().toLowerCase(),
		secondInput: secondInput.val().toLowerCase(),
		thirdInput: thirdInput.val().toLowerCase(),
		encryptedLastName: queryData.lastname,
		timestamp: queryData.timestamp,
	};

	const requestObject = {
		data: JSON.stringify(requestData),
		request: "compare-link-owner",
	};

	await compareLinkOwnerRequest(requestObject, firstInput, secondInput, thirdInput, acceptBtn);
}

async function compareLinkOwnerRequest(requestObject, firstInput, secondInput, thirdInput, acceptBtn) {
	handleAPIRequest(requestObject).then((response) => {
		if (response.nameMatchesOwner === true) {
			handleNameMatchesOwner(firstInput, secondInput, thirdInput, acceptBtn);
		} else {
			handleNameDoesntMatchOwner(firstInput, secondInput, thirdInput, acceptBtn);
		}
	});
}

function handleNameMatchesOwner(firstInput, secondInput, thirdInput, acceptBtn) {
	switchInputClasses(firstInput, "error", "success");
	switchInputClasses(secondInput, "error", "success");
	switchInputClasses(thirdInput, "error", "success");

	acceptBtn.prop("disabled", false);

	// add event listener to accept the return key as yes.
	document.addEventListener("keydown", handleEnterEventListener);
	return;
}

function handleNameDoesntMatchOwner(firstInput, secondInput, thirdInput, acceptBtn) {
	switchInputClasses(firstInput, "success", "error");
	switchInputClasses(secondInput, "success", "error");
	switchInputClasses(thirdInput, "success", "error");

	// remove the return key event listener again.
	document.removeEventListener("keydown", handleEnterEventListener);
	acceptBtn.prop("disabled", true);

	// empty the input again
	firstInput[0].value = "";
	secondInput[0].value = "";
	thirdInput[0].value = "";

	// focus the first element again
	firstInput.focus();

	// decrease the remaining trys
	const nameVerifyer = $("#name-verifiyer")[0];
	const remainingAttempts = $("#remaining-attempts")[0];

	let userAttempts = parseInt(nameVerifyer.dataset.userAttempts); // Parse to integer
	userAttempts++; // Increment attempts
	nameVerifyer.dataset.userAttempts = userAttempts;

	if (userAttempts === 3) {
		// user has provided incorrect surname information three times. Now the query will be locked and is not accessible anymore.
		handleCookie(false, true);
		hideVisibility();
	}

	// Update remaining attempts text
	remainingAttempts.innerText = 3 - userAttempts;
	return;
}

function handleEnterEventListener(event) {
	if (event.key === "Enter" || event.keyCode === 13) {
		saveConsentCookie(true);
		handleCookie(true);
		hideVisibility();
	}
}

function switchInputClasses(element, oldClass, newClass) {
	element.removeClass(oldClass);
	element.addClass(newClass);
}

function checkEmptyInput(inputVal) {
	return inputVal !== "";
}
