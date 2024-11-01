(function ($) {
  "use strict";
  
  $(document).ready(function () {
	setTimeout(() => {
		// $(document).on('carbonFields.apiLoaded', function(e, api) {
			//alert("ok");
			if ($('.cf-field__body .cf-set__list:first').find('li input[type="checkbox"]:checked').length < 1) {
				$("#form-wizard-modal").addClass("is-active");
				// $(".close-modal-btn").hide();
			}
		// });
	}, 3000);
	
		
		jQuery(document).on('change', 'input[name="carbon_fields_compact_input[_bt_sst_message_text_template]"]', function() {
			var selectedValue = $(this).val();
			const replacements = {
				'#min_date#': 'Oct 08, 2024',
				'#max_date#': 'Oct 08, 2024',
				'#pincode#': '850011',
				'#city#': 'Mumbai',
				'#min_date_charges#': '50',
				'#max_date_charges#': '80',
				'#cutoff_time#': 'If ordered within 10 hrs 52 mins',
				'#edit#': '<a href="#">Change</a>'
			};
			for (const [key, value] of Object.entries(replacements)) {
				const regex = new RegExp(key, 'g');
				selectedValue = selectedValue.replace(regex, value);
			}
			jQuery("#bt_sst_pin_and_date_show_preiview").html(selectedValue);
			jQuery("#bt_sst_pin_and_date_show_preiview").css("display","block");
		});
		
		jQuery(document).on('change', '#bt_sst_pin_and_date_preview', function() {
			jQuery("input[name='carbon_fields_compact_input[_bt_sst_message_text_template]']").val(jQuery(this).val());
		    jQuery("input[name='carbon_fields_compact_input[_bt_sst_message_text_template]']").trigger('change');
		});
		
		setTimeout(() => {
			var previewImage = jQuery('#template-preview-img');
			var imageFilenames = {
				'classic':  'admin/images/classic-template.jpg', // Escaped backslashes
				'realistic':  'admin/images/realistic-template.jpg' // Escaped backslashes
			};
			var selectedValue = $('select[name="carbon_fields_compact_input[_bt_sst_pincode_box_template]"]').val();
			if (imageFilenames[selectedValue]) {
				var previewImage_basepath = jQuery('#bt_sst_template_preview_img').val();
				previewImage.attr('src',previewImage_basepath +  imageFilenames[selectedValue]);
				previewImage.show();
			} else {
				previewImage.hide();
			}
			jQuery(document).on('change', 'select[name="carbon_fields_compact_input[_bt_sst_pincode_box_template]"]', function() {
				var previewImage_basepath = jQuery('#bt_sst_template_preview_img').val();
				var selectedValue = jQuery(this).val();
				// var previewImage = jQuery('#template-preview-img');
				if (imageFilenames[selectedValue]) {
					previewImage.attr('src', previewImage_basepath + imageFilenames[selectedValue]);
					previewImage.show();
				} else {
					previewImage.hide();
				}
			});
		}, 3000);
		setTimeout(() => {
			var previewImage = jQuery('#tracking-template-preview-img');
			var imageFilenames = {
				'classic':  'admin/images/classic-tracking-template.png', // Escaped backslashes
				'trackingmaster':  'admin/images/trackingmaster-template.png' // Escaped backslashes
			};
			var selectedValue = $('select[name="carbon_fields_compact_input[_bt_sst_tracking_page_template]"]').val();
			if (imageFilenames[selectedValue]) {
				var previewImage_basepath = jQuery('#bt_sst_tracking_page_template_preview_img').val();
				previewImage.attr('src',previewImage_basepath +  imageFilenames[selectedValue]);
				jQuery('#tracking_page_template_preview_img_href').attr('href', previewImage_basepath + imageFilenames[selectedValue]);
				previewImage.show();
			} else {
				previewImage.hide();
			}
			jQuery(document).on('change', 'select[name="carbon_fields_compact_input[_bt_sst_tracking_page_template]"]', function() {
				var previewImage_basepath = jQuery('#bt_sst_tracking_page_template_preview_img').val();
				var selectedValue = jQuery(this).val();
				// var previewImage = jQuery('#template-preview-img');
				if (imageFilenames[selectedValue]) {
					previewImage.attr('src', previewImage_basepath + imageFilenames[selectedValue]);
					jQuery('#tracking_page_template_preview_img_href').attr('href', previewImage_basepath + imageFilenames[selectedValue]);
					previewImage.show();
				} else {
					previewImage.hide();
				}
			});
		}, 3000);
		

		jQuery('#bt_sst_sync_now_awb').click(function () {
            jQuery('#bt_sst_awbPopup').show();
			$(this).html("Loading...");
			var order_id = $(this).attr("data-order-id");
			save_tracking_data(order_id,this,"ship24");	
        });
	
		setTimeout(() => {
			var company_name = localStorage.getItem('triggerCompanyTab');
			if ( company_name === 'delhivery') {
				jQuery(".cf-container__tabs-list li").each(function() {
					if (jQuery(this).text().trim() === "Delhivery") {
						jQuery(this).find('button').trigger('click');
					}
				});
			}else if(company_name === 'nimbuspost'){
				jQuery(".cf-container__tabs-list li").each(function() {
					if (jQuery(this).text().trim() === "Nimbuspost (NEW) (Premium Only)") {
						jQuery(this).find('button').trigger('click');
					}
				});
			}else if(company_name === 'shipmozo'){
				jQuery(".cf-container__tabs-list li").each(function() {
					if (jQuery(this).text().trim() === "Shipmozo (Premium Only)") {
						jQuery(this).find('button').trigger('click');
					}
				});
			}else if(company_name === 'shiprocket'){
				jQuery(".cf-container__tabs-list li").each(function() {
					if (jQuery(this).text().trim() === "Shiprocket") {
						jQuery(this).find('button').trigger('click');
					}
				});
			}else if(company_name === 'xpressbees'){
				jQuery(".cf-container__tabs-list li").each(function() {
					if (jQuery(this).text().trim() === "Xpressbees") {
						jQuery(this).find('button').trigger('click');
					}
				});
			}else if(company_name === 'manual'){
				jQuery(".cf-container__tabs-list li").each(function() {
					if (jQuery(this).text().trim() === "Custom Shipping") {
						jQuery(this).find('button').trigger('click');
					}
				});
			}else if(company_name === 'ship24'){
				jQuery(".cf-container__tabs-list li").each(function() {
					if (jQuery(this).text().trim() === "Ship24") {
						jQuery(this).find('button').trigger('click');
					}
				});
			}
			localStorage.removeItem('triggerCompanyTab');
		}, 3000);
		

		$(document).on('click', '#api_test_connection_btn', function (e) {
			e.preventDefault();
			$(this).addClass('is-loading');
			api_test_connection();
		});

		$(document).on('click', '#api_test_connection_btn_delh', function (e) {
			e.preventDefault();
			$(this).addClass('is-loading');
			api_test_connection_delh();
		});
		$(document).on('click', '#api_test_connection_btn_ship24', function (e) {
			e.preventDefault();
			$(this).addClass('is-loading');
			api_test_connection_ship24();
		});

		$(document).on('click', '#btn-bt-sync-now-shyplite', function (e) {
			e.preventDefault();
			if (!confirm("Are you sure?")) return;
			$("#btn-bt-sync-now-shyplite").text("processing...");
			$("#btn-bt-sync-now-shyplite").prop("disabled", true);
			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: "/wp-admin/admin-ajax.php",
				data: { action: "sync_now_shyplite" },
				success: function (response) {
				if (response.status == true) {
					alert(
					"Tracking of " +
						response.orders_count +
						" Orders Synced from Shyplite."
					);
				} else {
					alert("An error happened, please try again.");
				}
				},
				complete: function () {
				$("#btn-bt-sync-now-shyplite").text("Sync Now");
				$("#btn-bt-sync-now-shyplite").prop("disabled", false);
				},
			});
		});

		$(document).on('click', '#bt_premium_login_btn', function (e) {
			e.preventDefault();
			var user = $(this).closest("div.bt_premium_login_div").find("input[name='bt_premium_login_user']").val();
			var password = $(this).closest("div.bt_premium_login_div").find("input[name='bt_premium_login_password']").val();
			if(user.trim()=="" || password.trim()==""){
				return;
			}
			check_user_for_premium_features(user, password);
		});


		$(document).on('click', '#bt_st_buy_premium_login_submit_btn', function (e) {
			e.preventDefault();
			$(this).addClass('is-loading');
			var email = $('#bt_st_buy_premium_login_email').val();
			var password = $('#bt_st_buy_premium_login_password').val();
			var nonce = $('#_wpnonce').val();
			if(email.trim() === "" || password.trim() === ""){
				return;
			}
			check_user_for_premium_features(email, password, nonce);
		});

		$(document).on('click', '.bt_sync_order_tracking', function (e) {
			e.preventDefault();
			var id = $(this).attr("data-order-id");
			$(this).html("just a moment...");
			$(this).addClass('is-loading');
			api_sync_order_status(this,id);
		});

		$('#hide_this_for_30_days ').click(function (e) {
			e.preventDefault();
			$('#bt-sst-premium-notice').css("display", "none");
			hide_bt_sst_premium_notice();
		});
		var free_msg = "<div>Shipment Tracking - (Free Version) <a href='https://billing.bitss.tech/order.php?step=2&productGroup=5&product=612&paymentterm=12' target='_blank'>Upgrade now</a></div></div>";
		$(".woocommerce_page_crb_carbon_fields_container_shipment_tracking #wpbody-content .carbon-theme-options>h2").html(free_msg);

		var is_premium = bt_sync_shipment_track_data['is_premium_active'];
		if (is_premium['is_active'] == true) {
			$('#bt_st_buy_premium_login_email').val(is_premium['user']);
			$('#bt_st_buy_premium_login_email').attr('disabled', 'disabled');
			$('#bt_st_buy_premium_login_password').val("**********");
			$('#bt_st_buy_premium_login_password').attr('disabled', 'disabled');
			$('#bt_st_buy_premium_login_submit_btn').attr('disabled', 'disabled');
			$('#bt_st_buy_premium_login_message').text('Your premium license is active.');
			$('#bt_st_buy_premium_login_message').removeClass('is-danger');
			$('#bt_st_buy_premium_login_message').addClass('is-success');
			$('#bt_st_buy_premium_login_panel').removeClass('is-danger');
			$('#bt_st_buy_premium_login_panel').addClass('is-success');
			$(".woocommerce_page_crb_carbon_fields_container_shipment_tracking #wpbody-content .carbon-theme-options>h2").html("Shipment Tracking - (Premium Version)");
		}

		if(getUrlVars()["t"]=='bp'){
			$('button:contains("Buy Premium")').trigger('click');
		}

		$('.show_st_popup').click(function (e) {
			e.preventDefault();
			$(this).html("Loading...");
			var order_id = $(this).attr("data-order-id");
			save_tracking_data(order_id,this, '');			
		});
		
		$('.bt_sst_copy_link').click(function (e){
			$(this).html('');
			e.preventDefault();
			var value = $(this).closest("p");
			copy_text(value);
		});
		
		$('#bt_sst_select_track_page').click(function (e) {
			e.preventDefault();
			$(this).html("Creating a page...");
			create_add_tracking_page();
		});

		$('#api_tc_m_close_btn').click(function (e){
			$('#api_test_connection_modal').removeClass('is-active');
			$('#get_sms_trial_test_connection_modal').removeClass('is-active');

		});

		$('#api_tc_m_close_btn_delh').click(function (e){
			$('#api_test_connection_modal_delh').removeClass('is-active');
		});
		$('#api_tc_m_close_btn_ship24').click(function (e){
			$('#api_test_connection_modal_ship24').removeClass('is-active');
			$('#api_test_connection_modal_ship24').css('display','none');

		});
	
		$('#api_shipmozo_tc_m_close_btn').click(function (e){
			$('#api_shipmozo_test_connection_modal').removeClass('is-active');
		});

		$('#api_nimbuspost_tc_m_close_btn').click(function (e){
			$('#api_nimbuspost_test_connection_modal').removeClass('is-active');
		});

		$('#buy_credit_tc_m_close_btn').click(function (e){
			$('#buy_credit_test_connection_modal').removeClass('is-active');
		});
		
		$('#register_get_api_key_tc_m_close_btn').click(function (e){
			$('#register_get_api_key_test_connection_modal').removeClass('is-active');
		});

		$('#get_sms_trial_tc_m_close_btn').click(function (e){
			$('#get_sms_trial_test_connection_modal').removeClass('is-active');
		});

		const $modal = $("#form-wizard-modal");
		const $openModalBtn = $("#open-modal");
		const $closeModalBtns = $(".close-modal-btn");
	
		$openModalBtn.on("click", function () {
			$modal.addClass("is-active");
		});
	
		$closeModalBtns.on("click", function () {
			$modal.removeClass("is-active");
		});
	
		const $steps = $(".wizard-step");
		const $progressSteps = $(".progress-step");
		const $progressBarFill = $("#progress-bar-fill");
		let currentStep = 0;
	
		const $prevBtn = $("#prev-step");
		const $nextBtn = $("#next-step");
		const $final_button = $("#final_button");
	$final_button.hide();
		function updateProgressBar(step) {
			const progress = (step / ($steps.length - 1)) * 100;
			$progressBarFill.css("width", progress + "%");
			$progressSteps.each(function (index) {
				$(this).toggleClass("active", index <= step);
			});
		}
	
		function showStep(step) {
			$steps.each(function (index) {
				$(this).toggleClass("active", index === step);
			});
			$prevBtn.toggle(step > 0);
	
			if (step === $steps.length - 1) {
				$nextBtn.text("Finish & Save");
			} else {
				if (step == 0){
					$nextBtn.text("Get Started ⟿");
				}else{
					$nextBtn.text("Next");
				}
				
			}
	
			updateProgressBar(step);
		}
		var shipping_company = "";
		$nextBtn.on("click", function () {
			shipping_company = $('input[name="shipping_company"]:checked').val();
			$('.bt_sst_shipping_company_details').hide();
			$('.bt_sst_shipping_company_details.'+shipping_company).show();
			if (currentStep < $steps.length - 1) {
				currentStep++;
				showStep(currentStep);
			} else {
				const formData = {
					shipping_company: $('input[name="shipping_company"]:checked').val(),
					create_tracking_page: $('input[name="stw_wizard_create_tracking_page"]:checked').val(),
					enable_location_map: $('#stw_wizard_enable_location_map').is(':checked'),
					enable_rating_bar: $('#stw_wizard_enable_rating_bar').is(':checked'),
					etd_checker: $('input[name="stw_wizard_etd_checker"]:checked').val(),
					dynamic_shipping_methods: $('input[name="stw_wizard_dsm_checker"]:checked').val(),
					shipping_manual_or_s24: $('input[name="custom_shipping_mode"]:checked').val(),
				};
				$nextBtn.prop('disabled', true).text('Loading...');

				$.post(bt_sync_shipment_track_data.ajax_url, { 
					action: "handle_stw_wizard_form_data_save", 
					data: formData,
				})
				.done(function(data) {
					$nextBtn.hide();
					$prevBtn.hide();
					$final_button.show();
					$(".progress-container").html('🎉 Congratulations! You\'re All Set Up! 🎉');
					$(".wizard-step.last-step .pre-complete-page").hide();
					$(".wizard-step.last-step .post-complete-page").show();
					$final_button.text('Go to '+data['shipping_company']+' settings');
				
				
					if(data['create_tracking_page'] =='yes' ){
						var pop_up_html = 'Your brand new tracking page is ready. <a target="_blank" href="'+data["tracking_page_url"]+'">Click here view your tracking page.</a>';
						$("#created-tracking-page").html(pop_up_html);
						$("#created-tracking-page").show();
					}
				
					
					localStorage.setItem('triggerCompanyTab', data['shipping_company']);
					
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					alert("Error: ");
				});
				
			}
		});
					
		$prevBtn.on("click", function () {
			if (currentStep > 0) {
				currentStep--;
				showStep(currentStep);
			}
		});
		$final_button.on("click", function () {
			window.location.reload();
		});
	
		showStep(currentStep);

		jQuery(document).on('click', '#bt_sst_fetch_pichup_locations', function() {
			$(this).attr("disabled", true);
			$.post(
				bt_sync_shipment_track_data.ajax_url,
				{ action: 'bt_sst_get_users_list', task: 'get_pick_up_location' },
				function(res) {
					console.log(res);
					if (res) {
						$(this).attr("disabled", false);
						// Insert response HTML into modal content
						$("#pickupLocationContent").html(res.html_pick_lo); 
						// Show modal
						$("#pickupLocationModal").addClass("is-active");
					}
				}
			);                
		});

		// Listen for changes on the pickup location dropdown
		jQuery(document).on('change', '#bt_sst_vendor_pickup_location', function() {
			// Get the selected value
			let selectedValue = $(this).val();
			console.log("Selected Pickup Location:", selectedValue);
			
			// Set the selected value to the hidden input field
			jQuery('input[name="carbon_fields_compact_input[_bt_sst_shiprocket_pickup_location]"]').val(selectedValue);
		});

		jQuery(document).on('click', '#bt_sst_save_pickuplocation', function() {
			$(this).attr("disabled", true);
			// let pickupLocationValue = jQuery("#bt_sst_vendor_pickup_location").val();
			// console.log(pickupLocationValue);
			// jQuery('input[name="carbon_fields_compact_input[_bt_sst_shiprocket_pickup_location]"]').val(pickupLocationValue);
			// setTimeout(function() {
				$('#bt_sst_save_pickuplocation').closest('form').submit();
			// }, 2000);
		});
		
		
		// Close modal on close button click or background click
		jQuery(document).on('click', '#closeModal, .modal-background', function() {
			$("#pickupLocationModal").removeClass("is-active");
		});

			// Show the popup when the button is clicked
			$('.bt_sst_button').on('click', function() {
				$('.bt_sst_popup').show();
				$('.bt_sst_overlay').show();
				if ($("#bt_sst_select_vendor #bt_sst_select").length < 1) {
					$.post(
						bt_sync_shipment_track_data.ajax_url,
						{ action: 'bt_sst_get_users_list'},
						function(res) {
							console.log(res);
							if (res) {
								$("#bt_sst_select_vendor").html(res.html);
								$(".bt_sst_vendor_pickup_location_container").html(res.html_pick_lo);
							}
						}
					);				
				}
			});

			$('#bt_sst_set_vendor_submit').on('click', function() {
				var vendor_user_id = $("#bt_sst_select").val();
				var vendor_pickup_location = $("#bt_sst_vendor_pickup_location").val();
					$(this).attr("disabled", true);
				$.post(
					bt_sync_shipment_track_data.ajax_url,
					{ action: 'bt_sst_set_users_list',vendor_user_id:vendor_user_id,vendor_pickup_location:vendor_pickup_location},
					function(res) {
						$("#bt_sst_set_vendor_submit").attr("disabled", false);
						if (res) {
							$('.bt_sst_popup').hide();
							$('.bt_sst_overlay').hide();
							alert(res);
						}
					}
				);				
			});

			$(document).on('change', '#bt_sst_select', function() {
				var vendor_user_id = $(this).val();
				$("#bt_sst_vendor_pickup_location").attr("disabled", true);
				if(vendor_user_id){
					$.post(
						bt_sync_shipment_track_data.ajax_url,
						{ action: 'bt_sst_check_users_list',vendor_user_id:vendor_user_id},
						function(res) {
							$("#bt_sst_vendor_pickup_location").attr("disabled", false);
							if (res) {
								$("#bt_sst_vendor_pickup_location").val(res);
							} else {
								$("#bt_sst_vendor_pickup_location").val('');
							}
						}
					);
				}
			});
		
			// Close the popup when the close button is clicked
			$('.bt_sst_close').on('click', function() {
				$('.bt_sst_popup').hide();
				$('.bt_sst_overlay').hide();
			});
		
			// Form submission and validation
			$('.bt_sst_form').on('submit', function(event) {
				event.preventDefault();
				const idValue = $('#bt_sst_id').val();
				const classValue = $('#bt_sst_class').val();
		
				// Check if the ID and Class Name start with bt_sst_
				if (!idValue.startsWith('bt_sst_') || !classValue.startsWith('bt_sst_')) {
					alert('ID and Class Name must start with bt_sst_');
					return;
				}
		
				alert('Form submitted successfully!\nID: ' + idValue + '\nClass Name: ' + classValue);
				$('.bt_sst_popup').hide();
				$('.bt_sst_overlay').hide();
			});
		
	});

	function copy_text(element) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).text().trim()).select();
		document.execCommand("copy");
		$temp.remove();
		$('.bt_sst_copy_link').html(' Copied');
	}

	function save_tracking_data(order_id,ele,company) {
		var nonce = bt_sync_shipment_track_data.show_st_popup;
		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'get_st_form_with_data', order_id: order_id, nonce: nonce },
			function(res) {
				if(company == "ship24"){
					$(ele).html("Add AWB No.");
					if (jQuery('#bt_sst_check_already_exist').length < 1) {
						$('#show_dialog').html(res.data);
					}
				}else{
					$('#show_dialog').html(res.data);
					$(ele).html("Update Tracking");
					var show_dialog = $("#show_dialog").dialog({
						autoOpen: false,
						height: 480,
						width: 380,
						modal: true,
					});
					show_dialog.dialog( "open" );
				}

				$(".ui-button-icon-only").html("");
				$(".ui-button-icon-only").append("<span class='ui-button-icon ui-icon ui-icon-closethick'></span>");
				
			}
		).fail(function(err) {
			$('.show_st_popup').html("edit");
			alert( 'Please try again.');
		});
	}

	function create_add_tracking_page() {
		var nonce = bt_sync_shipment_track_data.create_tracking_page;
		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'create_and_add_tracking_page', nonce: nonce },
			function(res) {
				$('#bt_sst_select_track_page').html('Create One');
				alert(res.message);
			}
		).fail(function(err) {
			alert( 'Please try again.');
		});
	}

	function hide_bt_sst_premium_notice() {
		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'api_call_hide_bt_sst_premium_notice' },
			function(res) {
				alert(res.message);
			}
		).fail(function(err) {
			alert( 'An error occured, please try again.');
		});
	}

	function getUrlVars(){
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}

	function api_test_connection() {
		console.log("hello1");
		var nonce = bt_sync_shipment_track_data.test_conn_nonce;
		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'api_call_for_test_connection', value: nonce },
			function (res) {
				$('#api_tc-m-content').html(res.message);
				$('#api_test_connection_modal').addClass('is-active');
				$('#api_test_connection_btn').removeClass('is-loading');
				
			}
		)		
	}

	function api_test_connection_delh() {
		// console.log(bt_sync_shipment_track_data.test_conn_nonce);		
		var nonce = bt_sync_shipment_track_data.test_conn_nonce;
		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'api_call_for_delhivery_test_connection', value: nonce },
			function (res) {
				$('#api_tc-m-content_delh').html(res.message);
				$('#api_test_connection_modal_delh').addClass('is-active');
				$('#api_test_connection_btn_delh').removeClass('is-loading');
				
			}
		)		
	}
	function api_test_connection_ship24() {
		// console.log(bt_sync_shipment_track_data.test_conn_nonce);		
		var nonce = bt_sync_shipment_track_data.test_conn_nonce;
		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'api_call_for_ship24_test_connection', value: nonce },
			function (res) {
				$('#api_tc-m-content_ship24').html(res.message);
				$('#api_test_connection_modal_ship24').addClass('is-active');
				$('#api_test_connection_modal_ship24').css('display','flex');
				$('#api_test_connection_btn_ship24').removeClass('is-loading');
				
			}
		)		
	}
	function bt_st_show_info(info_text){
		jQuery('#bt_notify_popup_content_title').text(info_text);
		jQuery('#bt_notify_popup').trigger("click");
	}
	function api_sync_order_status(ele, id ) {
		var nonce = bt_sync_shipment_track_data.sync_order_nonce;
		jQuery('#sync_manual').addClass("disabled");
		jQuery('#bt_sync-box .spinner').addClass("is-active");
		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'api_call_for_sync_order_by_order_id', nonce: nonce , order_id: id},
			(res)=> {
				$(ele).html("Sync Now");
				if(res.status){
					// alert("done");
					jQuery('#add_awb_number').removeClass("disabled");
                    jQuery('#bt_sync-box .spinner').removeClass("is-active");
					$('.bt-sync-tracking.order-'+id).html(res.data);
					bt_st_show_info("Tracking Synced.");
				}
				
			}
		).fail(function(err) {
			alert( 'An error occured, please try again.');
			$(ele).html("Sync Now");
			jQuery('#add_awb_number').removeClass("disabled");
			jQuery('#bt_sync-box .spinner').removeClass("is-active");
		});
	}

	function check_user_for_premium_features(user, password, nonce) {
		$.post(
			bt_sync_shipment_track_data.ajax_url,
			{ action: "check_user_data_for_premium_features", value: {"user": user, "password": password, "nonce": nonce} },
			function (abc) {
				$('#bt_st_buy_premium_login_submit_btn').removeClass('is-loading');
				if (abc.status) {
					$('#bt_st_buy_premium_login_message').html(abc.message);
					$('#bt_st_buy_premium_login_email').attr('disabled', 'disabled');
					$('#bt_st_buy_premium_login_password').attr('disabled', 'disabled');
					$('#bt_st_buy_premium_login_submit_btn').attr('disabled', 'disabled');
					$('#bt_st_buy_premium_login_message').removeClass('is-danger');
					$('#bt_st_buy_premium_login_message').addClass('is-success');
					$('#bt_st_buy_premium_login_panel').removeClass('is-danger');
					$('#bt_st_buy_premium_login_panel').addClass('is-success');
					$(".woocommerce_page_crb_carbon_fields_container_shipment_tracking #wpbody-content .carbon-theme-options>h2").html("Shipment Tracking - (Premium Version)");
				}else{
					$('#bt_st_buy_premium_login_message').html(abc.message);
					$('#bt_st_buy_premium_login_message').addClass('is-danger');
					$('#bt_st_buy_premium_login_message').removeClass('is-success');
					$('#bt_st_buy_premium_login_panel').addClass('is-danger');
					$('#bt_st_buy_premium_login_panel').removeClass('is-success');
					var free_msg = "Shipment Tracking - (Free Version) <a href='https://billing.bitss.tech/order.php?step=2&productGroup=5&product=612&paymentterm=12' target='_blank'>Upgrade now</a>";
					$(".woocommerce_page_crb_carbon_fields_container_shipment_tracking #wpbody-content .carbon-theme-options>h2").html(free_msg);
					//$(".woocommerce_page_crb_carbon_fields_container_shipment_tracking #wpbody-content .carbon-theme-options>h2").html("Shipment Tracking - (Free Version)");
				}
			} 
		);
	}

})(jQuery);

