<?php
    $countries = WC()->countries->get_shipping_countries();
    $plugin_public_url = plugin_dir_url(dirname(__FILE__));
    $shop_country = WC()->countries->get_base_country();
    $post_code_auto_fill = carbon_get_theme_option( 'bt_sst_enable_auto_postcode_fill' );
    if (defined('DOING_AJAX') && DOING_AJAX) {
        
        wp_register_script('bt-sync-shipment-tracking-public', '/wp-content/plugins/shipment-tracker-for-woocommerce/public/js/bt-sync-shipment-tracking-public.js', array('jquery'),'v3.4.1', true);
        wp_register_style('bt-sync-shipment-tracking-public-css', '/wp-content/plugins/shipment-tracker-for-woocommerce/public/css/bt-sync-shipment-tracking-public.css', array(),'', 'all');

        $script_data = array(
            "ajax_url" => admin_url('admin-ajax.php'),
            "bt_sst_autofill_post_code" => $post_code_auto_fill,
            "plugin_public_url" => dirname(plugin_dir_url(__FILE__)),
            "pincode_checkout_page_nonce" => wp_create_nonce('get_data_by_pincode_checkout_page')
        );
        wp_localize_script('bt-sync-shipment-tracking-public', 'bt_sync_shipment_tracking_data', $script_data);

        wp_print_styles('bt-sync-shipment-tracking-public-css');
        wp_print_scripts('bt-sync-shipment-tracking-public');
    }

?>

