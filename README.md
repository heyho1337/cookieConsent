# cookieConsent
google cookie consent mode php module

# status
v1.0 beta

# dependencies
1. php8 or higher
2. mysql mariadb 10 or higher
3. jquery 1.8 or higher
4. implemented googletag manager
# install
1. download the repo
2. upload the folders onto the server
3. follow #useage
# useage
1. include("includes/autoloader.inc.php");
2. $cookieConsent = new \Cookie\Consent("gtagCode","languageCode");
4. run this method on the server: $cookieConsent->createWordsTable(); 
5. run this method on the server: $cookieConsent->setText();