document.addEventListener('DOMContentLoaded', () => {
	// Functions to open and close a modal
	function openModal($el) {
		if($el!=null){
	  		$el.classList.add('is-active');
		}
	}
  
	function closeModal($el) {
		if($el!=null){
			$el.classList.remove('is-active');
		}
	}
  
	function closeAllModals() {
	  (document.querySelectorAll('.modal') || []).forEach(($modal) => {
		closeModal($modal);
	  });
	}

	document.addEventListener('click', function(event) {

		if (event.target.matches('.js-modal-trigger')) {
			const modal = event.target.dataset.target;
	  		const $target = document.getElementById(modal);
			openModal($target);
		}
		// if (event.target.matches('.modal-background')) {
		// 	const $target = event.target.closest('.modal');
		// 	closeModal($target);
		// }
		if (event.target.matches('.modal-close')) {
			const $target = event.target.closest('.modal');
			closeModal($target);
		}
		if (event.target.matches('.button')) {
			//const $target = event.target.closest('.modal');
			//closeModal($target);
		}
	}, false);
  
  
	// Add a click event on various child elements to close the parent modal
	(document.querySelectorAll('.modal-close, .modal-card-head .delete, .modal-card-foot.close') || []).forEach(($close) => {
	  const $target = $close.closest('.modal');
  
	  $close.addEventListener('click', () => {
		closeModal($target);
	  });
	});
  
	// Add a keyboard event to close all modals
	document.addEventListener('keydown', (event) => {
	  const e = event || window.event;
	  if (e.keyCode === 27) { // Escape key
		closeAllModals();
	  }
	});
});

