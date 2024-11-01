<?php
    $payment_redirect_url = admin_url( "admin.php?page=".sanitize_text_field($_GET["page"] ));
    $api = get_option('register_for_sms_apy_key');
?>
<style>
.modal {
	/* Fix for overriding jquery ui modal css */
  align-items: center;
  display: none;
  flex-direction: column;
  justify-content: center;
  overflow: hidden;
  position: fixed !important;
  z-index: 40;
  max-width: unset !important;
  width:100% !important;
}

</style>
<div id="bt_sst_buy_credits_modal" class="modal my-3">
						<div class="modal-background"></div>
						<div class="modal-card">
							<header class="modal-card-head">
								<p class="modal-card-title">Buy SMS Credits</p>
								<button type="button" class="delete" aria-label="close"></button>
							</header>
							<form id="bt_buy_sms_form" class="form" action="https://quickengage.bitss.in/home/paymentredirect" method="post">
								<section class="modal-card-body">
									<div class="container columns">
										<div class="column ">
											<input type="hidden" name="redirect_url" value="<?php echo esc_url($payment_redirect_url); ?>" />                                
											<input type="hidden" name="apikey"  value="<?php echo esc_html($api); ?>" />     
											<p class="is-size-6" for="quantity">No. of Credits:</p>
											<input id="bt_sms_input_credits_buy" value="" class="input is-medium mb-2" required type="number" name="quantity" maxlength="7" min="3000" max="200000" placeholder="Enter quantity"/><br>
											<p class="is-size-6" >Price per Credit:</p>
											<p id="bt_sms_price_per_credit" class="is-size-5 pb-2" >-</p>
											<p class="is-size-6" >Amount:</p>
											<p id="bt_sms_price_of_credit" class="is-size-5 pb-2" >-</p>
											<p class="is-size-6" >Tax (GST - 18%):</p>
											<p id="bt_sms_total_gst_on_credits" class="is-size-5 pb-2" >-</p>
											<p class="is-size-6" >Total Amount:</p>
											<p id="bt_sms_total_credits_price_with_gst" class="is-size-3 pb-2 has-text-info" ><b>-</b></p>
										</div>
										<div class="column ">
											<table class="table is-size-7">
												<thead>
													<tr>
														
														<th colspan="2">SMS Price List</th>
													</tr>
												</thead>
												<tbody id="credits_pricing_table">

												</tbody>
												<tfoot>
													<tr>
														<td colspan="2">1 SMS to India = 1 Credit</td>
													</tr>
													<tr>
														<td colspan="2">If you wish to send sms outside India, please create a <a target="_blank" href="https://billing.bitss.tech/index.php?fuse=support&controller=ticket&view=submitticket">support ticket</a></td>
													</tr>
													<tr>
														<td colspan="2">Valid for 2 years from last purchase</td>
													</tr>
													<tr>
														<td colspan="2"><a target="_blank" href="https://smsapi.bitss.tech">Signup here for fast, reliable & cost effective sms service.</a></td>
													</tr>
												</tfoot>
											</table>
										</div>
										<div class="is-overlay level" style="background: #202020d4;">
											<p class="has-text-centered has-text-white title level-item" style="margin: auto;" > 
												loading <button class="button is-large is-ghost ml-2 is-loading "></button>
											</p>
										</div>
										
									</div>
								</section>
								<footer class="modal-card-foot">
									<button type="submit" class="button is-info" >Proceed to checkout</button>
								</footer>
							</form>
						</div>
						<button class="modal-close is-large" aria-label="close"></button>
</div>