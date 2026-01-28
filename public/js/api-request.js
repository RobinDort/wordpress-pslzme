function handleAPIRequest(requestObject) {
	console.log(requestObject);
	return new Promise(function (resolve, reject) {
		try {
			fetch(pslzmeData.rest_url, {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-WP-Nonce": pslzmeData.nonce,
				},
				body: JSON.stringify(requestObject),
			})
				.then((response) => {
					if (!response.ok) {
						throw new Error("Network response was not ok: " + response.status);
					}
					return response.json();
				})
				.then((data) => resolve(data))
				.catch((error) => {
					console.error("Action failed:", requestObject.request, error);
					reject(error);
				});
		} catch (error) {
			console.error("Unexpected error:", error);
			reject(error);
		}
	});
}
