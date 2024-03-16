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

	ShowCookie() {
		$(document).ready(function(){
			if(this.cookie_accept === 'false'){
				$('.google_cookie').addClass('showCookie');
			}
		});
	}
	
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

	acceptTrue() {
		gtag('consent', 'update', {
			'ad_storage': setGtag('ad_storage'),
			'ad_user_data': setGtag('ad_user_data'),
			'ad_personalization': setGtag('ad_personalization'),
			'analytics_storage': setGtag('analytics_storage')
		});
	}

	setGtag(name) {
		if ($.cookie(name) === 'granted') {
			return 'granted';
		}
		else {
			return 'denied';
		}
	}

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

	checkInput(name,action){
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