<?php

/**
 * Class for admin notice requesting plugin review.
 *
 */
class Bt_Sync_Shipment_Tracking_Review {

	/**
	 * The name of the WP option for the review notice data.
	 *
	 * Data attributes:
	 * - time
	 * - dismissed
	 *
	 */
	const NOTICE_OPTION = '_bt_sst_review_notice3';

	/**
	 * Days the plugin waits before displaying a review request.
	 *

	 */
	const WAIT_PERIOD = 3;

	/**
	 * Initialize hooks.
	 *
	 */
	public function hooks() {

		add_action( 'admin_init',array( $this, 'admin_init') );
	
	//	echo "okk1";exit;
	}

	public function admin_init() {		
		if($this->should_request_review()){
			add_action( 'admin_enqueue_scripts',array( $this, 'enqueue_styles') );
			add_action( 'admin_enqueue_scripts',array( $this, 'enqueue_scripts') );
			add_action( 'admin_notices', array( $this, 'review_request' ) );
			add_action( 'wp_ajax_bt_sst_review_dismiss', array( $this, 'review_dismiss' ) );	
			
		}
		//add_action( 'admin_notices', array( $this, 'premium_admin_notice' ) );
	}

	public function enqueue_styles() {		
		
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		
	}

	public function enqueue_scripts() {		
		
		wp_enqueue_script( 'jquery-ui-dialog' );
	}

	/**
	 * Add admin notices as needed for reviews.
	 *
	 */
	public function review_request() {		
		$this->review();	
	}

	public function should_request_review() {

		// Only consider showing the review request to admin users.
		if ( ! is_super_admin() ) {
			return false;
		}

		// Verify that we can do a check for reviews.
		$review = get_option( self::NOTICE_OPTION );
		$time   = time();
		$load   = false;

		if ( empty( $review ) ) {
			$review = [
				'time'      => $time,
				'dismissed' => false,
			];
			update_option( self::NOTICE_OPTION, $review );
		} else {
			// Check if it has been dismissed or not.
			if ( isset( $review['dismissed'] ) && ! $review['dismissed'] ) {
				$load = true;
			}
		}

		// If we cannot load, return early.
		if ( ! $load ) {
			return false;
		}
		return true;
	}

