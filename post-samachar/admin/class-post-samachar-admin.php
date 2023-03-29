<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://mithilesh.wisdmlabs.net/
 * @since      1.0.0
 *
 * @package    Post_Samachar
 * @subpackage Post_Samachar/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Post_Samachar
 * @subpackage Post_Samachar/admin
 * @author     Mithilesh <mithilesh.chaudhaudhari@wisdmlabs.com>
 */
class Post_Samachar_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Post_Samachar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Samachar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/post-samachar-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Post_Samachar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Samachar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/post-samachar-admin.js', array('jquery'), $this->version, false);
	}

	// $CUSTOM

	// function for cron scheduling
	function my_cron_schedules($schedules)
	{
		if (!isset($schedules["1min"])) {
			$schedules["1min"] = array(
				'interval' => 60,
				'display' => __('Once every minutes')
			);
		}

		if (!isset($schedules["2min"])) {
			$schedules["2min"] = array(
				'interval' => 2 * 60,
				'display' => __('Once every 2 minutes')
			);
		}

		return $schedules;
	}

	// this function decides the timings of the mail
	// here you can Test the mail.
	function schedule_admin_email()
	{
		if (!wp_next_scheduled('send_admin_email')) {
			// Convert the time to the UTC timestamp
			$timestamp = strtotime('6:30pm GMT+5:30');
			wp_schedule_event($timestamp, 'daily', 'send_admin_email');
		}
	}

	// Fetches actual Post data
	function fetch_post()
	{

		// Setup Args for the query
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => -1,
			'date_query'     => array(
				'year'  => date('Y'),
				'month' => date('n'),
				'day'   => date('j'),
			),
		);

		// Retrieve the posts using WP_Query
		$posts_array = get_posts($args);

		$post_data = array();

		foreach ($posts_array as $post) {

			$title = $post->post_title;
			$url = get_permalink($post->ID);

			$meta_title = get_post_meta($post->ID, '_yoast_wpseo_title', true);
			$meta_description = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
			$meta_keywords = get_post_meta($post->ID, '_yoast_wpseo_focuskw', true);
			$score = $this->get_page_speed_score($url);


			$post_data[] = array(
				'title' => $title,
				'url'   => $url,
				'meta_title' => $meta_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'page_speed' => $score,
			);
		}

		if (empty($post_data)) {
			echo "<center><h1>Oops! there are no posts published today.</h1></center>";
		} else {
			print("<pre>" . print_r($post_data, true) . "</pre>");
		}

		return $post_data;
	}

	// Sends the mail
	function send_email_to_admin()
	{
		$data = $this->fetch_post();
		$to = 'dev-email@wpengine.local';
		$subject = 'Daily Update';
		$message = '';

		foreach ($data as $post_data) {
			$message .= 'Post Title: ' . $post_data['title'] . "\n";
			$message .= 'Post URL: ' . $post_data['url'] . "\n";
			$message .= 'Meta Title: ' . $post_data['meta_title'] . "\n";
			$message .= 'Meta Description: ' . $post_data['meta_description'] . "\n";
			$message .= 'Meta Keywords: ' . $post_data['meta_keywords'] . "\n";
			$message .= 'Google Page Speed: ' . $post_data['page_speed'] . "\n";
			$message .= "\n\n";
		}

		$headers = array(
			'From: misuchaudhari25@gmail.com',
			'Content-Type: text/html; charset=UTF-8'
		);

		wp_mail($to, $subject, $message, $headers);
	}

	//Google Page Speed
	function get_page_speed_score($url)
	{

		$api_key = "416ca0ef-63e4-4caa-a047-ead672ecc874"; // your api key
		$new_url = "http://www.webpagetest.org/runtest.php?url=" . $url . "&runs=1&f=xml&k=" . $api_key;
		$run_result = simplexml_load_file($new_url);
		$status = $run_result->statusCode;
		if ($status == 400) {
			$error = "API Limit Crossed!";
			return $error;
		} else {
			$test_id = $run_result->data->testId;
			$status_code = 100;

			while ($status_code != 200) {
				sleep(10);
				$xml_result = "http://www.webpagetest.org/xmlResult/" . $test_id . "/";
				$result = simplexml_load_file($xml_result);
				$status_code = $result->statusCode;
				$time = (float) ($result->data->median->firstView->loadTime) / 1000;
			}

			return $time;
		}
	}
}
