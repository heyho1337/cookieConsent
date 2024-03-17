# cookieConsent
google cookie consent mode php module

# status
under developement

# dependencies
1. php8 or higher
2. jquery 1.8 or higher
3. implemented googletag manager
# install
1. download the repo
2. upload the folders onto the server
3. follow #useage
# useage
1. include("includes/autoloader.inc.php");
2. $cookieConsent = new \Cookie\Consent("gtagCode","languageCode");
3. //run these once separetly, then delete these two lines:
4. $cookieConsent->createWordsTable();
5. $cookieConsent->setText();
