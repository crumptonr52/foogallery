<?php
/**
 * Base class for video imports and queries
 * Date: 17/04/2018
 */
if ( ! class_exists( 'FooGallery_Pro_Video_Base' ) ) {

	class FooGallery_Pro_Video_Base {

		protected function error_response($message = "Unknown Error", $title = "An Error Occurred") {
			return array(
				"mode" => "error",
				"title" => $title,
				"message" => $message
			);
		}

		protected function get_json($url) {
			$remote = wp_remote_get($url);
			if (is_wp_error($remote)) {
				return $this->error_response("Error fetching JSON: " . $remote->get_error_message());
			}
			// get the json string from the body of the response
			$body = wp_remote_retrieve_body($remote);
			// decode it into an object
			$json = json_decode($body);
			if (!is_object($json) && !is_array($json)){
				return $this->error_response("Error fetching JSON: Invalid response body, unable to decode.");
			}
			return $json;
		}

		protected function is_error($response) {
			return is_array($response) && $response["mode"] === "error";
		}

		protected function url_exists($url){
			$remote = wp_safe_remote_head($url);
			return !is_wp_error($remote) && wp_remote_retrieve_response_code($remote) === 200;
		}

		protected function get_mime_type($url){
			$remote = wp_safe_remote_head($url);
			if (is_wp_error($remote)) {
				return false;
			}
			if ( !empty($remote) && is_array($remote["response"]) && $remote["response"]["code"] === 200 ){
				return wp_remote_retrieve_header($remote, "content-type");
			}
			return false;
		}
	}
}