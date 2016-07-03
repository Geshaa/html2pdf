/*global console:false, alert:false,Browser:false, IN:false, UI_Anci:false, jQuery:false*/

(function($) {
'use strict';
	$(document).ready(function() {
		var userAuthenticate 	= new UserAuthenticate();
		var livepr			 	= new LivePreview();
		var popup      			= new Popups();
		var admin				= new AdminOperations();
		var listpdf				= new ListCreatedPDF();
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
			var formData = $(this).serializeArray();
			formData.push({name: 'mode', value: 'login'});

			$.ajax({
				url: 'lib/Authenticate.php',
				type: 'POST',
				data: formData,
				success: function(data) {
					window.console.log(data);
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
				url: 'lib/Authenticate.php',
				type: 'POST',
				data: {mode: 'logout'},
				success: function(data) {
					var __this = _this;

					setTimeout(function() {  //because of delay that needs for facebook to remove the app from users profile
						window.location = __this.url + '/index.php';
					}, 1000);
				}
			});
		});

		$(document).on(Browser.click(), this.openForms.selector ,function() {
			var trg = $(this).attr('data-open');

			$('.formHolder.' + trg).addClass('active').siblings().removeClass('active');
		});

		$(document).on('submit', this.registerForm.selector, function(e) {
			e.preventDefault();
			var formData = $(this).serializeArray();
			formData.push({name: 'mode', value: 'register'});

			$.ajax({
				url: 'lib/Authenticate.php',
				type: 'POST',
				data: formData,
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
		this.iframe 				= $('#livepreviewIframe');
		this.contents 				= this.iframe.contents();
		this.iframeBody 			= this.contents.find('body');
		this.styleTag 				= this.contents.find('head').append('<style></style>').children('style');
		this.codeSourceTextareas 	= $('.dashboard__codeSource textarea');
		this.uploadHTMLInput		= $('#uploadHTML');
		this.uploadFileDisplayArea  = $('#fileDisplayArea');

		this.events();
	}

	LivePreview.prototype.events = function() {
		var _this 			= this;
		var fileInput 		= document.getElementById('uploadHTML');

		this.codeSourceTextareas.on('focus', function() {
			$(this).on('keyup', function() {

				if ( $(this).attr('name') === 'htmlSource')
					_this.iframeBody.html( $(this).val() );
				else
					_this.styleTag.text( $(this).val() );

				_this.iframe.css('height', '350px').parent().addClass('visible');
			});
		});

		this.uploadHTMLInput.on('change', function(e) {
			var file = fileInput.files[0];
			var textType = /html.*/;

			if (file.type.match(textType)) {
				var reader = new FileReader();

				reader.onload = function(e) {
					_this.iframeBody.html( reader.result );
				};

				reader.readAsText(file);
				_this.iframe.css('height', '350px').parent().addClass('visible');
				_this.uploadFileDisplayArea.removeClass('visible');
			} 
			else {
				_this.uploadFileDisplayArea.addClass('visible').text('File not supported!');
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
			// $('[data-popup="'+elToOpen+'"]').find('.btn').attr('data-user-id', $(this).attr('data-id'));
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
		this.usersTable 			= $('#listAllUsers tbody');
		this.updateUserForm			= $('form[name="updateUserForm"]');
		this.openUpdateForm			= $('.userEdit');
		this.openDeleteForm			= $('.userDelete');

		this.init();
		this.events();
	}

	AdminOperations.prototype.init = function() {
		var _this = this;

		if ( this.usersTable.length ) {

			this.usersTable.empty();

			$.ajax({
				url: 'lib/AdministrateUsers.php',
				type: 'POST',
				data: {mode: 'list'},
				success: function(data) {
					var __this = _this;
					var decodedData = JSON.parse(data);

					$.each(decodedData, function(key, val) {
						
						__this.usersTable.append('<tr><td class="readFirstName">' + val.firstName + '</td><td class="readLastName">' + val.lastName + '</td><td class="readEmail">' + val.email + '</td><td><span data-id="'+ val.id +'" data-popup-open="editUserData" class="btn userEdit"><span>Edit</span></span><span data-id="'+ val.id +'" data-popup-open="deleteUser" class="btn userDelete"><span>Delete</span></span></td></tr>');
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
				url: 'lib/AdministrateUsers.php',
				type: 'POST',
				data: {
					userID: $(this).attr('data-user-id'),
					mode: 'delete'
				},
				success: function(data) {
					window.console.log(data);
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

		$(document).on(Browser.click(), this.openDeleteForm.selector, function() {
			_this.deleteUserBtn.attr('data-user-id',$(this).attr('data-id'));
		});

		$(document).on('submit', this.updateUserForm.selector , function(e) {
			e.preventDefault();
			var __this = _this;
			
			var formData = $(this).serializeArray();
			formData.push({name: 'mode', value: 'update'});

			$.ajax({
				url: 'lib/AdministrateUsers.php',
				type: 'POST',
				data: formData,
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



	/* List user generate pdf in user section -----------------------------*/
	function ListCreatedPDF() {
		this.pdfTable   		= $('#createdPDFTable tbody');
		this.pdfDeleteBtn 		= $('#deletepdf');
		this.openDeletePopup	= $('.pdfDelete');
		this.extendDetailsBtn 	= $('.extendDetails');
		this.editForm			= $('form[name="pdfEditForm"]');
		this.editCSS 			= $('textarea[name="listEditCss"]');
		this.editHTML 			= $('textarea[name="listEditHtml"]');
		this.openPdfSendPopup	= $('.pdfSend');
		this.sendPdfForm		= $('form[name="sendPdfToEmail"]');
		this.emailRecepient		= this.sendPdfForm.find('input[type="email"]');

		this.init();
		this.deletepdf();
		this.events();
	}

	ListCreatedPDF.prototype.init = function() {
		var _this = this;

		if ( this.pdfTable.length ) {

			this.pdfTable.empty();

			$.ajax({
				url: 'lib/ManagePDF.php',
				data: { mode: 'list'},
				type: 'POST',
				success: function(data) {
					var __this = _this;
					var decodedData = JSON.parse(data);

					$.each(decodedData, function(key, val) {

						__this.pdfTable.append('<tr><td class="picture"><img src="' + val.photo + '" alt="pdf picture"/></td><td>' + val.dateCreated + '</td><td><span data-popup-open="deletepdf" data-id="'+ val.id +'" class="btn pdfDelete"><span>Delete</span></span><span data-popup-open="sendpdf" data-id="'+ val.id +'" class="btn pdfSend"><span>Send via Email</span></span><span class="extendDetails"></span></td></tr>');
						__this.pdfTable.append('<tr class="hidden"><td colspan="3"><form name="pdfEditForm" method="post"><div class="codeHolder"><textarea name="listEditHtml">'+val.htmlSource+'</textarea><textarea name="listEditCss">'+val.cssSource+'</textarea></div><button type="submit" data-id="'+ val.id +'" class="btn pdfEdit"><span>Save changes</span></button></form></td></tr>');
					});

				},
				error: function() {
					console.log('problem with listing users');
				}
			});
		}
	};

	ListCreatedPDF.prototype.events = function() {
		var _this = this;

		$(document).on(Browser.click(), this.openDeletePopup.selector, function() {
			$('[data-popup="deletepdf"]').find('.btn').attr('data-pdf-id', $(this).attr('data-id'));
		});

		$(document).on(Browser.click(), this.openPdfSendPopup.selector, function() {
			$('[data-popup="sendpdf"]').find('.btn').attr('data-pdf-id', $(this).attr('data-id'));
		});

		$(document).on(Browser.click(), this.extendDetailsBtn.selector, function() {
			$(this).toggleClass('active').closest('tr').next().toggleClass('hidden');
		});

		$(document).on('submit', this.editForm.selector , function(e) {
			e.preventDefault();
			var __this = _this;

			if ( _this.editCSS.val() === '' || _this.editHTML.val() === '' )
				return;

			$.ajax({
				url: 'lib/ManagePDF.php',
				type: 'POST',
				data: {
					mode: 'update',
					htmlSource: $('textarea[name="listEditHtml"]').val(),
					cssSource: $('textarea[name="listEditCss"]').val(),
					id: $(this).find('.pdfEdit').attr('data-id')
				},
				success: function(data) {
					__this.init();
				},
				error: function() {
					console.log('problem with updating pdf');
				}
			});
		});

		$(document).on('submit', this.sendPdfForm.selector, function(e) {
			e.preventDefault();

			if ( _this.emailRecepient.val() === '' )
				return;

			$.ajax({
				url: 'lib/ManagePDF.php',
				type: 'POST',
				data: {
					mode: 'send',
					id: $(this).find('.btn').attr('data-pdf-id'),
					emailRecepient: $('input[name="emailRecepient"]').val()
				},
				success: function(data) {
					$('[data-popup-close="sendpdf"]').trigger('click');
				},
				error: function() {
					console.log('problem with updating sending mail with pdf attachment');
				}
			});
		});
	};

	ListCreatedPDF.prototype.deletepdf = function() {
		var _this = this;

		$(document).on(Browser.click(), this.pdfDeleteBtn.selector, function() {
			var __this = _this;

			$.ajax({
				url: 'lib/ManagePDF.php',
				type: 'POST',
				data: {
					mode: 'delete',
					id: $(this).attr('data-pdf-id')
				},
				success: function(data) {
					__this.init();
				},
				error: function() {
					console.log('problem with deleting pdf');
				}
			});
		});
	};

})(jQuery);
