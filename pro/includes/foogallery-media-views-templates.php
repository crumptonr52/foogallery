<script type="text/html" id="tmpl-fg-importer">
	<?php
	$nonce = wp_create_nonce('fgi_nonce');
	echo "<input type=\"hidden\" class=\"fgi_nonce\" value=\"{$nonce}\"/>";
	?>

	<div class="fgi-region-query"></div>
	<div class="fgi-region-content"></div>
	<div class="fgi-region-help"></div>

</script>
<script type="text/html" id="tmpl-fgi-error">

	<div class="fgi-splash fgi-error-message">
		<h2>{{data.title}}</h2>
		<p>{{data.message}}</p>
		<div class="button-hero-container">
			<button type="button" class="button button-hero fgi-ok"><?php _e("OK", "foogallery") ?></button>
		</div>
	</div>

</script>
<script type="text/html" id="tmpl-fgi-help">

	<h2>Video Help</h2>
	<p>FooGallery supports a number of providers for importing videos and provides additional methods of importing multiple videos from YouTube and Vimeo.</p>
	<dl class="fgi-providers">
		<dt class="fgi-provider-title mode-expanded">YouTube</dt>
		<dd class="fgi-provider-content mode-expanded">
			<p>There are a number of ways to import YouTube videos.</p>

			<h4>Single Video</h4>
			<p>Simply enter the videos url into the search input to fetch a single video. The following URL formats are supported:</p>
			<ul>
				<li>http(s)://www.youtube.com/watch?v=[VIDEO_ID]</li>
				<li>http(s)://youtu.be/[VIDEO_ID]</li>
				<li>http(s)://www.youtube.com/embed/[VIDEO_ID]</li>
			</ul>
			<p>You can also provide just the videos' ID in the search input.</p>

			<h4>Playlists</h4>
			<p>Import an entire playlist or a subselection of its' videos by entering its' url into the search input. The following URL format is supported:</p>
			<ul>
				<li>http(s)://www.youtube.com/playlist?list=[PLAYLIST_ID]</li>
			</ul>
			<p>You can also provide just the playlists' ID in the search input.</p>

			<h4>Search</h4>
			<p>You can also perform a search on YouTube and select the videos to import from the results by simply typing your query into the search input.</p>
		</dd>
		<dt class="fgi-provider-title">Vimeo</dt>
		<dd class="fgi-provider-content">
			<p>There are a number of ways to import Vimeo videos.</p>

			<h4>Single Video</h4>
			<p>Simply enter the videos url into the search input to fetch a single video. The following URL formats are supported:</p>
			<ul>
				<li>http(s)://vimeo.com/[VIDEO_ID]</li>
				<li>http(s)://player.vimeo.com/video/[VIDEO_ID]</li>
				<li>http(s)://vimeo.com/album/[ALBUM_ID]/video/[VIDEO_ID]</li>
				<li>http(s)://vimeo.com/channels/[CHANNEL_ID]/[VIDEO_ID]</li>
			</ul>

			<h4>Albums</h4>
			<p>Import an entire album or a subselection of its' videos by entering its' url into the search input. The following URL format is supported:</p>
			<ul>
				<li>http(s)://vimeo.com/album/[ALBUM_ID]</li>
			</ul>

			<h4>User Videos</h4>
			<p>Import all videos for a specific user or a subselection of their videos by entering their user url into the search input. The following URL formats are supported:</p>
			<ul>
				<li>http(s)://vimeo.com/[USER_ID]</li>
				<li>http(s)://vimeo.com/[USER_ID]/videos</li>
			</ul>
		</dd>
		<dt class="fgi-provider-title">Self Hosted</dt>
		<dd class="fgi-provider-content">

		</dd>
		<dt class="fgi-provider-title">WordPress oEmbed</dt>
		<dd class="fgi-provider-content">
			<p>
				FooGallery supports importing videos from all registered WordPress oEmbed video providers by entering the supported video URL into the search input.
				For a full list of these providers please see the <a href="https://codex.wordpress.org/Embeds#oEmbed" target="_blank">official WordPress documentation on oEmbed providers</a>.
			</p>
			<p>The following table displays a list of these providers and there supported formats:</p>
			<table>
				<thead>
					<tr>
						<th>Provider</th>
						<th>URL Formats</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Animoto</td>
						<td>
							<ul>
								<li>http(s)://animoto.com/play/[VIDEO_ID]</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td>Cloudup</td>
						<td>
							<ul>
								<li>http(s)://cloudup.com/[VIDEO_ID]</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td>CollegeHumor</td>
						<td>
							<ul>
								<li>http(s)://www.collegehumor.com/video/[VIDEO_ID]</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td>DailyMotion</td>
						<td>
							<ul>
								<li>http(s)://www.dailymotion.com/video/[VIDEO_ID]</li>
								<li>http(s)://www.dailymotion.com/embed/video/[VIDEO_ID]</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td>TED</td>
						<td>
							<ul>
								<li>http(s)://www.ted.com/talks/[VIDEO_ID]</li>
							</ul>
						</td>
					</tr>
				</tbody>
			</table>
		</dd>
	</dl>

