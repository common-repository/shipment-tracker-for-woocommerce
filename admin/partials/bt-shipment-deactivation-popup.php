<!-- The Modal -->
<div id="bt-st-deactivation_popup" class="bt_st_deactivation_popup">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2 class="modal-heading">If you have a moment, please let us know why you are deactivating:</h2>
        </div>

        <div class="modal-body">
            <input type="radio" id="one" class="feedback_option" name="feedback_option" value="I couldn't understand how to make it work">
            <label for="one">I couldn't understand how to make it work</label><br>

            <input type="radio" id="two" class="feedback_option" name="feedback_option" value="I found a better plugin">
            <label for="two">I found a better plugin</label><br>

            <input type="radio" id="three" class="feedback_option" name="feedback_option" value="The plugin is great, but I need specific feature that you don't support">
            <label for="three">The plugin is great, but I need specific feature that you don't support</label><br>

            <input type="radio" id="four" class="feedback_option" name="feedback_option" value="The plugin is not working">
            <label for="four">The plugin is not working</label><br>

            <input type="radio" id="five" class="feedback_option" name="feedback_option" value="It's not what I was looking for">
            <label for="five">It's not what I was looking for</label><br>

            <input type="radio" id="six" class="feedback_option" name="feedback_option" value="The plugin didn't work as expected">
            <label for="six">The plugin didn't work as expected</label><br>

            <input type="radio" id="seven" class="feedback_option" name="feedback_option" value="Other">
            <label for="seven">Other</label><br>
           
            <input type="checkbox" id="bt_sst_ast_contact_help" class="feedback_option" name="bt_sst_ast_contact_help">
            <label for="bt_sst_ast_contact_help">Allow support team to contact me (to better understand to problem)</label><br>
            
            <div id="bt_ss_contactField" style="display:none;">
                <label for="seven">Please Enter Your Contact Number</label><br>
                <input name="bt_st_help_contact" id="bt_st_help_contact" style="width:100%" required>
            </div>
            
            <label for="seven">Additional remark: (Optional)</label><br>
            <input type="text" name="bt_st_additional_remark" id="bt_st_additional_remark" style="width:100%" required>
            <br>
            
            Instead of deactivating, consider raising a <a target="_blank" href="https://wordpress.org/support/plugin/shipment-tracker-for-woocommerce/">support ticket</a>. We'd love to help!
        </div>
        <div class="modal-footer">
            <a id="bt_st_deactivate_plugin" href="plugins.php?action=deactivate&amp;plugin=shipment-tracker-for-woocommerce%2Fbt-sync-shipment-tracking.php&amp;plugin_status=all&amp;paged=1&amp;s&amp;_wpnonce=a94259e4fb">I rather wouldn't say</a>
            <span>
                <button type="submit" class="submit_deactivate" >Submit & Deactivate</button>
                <button class="cancel">Cancel</button>
            </span>
        </div>
    </div>

</div>

<style>

    /* The Modal (background) */
    #bt-st-deactivation_popup.bt_st_deactivation_popup {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }
    #bt-st-deactivation_popup .modal-content .modal-heading {
        font-size: 16px;
    }
    #bt-st-deactivation_popup .modal-content label {
        line-height: 35px;
    }
    /* Modal Content/Box */
    #bt-st-deactivation_popup .modal-content {
        font-size: 18px;
        background-color: #fefefe;
        margin: 8% auto;
        /* 15% from the top and centered */
        padding: 0px;
        border: 1px solid #888;
        max-width: 650px;
        /* Full width */
        width: 80%;
        /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    #bt-st-deactivation_popup .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    #bt-st-deactivation_popup .close:hover,
    #bt-st-deactivation_popup .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    #bt-st-deactivation_popup .modal-footer {
        display: flex;
        padding: 10px 20px;
        justify-content: space-between;
        background-color: #ececec;
        color: white;
        font-size: 14px;
    }
    #bt-st-deactivation_popup .modal-header {
        padding: 2px 16px;
        background-color: #ececec;
        color: white;
    }
    #bt-st-deactivation_popup .modal-body {padding: 20px;font-size: 14px;}
</style>