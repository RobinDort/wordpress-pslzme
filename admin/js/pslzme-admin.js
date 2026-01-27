(function ($) {
	"use strict";

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(window).load(function () {
		$("#create-tables-sbmt").on("click", function (e) {
			e.preventDefault();
			createPslzmeTables();
		});

		$("#license-domain-sbmt").on("click", function (e) {
			e.preventDefault();
			registerDomain();
		});
	});

	function createPslzmeTables() {
		if (!confirm("Möchten Sie die Tabellen wirklich anlegen?")) return;

		$.post(
			pslzme_admin_ajax.ajax_url,
			{
				action: "pslzme_create_tables",
				_ajax_nonce: pslzme_admin_ajax.nonce,
			},
			function (response) {
				if (response.success) {
					console.log(response);
					alert("Tabellen erfolgreich erstellt!");
				} else {
					console.log(response);
					alert("Fehler beim Erstellen der Tabellen: " + response);
				}
			},
		);
	}

	function registerDomain() {
		const domainName = window.location.origin;
		const request = {
			domain: domainName,
			cms: "Wordpress",
		};

		const requestObject = {
			data: JSON.stringify(request),
		};

		$.ajax({
			url: "https://www.pslzme.com/api/v1/domain",
			method: "post",
			data: requestObject,
			success: function (response) {
				const customer = response.customer;
				const key = response.key;

				if (customer === "" || key === "") {
					alert("No pslzme customer registered for this URL. Please visit www.pslzme.com to register.");
					return;
				}

				const secondRequestData = {
					customer,
					key,
				};

				$.post(
					pslzme_admin_ajax.ajax_url,
					{
						action: "pslzme_register_customer",
						_ajax_nonce: pslzme_admin_ajax.nonce,
						data: JSON.stringify(secondRequestData),
					},
					function (response) {
						if (response.success) {
							alert("Domain registration successful");
						} else {
							alert("Something went wrong. Are you sure you already have a pslzme account registered?");
							console.log(response);
						}
					},
				);
			},
		});
	}
})(jQuery);