</script>
<script type="text/html" id="tmpl-fgi-getting-started">

<?php
	$help = sprintf('<a href="#toggle-help">%s</a>', __("help", "foogallery"));
?>

	<div class="fgi-splash fgi-getting-started-instructions">
		<h2><?php _e("Enter a supported URL or a YouTube search term, playlist or video ID in the input above.", "foogallery") ?></h2>
		<p><?php _e("or", "foogallery") ?></p>
		<button type="button" class="button button-hero fgi-select"
						data-options='{"type": "video/mp4,video/ogg,video/webm", "title":"<?php _e("Select a video", "foogallery") ?>", "button":"<?php _e("Select Video", "foogallery") ?>"}'>
			<?php _e("Choose a video from your Media Library", "foogallery") ?>
		</button>
		<p><small><?php printf(__("See the %s for more information.", "foogallery"), $help) ?></small></p>
	</div>

</script>
<script type="text/html" id="tmpl-fgi-query">

	<div class="fgi-query-left">
		<input type="text" class="fgi-query-input" placeholder="<?php _e("Enter a supported URL or a YouTube search term, playlist or video ID", "foogallery") ?>" spellcheck="false"/>
		<span class="fgi-query-input-spinner"></span>
	</div>

	<div class="fgi-query-right">
		<a href="#toggle-help"><?php _e("Help", "foogallery") ?></a>
	</div>

</script>
<script type="text/html" id="tmpl-fgi-self-hosted">

<?php
	$webm = '<a target="_blank" href="https://caniuse.com/#feat=webm">.webm</a>';
	$mp4 = '<a target="_blank" href="https://caniuse.com/#feat=mp4">.mp4</a>';
	$ogg = '<a target="_blank" href="https://caniuse.com/#feat=ogv">.ogg</a>';
