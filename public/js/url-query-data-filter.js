// The actual function that extracts all the needed data from the pslzme link
const queryParamsSet = () => {
	const queryParams = new URLSearchParams(window.location.search);

	if (!checkParams(queryParams)) return { isSet: false, params: {} };

	if (queryParams.has("pslzme-follow")) {
		return {
			isSet: true,
			params: {
				acceptionParam: queryParams.get("plszme-follow"),
				linkCreator: queryParams.get("q1") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q1")),
				title: queryParams.get("q2") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q2")),
				firstname: queryParams.get("q3") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q3")),
				lastname: queryParams.get("q4") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q4")),
				company: queryParams.get("q5") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q5")),
				gender: queryParams.get("q6") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q6")),
				position: queryParams.get("q7") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q7")),
				curl: queryParams.get("q8") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q8")),
				fc: queryParams.get("q9") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q9")),
				timestamp: queryParams.get("q10"),
				companyGender: queryParams.get("q11") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q11")),
				address: queryParams.get("q12") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q12")),
				housenumber: queryParams.get("q13") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q13")),
				postcode: queryParams.get("q14") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q14")),
				place: queryParams.get("q15") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q15")),
				country: queryParams.get("q16") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q16")),
			},
		};
	} else {
		return {
			isSet: true,
			params: {
				linkCreator: queryParams.get("q1") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q1")),
				title: queryParams.get("q2") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q2")),
				firstname: queryParams.get("q3") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q3")),
				lastname: queryParams.get("q4") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q4")),
				company: queryParams.get("q5") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q5")),
				gender: queryParams.get("q6") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q6")),
				position: queryParams.get("q7") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q7")),
				curl: queryParams.get("q8") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q8")),
				fc: queryParams.get("q9") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q9")),
				timestamp: queryParams.get("q10"),
				companyGender: queryParams.get("q11") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q11")),
				address: queryParams.get("q12") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q12")),
				housenumber: queryParams.get("q13") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q13")),
				postcode: queryParams.get("q14") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q14")),
				place: queryParams.get("q15") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q15")),
				country: queryParams.get("q16") === null ? encodeURIComponent("") : encodeURIComponent(queryParams.get("q16")),
			},
		};
	}
};

function checkParams(queryParams) {
	if (
		queryParams.has("q1") &&
		queryParams.has("q2") &&
		queryParams.has("q3") &&
		queryParams.has("q4") &&
		queryParams.has("q5") &&
		queryParams.has("q6") &&
		queryParams.has("q7") &&
		queryParams.has("q8") &&
		queryParams.has("q9") &&
		queryParams.has("q10")
	) {
		return true;
	} else {
		return false;
	}
}