	/**
	 * Maybe show review request.
	 *
	 */
	private function review() {

		// Fetch when plugin was initially activated.
		$activated = get_option( '_bt_sst_activated_time' );

		// Skip if the plugin activated time is not set.
		if ( empty( $activated ) ) {
			update_option( '_bt_sst_activated_time', time(), '', false );
			return;
		}

		// Skip if the mailer is not set or the plugin is active for less then a defined number of days.
		if ( ( $activated + ( DAY_IN_SECONDS * self::WAIT_PERIOD ) ) > time() ) {
			return;
		}

        $plugin_info = get_plugin_data( __FILE__ );		
		// We have a candidate! Output a review message.
		?>

		<div class="notice notice-info is-dismissible bt-sst-review-notice">
			<div class="bt-sst-review-step bt-sst-review-step-1">
				<h4>Shipment Tracker for Woocommerce needs your feedback 😊 </h4>
				<p>Is this plugin doing it's job (tracking shipments for your orders)?</p>
				<p>
					<a href="#" class="bt-sst-review-switch-step" data-step="3"><?php esc_html_e( 'Yes', $plugin_info['TextDomain'] ); ?></a><br />
                    <!-- Trigger/Open The Modal -->
					<a id="bt-review-feedback" href="#" name="Feedback"
                       class="bt-sst-review-switch-step" data-step="2"><?php esc_html_e( 'Not Really', $plugin_info['TextDomain'] ); ?></a>
				</p>

			</div>

            <!-- The Modal -->
            <div id="bt-review-feedback-modal" style="display:none;"  title="Shipment Tracker for Woocommerce">
                <div class="bt-sst-review-step bt-sst-review-step-2">
                    <p> We're sorry to hear that this plugin didn't meet your expections. We would love a chance to improve. Could you take a minute and let us know what we can do better?</p>
                    <textarea class="bt-textarea" name="bt-feedback-text" id="bt-feedback-text" placeholder="Please write your concern here" rows="5" style="width: 100%"></textarea>
					<small>Note: This site's address, admin email and your name will be sent to us along with your feedback.</small>
					<span class="spinner"></span> 
				</div>                
            </div>
			<div class="bt-sst-review-step bt-sst-review-step-3" style="display: none">
				<h4>That's awesome 🤩</h4>
				<p>If you find this plugin useful, please spare a minute to give a 5 star review on wordpress. It gives us motivation to prioritize the plugin development. More importantly, your review will help other users in their plugin-installation decisions.</p>
				<p>
					<a href="https://wordpress.org/support/plugin/shipment-tracker-for-woocommerce/reviews/?filter=5#new-post" class="bt-sst-dismiss-review-notice bt-sst-review-out" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Ok, you deserve it', $plugin_info['Name'] ); ?>
					</a><br>
					<a href="#" class="bt-sst-dismiss-review-notice" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Nope, maybe later', $plugin_info['Name'] ); ?></a><br>
					<a href="#" class="bt-sst-dismiss-review-notice" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'I already did', $plugin_info['Name'] ); ?></a>
				</p>
			</div>
		</div>
		<script type="text/javascript">
			jQuery( document ).ready( function ( $ ) {
				$( document ).on( 'click', '.bt-sst-dismiss-review-notice, .bt-sst-review-notice button', function( e ) {
					
					if (!$( this ).hasClass( 'bt-sst-review-out' ) ) {
						e.preventDefault();
					}
					$.post( ajaxurl, { action: 'bt_sst_review_dismiss' } );                    
                    $( '.bt-sst-review-notice' ).remove();
				} );

				$( document ).on( 'click', '.bt-sst-review-switch-step', function( e ) {
					e.preventDefault();
					var target = parseInt( $( this ).attr( 'data-step' ), 10 );

					if ( target ) {
					    if(target == 2) {
                            return
                        }
						var $notice = $( this ).closest( '.bt-sst-review-notice' );
						var $review_step = $notice.find( '.bt-sst-review-step-' + target );

						if ( $review_step.length > 0 ) {
							$notice.find( '.bt-sst-review-step:visible' ).fadeOut( function() {
								$review_step.fadeIn();
							} );
						}
					}
				} );

				$(document).on('click','#bt-review-feedback',function(e){
					e.preventDefault();
					$('#bt-review-feedback-modal').dialog({
						resizable: false,
						height: "auto",
						width: 400,
						modal: true,
						buttons:[
							{
								text: "Submit",
								"class": 'bt_btn_sst_feedback_submit',
								click: function() {
									
									var feedback = '';
									if((feedback = $("#bt-feedback-text").val()) != '') {
										$('.bt_btn_sst_feedback_submit').addClass("disabled");
            							$('#bt-review-feedback-modal .spinner').addClass("is-active");
										$(this).addClass('disabled');
										$.post(ajaxurl, {action: 'post_customer_feedback_to_sever', feedback: feedback}, function( data ) {
										
											alert("Thank you for your valuable feedback.");
											$('.bt_btn_sst_feedback_submit').removeClass("disabled");
											$('#bt-review-feedback-modal .spinner').removeClass("is-active");

											$('#bt-review-feedback-modal').dialog( "close" );
											$.post( ajaxurl, { action: 'bt_sst_review_dismiss' } );    
											$( '.bt-sst-review-notice' ).remove();
											
										});
									}	
								}
							},
							{
								text: "Cancel",
								"class": 'bt_btn_sst_feedback_cancel',
								click: function() {
									$( this ).dialog( "close" );
								}
							},

						]
						});
				});

			} );
		</script>
		<?php
	}

	/**
	 * Dismiss the review admin notice.
	 *
	 */
	public function review_dismiss() {

		$review              = get_option( self::NOTICE_OPTION, [] );
		$review['time']      = time();
		$review['dismissed'] = true;
		update_option( self::NOTICE_OPTION, $review );

		// if ( is_super_admin() && is_multisite() ) {
		// 	$site_list = get_sites();
		// 	foreach ( (array) $site_list as $site ) {
		// 		switch_to_blog( $site->blog_id );

		// 		update_option( self::NOTICE_OPTION, $review );

		// 		restore_current_blog();
		// 	}
		// }

		wp_send_json_success();
	}


	public function premium_admin_notice(){
		$current_screen = get_current_screen();
		if($current_screen!=null && $current_screen->id!="woocommerce_page_crb_carbon_fields_container_shipment_tracking"){
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/bt-st-premium-admin-notice.php';
		}
	
	}
}
