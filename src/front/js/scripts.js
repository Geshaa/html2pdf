/*global console:false, alert:false,Browser:false, jQuery:false*/

(function($) {
'use strict';
	$(document).ready(function() {
	 
		var userAuthenticate = new UserAuthenticate();
		var livepr			 = new LivePreview();


	});


	/* Login/Logout/Register functionality -----------------------------*/
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

	/* Live preview when entering HTML/CSS code -----------------------*/
	function LivePreview() {
		this.iframe 		= $('#livepreviewIframe');
		this.contents 		= this.iframe.contents();
		this.body 			= this.contents.find('body');
		this.styleTag 		= this.contents.find('head').append('<style></style>').children('style');

		this.events();
	}

	LivePreview.prototype.events = function() {
		var _this = this;

		$('.codeSource textarea').on('focus', function() {
			$(this).on('keyup', function() {

				if ( $(this).attr('name') === 'htmlSource')
					_this.body.html( $(this).val() );
				else
					_this.styleTag.text( $(this).val() );


				_this.iframe.css('height', '350px');
			});
		});

		var fileInput = document.getElementById('uploadHTML');
		var fileDisplayArea = document.getElementById('fileDisplayArea');

		$('#uploadHTML').on('change', function(e) {
			var file = fileInput.files[0];
			var textType = /html.*/;

			if (file.type.match(textType)) {
				var reader = new FileReader();

				reader.onload = function(e) {
					_this.body.html( reader.result );
				};

				reader.readAsText(file);
				_this.iframe.css('height', '350px');

			} else {
				fileDisplayArea.innerText = 'File not supported!';
			}
		});
	};


})(jQuery);
