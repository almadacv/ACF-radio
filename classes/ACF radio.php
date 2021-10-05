<?php

/**
 * Plugin Name:       ACF radio
 * Description:       tentativa
 * Requires at least: 4.0
 * Author:            ninguem ainda
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

class RadioDinamico
{


	function __construct()
	{
		add_action('generate_rewrite_rules', array($this, 'add_rewrite_rules'));
		add_filter('query_vars', array($this, 'query_vars'));
		add_action('parse_request', array($this, 'parse_request'));
		add_action('init', array($this, 'register_shortcodes'));
		add_action('wp_enqueue_scripts', array($this, 'load_js'));
	}

	function register_shortcodes()
	{
		add_shortcode('radio_dinamico', array($this, 'render_radio_widget'));
	}

	function load_js($the_content)
	{
		wp_enqueue_style('dashicons');
	}

	function add_rewrite_rules($wp_rewrite)
	{
		$rules = array(
			'radio-tools-stream-proxy\/?$' 	=> 'index.php?radio-tools-stream-proxy=true',
			'radio-tools-window-player\/?$'	=>	'index.php?radio-tools-window-player=true',
		);
		$wp_rewrite->rules = $rules + (array)$wp_rewrite->rules;
	}

	function query_vars($public_query_vars)
	{
		array_push($public_query_vars, 'radio-tools-stream-proxy');
		array_push($public_query_vars, 'radio-tools-window-player');
		return $public_query_vars;
	}

	function parse_request(&$wp)
	{
		if (array_key_exists('radio-tools-stream-proxy', $wp->query_vars)) {
			$this->stream_proxy();
			die();
		}

		if (array_key_exists('radio-tools-window-player', $wp->query_vars)) {
			$this->render_window_player();
			die();
		}
	}

	function render_radio_widget()
	{
		$html = '';

		$stream = get_field('endereco_stream');
		$img_post = get_the_post_thumbnail_url();
		ob_start();

		include RADIO_DINAMICO_PLUGIN_TEMPLATES_PATH . 'player.php';

		$player = ob_get_contents();

		ob_end_clean();

		return $player;
	}

	function render_window_player()
	{

?>
		<html>

		<head>
			<?php wp_head(); ?>
		</head>

		<body>
			<?php
			echo do_shortcode('[radio_dinamico]');
			wp_footer();
			?>
		</body>

		</html>

<?php
	}
}


?>