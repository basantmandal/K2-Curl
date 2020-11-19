<?php

/* K2 CURL - Easy Light Weight - Based on PHP (Can be used on PHP Version > PHP 5.6)
	     * Can be easily customized as per your requirements
	     * This Lightweight PHP Curl Library helps in Sending HTTP requests and can be integrated with PHP based Web APIs.
	     * Author - Basant Mandal
	     * Version - 0.0.1
	     * Last Updated - 18 Nov 2020
*/

namespace Curl;

class K2_CURL {
	const DEBUG = false; // TURNS DEBUG MODE ON/OFF
	const MEASURE_PERFORMANCE = true; // TURNS TIME TAKEN - PERFORMANCE CAPTURE MODE ON/OFF

	// VARIABLE DECLATION
	private $url = "";
	private $curl = "";
	private $curlData = array();
	private $curlMethod = "";
	private $curlResult = "";
	private $curlHeader = array(
		'Cache-Control: no-cache',
		'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
	);
	private $curlError = "";
	private $time_taken = "";

	/**
	 * Method __construct
	 *
	 * @param $url      - URL of the Website
	 * @param $method   - POST/GET (Case Insensitive)
	 * @param $data     - Form Data
	 *
	 * @return void
	 */
	public function __construct($url, $method = "POST", $data = array("firstName" => "Basant", "lastName" => "Mandal"), $curlHeader, $measurePerformance = SELF::MEASURE_PERFORMANCE) {
		// IF DEBUG THEN ENABLE ERROR REPORTING
		try {
			if (function_exists('curl_version') && in_array('curl', get_loaded_extensions())) {
				// SANITIZE - URL
				$this->url = filter_var(strip_tags($url), FILTER_SANITIZE_URL);
				$this->curl = curl_init();
				$this->curlData = $data;
				$this->curlMethod = $method;
				$this->time_taken = $measurePerformance;
				if (SELF::DEBUG) {
					echo '<pre>';
					echo "<p>Debug Mode :- Enabled</p>";
					echo "<p>CURL Enabled</p>";
					echo "<p>URL = " . $this->url . "</p>";
				}
				// SET HEADER IF NOT EMPTY
				if (!empty($curlHeader) && count($curlHeader) > 0) {
					$this->curlHeader = $curlHeader;
					$this->set_header();
				}

			} else {
				throw new NO_CURL();
			}
		} catch (NO_CURL $ex) {
			echo "CURL Extension - Not Loaded/Enabled";
		} catch (Exception $x) {
			echo "Unknown Error...";
		}
	}

	/**
	 * Method initializeCurl - Executes Curl with Curl Options
	 *
	 * @return array(error, output)
	 */
	public function execCurl() {

		if (SELF::DEBUG) {
			echo '<p>Inside execCurl() </p>';
		}
		curl_setopt($this->curl, CURLOPT_URL, $this->url);
		strtolower($this->curlMethod) == "post" ? curl_setopt($this->curl, CURLOPT_POST, 1) : curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->curlData);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		// EXECUTE CURL
		$response = curl_exec($this->curl);
		// Check For Any Errors
		if ($response === false) {
			if (SELF::DEBUG) {
				echo 'Curl error: ' . curl_error($this->curl);
			}
			$this->curlError = curl_error($this->curl);
			$this->curlResult = "";
		} else {
			$info = curl_getinfo($this->curl);
			if (SELF::DEBUG || SELF::MEASURE_PERFORMANCE || $this->time_take) {
				echo 'Took <b>', $info['total_time'], ' seconds </b> to send a request to <b>', $info['url'], "</b><br><hr><br>";
			}
			$this->curlResult = $response;
			$this->curlError = "";
		}

		// LETS CLOSE CURL
		$this->closeCurl();
		return array("error" => $this->curlError, "output" => $this->curlResult);
	}

	/**
	 * Method set_header - Sets Curl Header
	 *
	 * @return void
	 */
	public function set_header() {
		if (SELF::DEBUG) {
			echo '<p>Inside set_header() </p>';
		}
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->curlHeader);
	}

	/**
	 * Method set_authentication - Sets Curl - Server Authentication
	 *
	 * @return void
	 */
	function set_authentication($username, $password) {
		if (SELF::DEBUG) {
			echo '<p>Inside set_authentication() </p>';
			echo 'Username = ' . $username . "<br>";
			echo 'Password = ' . $password . "<br>";
		}

		if (!empty($username) && !empty($password)) {
			curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($this->curl, CURLOPT_USERPWD, $username . ':' . $password);
		}
	}

	/**
	 * Method set_userAgent - Add Default UserAgent
	 *
	 * @return void
	 */
	function set_userAgent($userAgent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0') {
		if (SELF::DEBUG) {
			echo '<p>Inside set_userAgent() </p>';
			echo 'UserAgent = ' . $userAgent . "<br>";
		}
		curl_setopt($this->curl, CURLOPT_USERAGENT, $userAgent);
	}

	/**
	 * Method closeCurl - Closes Curl Connection - If Found
	 *
	 * @return void
	 */
	public function closeCurl() {
		if (SELF::DEBUG) {
			echo '<p>Inside closeCurl() </p>';
		}

		if (is_resource($this->curl)) {
			curl_close($this->curl);
		}
	}
}

// CHECK IF DEBUG MODE IS ENABLED - IF TRUE ENABLE ERROR MODE- SO ERRORS CAN BE DEBUG

if (K2_CURL::DEBUG) {
	echo '</pre>';
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
	ini_set("display_errors", 1);
}
// ------ ENDS ------ //
?>