<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> This shylesheet create issues in theme's font settings so it has been disabled. -->
<div class="bt_sync_shimpent_track_pincode_checker_wrap realistic">
 
    <div class="bt_sync_shimpent_track_pincode_checker_label_text">
        <?php 
             echo wp_kses(apply_filters('bt_sst_product_page_delivery_checker_label_text', carbon_get_theme_option('bt_sst_product_page_delivery_checker_label')),'post');
        ?>
    </div>
    <div id="bt_sync_shimpent_track_pincode_checker" >
        <div class="bt_sync_shimpent_track_pincode_checker_shipping_to_text">
        <?php 
            if(sizeof($countries)>1){
                $bt_sync_shimpent_track_pincode_checker_shipping_to_text = 'Shipping to <b id="bt_sst_delivery_base_country">'.$shop_country.'</b>'. (sizeof($countries)>1? ' <a href="#" id="myBtn">change</a>':'');
            }else{
                $bt_sync_shimpent_track_pincode_checker_shipping_to_text = '';
            }
             echo wp_kses(apply_filters('bt_sync_shimpent_track_pincode_checker_shipping_to_text', $bt_sync_shimpent_track_pincode_checker_shipping_to_text),'post');
        ?>
            
        </div>
        <div class="bt_sst_pincode_box">
            <img height="25px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAACXBIWXMAAAsTAAALEwEAmpwYAAABJElEQVR4nLWWMUoDQRSGvyRIiuQkwcI6MVjYiGAVRKIYwYvE0s4b2GTvIFgasVBB7ExnlCRVyBFWBkYYhrfLvsnMB6/Z+Wc+9s3ssFCNFjACMmBqK7PPzFgUzoEVkBfUChhuK7kpEeRejUMlFwpJbkv9Zu2Sdi1sSWNL7Z6NhEW+ga6T6QJzIXepEWXCAq7kn56QM3Mr8+xN/i3JLrzsk0b0KOxLEUsv+6AR3QktMW3y6Qu5W41IWmDuyfaBHyG3pxHVgFnA8X4lgOuAD/YkRNQAvhSSd9uJ5NfQEVtQBz4rSF6IwKCC6DCGqGZPU5FkSkSOS0QHROZDkLyRgCtBdJZC1AQ2jmQN7JCIiSO6JyGnjmiQUrTriDopRebHw9xpplQ/jn+qg9Ubw5MNLwAAAABJRU5ErkJggg==">
            <div>
                <input id="pin_input_box" placeholder="Enter a Pincode" type="text">
                <input id="bt_sst_delivery_estimate_country" value="<?=$shop_country?>"  type="hidden">
            </div>
            <div>
                <?php wp_nonce_field( 'get_pincode_data_product_page', 'get_pincode_data_product_page_nounce'); ?>
                <button id="pin_input_btn" class="btn button" type="button" >Check</button>
            </div>
        </div>
    </div>

    <div id="data_of_pin"></div>
    <?php if(sizeof($countries)>1){ ?>
        <!-- Trigger/Open The Modal -->
        

        <!-- The Modal -->
        <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <input style="width: 80%" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names..">

            <ul id="myUL">
                <?php foreach ( $countries as $code => $country ) {?>
                    <li> <a class="bt_sst_country_select" href="#" data-country="<?=$code?>"><?=$country?></a> </li>
                <?php } ?>
          
            </ul> 
        </div>

        </div> 
        <style>
            /* The Modal (background) */
            .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 999; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }


            /* Modal Content/Box */
            .modal-content {
            background-color: #fefefe;
            margin: 13% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            max-width:350px;
            position: relative;
            }

            .modal-content ul{
                max-height:40vh;
                overflow:scroll;
            }

            /* The Close Button */
            .close {
            color: #000;
           position: absolute;
            font-size: 28px;
            font-weight: bold;
            top:-20px;
            right:-10px;
            }

            .close:hover,
            .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
            } 

        </style>

        <script>
                        // Get the modal
            var modal = document.getElementById("myModal");

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on the button, open the modal
            btn.onclick = function(e) {
              e.preventDefault();
            modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
            modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
            } 
        </script>

        <style>
            #myInput {
            background-image: url('<?=$plugin_public_url?>images/searchicon.png'); /* Add a search icon to input */
            background-position: 10px 12px; /* Position the search icon */
            background-repeat: no-repeat; /* Do not repeat the icon image */
            width: 100%; /* Full-width */
            font-size: 16px; /* Increase font-size */
            padding: 12px 20px 12px 40px; /* Add some padding */
            border: 1px solid #ddd; /* Add a grey border */
            margin-bottom: 12px; /* Add some space below the input */
            background-color: white;
            }

            #myUL {
            /* Remove default list styling */
            list-style-type: none;
            padding: 0;
            margin: 0;
            }

            #myUL li a {
            border: 1px solid #ddd; /* Add a border to all links */
            margin-top: -1px; /* Prevent double borders */
            background-color: #f6f6f6; /* Grey background color */
            padding: 12px; /* Add some padding */
            text-decoration: none; /* Remove default text underline */
            font-size: 18px; /* Increase the font-size */
            color: black; /* Add a black text color */
            display: block; /* Make it into a block element to fill the whole list */
            }

            #myUL li a:hover:not(.header) {
            background-color: #eee; /* Add a hover effect to all links, except for headers */
            }

        </style>
        <script>
            function myFunction() {
            // Declare variables
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById('myInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName('li');

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
                } else {
                li[i].style.display = "none";
                }
            }
            }

         

            const boxes = document.querySelectorAll('.bt_sst_country_select');

            boxes.forEach(box => {
                box.addEventListener('click', function handleClick(e) {
                    e.preventDefault();
                    modal.style.display = "none";
                    var base_country = '<?=  $shop_country ?>';
                    var selected_country_code= this.dataset.country;
                    var selected_country= this.textContent;
                    document.getElementById("bt_sst_delivery_estimate_country").value = selected_country_code;
                    if(base_country!=selected_country_code){

                        document.getElementById("pin_input_box").value = selected_country;
                        document.getElementById("bt_sst_delivery_base_country").textContent = selected_country;
                    }else{
                        document.getElementById("pin_input_box").value = "";
                        document.getElementById("bt_sst_delivery_base_country").textContent = base_country;
                    }
                });
            });



        </script>
    <?php } ?>
</div>
<?php ?>
<style>
    /* caa for realistic templet  */
#bt_sync_shimpent_track_pincode_checker {
  border: none !important;
  padding: 0 !important;
  margin: 0 !important;
}

#pin_input_box {
  padding: 1px !important;
  padding-left: 7px !important;
  border: none !important;
}

#pin_input_btn {
  padding: 0 !important;
  background: white !important;
  color: #046bd2 !important;
}

.bt_sst_pincode_box {
  display: flex;
  border-bottom: 1px solid #046bd2 !important;
  margin: 7px 0;
  align-items: center;
  width: max-content;
}

.bt_sst_pincode_box img {
  height: 20px !important;
}

.bt_sync_shimpent_track_pincode_checker_wrap {
  width: 100%;
}

.cart {
  display: flex;
  flex-wrap: wrap;
}
</style>