(function ($) {

	$(document).on('click', '#api_test_connection_btn1', function (e) {
		e.preventDefault();
		$(this).addClass('is-loading');
		api_shipmozo_test_connection();
	});

	function api_shipmozo_test_connection(){
		var nonce = bt_sync_shipment_track_data.test_conn_nonce;
		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'api_call_for_shipmozo_test_connection', value: nonce },
			function (res) {
				$('#api_shipmozo_tc-m-content').html(res.message);
				$('#api_shipmozo_test_connection_modal').addClass('is-active');
				$('#api_test_connection_btn1').removeClass('is-loading');			
			}
		)		
	}

})(jQuery);


(function ($) {
	"use strict";

	$(document).on('click', '#api_nimbuspost_test_connection_btn', function (e) {
		e.preventDefault();
		$(this).addClass('is-loading');
		api_nimbuspost_test_connection();
	});

	function api_nimbuspost_test_connection(){
		var nonce = bt_sync_shipment_track_data.test_conn_nonce;
		// alert(bt_sync_shipment_track_data.ajax_url);
		// console.log(bt_sync_shipment_track_data.ajax_url);		

		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'api_check_for_nimbuspost_test_connection', value: nonce },
			function (res) {
				$('#api_nimbuspost_tc-m-content').html(res.message);
				$('#api_nimbuspost_test_connection_modal').addClass('is-active');
				$('#api_nimbuspost_test_connection_btn').removeClass('is-loading');			
			}
		);		
	}

})(jQuery);


