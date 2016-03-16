/*global console:false, Browser:false, jQuery:false*/

(function($) {
'use strict';
	$(document).ready(function() {
	 
		var userAuthenticate = new UserAuthenticate();
	});

	function UserAuthenticate()  {
		this.loginForm 			= $('form[name="loginForm"]');
		this.registerForm 		= $('form[name="registerForm"]');
		this.logoutButton 		= $('#logOutButton');
		this.openForms			= $('.openForm');
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
					console.log(data);
					var __this = _this;

					if ( data === '1' )
						window.location = __this.url + '/dashboard.php';
					else 
						__this.loginForm.find('.formHolder__message').addClass('active');
					
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

		$(document).on(Browser.click(), this.openForms.selector ,function() {
			var trg = $(this).attr('data-open');

			$('.formHolder.' + trg).addClass('active').siblings().removeClass('active');
		});

		$(document).on('submit', this.registerForm.selector, function(e) {
			e.preventDefault();

			$.ajax({
				url: 'register.php',
				type: 'POST',
				data: $(this).serialize(),
				success: function(data) {
					var __this = _this;

					if ( data === '0') {
						__this.registerForm.find('.openForm').trigger('click');
					}
					else {
						var ___this = __this;
						__this.registerForm.find('.formHolder__message').addClass('active');

						setTimeout(function() {
							___this.registerForm.find('.formHolder__message').removeClass('active');
						}, 5000);
					}
				},
				error: function() {
					console.log('error registering user');
				}
			});
		});
	};

})(jQuery);
