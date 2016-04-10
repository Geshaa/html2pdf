/*global console:false, alert:false,Browser:false, jQuery:false*/

(function($) {
'use strict';
	$(document).ready(function() {

		var userAuthenticate 	= new UserAuthenticate();
		var livepr			 	= new LivePreview();
		var popup      			= new Popups();
		var admin				= new AdminOperations();
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

					if ( data === '0' )
						window.location = __this.url + '/dashboard.php';
					else if ( data === '1')
						window.location = __this.url + '/admin.php';
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

				_this.iframe.css('height', '350px').parent().addClass('visible');
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
				_this.iframe.css('height', '350px').parent().addClass('visible');

			} else {
				fileDisplayArea.innerText = 'File not supported!';
			}
		});
	};


	/* Popup functionality ---------*/
	function Popups() {
		this.openPopup       		= $('[data-popup-open]');
		this.closePopup      		= $('[data-popup-close]');
		this.overlay         		= $('[data-overlay="popup"]');
		this.overlayVisibleCLass 	= 'visible';
		this.popupActiveClass    	= 'active';
		this.events();
	}

	Popups.prototype.events = function() {
		var _this = this;

		//you can exclude Browser and replace Browser.click() with 'click' or 'tochstart'  ---*/
		$(document).on( Browser.click(), this.openPopup.selector, function(e) {
			e.preventDefault();
			var elToOpen = $(this).attr('data-popup-open');

			_this.overlay.addClass( _this.overlayVisibleCLass );
			$('[data-popup="'+elToOpen+'"]').addClass('active');
			$('[data-popup="'+elToOpen+'"]').find('.btn').attr('data-user-id', $(this).attr('data-id'));
		});

		$(document).on( Browser.click(), this.closePopup.selector, function(e) {
			e.preventDefault();
			var elToClose = $(this).attr('data-popup-close');

			$('[data-popup="'+elToClose+'"]').removeClass('active');
			_this.overlay.removeClass( _this.overlayVisibleCLass );
		});

		$(document).on( Browser.click(), this.overlay.selector, function() {
			$('[data-popup]').removeClass('active');
			_this.overlay.removeClass( _this.overlayVisibleCLass );
		});

		
	};


	/* Admin page operations ---------------------------------------*/
	function AdminOperations() {
		this.deleteUserBtn			= $('#deleteUser');
		this.updateUserForm			= $('form[name="updateUserForm"]');
		this.usersTable 			= $('#listAllUsers tbody');
		this.openUpdateForm			= $('.userEdit');

		this.init();
		this.events();
	}

	AdminOperations.prototype.init = function() {
		var _this = this;

		if ( this.usersTable.length ) {

			this.usersTable.empty();

			$.ajax({
				url: 'listAllUsers.php',
				type: 'POST',
				success: function(data) {
					var __this = _this;
					var decodedData = JSON.parse(data);

					$.each(decodedData, function(key, val) {
						
						__this.usersTable.append('<tr><td class="readFirstName">' + val.firstName + '</td><td class="readLastName">' + val.lastName + '</td><td class="readEmail">' + val.email + '</td><td><span data-id="'+ val.id +'" data-popup-open="editUserData" class="btn userEdit">Edit</span><span data-id="'+ val.id +'" data-popup-open="deleteUser" class="btn userDelete">Delete</span></td></tr>');
					});

				},
				error: function() {
					console.log('problem with listing users');
				}
			});
		}
	};

	AdminOperations.prototype.events = function() {
		var _this = this;

		$(document).on(Browser.click(), this.deleteUserBtn.selector , function() {
			var __this = _this;

			$.ajax({
				url: 'deleteUser.php',
				type: 'POST',
				data: {
					userID: $(this).attr('data-user-id')
				},
				success: function(data) {
					__this.init();
				},
				error: function() {
					console.log('problem with deleting user');
				}
			});
		});

		$(document).on(Browser.click(), this.openUpdateForm.selector, function() {
			$('#userID').val( $(this).attr('data-id') );
			$('#edit-first-name').val( $(this).closest('tr').find('.readFirstName').text() );
			$('#edit-last-name').val( $(this).closest('tr').find('.readLastName').text() );
			$('#edit-password').val( $(this).closest('tr').find('.readEmail').text() );
		});

		$(document).on('submit', this.updateUserForm.selector , function(e) {
			e.preventDefault();
			var __this = _this;

			$.ajax({
				url: 'updateUser.php',
				type: 'POST',
				data: $(this).serialize(),
				success: function(data) {
					$('[data-popup-close="editUserData"]').trigger('click');
					__this.init();
				},
				error: function() {
					console.log('problem with deleting user');
				}
			});
		});
	};


})(jQuery);
