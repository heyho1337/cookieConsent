class ConsentJS{
	
	constructor(gtagCode, lang) {
        this.gtagCode = gtagCode;
		this.lang = lang;
		this.cookie_accept = $.cookie('cookie_accept');
		
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		switch (this.cookie_accept) {
			case 'false':
				acceptFalse();
				break;
			case 'true':
				acceptTrue();
				break;
			default:
				acceptFalse();
				break;
		}

		gtag('config', this.gtagCode);

		ShowCookie();
	}

	/**
	 * shows the cookie module on the 1st visit of the user
	*/
	ShowCookie() {
		$(document).ready(function(){
			if(this.cookie_accept === 'false'){
				$('.google_cookie').addClass('showCookie');
			}
		});
	}
	
	/**
	 * setting the tag manager's consent data on the 1st vision
	 * of the user 
	*/
	acceptFalse() {
		gtag('consent', 'default', {
			'ad_storage': 'denied',
			'ad_user_data': 'denied',
			'ad_personalization': 'denied',
			'analytics_storage': 'denied'
		});

		gtag('consent', 'update', {
			'ad_storage': 'denied',
			'ad_user_data': 'denied',
			'ad_personalization': 'denied',
			'analytics_storage': 'denied'
		});
	}

	/**
	 * setting the tag manager's consent data based on the
	 * selected values of the user when the user opens the site
	*/
	acceptTrue() {
		gtag('consent', 'update', {
			'ad_storage': setGtag('ad_storage'),
			'ad_user_data': setGtag('ad_user_data'),
			'ad_personalization': setGtag('ad_personalization'),
			'analytics_storage': setGtag('analytics_storage')
		});
	}

	/**
	 * setting a cookie for user's consent data
	 * @param string name - the constent parameter's name 
	*/
	setGtag(name) {
		if ($.cookie(name) === 'granted') {
			return 'granted';
		}
		else {
			return 'denied';
		}
	}

	/**
	 * the handling of the cookie modul's submission
	 * this function saves the user's selected consent
	 * parameter into cookies so it can set them when the 
	 * user opens the site
	 * @param string action - the button's id that was clicked
	 * 1 - deny all
	 * 2 - grant all
	 * 3 - set the selected options
	 * 4 - open the module to allow the user to determine which
	 * consent parameters they want to deny or grant
	*/
	handleConsent(action) {
		switch (action) {
			case '4':
				$('.cookie_options').addClass('cookieOpen');
				break;
			default:
				gtag('consent', 'update', {
					'ad_storage': checkInput('ad_storage', action),
					'ad_user_data': checkInput('ad_user_data', action),
					'ad_personalization': checkInput('ad_personalization', action),
					'analytics_storage': checkInput('analytics_storage', action)
				});
				$.cookie('cookie_accept', 'true', { path: '/', expires: 800 });
				$('.google_cookie').addClass('hideCookie');
				$('.google_cookie').removeClass('showCookie');
				break;
		}
	}

	/**
	 * the basic method for setting the cookies for the consent parameters
	 * based on the user's choice
	 * @param string name - name of the consent parameter
	 * @param string action - 1: denied | 2: granted the value of the consent parameter 
	 */
	checkInput(name, action) {
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

}