(function ($) {
	"use strict";

	$(document).on('click', '#buy_credit_balance', function (e) {
		e.preventDefault();
		$(this).addClass('is-loading');
		buy_credit_balance();
	});

	function credit_balance_details(){
		
		var nonce = bt_sync_shipment_track_data.test_conn_nonce;
		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'credit_balance_details', value: nonce },
			function (res) {
				console.log(res);
				$('#bt_sms_credit_bal').html(res.data.credit_balance);
				$('#bt_sms_credit_consume').html(res.data.credit_consumed);
			    $('#bt_sms_sent').html(res.data.sms_sent);
				$('#bt_sms_last_sent_time').html(res.data.last_sms_sent);			
			}
		);		
	}

	$(document).ready(function () {
		credit_balance_details();
	});

})(jQuery);

(function ($) {
	"use strict";
	$(document).on('click', '#register_get_api_key', function (e) {
		e.preventDefault();
		var checkbox1 = document.getElementById('checkbox1');
		var checkbox2 = document.getElementById('checkbox2');
		if (!checkbox1.checked || !checkbox2.checked) {
			alert('Please check both checkboxes to proceed.');
		}
		else{
			$(this).addClass('is-loading');
			register_get_api_key();
		}
	});
	
	function register_get_api_key(){
		var nonce = bt_sync_shipment_track_data.register_for_sms_nonce;
		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'register_for_sms', value: nonce  },
			function (res) {
				
				$('#register_get_api_key').removeClass('is-loading');		
				if(res.status){
					$('#register_get_api_key_tc-m-content').html(res.message + " Reloading, please wait...");
					$('#register_get_api_key_test_connection_modal').addClass('is-active');
					setTimeout(() => {
						window.location.reload();
					  }, 5000);
					
				}else{
					$('#register_get_api_key_tc-m-content').html(res.message);
					$('#register_get_api_key_test_connection_modal').addClass('is-active');
				}
			}
		);		
	}

	$(document).on('click', '#get_sms_trial', function (e) {
		$('#get_sms_trial').addClass('is-loading');		
		var selectValue  = document.getElementById('myselect').value;
		var phoneNumber = document.getElementById('bt_otpfy_test_phone_otp').value;
		var nonce = bt_sync_shipment_track_data.get_sms_trial_nonce;
		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'get_sms_trial', value: nonce, phonenumber: phoneNumber, selectvalue:  selectValue},
			function (res) {
				$('#get_sms_trial_tc-m-content').html(res.message);
				$('#get_sms_trial_test_connection_modal').addClass('is-active');
				$('#get_sms_trial').removeClass('is-loading');		
				
			}
		);	
	});

	$(document).on('click', '#bt_sst_test_email_send_btn', function (e) {
		$('#bt_sst_test_email_send_btn').addClass('is-loading');		
		var bt_sst_test_email_event  = document.getElementById('bt_sst_test_email_event').value;
		var bt_sst_test_email = document.getElementById('bt_sst_test_email').value;
		var nonce = bt_sync_shipment_track_data.get_sms_trial_nonce;
		$.ajax({
			url: bt_sync_shipment_track_data.ajax_url,
			method: 'GET',
			data: {
				action: 'get_bt_sst_email_trial',
				value: nonce,
				bt_sst_test_email: bt_sst_test_email,
				bt_sst_test_email_event: bt_sst_test_email_event
			},
			success: function(res) {
				$('#bt_sst_test_email_m_content').html(res.message);
				$('#bt_sst_test_email_modal').addClass('is-active');
				$('#bt_sst_test_email_send_btn').removeClass('is-loading');	
			},
			error: function(xhr, status, error) {
				console.error('Error: ' + error);
				$('#bt_sst_test_email_m_content').html('An error occurred: ' + xhr.responseText);
				$('#bt_sst_test_email_modal').addClass('is-active');
				$('#bt_sst_test_email_send_btn').removeClass('is-loading');
			}
		});	
		
	});
	
	$(document).on('submit', '#bt_buy_sms_form', function (e) {
		var qty = $('#bt_sms_input_credits_buy').val();
		if(qty<3000){
			e.preventDefault();
			alert("Minimum purchase of 3000 credit is required.");
		}
		
	});
		
	var pricing=[]; 
	$(document).on('click', '#bt_sms_buy_credits', function (e) {
		if(pricing.length>0) return;
		$('#credits_pricing_table').append("<p>loading...</p>");
		var nonce =bt_sync_shipment_track_data.buy_credit_balance_nonce;		
		$.get(
			bt_sync_shipment_track_data.ajax_url,
			{ action: 'buy_credit_balance', nonce: nonce},
			function (res) {
				pricing = res.data;
				$('#credits_pricing_table').html("");
				pricing.forEach(e => {
					let p = '<td> Up to ' + e.maxQuantity + ' credits</td>' + '<td>₹' + e.rate + ' per credit</td>';
					$('#credits_pricing_table').append("<tr>"+ p +"</tr>");
				});
				let p = '<td> Need more? </td>' + '<td>Custom Pricing</td>';
				$('#credits_pricing_table').append("<tr>"+ p +"</tr>");
				$('#bt_sst_buy_credits_modal .is-overlay').hide();
				// alert(res.message);
			}
		).fail( function(err) {
			console.log(err);
		});
	})

	$(document).on('keyup', '#bt_sms_input_credits_buy', function (e) {
		var qty = $('#bt_sms_input_credits_buy').val();
		var rate=0;
		for (let i = 0; i < pricing.length; i++) {
			var price = pricing[i];
			if(qty >= price.minQuantity && qty <= price.maxQuantity){
				rate = price.rate;
				break;
			}
		} 
		if(rate>0){
			var amt = Math.round(rate * qty * 100) / 100;
			var gst = Math.round(amt * 0.18 * 100) / 100;
			var total = Math.round((amt + gst) * 100) / 100;
			$('#bt_sms_price_per_credit').html(rate);
			$('#bt_sms_price_of_credit').html(amt);
			$('#bt_sms_total_gst_on_credits').html(gst);
			$('#bt_sms_total_credits_price_with_gst').html("<b>₹" + total + "</b>");
		}else{
			$('#bt_sms_price_per_credit').html('-');
			$('#bt_sms_price_of_credit').html('-');
			$('#bt_sms_total_gst_on_credits').html('-');
			$('#bt_sms_total_credits_price_with_gst').html("-");
		}		
		
	});

})(jQuery);