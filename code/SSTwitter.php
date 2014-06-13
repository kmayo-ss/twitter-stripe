<?php

require_once (dirname(dirname(__FILE__)) . '/vendor/jublonet/codebird-php/src/codebird.php');

/**
 * The SSTwitter class connects to Twitter API version 1.1 via OAuth
 * It can be used for fetching tweets from a users timeline 
 *
 * @package sstwitter
 */
class SSTwitter extends Object {

	private $cb;

	private $consumerKey;
	private $consumerSecret;

	private $accessToken;
	private $accessSecret;

	private $screenName;

	public function __construct() {
		// set OAuth details from config
		$this->setAuth();
		// connect and setup instance
		$this->connect();
	}

	/**
	 *
	 * Setup the auth properties from the config
	 *
	 */
	private function setAuth() {
		//set the auth details
		$this->consumerKey = Config::inst()->get('SSTwitter', 'CONSUMER_KEY');
		$this->consumerSecret = Config::inst()->get('SSTwitter', 'CONSUMER_SECRET');

		$this->accessToken = Config::inst()->get('SSTwitter', 'OAUTH_TOKEN');
		$this->accessSecret = Config::inst()->get('SSTwitter', 'OAUTH_SECRET');
	}

	/**
	 *
	 * Setup the screen name via a param or the config
	 * The config can be overridden by providing a param
	 *
	 * @param string $screenName Screen Name for a user timeline
	 */
	private function setScreenName($screenName = null) {
		if (!$screenName) {
			$screenName = Config::inst()->get('SSTwitter', 'TWITTER_SCREENNAME');
		}
		$this->screenName = $screenName;
	}

	/**
	 *
	 * Connect and setup a Twitter instance
	 *
	 */
	private function connect() {
		\Codebird\Codebird::setConsumerKey($this->consumerKey, $this->consumerSecret);
		$this->cb = \Codebird\Codebird::getInstance();
		$this->cb->setToken($this->accessToken, $this->accessSecret);
	}

	/**
	 *
	 * Fetch tweets for a instance and a screen name
	 *
	 * @param int $count number of tweets to fetch
	 * @param boolean $retweet Do we need to display retweets
	 * @param string $screenName Screen Name for a user timeline
	 */
	public function getTweets($count = 1, $retweet = false, $screenName = null) {
		$this->setScreenName($screenName);
		$params = array(
			'screen_name' => $this->screenName,
			'count' => $count,
			'include_rts' => $retweet
		);
		$tweets = $this->cb->statuses_userTimeline($params);
		return $tweets;
	} 
}
