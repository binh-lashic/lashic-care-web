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







/* メニュースクロール設定 jquery.mCustomScrollbar.concat.min.js */

		(function($){
			$(window).load(function(){
				
				$("#mainMenu").mCustomScrollbar({
					theme:"minimal-dark"
				});
				
			});
		})(jQuery);
	


/* ------------------------------------------------------

縦ライン揃え tile.js設定

------------------------------------------------------ */

  $(function() {
    $(".graph_tile").tile(3);
  });
  $(function() {
    $(".tile").tile(3);
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
    if (over_flg == false) {
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