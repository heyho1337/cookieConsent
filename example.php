<?php

	include("includes/autoloader.inc.php");

	$words = [
		"cookie_text" => ["en" => 'cookie basic text', "de" => 'cookie basic de'],
		"cookie_ad_storage" => ["en" => 'ad_storage text', "de" => 'ad_storage de'],
		"cookie_ad_user_data" => ["en" => 'ad_user_data text', "de" => 'ad_user_data de'],
		"cookie_ad_personalization" => ["en" => 'ad_personalization text', "de" => 'ad_personalization de'],
		"cookie_analytics_storage" => ["en" => 'analytics_storage text', "de" => 'analytics_storage de'],
		"cookie_deny" => ["en" => 'Deny', "de" => 'Deny de'],
		"cookie_setup" => ["en" => 'Options', "de" => 'Options de'],
		"cookie_select" => ["en" => 'Accept options', "de" => 'Accept options de'],
		"cookie_allow" => ["en" => 'Accept', "de" => 'Accept de']
	];
	
	$cookieConsent = new \Cookie\Consent("gtagCode","en",$words);
	$cookieConsent->createWordsTable();
	$cookieConsent->setText();