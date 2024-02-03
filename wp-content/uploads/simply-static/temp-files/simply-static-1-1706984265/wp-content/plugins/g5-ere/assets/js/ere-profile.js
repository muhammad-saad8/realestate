(function ($) {
	'use strict';
	$(document).ready(function () {
		if (typeof g5ere_vars !== "undefined") {

			var ajax_url = g5ere_vars.ajax_url;
			var ajax_upload_image_profile_url = g5ere_vars.ajax_upload_image_profile_url;
			var file_type_title = g5ere_vars.file_type_title;
			var ere_site_url = g5ere_vars.ere_site_url;
			var confirm_become_agent_msg = g5ere_vars.confirm_become_agent_msg;
			var confirm_leave_agent_msg = g5ere_vars.confirm_leave_agent_msg;
			var $first_name = $("#user_firstname");
			var $last_name = $("#user_lastname");
			var $email = $("#user_email");
			var $mobile = $("#user_mobile_number");

			$("#ere_update_profile").on('click', function () {
				var $this = $(this);
				var $form = $this.parents('form'),
					$wrap = $this.closest('.g5ere__profile-info-wrapper');
				if ($form[0].checkValidity() === false) {
					$form.addClass('was-validated');
					if ($first_name.is(':invalid')) {
						$('html, body').animate({
							scrollTop: ($first_name.offset().top - 60)
						}, 500);
					} else if ($last_name.is(':invalid')) {
						$('html, body').animate({
							scrollTop: ($last_name.offset().top - 60)
						}, 500);
					} else if ($email.is(':invalid')) {
						$('html, body').animate({
							scrollTop: ($email.offset().top - 60)
						}, 500);
					} else if ($mobile.is(':invalid')) {
						$('html, body').animate({
							scrollTop: ($mobile.offset().top - 60)
						}, 500);
					}
					return;
				}

				if (G5ERE_FRONTEND.LOADING.isLoading) {
					return;
				}

				var $alert_title = $this.text();

				var update_profile_ajax_url = ajax_url + '?action=ere_update_profile_ajax';

				$.ajax({
					type: 'POST',
					url: update_profile_ajax_url,
					dataType: 'json',
					data: $form.serialize(),
					beforeSend: function () {
						G5ERE_FRONTEND.LOADING.add($wrap);
					},
					success: function (response) {
						G5ERE_FRONTEND.LOADING.remove($wrap);
						if (response.success) {
							ERE.popup_alert('fa fa-check-square-o', $alert_title, response.message);
						} else {
							ERE.popup_alert('fa fa-exclamation-triangle', $alert_title, response.message);
						}
					},
					error: function () {
						G5ERE_FRONTEND.LOADING.remove($wrap);
					}
				});
			});
			/*-------------------------------------------------------------------
			 *  Change Password
			 * ------------------------------------------------------------------*/

			$("#ere_change_pass").on('click', function () {
				var securitypassword, oldpass, newpass, confirmpass;

				var $this = $(this);
				var $form = $this.parents('form'),
					$wrap = $this.closest('.g5ere__profile-password-wrapper');
				if ($form[0].checkValidity() === false) {
					$form.addClass('was-validated');
					return;
				}

				if (G5ERE_FRONTEND.LOADING.isLoading) {
					return;
				}
				var $alert_title = $this.text();
				oldpass = $("#oldpass").val();
				newpass = $("#newpass").val();
				confirmpass = $("#confirmpass").val();
				securitypassword = $("#ere_security_change_password").val();
				if ($form.valid()) {
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: ajax_url,
						data: {
							'action': 'ere_change_password_ajax',
							'oldpass': oldpass,
							'newpass': newpass,
							'confirmpass': confirmpass,
							'ere_security_change_password': securitypassword
						},
						beforeSend: function () {
							G5ERE_FRONTEND.LOADING.add($wrap);
						},
						success: function (response) {
							if (response.success) {
								window.location.href = ere_site_url;
							} else {
								G5ERE_FRONTEND.LOADING.remove($wrap);
								ERE.popup_alert('fa fa-exclamation-triangle', $alert_title, response.message);
							}
							G5ERE_FRONTEND.LOADING.remove($wrap);
						},
						error: function () {
							G5ERE_FRONTEND.LOADING.remove($wrap);
						}
					});
				}
			});

			$('#ere_user_as_agent').on('click', function () {
				var $this = $(this);
				var $alert_title = $this.text();
				ERE.confirm_dialog($alert_title, confirm_become_agent_msg, function () {
					$.ajax({
						type: 'post',
						url: ajax_url,
						dataType: 'json',
						data: {
							'action': 'ere_register_user_as_agent_ajax',
							'ere_security_become_agent': $('#ere_security_become_agent').val()
						},
						beforeSend: function () {
							ERE.show_loading();
						},
						success: function (response) {
							if (response.success) {
								ERE.close_loading(0);
								ERE.popup_alert('fa fa-check-square-o', $alert_title, response.message);
								setTimeout(function () {
									window.location.reload();
								}, 3000);
							} else {
								ERE.close_loading(0);
								ERE.popup_alert('fa fa-exclamation-triangle', $alert_title, response.message);
							}
						},
						error: function () {
							ERE.close_loading(0);
						}
					});
				});
			});

			$('#ere_leave_agent').on('click', function () {
				var $this = $(this);
				var $alert_title = $this.text();
				ERE.confirm_dialog($alert_title, confirm_leave_agent_msg, function () {
					$.ajax({
						type: 'post',
						url: ajax_url,
						dataType: 'json',
						data: {
							'action': 'ere_leave_agent_ajax',
							'ere_security_leave_agent': $('#ere_security_leave_agent').val()
						},
						beforeSend: function () {
							ERE.show_loading();
						},
						success: function (response) {
							if (response.success) {
								window.location.reload();
							} else {
								ERE.show_loading();
								ERE.popup_alert('fa fa-exclamation-triangle', $alert_title, response.message);
							}
						},
						error: function () {
							ERE.show_loading();
						}
					});
				});
			});
			/*-------------------------------------------------------------------
			 *  initialize uploader
			 * ------------------------------------------------------------------*/
			var uploader = new plupload.Uploader({
				browse_button: 'ere_select_profile_image',
				file_data_name: 'ere_upload_file',
				container: 'ere_profile_plupload_container',
				multi_selection: false,
				url: ajax_upload_image_profile_url,
				filters: {
					mime_types: [
						{title: file_type_title, extensions: "jpg,jpeg,gif,png"}
					],
					max_file_size: '2000kb',
					prevent_duplicates: true
				}
			});
			uploader.init();


			/* Run after adding file */
			uploader.bind('FilesAdded', function (up, files) {
				var html = '';
				var profileThumb = "";
				plupload.each(files, function (file) {
					profileThumb += '<div id="holder-' + file.id + '" class="profile-thumb"></div>';
				});
				document.getElementById('user-profile-img').innerHTML = profileThumb;
				up.refresh();
				uploader.start();
			});


			/* Run during upload */
			uploader.bind('UploadProgress', function (up, file) {
				document.getElementById("holder-" + file.id).innerHTML = '<span><i class="fa fa-spinner fa-spin"></i></span>';
			});


			/* In case of error */
			uploader.bind('Error', function (up, err) {
				document.getElementById('errors_log').innerHTML += "<br/>" + "Error #" + err.code + ": " + err.message;
			});

			/* If files are uploaded successfully */
			uploader.bind('FileUploaded', function (up, file, ajax_response) {
				var response = $.parseJSON(ajax_response.response);

				if (response.success) {

					var profileThumbHTML = '<img src="' + response.url + '"/>' +
						'<input type="hidden" class="profile-pic-id" id="profile-pic-id" name="profile-pic-id" value="' + response.attachment_id + '"/>';

					document.getElementById("holder-" + file.id).innerHTML = profileThumbHTML;
				}
			});

			$('#remove-profile-image').on('click', function (event) {
				event.preventDefault();
				document.getElementById('user-profile-img').innerHTML = '<div class="profile-thumb"></div>';
			});
		}
	});
})(jQuery);