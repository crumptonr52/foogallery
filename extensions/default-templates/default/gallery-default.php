<?php
/**
 * FooGallery default responsive gallery template
 */
global $current_foogallery;
global $current_foogallery_arguments;

$args = foogallery_gallery_template_setting( 'thumbnail_dimensions', array() );

$args['link'] = foogallery_gallery_template_setting( 'thumbnail_link', 'image' );
$lightbox = foogallery_gallery_template_setting( 'lightbox', 'unknown' );
$spacing = foogallery_gallery_template_setting( 'spacing', '' );
$alignment = foogallery_gallery_template_setting( 'alignment', 'fg-center' );

$caption_content = foogallery_gallery_template_setting( 'caption-content', 'title' );

$foogallery_default_classes = foogallery_build_class_attribute_safe( $current_foogallery, 'foogallery-lightbox-' . $lightbox, $spacing, $alignment );

$foogallery_default_attributes = foogallery_build_container_attributes_safe( $current_foogallery, array( 'class' => $foogallery_default_classes ) );

?><div <?php echo $foogallery_default_attributes; ?>>
	<?php foreach ( $current_foogallery->attachments() as $attachment ) {
        echo foogallery_attachment_html( $attachment, $args, $caption_content );
	} ?>
</div>