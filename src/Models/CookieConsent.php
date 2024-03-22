<?php
	
	namespace Models;

	class CookieConsent extends \Models\Database\SqlDb{
		
		/***
		 * database table for the module's texts  
		*/
		protected array $wordsTable = [
			'word_id' => 'INT AUTO_INCREMENT PRIMARY KEY',
			'word_code' => 'VARCHAR(50)'
		];
		
		/**
		 * @param string $lang current language's code
		 * @param array $words - the texts,words translations that the consent modul will contain
		*/
		function __construct(protected string $lang, protected array $words){
			parent::__construct();
		}

		/**
		 * get the id's translated text for the current language
		 * @param string $code - the text's id 
		 * @return string
		*/
		public function transLate(string $code): string{
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
				$this->wordsTable['word_'.$key] = 'TEXT';
			}
			$this->create('words',$this->wordsTable);
		}

		/**
		 * inserting the the translations of the module's texts into the database
		 * @param string $code - the id of the text's
		 * @param string $text - the text that connected to the id 
		 * @param string $lang - the text's language code
		 * @return string
		*/
		protected function insertText(string $code,string $text,string $lang): string{
			$query = $this->select("words",array('*'),array('word_code' => $code),'');
			if(count($query['data']) > 0){
				$this->update('words',array('word_'.$lang => $text),array('word_code' => $code));
				$result = $query['message'];
			}
			else{
				$_POST['word_'.$lang] = $text;
				$_POST['word_code'] = $code;
				$query = $this->insert('words');
				$result = $query;
			}
			return $result;
		}

	}