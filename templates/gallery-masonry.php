<?php
/**
 * FooGallery masonry gallery template
 */
global $current_foogallery;
global $current_foogallery_arguments;
wp_enqueue_script( 'masonry' );

if ( !foo_check_wp_version_at_least( '3.9' ) ) { ?>
	<script>
		jQuery(function ($) {
			$('#foogallery-gallery-<?php echo $current_foogallery->ID; ?>').masonry({
				itemSelector: '.item',
				columnWidth: 160
			});
		});
	</script>
<?php } ?>
<div id="foogallery-gallery-<?php echo $current_foogallery->ID; ?>"
	 class="foogallery-container foogallery-masonry js-masonry"
	 data-masonry-options='{ "columnWidth": 200, "itemSelector": ".item" }'>
	<?php foreach ( $current_foogallery->attachments() as $attachment_id ) {
		echo '<div class="item">';
		echo wp_get_attachment_link( $attachment_id, 'thumbnail', false );
		echo '</div>';
	} ?>
</div>
