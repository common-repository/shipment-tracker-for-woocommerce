(function ($) {
    "use strict";

	/**
	 * All of the code for your public-facing JavaScript source
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
    
    
    $(document).ready(function () {

        $('#deactivate-shipment-tracker-for-woocommerce').click( function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            $('#bt_st_deactivate_plugin').attr('href', href);
            // alert(href);
            document.getElementById("bt-st-deactivation_popup").style.display = "block";
        })

        $('#bt-st-deactivation_popup .close').click ( function (e) {
            e.preventDefault();
            document.getElementById("bt-st-deactivation_popup").style.display = "none";
        })

        $('#bt-st-deactivation_popup .cancel').click ( function (e) {
            e.preventDefault();
            document.getElementById("bt-st-deactivation_popup").style.display = "none";
        })

		$('#bt_sst_ast_contact_help').change(function() {
			$('#bt_ss_contactField').toggle(this.checked);
		});

        $('#bt-st-deactivation_popup .submit_deactivate').click ( function (e) {
            e.preventDefault();
			$("#bt-st-deactivation_popup .submit_deactivate").prop('disabled', true);
            $("#bt-st-deactivation_popup .submit_deactivate").html('loading...');
            // alert('clicked');
            var feedback = $("input[type='radio'].feedback_option:checked").val();
			var contact_help_checkbox = $("#bt_sst_ast_contact_help:checked").val();

            var addition_remark = $("#bt_st_additional_remark").val();
            var contact_help = $("#bt_st_help_contact").val();
            var value = feedback + '. ' + addition_remark + ' ' + contact_help_checkbox + ' ' + contact_help;
			console.log(value);
            post_feedback_to_sever(value);
           
        })
        
    });

    function post_feedback_to_sever(value) {
        var redirect = $('#bt_st_deactivate_plugin').attr('href');	
		$.post(
			bt_sync_shipment_track_deactivation.ajax_url,
			{ action: 'post_customer_feedback_to_sever', feedback: value},
			(res)=> {
                alert('Thank you for your feedback!\n\nClick "OK" to continue deactivating the plugin.')
                window.location = redirect;
				$('#bt-st-deactivation_popup .submit_deactivate').html('Thank you!');
			}
		).fail( function(err) {
			$('#bt-st-deactivation_popup .submit_deactivate').html('Submit & Deactivate');
			alert(res.err);

		});
	}

})(jQuery);