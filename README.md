# Twitter

## Introduction

The Twitter module supports OAuth on the 1.1 version of Twitter.
It uses the Twitter library codebird-php (https://github.com/jublonet/codebird-php)

Copyright (C) 2010-2014 kirk@silverstripe.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.


## Maintainer Contact

	* Kirk Mayo kirk (at) silverstripe (dot) com

## Requirements

	* SilverStripe 3.0 +

## Features

* Connects to Twitter API 1.1 via OAuth
* Fetches tweets for a user timeline

## Composer Installation

  composer require kmayo-ss/twitter-stripe
  
## Installation Manual

 1. Download the module form GitHub (Composer support to be added)
 2. Extract the file (if you are on windows try 7-zip for extracting tar.gz files
 3. Make sure the folder after being extracted is named 'twitter-stripe'
 4. Place this directory in your sites root directory. This is the one with framework and cms in it.
 5. Run in your browser - `/dev/build` to rebuild the database.

## Usage ##

To use the module you will need add your OAuth details to the config, see below for example yml config

```
---
Name: mysite
After:
  - 'framework/*'
  - 'cms/*'
---
# YAML configuration for SilverStripe
# See http://doc.silverstripe.org/framework/en/topics/configuration
# Caution: Indentation through two spaces, not tabs
SSTwitter:
  CONSUMER_KEY: Your Twitter Consumer Key from Twitter dashboard
  CONSUMER_SECRET: Your Twitter Consumer Secret from Twitter dashboard
  OAUTH_TOKEN: Your Twitter OAuth token from Twitter dashboard
  OAUTH_SECRET: Your Twitter OAuth secret from Twitter dashboard
  TWITTER_SCREENNAME: Your Twitter screenname/username

```

To fetch Tweets Twitter you need to call the constructor and the method getTweets as per the example below

```
			// setup the instance
			$twitter = new SSTwitter();
			// call the following method to get the number of tweets
			// this example fetches the last tweet you may 
			$tweets = (array)$twitter->getTweets(1);
			$tweet = $tweets[0];
```
To send tweets the constructor needs to be called and the method sendTweet needs to be used as below

```
		$twitter = new SSTwitter();
		$twitter->sendTweet('Your updated status');
```

## TODO ##

Add more Twitter features
