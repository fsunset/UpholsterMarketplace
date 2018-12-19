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
