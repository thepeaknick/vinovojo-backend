<?php

	return [

		'facebook' => [
			'client_id' => '2002499333299023',
			'client_secret' => '839ecda1ec85576a9b155ebc8ca76a3f',
			'redirect' => 'test'
		],
		'google' => [
			'client_id' => '108270205742-cdjk32vk0kshhpdp0b33a08r7ovoolse.apps.googleusercontent.com',
			'client_secret' => 'nySm8xZWFFzBObdNP_sYxxvW',
//			'redirect' => 'http://itcentar.rs',
            'redirect'=>'http://admin.vinovojo.com'
		],

		'instagram' => [
			'client_id' => '86d6dbd683804ebdb0518ffa846e41e7',
			'client_secret' => '2b51f12149934dc8b21674cf43a0b2bb',
			'redirect_uri' => 'https://itcentar.rs/',
			'request_url' => 'https://api.instagram.com/oauth/access_token',
			// 'request_url' => 'http://172.16.40.42:8080/dump',
			'grant_type' => 'authorization_code'
		],

		'mailgun' => [
		       'domain' => env('MAILGUN_DOMAIN'),
		       'secret' => env('MAILGUN_SECRET'),
		],

		'maps' => [
			'key' => 'AIzaSyC-RpJTVJRs0GxeYnTz2baSNdYHSFaLsdw'
		]

	];

 ?>
