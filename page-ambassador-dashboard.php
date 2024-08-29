<?php

/**
 * Template Name: Ambassador Dashboard

 */

get_header(); ?>

<?php
if ( current_user_can('is_influencer') ) { ?>

<div id="primary" class="content-area ">
	<main id="main" class="site-main" role="main">
        <article id="post-<?php echo get_the_ID(); ?>" class="post-<?php echo get_the_ID(); ?> page type-page hentry">
            <div class="container">

                <div class="row">
                    <div class="ambassador-dashboard-links-container">
                    <button id="dropdown-button" type="button" data-toggle="dropdown">Go to Section
                    <span class="toggle-icon">+</span></button>
                        <ul id="dashboard-dropdown">
                            <li><a href="#eq-announcements">EQ Announcements</a></li>
                            <li><a href="#ambassador-profile">Ambassador Profile</a></li>
                            <li><a href="#dosage-contact-form">Contact Dosage</a></li>
                            <li><a href="#ambassador-commission">My Commission</a></li>
                            <li><a href="#product-order-form">Product Ordering</a></li>
                            <li><a href="#generate-url">Generate a Referral URL</a></li>
                            <li><a href="#creative-assets">Creative Assets</a></li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <h2>Welcome back, <?php echo do_shortcode('[affiliate_name]'); ?>!</h2>
                </div>

                <div class="ambassador-card-container">

                    <div class="row">
                        <?php get_template_part('template-parts/ambassador-dashboard/announcements'); ?>
                    </div>

                    <div class="row display-flex">
                        <div class="flex-container col-md-6">
                            <?php get_template_part('template-parts/ambassador-dashboard/ambassador-profile'); ?>

                            <?php get_template_part('template-parts/ambassador-dashboard/dosage-contact-form'); ?>
                        </div>

                        <?php get_template_part('template-parts/ambassador-dashboard/commission'); ?>

                    </div>

                    <div class="row display-flex">

                        <?php get_template_part('template-parts/ambassador-dashboard/product-order-form'); ?>

                        <?php get_template_part('template-parts/ambassador-dashboard/generate-url'); ?>

                        <?php get_template_part('template-parts/ambassador-dashboard/creative-assets'); ?>

                    </div>

                </div>

            </div>

        </article>

	</main><!-- #main -->
</div><!-- #primary -->

<script>

    (function ($) {
        $(document).ready(function () {
            /*Adds slideToggle functionality to mobile anchor links menu*/
            $("#dashboard-dropdown").hide();
            $('#dropdown-button').click(function (e) {
                e.preventDefault();
                //$('#dashboard-dropdown').toggleClass('open');
                $('#dashboard-dropdown').slideToggle('slow');
            });

            /*Adds class to .toggle-trigger if <= desktop breakpoint of 1200px*/
            if ($(window).width() <= 1199) {
                $('.toggle-trigger').addClass('mobile-toggle');
            }

            /*Adds accordion functionality to cards*/
            $('.card-title').click(function (e) {
                e.preventDefault();

                let $this = $(this);
                let $toggle = $('.toggle-trigger', this);

                $toggle.toggleClass('mobile-toggle');
                $this.next().slideToggle(300);

                if ($toggle.hasClass('mobile-toggle')) {
                    $this.next().removeClass('open');
                    $this.parent().removeClass('full-height');
                }
                else {
                    $this.next().addClass('open');
                    $this.parent().addClass('full-height');
                }
            });
        });
    })(jQuery);
</script>

<?php 

} else {
    echo '<div class="container">You need to be logged in to see this page. Please <a href="/wp-login.php">log in here.</a></div>';
}
?>

<?php
# intentionally leaving footer tag unclosed: https://wordpress.stackexchange.com/questions/210765/to-close-or-not-to-close-php
get_footer();

