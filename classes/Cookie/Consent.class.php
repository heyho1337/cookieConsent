<?php
	
	namespace Cookie;
	
	/**
	 * Class Cookie\Consent
	*/
	class Consent extends \Db\SqlDb{
		
		function __construct(protected string $gtagCode,protected string $lang, protected array $words){
			parent::__construct();
			echo $this->cookieSrc();
			echo '<script>
				const consentJS = new ConsentJS("'.$this->gtagCode.'", "'.$this->lang.'");
				</script>';
			echo $this->cookieHTML();
		}
		
		/**
		 * loading a neccesary resources for the module
		 * @return html
		*/
		private function cookieSrc(){
			return '<script type="text/javascript" src="/js/cookie.js"></script>
				<script type="text/javascript" src="/js/consent.js"></script>
				<link type="text/css" rel="stylesheet" href="/style/cookie.css" media="all"/>
			';
		}
		
		/**
		 * rendering the module's html
		 * @return html 
		*/
		private function cookieHTML(){
			return '<div class="google_cookie">
					<span>{$this->transLate("cookie_text",$this->lang)}</span>
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

		/**
		 * inserting the the translations of the module's texts into the database
		 * @param string $code - the id of the text's
		 * @param string $text - the text that connected to the id 
		 * @return string
		*/
		private function insertText($code,$text,$lang){
			$query = $this->select("words",array('*'),array('word_code' => $code),'');
			if($query['status'] === 'success'){
				$this->update('words',array('word_'.$lang => $text),array('word_code' => $code));
				$result = $query['message'];
			}
			else{
				$_POST['word_'.$lang] = $text;
				$_POST['word_code'] = $code;
				$query = $this->insert('words');
				$result = $query();
			}
			return $result;
		}
	
		/**
		 * get the id's translated text for the current language
		 * @param string $code - the text's id 
		 * @return string
		*/
		private function transLate($code){
			$word = $this->select("words",array('*'),array('word_code' => $code),'');
			if($word['status'] === 'success'){
				return $word['data'][0]->{'word_'.$this->lang};
			}
			return $word['message'];
		}

		/**
		 * insertind all neccesary texts into the database, this method only
		 * needs to run once.
		*/
		public function setText(){
			foreach($this->words as $key => $value){
				foreach($value as $key2 => $value2){
					$this->insertText($key,$value2,$key2);
				}
			}
		}

		/**
		 * adding the language colums into the database
		 * and then creating the database is if not exists
		 * this method only needs to run once. 
		*/
		public function createWordsTable(){
			foreach($this->words['cookie_text'] as $key => $value){
				foreach($value as $key2 => $value2){
					$this->wordsTable['word_'.$key2] = 'TEXT';
				}
			}
			$this->create('words',$this->wordsTable);
		}
		
	}