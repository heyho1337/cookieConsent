<?php
	
	namespace Cookie;
	
	/**
	 * Class Cookie\Consent
	*/
	class Consent extends \Db\SqlDb{
		
		protected array $wordsTable = [
			'word_id' => 'INT AUTO_INCREMENT PRIMARY KEY',
			'word_code' => 'VARCHAR(50)'
		];
		
		function __construct(protected string $gtagCode,protected string $lang){
			echo $this->cookieSrc();
			echo '<script>
				const consentJS = new ConsentJS("'.$this->gtagCode.'", "'.$this->lang.'");
				</script>';
			echo $this->cookieHTML();
		}
		
		private function cookieSrc(){
			return '<script type="text/javascript" src="/cookieConsent/js/cookie.js"></script>
				<script type="text/javascript" src="/cookieConsent/js/consent.js"></script>
				<link type="text/css" rel="stylesheet" href="/cookieConsent/css/cookie.css" media="all"/>
			';
		}
		
		private function cookieHTML(){
			return '<div class="google_cookie">
					<span>'.$this->transLate("cookie_text",$this->lang).'</span>
					<div class="cookie_options">
						<div class="check">
							<input checked type="checkbox" id="ad_storage" name="ad_storage">
							<span class="fa fa-check"></span>
							<label for="ad_storage">'.$this->transLate("cookie_ad_storage",$this->lang).'</label>
						</div>
						<div class="check">
							<input type="checkbox" id="ad_personalization" name="ad_personalization">
							<span class="fa fa-check"></span>
							<label for="ad_personalization">'.$this->transLate("cookie_ad_personalization",$this->lang).'</label>
						</div>
						<div class="check">
							<input type="checkbox" id="ad_user_data" name="ad_user_data">
							<span class="fa fa-check"></span>
							<label for="ad_user_data">'.$this->transLate("cookie_ad_user_data",$this->lang).'</label>
						</div>
						<div class="check">
							<input type="checkbox" id="analytics_storage" name="analytics_storage">
							<span class="fa fa-check"></span>
							<label for="analytics_storage">'.$this->transLate("cookie_analytics_storage",$this->lang).'</label>
						</div>
					</div>
					<div class="cookie_buttons">
						<button onclick="consentJS.handleConsent(\'2\')">'.$this->transLate("cookie_allow",$this->lang).'</button>
						<button onclick="consentJS.handleConsent(\'4\')">'.$this->transLate("cookie_setup",$this->lang).'</button>
						<button onclick="consentJS.handleConsent(\'3\')">'.$this->transLate("cookie_select",$this->lang).'</button>
						<button onclick="consentJS.handleConsent(\'1\')">'.$this->transLate("cookie_deny",$this->lang).'</button>
					</div>
				</div>
			';
		}

		private function insertText($code,$text){
			$query = $this->select("words",array('*'),array('word_code' => $code),'');
			if($query['status'] === 'success'){
				$this->update('words',array('word_'.$this->lang => $text),array('word_code' => $code));
			}
			else{
				$_POST['word_'.$this->lang] = $text;
				$_POST['word_code'] = $code;
				$query = $this->insert('words');
			}
		}
	
		private function transLate($words_code){
			$word = $this->select("words",array('*'),array('word_code' => $words_code),'');
			if($word['status'] === 'success'){
				return $word->{'word_'.$this->lang};
			}
		}

		public function setText(){
			$this->insertText('cookie_text','cookie basic text');
			$this->insertText('cookie_ad_storage','ad_storage text');
			$this->insertText('cookie_ad_user_data','ad_user_data text');
			$this->insertText('cookie_ad_personalization','ad_personalization text');
			$this->insertText('cookie_analytics_storage','analytics_storage text');
			$this->insertText('cookie_deny','Deny');
			$this->insertText('cookie_setup','Options');
			$this->insertText('cookie_select','Accept options');
			$this->insertText('cookie_allow','Accep');
		}

		public function createWordsTable(){
			$this->wordsTable['word_'.$this->lang] = 'TEXT';
			$this->create('words',$this->wordsTable);
		}
		
	}