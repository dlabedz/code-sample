 
<div id="ambassador-profile" class="ambassador-dashboard-card col">
    <div class="card-inner full-height">
        <h4 class="card-title">Ambassador Profile<span class="toggle-trigger close-toggle"></span></h4>
        <div class="card-content open">   
            <div class="profile-text">
                <p><strong>Billing Email</strong></p>
                <p><?php global $current_user;
                    wp_get_current_user();
                    echo $current_user->user_email;
                ?></p>
            </div>

            <div class="profile-text">
                <p><strong>Ambassador Code</strong></p>
                <p><?php echo do_shortcode('[affiliate_username]'); ?></p>
            </div>

            <div class="profile-text">
                <p><strong>Referral</strong></p>
                <p id="select-this"><?php echo do_shortcode('[affiliate_referral_url format="username" pretty="yes" url="https://myeq.com"]?coupon-code=[affiliate_username]'); ?></p>

                <div class="dashboard-link" id="change-text" onclick="copyTextFromElement('select-this')">Copy Link</div>
            </div>
        </div>
    </div>
</div>


<script>
    function copyTextFromElement(elementID) {
        let element = document.getElementById(elementID); //select the element
        let elementText = element.textContent; //get the text content from the element
        copyText(elementText); //use the copyText function below
        changeText(elementText); //use the copyText function below
    }

    function copyText(text) {
        navigator.clipboard.writeText(text);
    }

    function changeText(){
        document.getElementById("change-text").innerHTML = "Link Copied";
        setTimeout(function() {
        document.getElementById("change-text").innerHTML = "Copy Link";
        }, 5000); 
    }
</script>




 