?>

	<div class="fgi-self-hosted-notification">
		<p><?php _e("Enter the details for your video below and then click the Import button.", "foogallery") ?></p>
	</div>
	<div class="fgi-self-hosted-details">
		<div class="fgi-form">
			<input type="hidden" name="id" value="{{data.id}}"/>
			<input type="hidden" name="provider" value="{{data.mode}}"/>
			<label class="fgi-row">
				<span class="fgi-col-label"><?php _e("Thumbnail", "foogallery") ?></span>
				<span class="fgi-col-input">
					<span class="fgi-browse">
						<span class="fgi-browse-inner">
							<span class="fgi-browse-col-input">
								<input type="text" name="thumbnail" value="{{data.thumbnail}}" spellcheck="false"
											 data-messages='{"required":"<?php _e("You must supply a thumbnail for the video.", "foogallery") ?>","pattern":"<?php _e("Please enter a .jpg, .jpeg, .png or .gif file.", "foogallery") ?>"}'
											 data-pattern="(?:\/|=)(?<name>[^\/]+?)\.(?<ext>jpg|jpeg|png|gif)(?:$|\?|&|#|,)" data-required="true"/>
							</span>
							<span class="fgi-browse-col-button">
								<button type="button" class="button button-secondary"
												data-options='{"type": "image/png,image/jpg,image/jpeg,image/gif", "title":"<?php _e("Select a thumbnail for the video", "foogallery") ?>", "button":"<?php _e("Select Image", "foogallery") ?>"}'
								><?php _e("Select", "foogallery") ?></button>
							</span>
						</span>
					</span>
				</span>
			</label>
			<label class="fgi-row">
				<span class="fgi-col-label"><?php _e("Title", "foogallery") ?></span>
				<span class="fgi-col-input">
					<input type="text" name="title" value="{{data.title}}"/>
				</span>
			</label>
			<label class="fgi-row">
				<span class="fgi-col-label"><?php _e("Description", "foogallery") ?></span>
				<span class="fgi-col-input">
					<textarea name="description" rows="5">{{data.description}}</textarea>
				</span>
			</label>
			<label class="fgi-row">
				<span class="fgi-col-label"><?php _e("URL(s)", "foogallery") ?></span>
				<span class="fgi-col-input">
					<# var first = true; _(data.urls).each(function(url, type){ #>
						<span class="fgi-browse">
							<span class="fgi-browse-inner">
								<span class="fgi-browse-col-type">
									<span>{{type}}</span>
								</span>
								<span class="fgi-browse-col-input">
									<# if (first){ first = false; #>
									<input type="text" name="urls[{{type}}]" value="{{url}}" spellcheck="false" data-type="{{type}}"
												 data-messages='{"required":"<?php _e("You must supply at least one URL.", "foogallery") ?>","pattern":"<?php printf(__("Please enter a .%s file.", "foogallery"), "{{type}}") ?>"}'
												 data-pattern="(?:\/|=)(?<name>[^\/]+?)\.(?<ext>{{type}})(?:$|\?|&|#|,)" data-required="[name^='urls[']"/>
									<# } else { #>
									<input type="text" name="urls[{{type}}]" value="{{url}}" spellcheck="false" data-type="{{type}}"
												 data-messages='{"pattern":"<?php printf(__("Please enter a .%s file.", "foogallery"), "{{type}}") ?>"}'
												 data-pattern="(?:\/|=)(?<name>[^\/]+?)\.(?<ext>{{type}})(?:$|\?|&|#|,)"/>
									<# } #>
								</span>
								<span class="fgi-browse-col-button">
									<button type="button" class="button button-secondary"
													data-options='{"type": "video/{{type}}", "title":"<?php printf(__("Select a %s video", "foogallery"), "{{type}}") ?>", "button":"<?php _e("Select Video", "foogallery") ?>"}'
									><?php _e("Select", "foogallery") ?></button>
								</span>
							</span>
						</span>
					<# }) #>
					<span class="fgi-input-description">
						<?php _e("We recommend using .mp4 videos for the best cross browser compatibility. If you already have the URL you can simply paste it into the appropriate input.", "foogallery") ?>
					</span>
					<span class="fgi-input-description">
						<?php _e("As you enter URLs above the below compatibility list will be updated giving you an idea of which browsers will be able to play your video.", "foogallery") ?>
					</span>
					<span class="fgi-video-compatibility"></span>
					<span class="fgi-input-description">
						<?php printf(__("For more information on compatibility please see the following links: %s, %s and %s", "foogallery"), $mp4, $webm, $ogg) ?>
					</span>
				</span>
			</label>
		</div>
	</div>

</script>
<script type="text/html" id="tmpl-fgi-compatibility">
	<# _.each(data, function(result, device){ #>
		<span class="fgi-compat-device fgi-{{device}}" title="{{result.title}}">
			<# _.each(result.browsers, function(current, browser){ #>
				<# if (current.value === 0){ #>
					<span class="fgi-compat-browser fgi-{{device}} fgi-{{browser}} fgi-partial" title="{{current.title}}"></span>
				<# } else if (current.value === 1){ #>
					<span class="fgi-compat-browser fgi-{{device}} fgi-{{browser}} fgi-supported" title="{{current.title}}"></span>
				<# } else { #>
					<span class="fgi-compat-browser fgi-{{device}} fgi-{{browser}} fgi-not-supported" title="{{current.title}}"></span>
				<# } #>
			<# }) #>
		</span>
	<# }) #>
</script>
<script type="text/html" id="tmpl-fgi-query-result">

	<div class="fgi-query-result-notification"></div>
	<ul class="fgi-query-result-list"></ul>
	<div class="fgi-query-result-status"></div>

</script>
<script type="text/html" id="tmpl-fgi-query-result-notification">

	<# if (data.total === 1){ #>
		<p><?php _e("Confirm the video is correct and then click the Import button.", "foogallery") ?></p>
	<# } else { #>
		<p><?php _e("Select the videos to import by clicking the thumbnails and then click the Import button.", "foogallery") ?></p>
	<# } #>

</script>
<script type="text/html" id="tmpl-fgi-query-result-items">

	<# _(data.videos).each(function(video){ #>
		<# if (data.total === 1){ #>
			<li class="mode-selected mode-current" data-id="{{video.id}}">
		<# } else { #>
			<li data-id="{{video.id}}">
		<# } #>
				<div class="fgi-query-result-video">
					<div class="fgi-query-result-video-thumbnail" style="background-image: url('{{video.thumbnail}}')">
						<button type="button" class="fgi-query-result-video-check"></button>
					</div>
					<h2><a href="{{video.url}}" target="_blank">{{{video.title}}}</a></h2>
					<pre>{{{video.description}}}</pre>
				</div>
		</li>
	<# }) #>

