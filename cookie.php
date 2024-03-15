<?php
	class cookie extends Database{
		
		function __construct(protected string $gtagCode,protected string $lang){
			$this->gtagCode = $gtagCode;
			echo $this->cookieSrc();
			echo '<script>'
				.$this->gtagInit()
				.$this->gtagAction()
				.$this->setGtag()
				.'</script>';
			echo $this->cookieHTML();
		}
		
		private function gtagInit(){
			return "window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());
				
				if($.cookie('cookie_accept') !== 'true'){
					gtag('consent', 'default', {
					  'ad_storage': 'denied',
					  'ad_user_data': 'denied',
					  'ad_personalization': 'denied',
					  'analytics_storage': 'denied'
					});
				}
				
				if($.cookie('cookie_accept') === 'true'){
					gtag('consent', 'update', {
					  'ad_storage': setGtag('ad_storage'),
					  'ad_user_data': setGtag('ad_user_data'),
					  'ad_personalization': setGtag('ad_personalization'),
					  'analytics_storage': setGtag('analytics_storage')
					});
				}
				
				gtag('config', '".$this->gtagCode."');
				
				$(document).ready(function(){
					if($.cookie('cookie_accept') != 'true'){
						$('.google_cookie').addClass('showCookie');
					}
				});
			";
		}
		
		private function setGtag(){
			return "function setGtag(name){
				if($.cookie(name) === 'granted'){
					return 'granted';
				}
				else{
					return 'denied';
				}
			}";
		}
		
		private function gtagAction(){
			return "function handleConsent(action) {
					if(action !== '4'){
						gtag('consent', 'update', {
							'ad_storage': checkInput('ad_storage',action), //sz�ks�ges
							'ad_user_data': checkInput('ad_user_data',action), //h�rdet�s
							'ad_personalization': checkInput('ad_personalization',action), //preferences
							'analytics_storage': checkInput('analytics_storage',action) //statisztika
						});
						$.cookie('cookie_accept', 'true',{ path: '/' , expires: 800});
						$('.google_cookie').addClass('hideCookie');
						$('.google_cookie').removeClass('showCookie');
					}
					else{
						$('.cookie_options').addClass('cookieOpen');
					}
				}
			
				function checkInput(name,action){
					var result = '';
					switch(action){
						case '1':
							result = 'denied';
							break;
						case '2':
							result = 'granted';
							break;
						case '3':
							if($('input[name=\'' + name + '\']').is(':checked')){
								result = 'granted';
							}
							else{
								result = 'denied';
							}
							break;
					}
					$.cookie(name, result,{ path: '/' , expires: 800});
					return result;
				}
			";
		}
		
		private function cookieSrc(){
			return '<script type="text/javascript" src="/cookie/cookie.js"></script>
				<link type="text/css" rel="stylesheet" href="/cookie/cookie.css" media="all"/>
			';
		}
		
		public function setText(){
			$this->insertText('cookie','cookie basic text');
			$this->insertText('cookie_options0','ad_storage text');
			$this->insertText('cookie_options1','ad_user_data text');
			$this->insertText('cookie_options2','ad_personalization text');
			$this->insertText('cookie_options3','analytics_storage');
			$this->insertText('cookie_deny','Deny');
			$this->insertText('cookie_setup','Options');
			$this->insertText('cookie_select','Accept options');
			$this->insertText('cookie_allow','Accep');
		}
		
		private function cookieHTML(){
			return '<div class="google_cookie">
					<span>'.$this->transLate("cookie",$this->lang).'</span>
					<div class="cookie_options">
						<div class="check">
							<input checked type="checkbox" id="ad_storage" name="ad_storage">
							<span class="fa fa-check"></span>
							<label for="ad_storage">'.$this->transLate("cookie_options0",$this->lang).'</label>
						</div>
						<div class="check">
							<input type="checkbox" id="ad_personalization" name="ad_personalization">
							<span class="fa fa-check"></span>
							<label for="ad_personalization">'.$this->transLate("cookie_options2",$this->lang).'</label>
						</div>
						<div class="check">
							<input type="checkbox" id="ad_user_data" name="ad_user_data">
							<span class="fa fa-check"></span>
							<label for="ad_user_data">'.$this->transLate("cookie_options1",$this->lang).'</label>
						</div>
						<div class="check">
							<input type="checkbox" id="analytics_storage" name="analytics_storage">
							<span class="fa fa-check"></span>
							<label for="analytics_storage">'.$this->transLate("cookie_options3",$this->lang).'</label>
						</div>
					</div>
					<div class="cookie_buttons">
						<button onclick="handleConsent(\'2\')">'.$this->transLate("cookie_allow",$this->lang).'</button>
						<button onclick="handleConsent(\'4\')">'.$this->transLate("cookie_setup",$this->lang).'</button>
						<button onclick="handleConsent(\'3\')">'.$this->transLate("cookie_select",$this->lang).'</button>
						<button onclick="handleConsent(\'1\')">'.$this->transLate("cookie_deny",$this->lang).'</button>
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
		
	}