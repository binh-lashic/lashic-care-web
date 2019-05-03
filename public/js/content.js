/* content js */




/* ------------------------------------------------------

pagetop

------------------------------------------------------ */
$(function() {
			var topBtn = $('#page-top');	
			topBtn.hide();
			$(window).scroll(function () {
				if ($(this).scrollTop() > 100) {
					topBtn.fadeIn();
				} else {
					topBtn.fadeOut();
				}
			});
			//スクロールしてトップ
			topBtn.click(function () {
				$('body,html').animate({
					scrollTop: 0
				}, 500);
				return false;
			});
		});

		
/* ------------------------------------------------------

mouse over

------------------------------------------------------ */
function smartRollover() {
	if(document.getElementsByTagName) {
		var images = document.getElementsByTagName("img");

		for(var i=0; i < images.length; i++) {
			if(images[i].getAttribute("src").match("_off."))
			{
				images[i].onmouseover = function() {
					this.setAttribute("src", this.getAttribute("src").replace("_off.", "_on."));
				}
				images[i].onmouseout = function() {
					this.setAttribute("src", this.getAttribute("src").replace("_on.", "_off."));
				}
			}
		}
	}
}

if(window.addEventListener) {
	window.addEventListener("load", smartRollover, false);
}
else if(window.attachEvent) {
	window.attachEvent("onload", smartRollover);
}






/* ------------------------------------------------------

メニューバー drawer.js設定

------------------------------------------------------ */
$(function(){
	$('.drawer-menu > .drawer-dropdown')
		.mouseover(function(){
		$(this).addClass("open");
		$(this).siblings().removeClass("open");
		$(".drawer-menu-item").attr({
				'aria-expanded' : 'true'
			});
	});

	$(document).on('click', function(e) {
		if($('.drawer-menu > .drawer-dropdown').hasClass('open')) {
			$('.drawer-menu > .drawer-dropdown').removeClass("open");
		} else if($(e.target).hasClass('drawer-menu-item')){
			$(e.target).parent().addClass("open");
		}
	});
});



/* 高さ設定 */
$(function(){
	//*********************************
	//初期設定

	var minus = 80　//Header+要素AのHeight値（要素B、要素Cと追加していきたい分だけ高さを足してください。）
	var mainID = 'mainMenu'　//高さを動的にするdivのID名
	hsize = $('.drawer-dropdown-menu').height();

	//*********************************
	if ($(window).height() < hsize) {
	function heightSetting(){
		windowH = $(window).height();
		mainH = windowH - minus;
		$('#'+mainID).height(mainH+'px');
	}
	
	heightSetting();
 
	$(window).resize(function() {
		heightSetting();
	});
	}
});
$(function(){
	//*********************************
	//初期設定
	
	var minus2 = 80　//Header+要素AのHeight値（要素B、要素Cと追加していきたい分だけ高さを足してください。）
	var mainID2 = 'cartMenu'　//高さを動的にするdivのID名
	hsize2 = $('.cartMenu').height();
	
	//*********************************
	if ($(window).height() < hsize2) {
	function heightSetting2(){
		windowH2 = $(window).height();
		mainH2 = windowH2 - minus2;
		$('#'+mainID2).height(mainH2+'px');
	}
	
	heightSetting2();
 
	$(window).resize(function() {
		heightSetting2();
	});
	}
});


/* メニュースクロール設定 jquery.mCustomScrollbar.concat.min.js */

		(function($){
			$(window).load(function(){
				
				$("#mainMenu").mCustomScrollbar({
					theme:"minimal-dark"
				});
				
				$("#cartMenu").mCustomScrollbar({
					theme:"minimal-dark"
				});
				
			});
		})(jQuery);






