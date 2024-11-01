(function ($) {
  "use strict";
  $(document).ready(function () {
    
    /**on product page above add to cart button */
    $("#pin_input_btn").on("click", function (e) {
      e.preventDefault();
      fetch_pincode_data();
    });
    $('#pin_input_box').on('input', function() {
      let inputLength = $(this).val().length;
      if(inputLength === 6) {
        fetch_pincode_data();
      }
    });
    $("#pin_input_box").on("keypress", function (e) {
      if(e.which == 13) {
        e.preventDefault();
        fetch_pincode_data();
      }
    });
    
    var check_autopostcode = bt_sync_shipment_tracking_data.bt_sst_autofill_post_code;
    console.log(bt_sync_shipment_tracking_data);
    var postcode_cookieValue = Cookies.get('bt_sst_postcode_cookie');
    if(postcode_cookieValue){
      jQuery('#pin_input_box').val(postcode_cookieValue);
      fetch_pincode_data();
    }else{
        if( check_autopostcode == 1) {
          jQuery.get('https://freeipapi.com/api/json', function(data) {
            var postcode = data.zipCode;
            if(postcode) {
                jQuery('#pin_input_box').val(postcode);
                fetch_pincode_data();
            }
          });
      }
    }
  
    /**on checkout page in billing address */
    $("#billing_postcode").keyup(function (e) {
      e.preventDefault();
      handle_keyup("#billing");
    });
    $("#shipping_postcode").keyup(function (e) {
      e.preventDefault();
      handle_keyup("#shipping");
    });

    /**on checkout page in shipping address */
    $("#billing_postcode").on("change", function (e) {
      e.preventDefault();
      handle_onchange("#billing");
    });
    $("#shipping_postcode").on("change", function (e) {
      e.preventDefault();
      handle_onchange("#shipping");
    });
  });

  $(document).on("click", "#bt_sst_pincode_box_change_button", function (e) {
      e.preventDefault();
      $('#bt_sync_shimpent_track_pincode_checker').css('display', 'flex');
      $("#bt_sst_pincode_box_change_button").hide();
      $("#data_of_pin").hide();
  });


  function fetch_pincode_data() {

    var pin = $("#pin_input_box").val();
    var country = $("#bt_sst_delivery_estimate_country").val();
    var product_id = $("[name='add-to-cart']").val();
    var variation_id = $("input[name='variation_id']").val();
    var nounce = $("#get_pincode_data_product_page_nounce").val();
    if (pin == "" || pin == false || pin == null) {
      $("#data_of_pin").html("Please enter the pincode!");
      return;
    }
    Cookies.set('bt_sst_postcode_cookie', pin , { expires: 1/144 });
    $("#pin_input_box").attr(
      "style",
      'background-image: url("' +
        bt_sync_shipment_tracking_data.plugin_public_url +
        '/images/loading.gif");background-repeat: no-repeat;background-position: right center;'
    );
    show_pincode_data_product_page(pin, nounce,country,product_id,variation_id);
  }

  function show_pincode_data_product_page(pin, nounce,country,product_id,variation_id) {
    $.post(
      bt_sync_shipment_tracking_data.ajax_url,
      { action: "get_pincode_data_product_page", value: { p: pin, n: nounce,c:country, product_id:product_id,variation_id:variation_id} },
      function (abc) {
        $("#data_of_pin").show();
        if (abc.status) {
          var resp = abc.data;
          $("#data_of_pin").html(resp);
          if (abc.check_error.data) {
              $('#bt_sync_shimpent_track_pincode_checker').css('display', 'none');
              $("#bt_sst_pincode_box_change_button").show();
            }else{
              $('#bt_sst_pincode_box_change_button').css('display', 'none');
          }
        } else {
          var message = abc.message;
          $("#data_of_pin").html(message);

        }
        if (abc.error) {
          $("#pin_input_box").attr("style", "background-image: inherit");
        }
        $("#pin_input_box").attr("style", "background-image: inherit");
      }
    );
  }

  function handle_keyup(handle) {
    var country = $(handle + "_country").val();
    if (country !== "IN" && country !== "CN" && country !== "CA") {
      return;
    }
    var length = $(handle + "_postcode").val().length;
    if (length !== 6) {
      return;
    }
    $(handle + "_postcode").prop("disabled", "disabled");
    $(handle + "_postcode").attr(
      "style",
      'background-image: url("' +
        bt_sync_shipment_tracking_data.plugin_public_url +
        '/images/loading.gif");background-repeat: no-repeat;background-position: right center;'
    );

    show_pincode_data_checkout_page(handle);
  }

  function handle_onchange(handle) {
    var country = $(handle + "_country").val();
    if (country == "IN" && country == "CN" && country == "CA") {
      return;
    }
    $(handle + "_postcode").prop("disabled", "disabled");
    $(handle + "_postcode").attr(
      "style",
      'background-image: url("' +
        bt_sync_shipment_tracking_data.plugin_public_url +
        '/images/loading.gif");background-repeat: no-repeat;background-position: right center;'
    );
    show_pincode_data_checkout_page(handle);
  }

  function show_pincode_data_checkout_page(handle) {
    var pincode = $(handle + "_postcode").val();
    var country = $(handle + "_country").val();

    $.post(
      bt_sync_shipment_tracking_data.ajax_url,
      {
        action: "get_pincode_data_checkout_page",
        value: {
          p: pincode,
          c: country,
          n: bt_sync_shipment_tracking_data.pincode_checkout_page_nonce,
        },
      },
      function (abc) {
        if (abc.status == true) {
          $(handle + "_city").val("");
          $(handle + "_state")
            .val("")
            .trigger("change");
          var res = abc.data;
          console.log(res);
          $(handle + "_city").val(res["city"]);
          $(handle + "_state")
            .val(res["state"])
            .trigger("change");
          // $(handle + "_city").prop("disabled", "disabled");
          // $(handle + "_state").prop("disabled", "disabled");
          $(handle + "_postcode").css("background-image", "inherit");
          $(handle + "_postcode").prop("disabled", false);
          // $(".loading").remove();
        } else if (abc.status == false) {
          $(handle + "_city").val("");
          $(handle + "_state")
            .val("")
            .trigger("change");
          // $(".loading").remove();
          // $(handle + "_city").prop("disabled", false);
          // $(handle + "_state").prop("disabled", false);
          $(handle + "_postcode").css("background-image", "inherit");
          $(handle + "_postcode").prop("disabled", false);
        }
      }
    );
  }

  $("#_bt_shipping_tracking_from").on("submit", function (e) {
    e.preventDefault();

    var _bt_track_order_id = $("#_bt_track_order_id").val();
    if (_bt_track_order_id == null || _bt_track_order_id == "") {
      alert("Please provide order id!");
      return false;
    }

    $.ajax({
      method: "POST",
      url: "/wp-admin/admin-ajax.php",
      dataType: "json",
      data: {
        order_id: _bt_track_order_id,
        bt_get_tracking_form_nonce: $(
          'input[name="bt_get_tracking_form_nonce"]'
        ).val(),
        action: "bt_get_tracking_data",
      },
      success: function (response) {
        if (response != null && response.status != null) {
          if (response.status == true) {
            $("#_bt_shipping_tracking_table tbody").html(""); //hide before insert new

            var responseTable = "<tr>";
            responseTable += "<td>" + _bt_track_order_id + "</td>";
            responseTable += "<td>" + response.data.order_status + "</td>";
            if (response.has_tracking) {
              var response_obj = response.data.obj;
              responseTable +=
                "<td>" +
                response_obj.awb +
                '<br/><small><a target="_blank" href="' +
                response.data.tracking_link +
                '">Track</a></small>' +
                "</td>";
              responseTable += "<td>" + response_obj.current_status + "</td>";
              responseTable += "<td>" + response_obj.courier_name + "</td>";
              responseTable += "<td>" + response_obj.etd + "</td>";
            } else {
              responseTable +=
                '<td colspan="4" style="text-align: center"><strong>' +
                response.message +
                "</strong></td>";
            }
            responseTable += "</tr>";
            $("#_bt_shipping_tracking_table tbody").append(responseTable);
            $("#_bt_shipping_tracking_table").show();
          } else {
            alert(response.message);
          }
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert("Something went wrong! Error: " + errorThrown);
        return false;
      },
    });
  });

})(jQuery);
