<?php
    $value = affwp_get_affiliate_username( $affiliate_id );
?>

<div id="generate-url" class="ambassador-dashboard-card col-md-4">
    <div class="card-inner full-height">
        <h4 class="card-title">Generate a Referral URL<span class="toggle-trigger close-toggle"></span></h4>
        <div class="card-content open">
            <p>Page URL you'd like linked:</p>
            <input type="url" id="page-url" placeholder="Page link"></input>
            <button id="generate-url">Generate</button>
            <p>Referral link:</p>
            <input type="text" id="referral-link" placeholder="Referral link will appear here"></input>
            <div class="dashboard-link" id="edit-text">Copy Link</div>
        </div>
    </div>
</div>


<script>

jQuery("#generate-url").click(function(){
    let coupon = "?coupon-code=<?php echo $value; ?>";
    jQuery("#referral-link").val(jQuery("#page-url").val() + coupon);  
});


jQuery("#edit-text").click(function(){
    jQuery("#referral-link").select();
    document.execCommand("copy");
    jQuery("#edit-text").html("Link Copied");
    setTimeout(function() {
    jQuery("#edit-text").html("Copy Link");
  }, 5000); 
});


</script>