/* cookie設定 */
/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD (Register as an anonymous module)
		define(['jquery'], factory);
	} else if (typeof exports === 'object') {
		// Node/CommonJS
		module.exports = factory(require('jquery'));
	} else {
		// Browser globals
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function encode(s) {
		return config.raw ? s : encodeURIComponent(s);
	}

	function decode(s) {
		return config.raw ? s : decodeURIComponent(s);
	}

	function stringifyCookieValue(value) {
		return encode(config.json ? JSON.stringify(value) : String(value));
	}

	function parseCookieValue(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape...
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}

		try {
			// Replace server-side written pluses with spaces.
			// If we can't decode the cookie, ignore it, it's unusable.
			// If we can't parse the cookie, ignore it, it's unusable.
			s = decodeURIComponent(s.replace(pluses, ' '));
			return config.json ? JSON.parse(s) : s;
		} catch(e) {}
	}

	function read(s, converter) {
		var value = config.raw ? s : parseCookieValue(s);
		return $.isFunction(converter) ? converter(value) : value;
	}

	var config = $.cookie = function (key, value, options) {

		// Write

		if (arguments.length > 1 && !$.isFunction(value)) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setMilliseconds(t.getMilliseconds() + days * 864e+5);
			}

			return (document.cookie = [
				encode(key), '=', stringifyCookieValue(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// Read

		var result = key ? undefined : {},
			// To prevent the for loop in the first place assign an empty array
			// in case there are no cookies at all. Also prevents odd result when
			// calling $.cookie().
			cookies = document.cookie ? document.cookie.split('; ') : [],
			i = 0,
			l = cookies.length;

		for (; i < l; i++) {
			var parts = cookies[i].split('='),
				name = decode(parts.shift()),
				cookie = parts.join('=');

			if (key === name) {
				// If second argument (value) is a function it's a converter...
				result = read(cookie, value);
				break;
			}

			// Prevent storing a cookie that we couldn't decode.
			if (!key && (cookie = read(cookie)) !== undefined) {
				result[name] = cookie;
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		// Must not alter options, thus extending a fresh object...
		$.cookie(key, '', $.extend({}, options, { expires: -1 }));
		return !$.cookie(key);
	};

}));


/* メニュー通知 ON OFF 切り替え */
$(function(){
    $(".mailSetting a").click(function(){
        if($(this).attr("class")=="mail_on"){
        $(this).removeClass("mail_on").addClass("mail_off");
        $(this).text("メール通知 OFF");
		
		}else{
        $(this).removeClass("mail_off").addClass("mail_on");
        $(this).text("メール通知 ON");}
        });
});


/* ------------------------------------------------------

縦ライン揃え tile.js設定

------------------------------------------------------ */

  $(function() {
    $(".graph_tile").tile(3);
  });
  $(function() {
    $(".tile").tile(3);
  });
  $(function() {
    $(".shopping_tile .shoppingCart_address").tile();
  });



/* ------------------------------------------------------

カレンダー表示・非表示

------------------------------------------------------ */
$(document).ready( function(){
    //With some options
    $('#def-html').darkTooltip({
		opacity:1,
		gravity:'north',
		trigger:'click',
		theme:'light'
	});
});


/* toggle */
$(function () {
  $('.slide_btn').click(function() { 
    if ($(this).attr('class') == 'selected') {
      // メニュー非表示
      $(this).removeClass('selected').next('.graph24_cal_otherMonth').slideUp('fast');
    } else {
      // 表示しているメニューを閉じる
      $('.slide_btn').removeClass('selected');
      $('.graph24_cal_otherMonth').hide();

      // メニュー表示
      $(this).addClass('selected').next('.graph24_cal_otherMonth').slideDown('fast');
    }    
  });
  
  // マウスカーソルがメニュー上/メニュー外
  $('.slide_btn,.graph24_cal_otherMonth').hover(function(){
    over_flg = true;
  }, function(){
    over_flg = false;
  });  
  
  // メニュー領域外をクリックしたらメニューを閉じる
  $('body').click(function() {
    if (typeof over_flg !== 'undefined' && over_flg == false) {
      $('.slide_btn').removeClass('selected');
      $('.graph24_cal_otherMonth').slideUp('fast');
    }
  });
  $('.slide_btn_back').click(function() {
      $('.slide_btn').removeClass('selected');
      $('.graph24_cal_otherMonth').hide();
  });
});








/* ------------------------------------------------------

確認・報告ページ　開閉

------------------------------------------------------ */
/* 表示を切り替えるための JavaScript */
function show_body(d){
	document.getElementById('toggle_on'+d).style.display = 'none';
	document.getElementById('toggle_off'+d).style.display = 'block';
	document.getElementById('body'+d).style.display = '';
}
function hide_body(d){
	document.getElementById('toggle_on'+d).style.display = 'block';
	document.getElementById('toggle_off'+d).style.display = 'none';
	document.getElementById('body'+d).style.display = 'none';
}





