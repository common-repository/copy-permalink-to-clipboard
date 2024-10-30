<?php
/*
Plugin Name:	Copy Permalink To Clipboard
Plugin URI:		https://progr.interplanety.org/en/wordpress-plugin-copy-permalink-to-clipboard/
Version:		1.0.0
Author:			Nikita Akimov
Author URI:		https://progr.interplanety.org/
License:		GPL-3.0-or-later
Description:	Adds a button for quick copying post permalink to the clipboard.
*/

//	not run directly
if(!defined('ABSPATH')) {
	exit;
}

// function to add a button
function add_copy_permalink_to_clipboard_button($content) {
	global $post;
	if (in_array($post->post_status, array('draft', 'pending', 'auto-draft', 'future'))) {
		$permalink_arr = get_sample_permalink($post->ID);
		$permalink = str_replace('%postname%', $permalink_arr[1], $permalink_arr[0]);
	} else {
		$permalink = get_permalink();
	}
    $content .= '<div id="copy_sample_permalink_button" permalink="'.$permalink.'"';
	$content .= ' onclick="copy_sample_permalink_to_clipboard()"';
	$content .= ' style="
		font-size: 11px;
		cursor: pointer;
		color: #0a4b78;
		padding: 2px 18px;
		background: #f6f7f7;
		margin: auto 5px;
		display: inline-block;
		border-width: 1px;
		border-style: solid;
		border-radius: 3px;
	"';
	$content .= '>To Clipboard</div>';
	$content .= '<script>
			function copy_sample_permalink_to_clipboard() {
				var a = document.getElementById("copy_sample_permalink_button").getAttribute("permalink");
				var textArea = document.createElement("textarea");
				textArea.value = a;
				document.body.appendChild(textArea);
				textArea.select();
				var successful = document.execCommand("copy");
				document.body.removeChild(textArea);
			}
		</script>';
    return $content;
}

// add filter to start it work
add_filter('get_sample_permalink_html', 'add_copy_permalink_to_clipboard_button');