</script>
<script type="text/html" id="tmpl-fgi-query-result-status">

<?php
	$offset = '<span class="fgi-query-result-offset">{{data.offset}}</span>';
	$total = '<span class="fgi-query-result-total">{{data.total}}</span>';
	$load_more = sprintf('<a href="#load-more">%s</a>', __("load more", "foogallery"));
	$try_again = sprintf('<a href="#try-again">%s</a>', __("try again", "foogallery"));
?>

	<p>
		<?php printf(__("Displaying %s of %s results.", "foogallery"), $offset, $total) ?>
		<# if (data.total !== 1 && data.nextPage !== 0){ #>
			<span class="fgi-query-result-paged">
				<span class="fgi-query-result-loading"><?php _e("Loading...", "foogallery") ?></span>
				<span class="fgi-query-result-load-more"><?php printf(__("Would you like to %s?", "foogallery"), $load_more) ?></span>
				<span class="fgi-query-result-try-again"><?php printf(__("An error occurred loading additional results, %s?", "foogallery"), $try_again) ?></span>
			</span>
		<# } #>
	</p>

</script>
<script type="text/html" id="tmpl-fgi-album-notification">

<?php
	$import_album = sprintf('<a href="#import-album">%s</a>', __("import the entire album", "foogallery"));
?>

	<# if (data.total === 1){ #>
		<p><?php _e("Confirm the video is correct and then click the Import button.", "foogallery") ?></p>
	<# } else { #>
		<p><?php printf(__("Select the videos to import by clicking the thumbnails and then click the Import button, or would you like to %s?", "foogallery"), $import_album) ?></p>
	<# } #>

</script>
<script type="text/html" id="tmpl-fgi-channel-notification">

<?php
	$import_channel = sprintf('<a href="#import-channel">%s</a>', __("import the entire channel", "foogallery"));
?>

	<# if (data.total === 1){ #>
		<p><?php _e("Confirm the video is correct and then click the Import button.", "foogallery") ?></p>
	<# } else { #>
		<p><?php printf(__("Select the videos to import by clicking the thumbnails and then click the Import button, or would you like to %s?", "foogallery"), $import_channel) ?></p>
	<# } #>

</script>
<script type="text/html" id="tmpl-fgi-playlist-notification">

<?php
	$import_playlist = sprintf('<a href="#import-playlist">%s</a>', __("import the entire playlist", "foogallery"));
?>

	<# if (data.total === 1){ #>
		<p><?php _e("Confirm the video is correct and then click the Import button.", "foogallery") ?></p>
	<# } else { #>
		<p><?php printf(__("Select the videos to import by clicking the thumbnails and then click the Import button, or would you like to %s?", "foogallery"), $import_playlist) ?></p>
	<# } #>

</script>
<script type="text/html" id="tmpl-fgi-user-notification">

<?php
	$import_user = sprintf('<a href="#import-user">%s</a>', __("import all videos for the user", "foogallery"));
?>

	<# if (data.total === 1){ #>
		<p><?php _e("Confirm the video is correct and then click the Import button.", "foogallery") ?></p>
	<# } else { #>
		<p><?php printf(__("Select the videos to import by clicking the thumbnails and then click the Import button, or would you like to %s?", "foogallery"), $import_user) ?></p>
	<# } #>

</script>
<script type="text/html" id="tmpl-fgi-import">
<?php
	$single = __("video", "foogallery");
	$plural = __("videos", "foogallery");
	$video = sprintf("{{data.total > 1 ? \"%s\" : \"%s\"}}", $plural, $single);
?>
	<div class="fgi-splash fgi-import-confirm">
		<h2><?php _e("Confirm multiple video import", "foogallery") ?></h2>
		<p><?php _e("Please note that depending on the source of the videos this process may take some time. If you like you can click the No button and change your selection.", "foogallery") ?></p>
		<p><?php printf(__("Are you sure you want to import %s videos?", "foogallery"), "{{data.total}}") ?></p>
		<div class="button-hero-container">
			<button type="button" class="button button-hero fgi-import-back"><?php _e("No - Change Selection", "foogallery") ?></button>
			<button type="button" class="button button-hero button-primary fgi-import-yes"><?php _e("Yes - Import Videos", "foogallery") ?></button>
		</div>
	</div>

	<div class="fgi-splash fgi-import-status">
		<h2><?php printf(__("Importing %s please wait...", "foogallery"), $video) ?></h2>
		<div class="fgi-import-progress">
			<div class="fgi-import-progress-value"></div>
			<div class="fgi-import-progress-text"></div>
		</div>
		<# if (data.total !== 1){ #>
			<p><?php _e("Cancelling the import will not remove any videos already imported into your Media Library, it simply stops the process as soon as possible.", "foogallery") ?></p>
			<div class="button-hero-container">
				<button type="button" class="button button-hero fgi-import-cancel"><?php _e("Cancel", "foogallery") ?></button>
			</div>
		<# } #>
	</div>

