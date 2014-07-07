<?php

require_once (dirname(dirname(__FILE__)) . '/vendor/codebird-php/src/codebird.php');

/**
 *
 * @package twitter-stripe
 *
 */

class TwitterTest extends FunctionalTest {

	private $cb;

	public static $consumerKey = 'consumerkeypass';
	public static $consumerSecret = 'consumerecretpass';
	public static $oauthToken = 'oauthtokenpass';
	public static $oauthSecret = 'oauthsecretpass';
	static $twitterScreenName = 'twitterScreenname';

	public function setup() {
		Config::inst()->update('SSTwitter', 'CONSUMER_KEY', self::$consumerKey);
		Config::inst()->update('SSTwitter', 'CONSUMER_SECRET', self::$consumerSecret);

		Config::inst()->update('SSTwitter', 'OAUTH_TOKEN', self::$oauthToken);
		Config::inst()->update('SSTwitter', 'OAUTH_SECRET', self::$oauthSecret);

		Config::inst()->update('SSTwitter', 'TWITTER_SCREENNAME', self::$twitterScreenName);

		return new SSTwitterMock_Test();
	}

	public function testCodebird() {
		$twitter = $this->setup();
		$consumerKey = Config::inst()->get('SSTwitter', 'CONSUMER_KEY');
		$consumerSecret = Config::inst()->get('SSTwitter', 'CONSUMER_SECRET');

		$this->accessToken = Config::inst()->get('SSTwitter', 'OAUTH_TOKEN');
		$this->accessSecret = Config::inst()->get('SSTwitter', 'OAUTH_SECRET');

		TwitterObjectTest::setConsumerKey($consumerKey, $consumerSecret);

		$this->assertEquals(TwitterObjectTest::getConsumerKey(), $consumerKey);
		$this->assertEquals(TwitterObjectTest::getConsumerSecret(), $consumerSecret);

		$this->cb = \Codebird\Codebird::getInstance();
		$this->cb->setToken($this->accessToken, $this->accessSecret);

        	$this->assertEquals(TwitterObjectTest::getAccessToken(), $this->accessToken);
        	$this->assertEquals(TwitterObjectTest::getAccessSecret(), $this->accessSecret);
	}

	public function testGetTweets() {
		$twitter = $this->setup();
		$tweets = $twitter->getTweets(2);

        	$this->assertEquals(1, $tweets[0]->id);
        	$this->assertEquals('Tweet 1', $tweets[0]->text);

        	$this->assertEquals(2, $tweets[1]->id);
        	$this->assertEquals('Tweet 2', $tweets[1]->text);
	}
}

class SSTwitterMock_Test extends SSTwitter {
	public $tweets = array(
		1 => array(
			'id' => 1,
			'text' => 'Tweet 1'
		),
		2 => array(
			'id' => 2,
			'text' => 'Tweet 2'
		),
		3 => array(
			'id' => 3,
			'text' => 'Tweet 3'
		)
	);

	// needs more work as it is not really getTweets affectively
	public function getTweets($count = 1, $retweet = false, $screenName = null) {
		$noTweets = ($count > count($this->tweets)) ? count($tweets) : $count;
		for ($i=1; $i <= $noTweets; $i++) {
			$tweet = new stdClass();
			$tweet->id = $this->tweets[$i]['id'];
			$tweet->text = $this->tweets[$i]['text'];
			$tweets[] = $tweet;
		}
		return $tweets;
	}
}

class TwitterObjectTest extends \Codebird\Codebird {


	public static function getConsumerKey() {
		return self::$_oauth_consumer_key;
	}

	public static function getConsumerSecret() {
		return self::$_oauth_consumer_secret;
	}

	public static function getAccessToken() {
		return Config::inst()->get('SSTwitter', 'OAUTH_TOKEN');
	}

	public static function getAccessSecret() {
		return Config::inst()->get('SSTwitter', 'OAUTH_SECRET');
	}

}
