# cookieConsent
google cookie consent mode php module

# status
under developement

# dependencies
1. php8 or higher
2. jquery 1.8 or higher
3. implemented googletag manager
# install
1. upload the folders onto the server
2. include the autoloader with php
3. initialize the consent php class
4. after initialization, you need to run
once the createWordsTable and after that the setText methods.
# usage
1. include("includes/autoloader.inc.php");
2. $cookieConsent = new \Cookie\Consent("gtagCode","languageCode");
3. //run these once, then delete these two lines:
4. $cookieConsent->createWordsTable();
5. $cookieConsent->setText();
