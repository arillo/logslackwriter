<?php

require_once 'Zend/Log/Writer/Abstract.php';

/**
 * Sends an error message to Slack.
 */
class SS_LogSlackWriter extends Zend_Log_Writer_Abstract {

	/**
	 * @config
	 */
	private static $webhook;

	public static function factory($config) {
		return new SS_LogSlackWriter();
	}

	/**
	 * Send the error to the Slack channel.
	 */
	public function _write($event) {
		// If no formatter set up, use the log file formatter.
		if (!$this->_formatter) {
			$formatter = new SS_LogErrorFileFormatter();
			$this->setFormatter($formatter);
		}

		// $webhookUrl = Config::inst()->get('SS_LogSlackWriter', 'webhook');
		if (defined('SS_SLACK_LOG_WEBHOOK')) {
			$webhookUrl = SS_SLACK_LOG_WEBHOOK;
			$formattedData = $this->_formatter->format($event);

			$channel = '#monitor';
			if (defined('SS_SLACK_LOG_CHANNEL')) {
				$channel = SS_SLACK_LOG_CHANNEL;
			}

			$json = json_encode(array(
				'channel'    => $channel,
				'username'   => 'silverstripe',
				'text'       => $formattedData,
                'icon_emoji' => ':warning:',
                'unfurl_links' => false,
                'unfurl_media' => false
			));

			$ch = curl_init($webhookUrl);

			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

			# Return response instead of printing.
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

			curl_exec($ch);
			curl_close($ch);
		}

	}

}
