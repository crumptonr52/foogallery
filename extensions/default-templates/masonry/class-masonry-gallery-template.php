<?php

if ( !class_exists( 'FooGallery_Masonry_Gallery_Template' ) ) {

	define('FOOGALLERY_MASONRY_GALLERY_TEMPLATE_URL', plugin_dir_url( __FILE__ ));

	class FooGallery_Masonry_Gallery_Template {
		/**
		 * Wire up everything we need to run the extension
		 */
		function __construct() {
			add_filter( 'foogallery_gallery_templates', array( $this, 'add_template' ) );
			add_filter( 'foogallery_gallery_templates_files', array( $this, 'register_myself' ) );
			add_filter( 'foogallery_located_template-masonry', array( $this, 'enqueue_dependencies' ) );

			add_filter( 'foogallery_template_thumbnail_dimensions-masonry', array( $this, 'get_thumbnail_dimensions' ), 10, 2 );

			//add extra fields to the templates
			add_filter( 'foogallery_override_gallery_template_fields-masonry', array( $this, 'add_common_thumbnail_fields' ), 10, 2 );
		}

		/**
		 * Register myself so that all associated JS and CSS files can be found and automatically included
		 * @param $extensions
		 *
		 * @return array
		 */
		function register_myself( $extensions ) {
			$extensions[] = __FILE__;
			return $extensions;
		}

		/**
		 * Add our gallery template to the list of templates available for every gallery
		 * @param $gallery_templates
		 *
		 * @return array
		 */
		function add_template( $gallery_templates ) {
			$gallery_templates[] = array(
                'slug'        => 'masonry',
                'name'        => __( 'Masonry Image Gallery', 'foogallery' ),
                'lazyload_support' => true,
                'admin_js'	  => FOOGALLERY_MASONRY_GALLERY_TEMPLATE_URL . 'js/admin-gallery-masonry.js',
                'fields'	  => array(
                    array(
                        'id'      => 'thumbnail_width',
                        'title'   => __( 'Thumb Width', 'foogallery' ),
                        'desc'    => __( 'Choose the width of your thumbnails. Thumbnails will be generated on the fly and cached once generated', 'foogallery' ),
                        'section' => __( 'General', 'foogallery' ),
                        'type'    => 'number',
                        'class'   => 'small-text',
                        'default' => 150,
                        'step'    => '1',
                        'min'     => '0',
                    ),
                    array(
                        'id'      => 'layout',
                        'title'   => __( 'Masonry Layout', 'foogallery' ),
                        'desc'    => __( 'Choose a fixed width thumb layout, or responsive columns.', 'foogallery' ),
                        'section' => __( 'General', 'foogallery' ),
                        'type'    => 'radio',
                        'choices' => array(
                            'fixed'  => __( 'Fixed Width', 'foogallery' ),
                            '2col'   => __( '2 Columns', 'foogallery' ),
                            '3col'   => __( '3 Columns', 'foogallery' ),
                            '4col'   => __( '4 Columns', 'foogallery' ),
                            '5col'   => __( '5 Columns', 'foogallery' )
                        ),
                        'default' => 'fixed',
                        'row_data'=> array(
                            'data-foogallery-change-selector' => 'input:radio',
                            'data-foogallery-value-selector' => 'input:checked'
                        )
                    ),
                    array(
                        'id'      => 'gutter_width',
                        'title'   => __( 'Gutter Width', 'foogallery' ),
                        'desc'    => __( 'The spacing between your thumbnails. Only applicable when using a fixed layout!', 'foogallery' ),
                        'section' => __( 'General', 'foogallery' ),
                        'type'    => 'number',
                        'class'   => 'small-text',
                        'default' => 10,
                        'step'    => '1',
                        'min'     => '0',
                        'row_data'=> array(
                            'data-foogallery-hidden' => true,
                            'data-foogallery-show-when-field' => 'layout',
                            'data-foogallery-show-when-field-value' => 'fixed'
                        )
                    ),
                    array(
                        'id'      => 'gutter_percent',
                        'title'   => __( 'Gutter Size', 'foogallery' ),
                        'desc'    => __( 'Choose a gutter size when using responsive columns.', 'foogallery' ),
                        'section' => __( 'General', 'foogallery' ),
                        'type'    => 'radio',
                        'choices' => array(
                            'no-gutter'   => __( 'No Gutter', 'foogallery' ),
                            ''  => __( 'Normal Size Gutter', 'foogallery' ),
                            'large-gutter'   => __( 'Larger Gutter', 'foogallery' )
                        ),
                        'default' => '',
                        'row_data'=> array(
                            'data-foogallery-hidden' => true,
                            'data-foogallery-show-when-field' => 'layout',
                            'data-foogallery-show-when-field-operator' => '!==',
                            'data-foogallery-show-when-field-value' => 'fixed'
                        )
                    ),
                    array(
                        'id'      => 'center_align',
                        'title'   => __( 'Alignment', 'foogallery' ),
                        'desc'    => __( 'You can choose to center align your images or leave them at the default. Only applicable when using a fixed layout!', 'foogallery' ),
                        'section' => __( 'Look &amp; Feel', 'foogallery' ),
                        'type'    => 'radio',
                        'choices' => array(
                            'default'  => __( 'Left Alignment', 'foogallery' ),
                            'center'   => __( 'Center Alignment', 'foogallery' ),
                            'right'   => __( 'Right Alignment', 'foogallery' )
                        ),
                        'default' => 'default'
                    ),
                    array(
                        'id'      => 'thumbnail_link',
                        'title'   => __( 'Thumb Link', 'foogallery' ),
                        'default' => 'image' ,
                        'type'    => 'thumb_link',
                        'desc'	  => __( 'You can choose to link each thumbnail to the full size image, or to the image\'s attachment page, or you can choose to not link to anything', 'foogallery' ),
                    ),
                    array(
                        'id'      => 'lightbox',
                        'title'   => __( 'Lightbox', 'foogallery' ),
                        'desc'    => __( 'Choose which lightbox you want to display images with. The lightbox will only work if you set the thumbnail link to "Full Size Image"', 'foogallery' ),
                        'type'    => 'lightbox',
                    ),
                ),
			);


			return $gallery_templates;
		}

		/**
		 * Enqueue scripts that the masonry gallery template relies on
		 */
		function enqueue_dependencies() {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'masonry' );

			//enqueue core files
			foogallery_enqueue_core_gallery_template_style();
			foogallery_enqueue_core_gallery_template_script();

			$css = FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'masonry/css/foogallery.masonry.min.css';
			wp_enqueue_style( 'foogallery-masonry', $css, array( 'foogallery-core' ), FOOGALLERY_VERSION );

			$js = FOOGALLERY_DEFAULT_TEMPLATES_EXTENSION_URL . 'masonry/js/foogallery.masonry.min.js';
			wp_enqueue_script( 'foogallery-masonry', $js, array( 'foogallery-core' ), FOOGALLERY_VERSION );
		}

		/**
		 * Get the thumb dimensions arguments saved for the gallery for this gallery template
		 *
		 * @param array $dimensions
		 * @param FooGallery $foogallery
		 *
		 * @return mixed
		 */
		function get_thumbnail_dimensions( $dimensions, $foogallery ) {
			$width = $foogallery->get_meta( 'masonry_thumbnail_width', false );
			return array(
				'height' => 0,
				'width'  => intval( $width ),
				'crop'   => false
			);
		}

		/**
		 * Add thumbnail fields to the gallery template
		 *
		 * @uses "foogallery_override_gallery_template_fields"
		 * @param $fields
		 * @param $template
		 *
		 * @return array
		 */
		function add_common_thumbnail_fields( $fields, $template ) {
			return apply_filters( 'foogallery_gallery_template_common_thumbnail_fields', $fields );
		}
	}
}