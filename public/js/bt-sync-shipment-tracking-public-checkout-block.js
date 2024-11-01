wp.domReady(() => {

    function serializeData(data) {
        return Object.keys(data)
            .map(key => {
                const value = data[key];
                // If the value is an object, stringify it
                if (typeof value === 'object' && value !== null) {
                    return Object.keys(value)
                        .map(subKey => encodeURIComponent(key + '[' + subKey + ']') + '=' + encodeURIComponent(value[subKey]))
                        .join('&');
                }
                return encodeURIComponent(key) + '=' + encodeURIComponent(value);
            })
            .join('&');
    }


// 1. Define store and selectors
const wooCommerceStore = "wc/store/cart";
let previousPincode = '';
// 2. Function to update city and state
function updateShippingCityState(pincode) {

    let txtshipping = document.querySelector("#shipping-postcode");
    if(txtshipping!=null){
        document.querySelector("#shipping-postcode").style.backgroundImage = `url("${bt_sync_shipment_tracking_data.plugin_public_url}/images/loading.gif")`;
        document.querySelector("#shipping-postcode").style.backgroundRepeat = "no-repeat";
        document.querySelector("#shipping-postcode").style.backgroundPosition = "right center";
    }
    
    const url = bt_sync_shipment_tracking_data.ajax_url+"?action="+"get_pincode_data_checkout_page";
    const data = {value:{
        p: pincode,
        c: 'IN',
        n: bt_sync_shipment_tracking_data.pincode_checkout_page_nonce,
    }};
    const encodedData = serializeData(data);

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
       },
        body: encodedData
    })
    .then(response => response.json())
    .then(abc => {
        if (abc.status == true && abc.data) {
            if (abc.data.city && abc.data.state) {
                const shippingAddress = wp.data.select(wooCommerceStore).getCartData().shippingAddress;
                shippingAddress.city  = abc.data.city;
                shippingAddress.state  = abc.data.state;
                wp.data.dispatch(wooCommerceStore).setShippingAddress(shippingAddress);
            }
        }
        if(txtshipping!=null){
            document.querySelector("#shipping-postcode").style.backgroundImage = `inherit`;
        }
    })
      .catch(error => {
        if(txtshipping!=null){
            document.querySelector("#shipping-postcode").style.backgroundImage = `inherit`;
        }
        console.error('Error fetching city and state:', error);
      });
  
      
  }


// 3. Subscribe for shippinh pincode changes
const unsubscribe = wp.data.subscribe(() => {
  const shippingAddress = wp.data.select(wooCommerceStore).getCartData().shippingAddress;

    if (shippingAddress) {
        // Get the current billing pincode
        const currentPincode = shippingAddress.postcode;

        // Check if the pincode has changed
        if (currentPincode!=null && currentPincode!="" && currentPincode.length==6 && currentPincode !== previousPincode) {
            // The pincode has changed
            //console.log('Billing Pincode changed from', previousPincode, 'to', currentPincode);

            // Update the previous pincode
            previousPincode = currentPincode;
            updateShippingCityState(currentPincode);
            // Add your custom logic here
        }
    }
});

// 4. Unsubscribe when no longer needed
// (Optional, but recommended for performance)
// You can call unsubscribe() to stop listening for changes

   

});