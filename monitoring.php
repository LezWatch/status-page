<?php

// Get UpTimeRobot stats via cURL:

require 'time.php';

// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Defaults
$uptime_url = 'https://stats.uptimerobot.com/926OOTk28x/';
$filename   = 'status.txt';
$errorfile  = 'error.log';

if ( file_exists( './' . $filename ) ) {
	// file older than 2 minutes OR is empty
	if ( ( filesize( $filename ) < 1 ) || ( time()-filemtime( $filename ) > 250 ) ) {

		// Rebuild the file
		$f = @fopen( $filename, 'r+' );
		if ( $f !== false ) {
			ftruncate( $f, 0 );
			fclose( $f );
		}

		// API Keys (these are LezWatch, you may want to change them)
		$api_keys = array(
			'lwtv'      => 'm781800598-b7f0dce51e9c3b7d9d85e200',
			'lwtv-docs' => 'm783186644-93e4a02249e1011bac3c4923',
			'lwcomm'    => 'm782395487-68b8fa1fbc2388bfbc902752',
			'lezpress'  => 'm782395488-dc56250afd0cf12ca68857c9',
		);

		// Prepare array
		$all_responses = array();

		// Loop through the keys to get the data
		foreach ( $api_keys as $site => $api_key ) {
			// Build request:
			$request = 'api_key=' . $api_key . '&format=json&logs=1&log_types=1&logs_limit=1&all_time_uptime_ratio=1';

			// Access API via cURL:
			$curl = curl_init();
			curl_setopt_array( $curl, array(
				CURLOPT_URL            => 'https://api.uptimerobot.com/v2/getMonitors',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING       => '',
				CURLOPT_MAXREDIRS      => 10,
				CURLOPT_TIMEOUT        => 30,
				CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST  => 'POST',
				CURLOPT_POSTFIELDS     => $request,
				CURLOPT_HTTPHEADER     => array(
					'cache-control: no-cache',
					'content-type: application/x-www-form-urlencoded'
				),
			));
			$response = curl_exec( $curl );
			$error    = curl_error( $curl );
			curl_close( $curl );

			// Log Errors
			if ( !empty( $error ) ) {
				file_put_contents( $errorfile, json_encode( $error ) );
			}

			// Decode JSON response and get only the data needed:
			$response = json_decode( $response, true );

			// If there's a monitor value, we save it.
			if ( ! empty ( $response['monitors'][0] ) ) {
				$response               = $response['monitors'][0];
				$all_responses[ $site ] = $response;
			} else {
				file_put_contents( $errorfile, json_encode( $response ) );
			}
		}

		// save the data in the file
		file_put_contents( $filename, json_encode( $all_responses ) );
	}
}

// Since we have responses for sure, grab the file:
$all_responses = json_decode( file_get_contents( $filename ), true );
$websites      = array();

if ( ! empty( $all_responses ) && is_array( $all_responses ) ) {
	foreach( $all_responses as $response ) {

		if ( ! empty( $response) && is_array( $response ) ) {
			// Website details:
			$website_name = $response['friendly_name'];
			$website_url  = $response['url'];

			// Monitor Details
			$monitor_link = $uptime_url . $response['id'];

			// Date monitor was created:
			$monitor_started = $response['create_datetime'];
			$monitor_started = date( 'jS F Y', $monitor_started );

			// Overall uptime percentage:
			$monitor_uptime = $response['all_time_uptime_ratio'];
			$monitor_uptime = number_format( $monitor_uptime, 2 );

			// Current website status:
			$monitor_status = $response['status'];

			// Change content to be displayed based on current website status:
			if ( $monitor_status == 0 ) { // Monitor is paused:

				$class        = 'info';
				$monitor_status = $website_name . ' monitoring is currently <strong class="text-' . $class . '">paused</strong> <span class="link-info"><i class="bi bi-shield-slash"></i></span>';
				$monitor_info   = 'This may be for website updates/maintenance. Please check again later for an updated status report';

			} elseif ( $monitor_status == 2 ) { // Website is up:

				$class        = 'success';
				$monitor_status = $website_name . ' is currently <strong class="text-' . $class . '">operational</strong> <span class="link-success"><i class="bi bi-shield-check"></i></span>';

				// Check if there has been any recorded downtime:
				if ( empty( $response['logs'] ) ) {
					// No downtime recorded:
					$monitor_info = 'There has been no recorded downtime for ' . $website_name . '.';
				} else {
					// Date and time since last downtime:
					$last_downtime = date('jS F Y', $response['logs'][0]['datetime'] );
					$time_since = get_time_ago( $response['logs'][0]['datetime'] );

					// Duration of last downtime:
					$last_duration = time() - $response['logs'][0]['duration'];
					$duration = get_time_ago( $last_duration );

					// Output:
					$monitor_info = 'It has been ' . $time_since . ' since the last recorded downtime (' . $last_downtime . ') which lasted ' . $duration . '.';
				}
			} elseif ( $monitor_status == 9 ) {
				// Website is down:

				$class        = 'danger';
				$monitor_status = $website_name . ' is currently <strong class="text-' . $class . '">down</strong> <span class="link-danger"><i class="bi bi-shield-exclamation"></i></span>';

				// Get length of current downtime in hours:
				$last_duration = time() - $response['logs'][0]['duration'];
				$duration = get_time_ago( $last_duration );
				$monitor_info     = $website_name . ' has been down for' . $duration . '.';
			}

			// All the collected information.
			$websites[] = array(
				'website_name'    => $website_name,
				'website_url'     => $website_url,
				'monitor_link'    => $monitor_link,
				'monitor_started' => $monitor_started,
				'monitor_uptime'  => $monitor_uptime,
				'monitor_status'  => $monitor_status,
				'monitor_info'    => $monitor_info,
				'class'           => $class,
			);
		}
	}
}
