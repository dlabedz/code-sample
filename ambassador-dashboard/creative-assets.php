<div id="creative-assets" class="ambassador-dashboard-card col-md-4">
    <div class="card-inner full-height">
        <h4 class="card-title">Creative Assets<span class="toggle-trigger close-toggle"></span></h4>
        <div class="card-content open">
            <p>Follow these links to download creative assets for your use.</p>
            <?php if( have_rows('creative_assets') ): ?>
                <?php while( have_rows('creative_assets') ): the_row();?>
                    <?php if( get_sub_field('file') ): ?>
                        <a href="<?php the_sub_field('file'); ?>" target="_blank"><?php the_sub_field('file_description'); ?></a>
                    <?php endif; ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
