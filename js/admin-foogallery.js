(function (FOOGALLERY, $, undefined) {

    FOOGALLERY.media_uploader = false;
    FOOGALLERY.previous_post_id = 0;
    FOOGALLERY.attachments = [];
    FOOGALLERY.selected_attachment_id = 0;

    FOOGALLERY.calculateAttachmentIds = function() {
        var sorted = [];
        $('.foogallery-attachments-list li:not(.add-attachment)').each(function() {
            sorted.push( $(this).data('attachment-id') );
        });

        $('#foogallery_attachments').val( sorted.join(',') );
    };

    FOOGALLERY.initAttachments = function() {
        var attachments = $('#foogallery_attachments').val();
		if (attachments) {
			FOOGALLERY.attachments = $.map(attachments.split(','), function (value) {
				return parseInt(value, 10);
			});
		}
    };

	FOOGALLERY.galleryTemplateChanged = function(reloadPreview) {
		var selectedTemplate = FOOGALLERY.getSelectedTemplate(),
			$settingsToShow = $('.foogallery-settings-container-' + selectedTemplate),
			$settingsToHide = $('.foogallery-settings-container').not($settingsToShow);

		//hide all template fields
		$settingsToHide.hide()
			.removeClass('foogallery-settings-container-active')
			.find(':input').attr('disabled', true);

		//show all fields for the selected template only
		$settingsToShow.show()
			.addClass('foogallery-settings-container-active')
			.find(':input').removeAttr('disabled');

		//include a preview CSS if possible
		FOOGALLERY.includePreviewCss();

		//trigger a change so custom template js can do something
		FOOGALLERY.triggerTemplateChangedEvent();

		if (reloadPreview) {
			FOOGALLERY.reloadGalleryPreview();
		}
	};

	FOOGALLERY.handleSettingFieldChange = function(reloadPreview) {

		//make sure the fields that should be hidden or shown are doing what they need to do
        FOOGALLERY.handleSettingsShowRules();

		if (reloadPreview) {
			//update the gallery preview
			FOOGALLERY.updateGalleryPreview();
		}
	};

	FOOGALLERY.updateGalleryPreview = function() {
		var $preview = $('.foogallery_preview_container .foogallery');

		//build up the container class
		var $classFields = $('.foogallery-settings-container-active .foogallery-metabox-settings .foogallery_template_field[data-foogallery-preview="class"]');

		if ($classFields.length) {

			var array = $classFields.find(' :input').serializeArray(),
				selectedTemplate = FOOGALLERY.getSelectedTemplate(),
				classes = $.map(array, function (item) {
					return item.value;
				}).concat(['foogallery', 'fg-' + selectedTemplate]).join(' ');

			$preview.attr('class', classes);
		}

		$('body').trigger('foogallery-gallery-preview-updated-' + FOOGALLERY.getSelectedTemplate() );
	};

	FOOGALLERY.reloadGalleryPreview = function() {
		//build up all the data to generate a preview
        var $shortcodeFields = $('.foogallery-settings-container-active .foogallery-metabox-settings .foogallery_template_field[data-foogallery-preview="shortcode"]'),
			data = {};

        if ($shortcodeFields.length) {
			data = $shortcodeFields.find(' :input').serializeArray();
        }

        //add additional data for the preview
		data.push({name: 'foogallery_id', value: $('#post_ID').val()});
		data.push({name: 'foogallery_template', value: FOOGALLERY.getSelectedTemplate()});
		data.push({name: 'foogallery_attachments', value: $('#foogallery_attachments').val()});

		//add data needed for the ajax call
		data.push({name: 'action', value: 'foogallery_preview'});
		data.push({name: 'foogallery_preview_nonce', value: $('#foogallery_preview').val()});
		data.push({name: '_wp_http_referer', value: encodeURIComponent($('input[name="_wp_http_referer"]').val())});

        $('#foogallery_preview_spinner').addClass('is-active');
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
			//dataType: "json",
            success: function(data) {
                //updated the preview
				$('.foogallery_preview_container').html(data);
                $('#foogallery_preview_spinner').removeClass('is-active');

				FOOGALLERY.handleSettingFieldChange(true);
            }
        });
	};

	FOOGALLERY.handleSettingsShowRules = function() {
		var selectedTemplate = FOOGALLERY.getSelectedTemplate();

		//hide any fields that need to be hidden initially
		$('.foogallery-settings-container-active .foogallery_template_field[data-foogallery-hidden]').hide()
			.addClass('foogallery_template_field_template_hidden')
			.find(':input').attr('disabled', true);

		$('.foogallery-settings-container-active .foogallery_template_field[data-foogallery-show-when-field]').each(function(index, item) {
			var $item = $(item),
				fieldId = $item.data('foogallery-show-when-field'),
				fieldValue = $item.data('foogallery-show-when-field-value'),
                fieldOperator = $item.data('foogallery-show-when-field-operator'),
				$fieldRow = $('.foogallery_template_field_template_id-' + selectedTemplate + '-' + fieldId),
				$fieldSelector = $fieldRow.data('foogallery-value-selector'),
				fieldValueAttribute = $fieldRow.data('foogallery-value-attribute'),
				$field = $fieldRow.find($fieldSelector);

			$field.each(function() {
				var actualFieldValue = fieldValueAttribute ? $(this).attr(fieldValueAttribute) : $(this).val();

				if ( fieldOperator === '!==' ) {
					if ( actualFieldValue !== fieldValue ) {
						$item.show()
							.removeClass('foogallery_template_field_template_hidden')
							.find(':input').removeAttr('disabled');
					}
				} else if ( actualFieldValue === fieldValue ) {
					$item.show()
						.removeClass('foogallery_template_field_template_hidden')
						.find(':input').removeAttr('disabled');
				}
			});
		});
	};

	FOOGALLERY.initSettings = function() {
		//move the template selector into the metabox heading
        $('.foogallery-template-selector').appendTo( '#foogallery_settings .hndle span' ).removeClass('hidden');

		//move the items switch selector into the metabox heading
		$('.foogallery-items-view-switch-container').appendTo( '#foogallery_items .hndle span' ).removeClass('hidden');

		$('.foogallery-items-view-switch-container a').click(function(e) {
			e.preventDefault();

			var $currentButton = $('.foogallery-items-view-switch-container a.current'),
				currentSelector = $currentButton.data('container'),
				$nextButton = $(this),
				nextSelector = $nextButton.data('container');

			//toggle the views
			$(currentSelector).hide();
			$(nextSelector).show();

			//toggle the switch button
			$currentButton.removeClass('current');
			$nextButton.addClass('current');

			if ( $('.foogallery_preview_container').is(':visible') ) {
				FOOGALLERY.updateGalleryPreview();
			}
		});

		$(function() {

			// Prevent inputs in settings meta box headings opening/closing contents.
			$( '#foogallery_settings' ).find( '.hndle' ).unbind( 'click.postboxes' );

			$( '#foogallery_settings' ).on( 'click', '.hndle', function( event ) {

				// If the user clicks on some form input inside the h3 the box should not be toggled.
				if ( $( event.target ).filter( 'input, option, label, select' ).length ) {
					return;
				}

				$( '#foogallery_settings' ).toggleClass( 'closed' );
			});

			// Prevent inputs in items meta box headings opening/closing contents.
			$( '#foogallery_items' ).find( '.hndle' ).unbind( 'click.postboxes' );

			$( '#foogallery_items' ).on( 'click', '.hndle', function( event ) {

				// If the user clicks on some form input inside the h3 the box should not be toggled.
				if ( $( event.target ).filter( 'input, option, label, select' ).length ) {
					return;
				}

				$( '#foogallery_items' ).toggleClass( 'closed' );
			});
		});


		$('#FooGallerySettings_GalleryTemplate').change(function() {
			FOOGALLERY.galleryTemplateChanged(true);
		});

		//hook into settings fields changes
		$('.foogallery-metabox-settings .foogallery_template_field[data-foogallery-change-selector]').each(function(index, item) {
			var $fieldContainer = $(item),
				selector = $fieldContainer.data('foogallery-change-selector');

            $fieldContainer.find(selector).change(function() {
            	FOOGALLERY.handleSettingFieldChange(true);
			});
        });

		//trigger this onload too!
		FOOGALLERY.galleryTemplateChanged(false);
	};

	FOOGALLERY.getSelectedTemplate = function() {
		return $('#FooGallerySettings_GalleryTemplate').val();
	};

	FOOGALLERY.includePreviewCss = function() {
		var selectedPreviewCss = $('#FooGallerySettings_GalleryTemplate').find(":selected").data('preview-css');

		//remove any previously added preview css
		$('link[data-foogallery-preview-css]').remove();

		if ( selectedPreviewCss ) {
			var splitPreviewCss = selectedPreviewCss.split(',');
			for (var i = 0, l = splitPreviewCss.length; i < l; i++) {
				$('head').append('<link data-foogallery-preview-css rel="stylesheet" href="' + splitPreviewCss[i] + '" type="text/css" />');
			}
		}
	};

	FOOGALLERY.triggerTemplateChangedEvent = function() {
		$('body').trigger('foogallery-gallery-template-changed-' + FOOGALLERY.getSelectedTemplate() );
	};

    FOOGALLERY.addAttachmentToGalleryList = function(attachment) {

        if ($.inArray(attachment.id, FOOGALLERY.attachments) !== -1) return;

        var $template = $($('#foogallery-attachment-template').val());

        $template.attr('data-attachment-id', attachment.id);

        $template.find('img').attr('src', attachment.src);

        $('.foogallery-attachments-list .add-attachment').before($template);

        FOOGALLERY.attachments.push( attachment.id );

        FOOGALLERY.calculateAttachmentIds();
    };

    FOOGALLERY.removeAttachmentFromGalleryList = function(id) {
        var index = $.inArray(id, FOOGALLERY.attachments);
        if (index !== -1) {
            FOOGALLERY.attachments.splice(index, 1);
        }
		$('[data-attachment-id="' + id + '"]').remove();

        FOOGALLERY.calculateAttachmentIds();
    };

	FOOGALLERY.showAttachmentInfoModal = function(id) {
		FOOGALLERY.openMediaModal( id );
	};

	FOOGALLERY.openMediaModal = function(selected_attachment_id) {
		if (!selected_attachment_id) { selected_attachment_id = 0; }
		FOOGALLERY.selected_attachment_id = selected_attachment_id;

		//if the media frame already exists, reopen it.
		if ( FOOGALLERY.media_uploader !== false ) {
			// Open frame
			FOOGALLERY.media_uploader.open();
			return;
		}

		// Create the media frame.
		FOOGALLERY.media_uploader = wp.media.frames.file_frame = wp.media({
			title: FOOGALLERY.mediaModalTitle,
			//frame: 'post',
			button: {
				text: FOOGALLERY.mediaModalButtonText
			},
			multiple: 'add',  // Set to allow multiple files to be selected
			toolbar:  'select'
		});

		// When an image is selected, run a callback.
		FOOGALLERY.media_uploader
			.on( 'select', function() {
				var attachments = FOOGALLERY.media_uploader.state().get('selection').toJSON();

				$.each(attachments, function(i, item) {
					if (item && item.id && item.sizes) {
						if (item.sizes.thumbnail) {
							var attachment = {
								id: item.id,
								src: item.sizes.thumbnail.url
							};
						} else {
							//thumbnail could not be found for whatever reason
							var attachment = {
								id: item.id,
								src: item.url
							};
						}

						FOOGALLERY.addAttachmentToGalleryList(attachment);
					} else {
						//there was a problem adding the item! Move on to the next
					}
				});
			})
			.on( 'open', function() {
				var selection = FOOGALLERY.media_uploader.state().get('selection');
				if (selection) {
					//clear any previous selections
					selection.reset();
				}

				if (FOOGALLERY.selected_attachment_id > 0) {
					var attachment = wp.media.attachment(FOOGALLERY.selected_attachment_id);
					attachment.fetch();
					selection.add( attachment ? [ attachment ] : [] );
				} else {
					//would be nice to have all previously added media selected
				}
			});

		// Finally, open the modal
		FOOGALLERY.media_uploader.open();
	};

	FOOGALLERY.initUsageMetabox = function() {
		$('#foogallery_create_page').on('click', function(e) {
			e.preventDefault();

			$('#foogallery_create_page_spinner').addClass('is-active');
			var data = 'action=foogallery_create_gallery_page' +
				'&foogallery_id=' + $('#post_ID').val() +
				'&foogallery_create_gallery_page_nonce=' + $('#foogallery_create_gallery_page_nonce').val() +
				'&_wp_http_referer=' + encodeURIComponent($('input[name="_wp_http_referer"]').val());

			$.ajax({
				type: "POST",
				url: ajaxurl,
				data: data,
				success: function(data) {
					//refresh page
					location.reload();
				}
			});
		});
	};

	FOOGALLERY.initThumbCacheMetabox = function() {
		$('#foogallery_clear_thumb_cache').on('click', function(e) {
			e.preventDefault();

			$('#foogallery_clear_thumb_cache_spinner').addClass('is-active');
			var data = 'action=foogallery_clear_gallery_thumb_cache' +
				'&foogallery_id=' + $('#post_ID').val() +
				'&foogallery_clear_gallery_thumb_cache_nonce=' + $('#foogallery_clear_gallery_thumb_cache_nonce').val() +
				'&_wp_http_referer=' + encodeURIComponent($('input[name="_wp_http_referer"]').val());

			$.ajax({
				type: "POST",
				url: ajaxurl,
				data: data,
				success: function(data) {
					alert(data);
					$('#foogallery_clear_thumb_cache_spinner').removeClass('is-active');
				}
			});
		});
	};

    FOOGALLERY.adminReady = function () {
        $('.upload_image_button').on('click', function(e) {
            e.preventDefault();
			FOOGALLERY.mediaModalTitle = $(this).data( 'uploader-title' );
			FOOGALLERY.mediaModalButtonText = $(this).data( 'uploader-button-text' );
			FOOGALLERY.openMediaModal(0);
        });

        FOOGALLERY.initAttachments();

		FOOGALLERY.initSettings();

		FOOGALLERY.initUsageMetabox();

		FOOGALLERY.initThumbCacheMetabox();

        $('.foogallery-attachments-list')
            .on('click' ,'a.remove', function(e) {
				e.preventDefault();
                var $selected = $(this).parents('li:first'),
					attachment_id = $selected.data('attachment-id');
                FOOGALLERY.removeAttachmentFromGalleryList(attachment_id);
            })
			.on('click' ,'a.info', function() {
				var $selected = $(this).parents('li:first'),
					attachment_id = $selected.data('attachment-id');
				FOOGALLERY.showAttachmentInfoModal(attachment_id);
			})
            .sortable({
                items: 'li:not(.add-attachment)',
                distance: 10,
                placeholder: 'attachment placeholder',
                stop : function() {
                    FOOGALLERY.calculateAttachmentIds();
                }
            });

		//init any colorpickers
		$('.colorpicker').spectrum({
			preferredFormat: "rgb",
			showInput: true,
			clickoutFiresChange: true
		});
    };

}(window.FOOGALLERY = window.FOOGALLERY || {}, jQuery));

jQuery(function ($) {
	if ( $('#foogallery_attachments').length > 0 ) {
		FOOGALLERY.adminReady();
	}
});