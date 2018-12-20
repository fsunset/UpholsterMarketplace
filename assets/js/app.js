// any CSS you require will output into a single css file (app.css in this case)
require("../css/app.scss");

// Call jQuery
var $ = require("jquery");
// create global $ and jQuery variables
global.$ = global.jQuery = $;


// Fontawesome Files
require("@fortawesome/fontawesome-free/css/all.min.css");
require("@fortawesome/fontawesome-free/js/all.js");

// Foundation Files
require("./what-input.js");
require("./foundation.js");

// Initialize Foundation
$(document).foundation();

// Saving data from customer, profile page form
$(function() {
	$(document)
		.on("submit", "#customerForm", function(e) {
			e.preventDefault();

			let $this = $(this),
				nameFieldVal = $("#name").val(),
				phoneFieldVal = $("#phone").val(),
				emailFieldVal = $("#email").val(),
				servicesDesiredFieldVal = $("#servicesDesired").val(),
				messageFieldVal = $("#message").val(),
				$customerFormAlert = $("#customerFormAlert");

			$.ajax({
				type: "POST",
				url: "/customerData",
				data: {
					"nameFieldVal": nameFieldVal,
					"phoneFieldVal": phoneFieldVal,
					"emailFieldVal": emailFieldVal,
					"servicesDesiredFieldVal": servicesDesiredFieldVal,
					"messageFieldVal": messageFieldVal,
				},
				beforeSend: function() {

				},
				success: function(data) {
					$this[0].reset();
					$customerFormAlert.html("<p>" + data.alert + "</p>").removeClass("hide");
				},
				error: function(xhr) {
					var err = eval("(" + xhr.responseText + ")");
					alert(err.Message);
				}
			});
		});
});
