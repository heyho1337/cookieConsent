<?php

	include("includes/autoloader.inc.php");
	
	$cookieConsent = new \Cookie\Consent("gtagCode","en");
	$cookieConsent->createWordsTable();
	$cookieConsent->setText();