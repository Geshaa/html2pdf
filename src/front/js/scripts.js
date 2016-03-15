/*global console:false, Browser:false, jQuery:false*/

(function($) {
'use strict';
	$(document).ready(function() {
	 
		var userAuthenticate = new UserAuthenticate();

	});

	function UserAuthenticate()  {
		this.loginForm = $('form[name="loginForm"]');
		this.logoutButton = $('#logOutButton');
		this.url = window.location.href.substring(0, window.location.href.lastIndexOf('/'));

		this.events();
	}

	UserAuthenticate.prototype.events = function() {
		var _this = this;

		$(document).on('submit', this.loginForm.selector, function(e) {
			e.preventDefault();

			$.ajax({
				url: 'login.php',
				type: 'POST',
				data: $(this).serialize(),
				success: function(data) {
					var __this = _this;

					if ( data === '1' )
						window.location = __this.url + '/dashboard.php';

				},
				error: function() {
					console.log('wrong user/password');
				}
			});
		});

		$(document).on(Browser.click(), this.logoutButton.selector , function() {
			$.ajax({
				url: 'logout.php',
				success: function(data) {
					var __this = _this;
					window.location = __this.url + '/index.php';
				}
			});
		});
	};

})(jQuery);
