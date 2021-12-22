<div class="mj_ss_slides_wrap">
    <ul class="mj_ss_slides">
        <?php foreach( $images as $image ) : ?>
            <li>
                <img width="250" height="130" src="<?php echo wp_get_attachment_image_src( $image->ID, 'mj_slideshow_thumbnail' )[0]; ?>" />
                <div class="mj_slide_actions">
                    <a href="#" class="mj_slide_move">
                        <span class="tooltip">Drag & Sort</span>
                        <i class="dashicons dashicons-move"></i>
                    </a>
                    <a href="#" class="mj_slide_remove">
                        <span class="tooltip">Delete</span>
                        <i class="dashicons dashicons-trash"></i>
                    </a>
                </div>
                <input type="hidden" name="<?php echo __($metaKey) . "[]"; ?>" value="<?php echo __($image->ID); ?>" />
            </li>
        <?php endforeach; ?>
    </ul>
    <div style="clear:both"></div>
    <?php wp_nonce_field( 'mj_slideshow_metabox_data', 'mj_slideshow_metabox_nonce' ); ?>
    <a href="#" class="button mj_upload_slide">Add Slide</a>
</div>