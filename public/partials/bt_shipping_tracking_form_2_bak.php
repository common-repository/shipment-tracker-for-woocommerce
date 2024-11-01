<?php
  $last_four_digit = carbon_get_theme_option('bt_sst_valid_phone_no');

?>
<div class="bt_order_tracking_page" style=" max-width: 90%; margin: auto; ">
    <form class="bt_tracking_form" action="" method="post" class="bt_track_order_form" >
      <input type="hidden" name="bt_tracking_form_nonce" value="<?= wp_create_nonce('bt_shipping_tracking_form_2') ?>">
      <input name="bt_track_order_id" value = "<?= $bt_track_order_id ?>" type="text" placeholder="Your order id">
      <?php 
        
        if ($last_four_digit) {
          echo "<input id='bt_last_four_digit_no' name='bt_track_order_phone' type='text' placeholder='Last 4 digits of phone no.' value='". $bt_last_four_digit ."'>";
        }
      ?>
      <button>Search</button>
    </form>

    <?php 
      if ($auto_post) {
        echo "<div style='width: 100%;'>
        <div id='bt_loader_div' class='loader' style='text-align: center; margin: auto;'></div>
        </div>";
      }
    ?>

    <?php 
      
      if ($the_order==false && !empty($bt_track_order_id))
      {
        echo "<p style='text-align: center;'>". $message ."</p>";
      }
      else if (isset($the_order) && $the_order instanceof WC_Order && empty($tracking['tracking_data']['awb']))
      {
        // echo json_encode($tracking);
        // echo json_encode($the_order);
        $name = $the_order->get_billing_first_name() ." ". $the_order->get_billing_last_name() ;
        $order_status = $the_order->get_status();      
        $order_status_name = wc_get_order_status_name( $order_status);     
        $order_number = $the_order->get_order_number();      
        $ordering_date = $the_order->get_date_created();
        ?>
        <div class="bt_details">
        <p>Hello <?= $name ?>,</p> Your order is currently <em>'<?=  $order_status_name ?>'</em>. Tracking details (if applicable) will be available as soon as we ship your order.
           
          <div class="track">
          
            <div>
              <div class="tracking_details">
              
                <div class="bt_delivery_date">
                  <h4><?=  $order_status_name ?></h4>
                  <span>YOUR ORDER STATUS</span>
                </div>
              </div>
              <div class="bt_order_details">
                <h4>ORDER DETAILS</h4>
                <p>Order #: <?= $order_number ?></p>
                <p>AWB Number:  NA</p>
              </div>
            </div>
            <div class='order-track'>
                <h4>Order Status</h4>
                <div class='order-track-step'>
                  <div class='order-track-status'>
                    <span class='order-track-status-dot coloured'></span>
                    <span class='order-track-status-line faded'></span>
                  </div>
                  <div class='order-track-text'>
                    <p class='order-track-text-stat'> Order Created </p>
                    <span class='order-track-text-sub'></span>
                  </div>
                </div>
                <div class='order-track-step'>
                  <div class='order-track-status'>
                    <span class='order-track-status-dot faded'></span>
                    <span class='order-track-status-line faded'></span>
                  </div>
                  <div class='order-track-text'>
                    <p class='order-track-text-stat'>Out for Pickup</p>
                    <span class='order-track-text-sub'></span>
                  </div>
                </div>
                <div class='order-track-step'>
                  <div class='order-track-status'>
                    <span class='order-track-status-dot faded'></span>
                    <span class='order-track-status-line faded'></span>
                  </div>
                  <div class='order-track-text'>
                    <p class='order-track-text-stat'>Out for delivery</p>
                    <span class='order-track-text-sub'></span>
                  </div>
                </div>
                <div class='order-track-step'>
                  <div class='order-track-status'>
                    <span class='order-track-status-dot faded'></span>
                  </div>
                  <div class='order-track-text'>
                    <p class='order-track-text-stat'> Delivered </p>
                    <span class='order-track-text-sub'> </span>
                  </div>
                </div>     
            </div>
          </div>
        </div>
        <?php    
      }
      else if (isset($the_order)  && $the_order instanceof WC_Order && !empty($tracking['tracking_data']['awb']))
      {
        // echo json_encode($tracking['tracking_data']);
        // echo json_encode($the_order);

        $name = $the_order->get_billing_first_name() ." ". $the_order->get_billing_last_name();
        $expected_delv_date = $tracking['tracking_data']['etd'];
        $tracking_status = $tracking['tracking_data']['current_status'];
        $courier_name = $tracking['tracking_data']['courier_name'];
        $order_id = $tracking['tracking_data']['order_id'];
        $order_awb = $tracking['tracking_data']['awb'];

        $order_status = $the_order->get_status();
        
        $ordering_date = $the_order->get_date_created();
        ?>
        <div>
          <h3 style=" text-align: center; ">Order Tracking</h3>
          <div class="track">
            <div class="bt_tracking_details">
              <div class="tracking_details">
                <p>Hello <?= $name ?>!</p>
                <p>Your shipment's expected delivery date is </p>
                <div class="bt_delivery_date">
                  <h4><?= $expected_delv_date ?></h4>
                  <span>EXPECTED DELIVERY DATE</span>
                </div>
              </div>
              <div class="bt_order_details">
                <h4>ORDER DETAILS</h4>
                <P>Order Status: <?= $order_status ?></P>
                <p>Courier Name:  <?= $courier_name ?></p>
                <p>Order Id: <?= $order_id ?></p>
                <p>AWB Number:  <?= $order_awb ?></p>
              </div>
            </div>

            <?php
            if ($tracking) {   
              $status = '';
              $end_status = "Delivered";

              if ($tracking_status == "pending-pickup") {
                $status = "Pending Pickup";
              }
              else if ($tracking_status == "out-for-pickup") {
                $status = "Out for Pickup";
              }
              else if ($tracking_status == "in-transit") {
                $status = "In Transit";
              }
              else if ($tracking_status == "out-for-delivery" || $tracking_status == "delivered") {
                $status = "In Transit";
              }
              else if ($tracking_status == "canceled") {
                $end_status = "Order Canceled";
              }
              else if ($tracking_status == "rto-in-transit" || $tracking_status == "rto-delivered") {
                $status = "RTO in Transit";
                $end_status = 'RTO Delivered';
              }
              // echo  '<br>' . $tracking_status . '<br>';
              // echo $status . '<br>'; 
              
              $first = "
              <div class='order-track'>
                <h4>Order Status</h4>
                <div class='order-track-step'>
                  <div class='order-track-status'>
                    <span class='order-track-status-dot coloured'></span>".
                    "<span class='order-track-status-line ". ($tracking_status ? 'coloured' : 'faded') ."''></span>".
                  "</div>
                  <div class='order-track-text'>
                    <p class='order-track-text-stat'> Order Created </p>".
                    // "<span class='order-track-text-sub'>" . $ordering_date . "</span>".
                  "</div>
                </div>";

                $second = "
                <div class='order-track-step'>
                  <div class='order-track-status'>
                  <span class='order-track-status-dot ". ($tracking_status != 'Order Created' ? 'coloured' : 'faded') ."''></span>
                  <span class='order-track-status-line ". (($tracking_status == 'out-for-delivery' || $tracking_status == 'delivered' || $tracking_status == 'rto-delivered') ? 'coloured' : 'faded') ."''></span>
                  </div>
                  <div class='order-track-text'>
                    <p class='order-track-text-stat'> " . $status . " </p>".
                    // "<span class='order-track-text-sub'> " . date("dS F, Y") . " </span>".
                  "</div>
                </div>";

                $third = "
                <div class='order-track-step'>
                  <div class='order-track-status'>
                  <span class='order-track-status-dot ". (($tracking_status == 'out-for-delivery' || $tracking_status == 'delivered') ? 'coloured' : 'faded') ."''></span>
                  <span class='order-track-status-line ". (($tracking_status == 'delivered') ? 'coloured' : 'faded') ."''></span>
                  </div>
                  <div class='order-track-text'>
                    <p class='order-track-text-stat'>Out for delivery</p>".
                    // "<span class='order-track-text-sub'> " . ($expected_delv_date) . "</span>".
                  "</div>
                </div>";

                $fourth = "
                <div class='order-track-step'>
                  <div class='order-track-status'>
                  <span class='order-track-status-dot ". (($tracking_status == 'delivered' || $tracking_status == 'canceled' || $tracking_status == 'rto-delivered') ? 'coloured' : 'faded') ."'></span>
                  </div>
                  <div class='order-track-text'>
                    <p class='order-track-text-stat'>" . $end_status . " </p>".
                    // "<span class='order-track-text-sub'> " . ($expected_delv_date) . "</span>".
                  "</div>
                </div>                
              </div>
              ";
              
                echo $first;
                if ($tracking_status != 'canceled' && $tracking_status != 'rto-in-transit' && $tracking_status != 'rto-delivered') {
                  echo $second;
                  echo $third;
                  echo $fourth;
                }
                else {
                  if ($tracking_status == 'canceled') {
                    // $end_status = 'Order Canceled';
                  }
                  if ($tracking_status == 'rto-in-transit' || $tracking_status == 'rto-delivered') {
                    // $end_status = 'RTO Delivered';
                    echo $second;
                  }
                  if ($tracking_status == 'pending-pickup' || $tracking_status == 'rto-delivered') {
                    // $end_status = 'RTO Delivered';
                    echo $second;
                  }
                  echo $fourth;
                }
                  
            }              
            ?>
          </div>
        </div>
        <?php    
      }
    ?>
    
    <?php if($auto_post) : ?>
      <script>
        document.addEventListener("DOMContentLoaded", function(event) {
          var enable_ph = '<?= $last_four_digit ?>'
    
          if (enable_ph) {
            var ph = prompt("Enter last 4 digits of phone number");
            if (ph!="" && ph!=null){
              document.getElementById("bt_last_four_digit_no").value = ph;            
              document.getElementsByClassName('bt_tracking_form')[0].submit();
            }
            // else if (ph="" && ph=null){
              <?php $auto_post = false ?>
              var ele = document.getElementById('bt_loader_div');
              ele.classList.remove("loader");
            // }
          }
          else {
            document.getElementsByClassName('bt_tracking_form')[0].submit();
          }
        });
      </script>
    <?php endif ?>

</div>