<?php
	
	namespace Views;

	class CookieConsentView{

		protected $cookieConsentModel;

		/**
		 * @param string $gtagCode - google tagmanager's code
		 * @param string $lang current language's code
		 * @param array $words - the texts,words translations that the consent modul will contain
		*/
		public function __construct(protected string $lang, protected array $words, protected string $gtagCode) {
			$this->cookieConsentModel = new \Models\CookieConsent($lang,$words);
		}

		public function setDb(){
			$this->cookieConsentModel->createWordsTable();
			echo $this->cookieConsentModel->setText();
		}

		/**
		 * loading the js class for the consent logic
		 * @return string
		*/
		public function consentJs(): string{
			return "<script>
			const consentJS = new ConsentJS('{$this->gtagCode}', '{$this->lang}');
			</script>";
		}

		/**
		 * loading a neccesary resources for the module
		 * @return string
		*/
		public function cookieSrc(): string{
			return '<script type="text/javascript" src="src/js/cookie.js"></script>
				<script type="text/javascript" src="src/js/consent.js"></script>
				<link type="text/css" rel="stylesheet" href="src/style/cookie.css" media="all"/>
			';
		}

		/**
		 * rendering the module's html
		 * @return string 
		*/
		public function cookieHTML(): string{
			return "<div class='google_cookie'>
					<span>{$this->cookieConsentModel->transLate("cookie_text",$this->lang)}</span>
					<div class='cookie_options'>
						<div class='check'>
							<input checked type='checkbox' id='ad_storage' name='ad_storage'>
							<span class='fa fa-check'></span>
							<label for='ad_storage'>{$this->cookieConsentModel->transLate("cookie_ad_storage",$this->lang)}</label>
						</div>
						<div class='check'>
							<input type='checkbox' id='ad_personalization' name='ad_personalization'>
							<span class='fa fa-check'></span>
							<label for='ad_personalization'>{$this->cookieConsentModel->transLate("cookie_ad_personalization",$this->lang)}</label>
						</div>
						<div class='check'>
							<input type='checkbox' id='ad_user_data' name='ad_user_data'>
							<span class='fa fa-check'></span>
							<label for='ad_user_data'>{$this->cookieConsentModel->transLate("cookie_ad_user_data",$this->lang)}</label>
						</div>
						<div class='check'>
							<input type='checkbox' id='analytics_storage' name='analytics_storage'>
							<span class='fa fa-check'></span>
							<label for='analytics_storage'>{$this->cookieConsentModel->transLate("cookie_analytics_storage",$this->lang)}</label>
						</div>
					</div>
					<div class='cookie_buttons'>
						<button onclick='consentJS.handleConsent(\'2\')'>{$this->cookieConsentModel->transLate("cookie_allow",$this->lang)}</button>
						<button onclick='consentJS.handleConsent(\'4\')'>{$this->cookieConsentModel->transLate("cookie_setup",$this->lang)}</button>
						<button onclick='consentJS.handleConsent(\'3\')'>{$this->cookieConsentModel->transLate("cookie_select",$this->lang)}</button>
						<button onclick='consentJS.handleConsent(\'1\')'>{$this->cookieConsentModel->transLate("cookie_deny",$this->lang)}</button>
					</div>
				</div>
			";
		}
	}