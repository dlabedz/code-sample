<div id="ambassador-commission" class="ambassador-dashboard-card col-md-8">
    <div class="card-inner full-height">
        <h4 class="card-title commission-card-inner">My Commission<span class="toggle-trigger close-toggle"></span></h4>
        <div class="card-content open">

            <div class="commission-subtitle all-caps commission-card-inner">Commission Rates</div>
            <table class=ambassador-commission-rates>
                <tr>
                    <th></th>
                    <th>Discount</th>
                    <th>Commission</th>
                </tr>
                <tr>
                    <td class="commission-rate-padding">One-time purchase</td>
                    <td>15%</td>
                    <td>15%</td>
                </tr>
                <tr>
                    <td class="commission-rate-padding">Subscription (Month 1)</td>
                    <td>15%</td>
                    <td>20%</td>
                </tr>
                <tr>
                    <td class="commission-rate-padding">Renewal (Month 2)</td>
                    <td>-</td>
                    <td>30%</td>
                </tr>
                <tr>
                    <td class="commission-rate-padding">Renewal (Month 3)</td>
                    <td>-</td>
                    <td>50%</td>
                </tr>
            </table>

            <div class="commission-subtitle all-caps commission-card-inner">Order Total</div>

            <div class="commission-card-inner">
                <table class="ambassador-order-totals">
                    <tr>
                        <th>Today</th>
                        <th>WTD</th>
                        <th>MTD</th>
                        <th>YTD</th>
                    </tr>
                    <tr>
                        <td><?php echo number_format( equilibria_get_ambassador_order_total_today() ); ?></td>
                        <td><?php echo number_format( equilibria_get_ambassador_order_total_wtd() ); ?></td>
                        <td><?php echo number_format( equilibria_get_ambassador_order_total_mtd() ); ?></td>
                        <td><?php echo number_format( equilibria_get_ambassador_order_total_ytd() ); ?></td> <!-- Keep this as is for now -->
                    </tr>
                </table>
            </div>

            <div class="commission-subtitle all-caps commission-card-inner">Earnings Total</div>

            <div class="commission-card-inner">
                <table class="ambassador-total-earnings">
                    <tr>
                        <th>Today</th>
                        <th>WTD</th>
                        <th>MTD</th>
                        <th>YTD</th>
                    </tr>
                    <tr>
                        <td>$<?php echo number_format( equilibria_get_ambassador_commission_total_today(), 2 ); ?></td>
                        <td>$<?php echo number_format( equilibria_get_ambassador_commission_total_wtd(), 2 ); ?></td>
                        <td>$<?php echo number_format( equilibria_get_ambassador_commission_total_mtd(), 2 ); ?></td>
                        <td>$<?php echo number_format( equilibria_get_ambassador_commission_total_ytd(), 2 ); ?></td> <!-- Keep this as is for now -->
                    </tr>
                </table>

                <p>For questions regarding commissions, please contact <a href="mailto:accounting@myeq.com" target="_blank">accounting@myeq.com</a></p>
            </div>


            <div class="commission-subtitle commission-card-inner earnings-subtitle">Earnings by Order Type</div>

            <div class="order-type-wrapper">
                <div class="order-type-container">
                    <p>One-Time Purchase</p>
                    <table class="otp-earnings">
                        <tr>
                            <th>Today</th>
                            <th>WTD</th>
                            <th>MTD</th>
                        </tr>
                        <tr>
                            <td>$<?php echo number_format( equilibria_get_ambassador_earnings_today_by_order_type( "otp" ), 2 ); ?></td>
                            <td>$<?php echo number_format( equilibria_get_ambassador_earnings_wtd_by_order_type( "otp" ), 2 ); ?></td>
                            <td>$<?php echo number_format( equilibria_get_ambassador_earnings_mtd_by_order_type( "otp" ), 2 ); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="order-type-wrapper">
                <div class="order-type-container">
                    <p>Subscription (Month 1) </p>
                    <table class="new-sub-month-1">
                        <tr>
                            <th>Today</th>
                            <th>WTD</th>
                            <th>MTD</th>
                        </tr>
                        <tr>
                            <td>$<?php echo number_format( equilibria_get_ambassador_earnings_today_by_order_type( "sub1" ), 2 ); ?></td>
                            <td>$<?php echo number_format( equilibria_get_ambassador_earnings_wtd_by_order_type( "sub1" ), 2 ); ?></td>
                            <td>$<?php echo number_format( equilibria_get_ambassador_earnings_mtd_by_order_type( "sub1" ), 2 ); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="order-type-wrapper">
                <div class="order-type-container">
                    <p>Renewal (Month 2)</p>
                    <table class="new-sub-month-2">
                        <tr>
                            <th>Today</th>
                            <th>WTD</th>
                            <th>MTD</th>
                        </tr>
                        <tr>
                            <td>$<?php echo number_format( equilibria_get_ambassador_earnings_today_by_order_type( "sub2" ), 2 ); ?></td>
                            <td>$<?php echo number_format( equilibria_get_ambassador_earnings_wtd_by_order_type( "sub2" ), 2 ); ?></td>
                            <td>$<?php echo number_format( equilibria_get_ambassador_earnings_mtd_by_order_type( "sub2" ), 2 ); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="order-type-wrapper">
                <div class="order-type-container">
                    <p>Renewal (Month 3)</p>
                    <table class="new-sub-month-3">
                        <tr>
                            <th>Today</th>
                            <th>WTD</th>
                            <th>MTD</th>
                        </tr>
                        <tr>
                            <td>$<?php echo number_format( equilibria_get_ambassador_earnings_today_by_order_type( "sub3" ), 2 ); ?></td>
                            <td>$<?php echo number_format( equilibria_get_ambassador_earnings_wtd_by_order_type( "sub3" ), 2 ); ?></td>
                            <td>$<?php echo number_format( equilibria_get_ambassador_earnings_mtd_by_order_type( "sub3" ), 2 ); ?></td>
                        </tr>
                    </table>
                </div>
            </div>


            <div class="commission-subtitle commission-card-inner earnings-subtitle">Earnings by SKU</div>

            <div class="sku-tables-wrapper">

				<?php

				$all_products = wc_get_products( array(
					'orderby'  => 'date',
					'order'    => 'DESC',
					'limit'    => - 1,
					'category' => array( 'ambassador-dashboard' ),
				) );

				foreach ( $all_products as $product ) {
					?>
                    <div class="sku-wrapper">
                        <div class="sku-container">
                            <p><?php echo $product->get_title(); ?></p>
                            <table class="sku-earnings">
                                <tr>
                                    <th>Today</th>
                                    <th>WTD</th>
                                    <th>MTD</th>
                                </tr>
                                <tr>
                                    <td>$<?php echo number_format( equilibria_get_ambassador_earnings_today_by_product( $product->get_id() ), 2 ); ?></td>
                                    <td>$<?php echo number_format( equilibria_get_ambassador_earnings_wtd_by_product( $product->get_id() ), 2 ); ?></td>
                                    <td>$<?php echo number_format( equilibria_get_ambassador_earnings_mtd_by_product( $product->get_id() ), 2 ); ?></td>
                                </tr>
                            </table>

							<?php
							if ( method_exists( $product, 'get_available_variations' ) ) {
								$product_variations = $product->get_available_variations( 'objects' );
								if ( is_array( $product_variations ) && count( $product_variations ) > 0 ) {
									foreach ( $product_variations as $product_variation ) {
										$product_variation = wc_get_product( $product_variation );
										?>
                                        <p><?php echo $product_variation->get_name(); ?></p>
                                        <table class="sku-earnings">
                                            <tr>
                                                <th>Today</th>
                                                <th>WTD</th>
                                                <th>MTD</th>
                                            </tr>

                                            <tr>
                                                <td>$<?php echo number_format( equilibria_get_ambassador_earnings_today_by_product( $product_variation->get_id() ), 2 ); ?></td>
                                                <td>$<?php echo number_format( equilibria_get_ambassador_earnings_wtd_by_product( $product_variation->get_id() ), 2 ); ?></td>
                                                <td>$<?php echo number_format( equilibria_get_ambassador_earnings_mtd_by_product( $product_variation->get_id() ), 2 ); ?></td>
                                            </tr>
                                        </table>
										<?php
									}
								}
							}
							?>

                        </div>
                    </div>
					<?
				}

				?>

            </div>

            <div id="load-more-skus">Show Next 3 SKUs +</div>

        </div> <!-- end .card-content -->
    </div>
</div>


<script>

    jQuery(document).ready(function ($) {
        jQuery("#load-more-skus").click(function (e) {
            jQuery(".sku-wrapper:hidden").slice(0, 3).fadeIn("fast");
            if (jQuery(".sku-wrapper:hidden").length < 1) jQuery(this).fadeOut("fast");
        })
    })

</script>