</script>
<script type="text/html" id="tmpl-fgi-import-result">

<?php
	$single = __("video", "foogallery");
	$plural = __("videos", "foogallery");
	$video_imported = sprintf("{{imported > 1 ? \"%s\" : \"%s\"}}", $plural, $single);
	$video_failed = sprintf("{{failed > 1 ? \"%s\" : \"%s\"}}", $plural, $single);
	$video_cancelled = sprintf("{{cancelled > 1 ? \"%s\" : \"%s\"}}", $plural, $single);
	$media_library = sprintf('<a href="#media-library">%s</a>', __("Media Library", "foogallery"));
	$single_1 = __("this video", "foogallery");
	$plural_1 = __("these videos", "foogallery");
	$video_try_again = sprintf("{{failed > 1 ? \"%s\" : \"%s\"}}", $plural_1, $single_1);
	$try_again_failed = sprintf('<a href="#try-again-failed">%s</a>', sprintf(__("try importing %s again", "foogallery"), $video_try_again));
	$toggle_failed_title = __("Toggle failed list", "foogallery");
	$toggle_failed_message = sprintf(__("failed to import. Would you like to %s?", "foogallery"), $try_again_failed);
	$toggle_failed = sprintf('<a href="#toggle-failed" title="%s">{{failed}} %s</a>', $toggle_failed_title, $video_failed, $toggle_failed_message);
	$video_cancelled = sprintf("{{cancelled > 1 ? \"%s\" : \"%s\"}}", $plural_1, $single_1);
	$import_cancelled = sprintf('<a href="#import-cancelled">%s</a>', sprintf(__("import %s", "foogallery"), $video_cancelled));
	$toggle_cancelled_title = __("Toggle cancelled list", "foogallery");
	$toggle_cancelled_message = sprintf(__("were cancelled. Would you like to %s?", "foogallery"), $import_cancelled);
	$toggle_cancelled = sprintf('<a href="#toggle-cancelled" title="%s">{{cancelled}} %s</a>', $toggle_cancelled_title, $video_cancelled, $toggle_cancelled_message);
?>
	<div class="fgi-splash fgi-import-notification">

		<# if (data.imported.length){ var imported = data.imported.length; #>
			<h2><?php printf(__("Successfully imported %s %s", "foogallery"), "{{imported}}", $video_imported) ?></h2>
			<# if (imported !== 1){ #>
				<p><?php printf(__("All imported videos have been added to the current %s selection.", "foogallery"), $media_library) ?></p>
			<# } else { #>
				<p><?php printf(__("The imported video has been added to the current %s selection.", "foogallery"), $media_library) ?></p>
			<# } #>
		<# } else { #>
			<h2><?php _e("No videos were imported.", "foogallery") ?></h2>
		<# } #>

		<# if (data.failed.length){ var failed = data.failed.length; #>
			<p><?php echo $toggle_failed ?></p>
			<ul class="fgi-import-failed">
				<# _.each(data.failed, function(video){ #>
					<# if (video.urls){ #>
						<li><span>{{video.title}}</span></li>
					<# } else { #>
						<li><a href="{{video.url}}" target="_blank">{{video.title}}</a></li>
					<# } #>
				<# }) #>
			</ul>
		<# } #>

		<# if (data.cancelled.length){ var cancelled = data.cancelled.length; #>
			<p><?php echo $toggle_cancelled ?></p>
			<ul class="fgi-import-cancelled">
				<# _.each(data.cancelled, function(video){ #>
					<# if (video.urls){ #>
						<li><span>{{video.title}}</span></li>
					<# } else { #>
						<li><a href="{{video.url}}" target="_blank">{{video.title}}</a></li>
					<# } #>
				<# }) #>
			</ul>
		<# } #>

		<div class="button-hero-container">
			<button type="button" class="button button-hero button-secondary fgi-import-more-videos"><?php _e("Import More Videos", "foogallery") ?></button>
		</div>
	</div>

</script>