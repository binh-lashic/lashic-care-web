/*
 + JQuery         : switchHat.js 0.10
 +
 + Author         : Takashi Hirasawa
 + Special Thanks : kotarok (http://nodot.jp/)
 + Copyright (c) 2010 CSS HappyLife (http://css-happylife.com/)
 + Licensed under the MIT License:
 + http://www.opensource.org/licenses/mit-license.php
 +
 + Since    : 2010-06-24
 + Modified : 2010-06-27
 */

(function($) {

	//設定（コメントアウトすれば機能停止）
	$(function(){
		//サイトトップ
		$('.body-globaltop .footerSitemap').uHat({
			switchContents: $(this).find('.sitemapArea'),
			openAllBtnClass: $(this).find('.toggleBtn span'),
			textOpen: '開く',
			textClose: '閉じる'
		});

		$.each($('.toggleArea'), function(i, e){
			$(e).uHat({
				switchBtn: $(e).find('h3'),
				switchContents: $(e).find('.detail'),
				openAllBtnClass: $('.allOpenBtn').eq(i).find('span')
			});
		});
		$.each($('.qList'), function(i, e){
			$(e).uHat({
				switchBtn: $(e).find('dl dt'),
				switchContents: $(e).find('dl dd'),
				openAllBtnClass: $('.allOpenBtn').eq(i).find('span')
			});
		});

		//アンカー先のswitchOnを開く
		$hash = $(window.location.hash);
		if($hash.length > 0 && $hash.hasClass('switchOn')){
			$hash.trigger('click',[true]);
		}
		$('a[href^=#]').click(function() {
			var $target = $($(this).attr('href'));
			if($target.hasClass('switchOn') && !$target.hasClass('nowOpen')){
				$target.trigger('click',[true]);
			}
		});
	});

	$.fn.uHat = function(opts) {
        
        opts = $.extend({
            switchBtn: '.switchHat',
			switchContents: '.switchDetail',
			switchClickAddClass: 'nowOpen',
			openAllBtnClass: '.allOpenBtn span',
			openContents: opts.switchContents,
			textOpen:'全て開く',
			textClose: '全て閉じる'
        }, opts);

        return this.each(function(e, i) {
            _switchHat(e);
            _openAll(e);
        });

        // 折りたたみ
		function _switchHat(e) {
			$(opts.switchContents).hide();
			$(opts.switchBtn).addClass("switchOn").click(function(e, data){
				var index = $(opts.switchBtn).index(this);
				if(data){
					$(opts.switchContents).eq(index).show();
				}else{
					$(opts.switchContents).eq(index).slideToggle("fast");
				}
				$(this).toggleClass(opts.switchClickAddClass);
			}).css("cursor","pointer");
		}

		// 全部開くボタン
		function _openAll(e) {
			$(opts.openAllBtnClass).addClass("switchOn").click(	function(){
				if(!$(this).hasClass(opts.switchClickAddClass)){
					$(this).addClass(opts.switchClickAddClass).text(opts.textClose);
					$(opts.openContents).slideDown("fast");
					$(opts.switchBtn).addClass(opts.switchClickAddClass);
				}else{
					$(this).removeClass(opts.switchClickAddClass).text(opts.textOpen);
					$(opts.openContents).slideUp("fast");
					$(opts.switchBtn).removeClass(opts.switchClickAddClass);
				}
			}).css("cursor","pointer");
			$(opts.switchBtn).click(function(){
				var opened = false;
				$.each($(opts.switchBtn), function(i, e){
					if($(e).hasClass(opts.switchClickAddClass)){
						opened = true;
					}
				});
				if(opened){
					$(opts.openAllBtnClass).addClass(opts.switchClickAddClass).text(opts.textClose);
				}else{
					$(opts.openAllBtnClass).removeClass(opts.switchClickAddClass).text(opts.textOpen);
				}
			});
		}

    };

})(jQuery);