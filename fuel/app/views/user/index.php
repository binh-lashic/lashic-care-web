<!-- content -->
<main role="main" class="clearBoth">
	<div class="clearfix content"> 
		<!-- ユーザー名 -->
		<div class="com_usrName">
			<p>インフィック<span class="com_userSmall">さん</span></p>
		</div>
		<!-- /ユーザー名 --> 
		
		<!-- お知らせ -->
		<div class="com_news">
			<dl class="clearfix">
				<dt class="com_news_tile"><img src="images/common/hdr_news_megaphone.png" alt="icon"/><br>
					お知らせ</dt>
				<dd class="com_news_tile"> <a href="report/index.html" class="com_news_link"> <span class="com_news_text"> インフィック（95）さんが外出から戻られておられないようです。<br>
					<span class="small">その他未対応事項（18件）</span> </span> </a> </dd>
			</dl>
		</div>
		<!-- /お知らせ --> 
	</div>
	<div class="clearfix content"> 
		<!-- content start -->
		<section id="contentBox">
			<h1 class="content_h1 graph_title_icon">インフィックさんの様子</h1>
			
			<!-- 現在のグラフ -->
			<h2 class="content_h2">現在のグラフ</h2>
			<ul class="graph_list">
				<li class="graph_tile">
					<div class="graph_set">
						<p class="graph_rank">★★★★</p>
						<p class="graph_text">起床 <span class="graph_number">5:34</span></p>
						<p class="graph_text_gray">（平均起床時間 5:18）</p>
						<hr>
						<p class="graph_rank">★★★★★</p>
						<p class="graph_text">起床 <span class="graph_number">5:34</span></p>
						<p class="graph_text_gray">（平均起床時間 5:18）</p>
					</div>
				</li>
				<li class="graph_tile">
					<div class="graph_set">
						<p class="graph_rank">★★★★★</p>
						<div class="graph_chart">
							<div class="myStat" data-dimension="153" data-text="25.6℃" data-info="" data-width="30" data-bordersize="30" data-fontsize="38" data-percent="35" data-fgcolor="#ffaf61" data-bgcolor="#dcdcdc"></div>
						</div>
						<div class="graph_title"><img src="images/graph/graph_icon_temperature.png" width="17" height="42" alt=""/>
							<p>室温</p>
						</div>
					</div>
				</li>
				<li class="graph_tile">
					<div class="graph_set">
						<p class="graph_rank">★★★</p>
						<div class="graph_chart">
							<div class="myStat" data-dimension="153" data-text="28.6%" data-percent="28.6" data-info="" data-width="30" data-bordersize="30" data-fontsize="38" data-fgcolor="#81cef2" data-bgcolor="#dcdcdc"></div>
						</div>
						<div class="graph_title"><img src="images/graph/graph_icon_humidity.png" width="26" height="42" alt=""/>
							<p>湿度</p>
						</div>
					</div>
				</li>
				<li class="graph_tile">
					<div class="graph_set">
						<p class="graph_rank">★</p>
						<div class="graph_chart">
							<div class="myStat" data-dimension="153" data-text="13.3" data-percent="13.3" data-info="" data-width="60" data-bordersize="30" data-fontsize="38" data-fgcolor="#eb71b6" data-bgcolor="#dcdcdc" ></div>
						</div>
						<div class="graph_title"><img src="images/graph/graph_icon_motion.png" width="19" height="37" alt=""/>
							<p>運動量</p>
						</div>
					</div>
				</li>
				<li class="graph_tile">
					<div class="graph_set">
						<p class="graph_rank">★★★★★</p>
						<div class="graph_chart">
							<div class="myStat" data-dimension="153" data-text="1243lux" data-percent="96" data-info="" data-width="60" data-bordersize="30" data-fontsize="38" data-fgcolor="#ffef00" data-bgcolor="#dcdcdc" ></div>
						</div>
						<div class="graph_title"><img src="images/graph/graph_icon_light.png" width="22" height="38" alt=""/>
							<p>照度</p>
						</div>
					</div>
				</li>
				<li class="graph_tile">
					<div class="graph_set">
						<p class="graph_rank">★★★★</p>
						<div class="graph_chart">
							<div class="myStat" data-dimension="153" data-text="70%" data-percent="70" data-info="" data-width="60" data-bordersize="30" data-fontsize="38" data-fgcolor="#2baa3f" data-bgcolor="#dcdcdc" ></div>
						</div>
						<div class="graph_title"><img src="images/graph/graph_icon_comfortable.png" width="31" height="31" alt=""/>
							<p>室温</p>
						</div>
					</div>
				</li>
			</ul>
			<!-- /現在のグラフ --> 
			
			<!-- 24時間グラフ -->
			<h2 class="content_h2">24時間グラフ</h2>
			<table class="graph24_select lazy">
				<tr>
					<th>グラフ表示項目選択</th>
					<td class="clearfix"><input type="checkbox" id="i1">
						<label for="i1" class="checkbox">室温 <img src="images/graph/graph_select_01.png" width="25" height="9" alt=""/></label>
						<input type="checkbox" id="i2">
						<label for="i2" class="checkbox">湿度 <img src="images/graph/graph_select_02.png" width="25" height="9" alt=""/></label>
						<input type="checkbox" id="i3">
						<label for="i3" class="checkbox">運動量 <img src="images/graph/graph_select_03.png" width="25" height="15" alt=""/></label>
						<input type="checkbox" id="i4">
						<label for="i4" class="checkbox">照度 <img src="images/graph/graph_select_04.png" width="25" height="9" alt=""/></label>
						<input type="checkbox" id="i5">
						<label for="i5" class="checkbox">点灯 <img src="images/graph/graph_select_05.png" width="25" height="9" alt=""/></label>
						<br>
						<input type="checkbox" id="i6">
						<label for="i6" class="checkbox">起床時間 <img src="images/graph/graph_select_06.png" width="15" height="15" alt=""/></label>
						<input type="checkbox" id="i7">
						<label for="i7" class="checkbox">就寝時間 <img src="images/graph/graph_select_07.png" width="15" height="15" alt=""/></label></td>
				</tr>
			</table>
			<div class="graph24_select_arrow"><img src="images/graph/graph_select_arrow.png" width="21" height="16" alt=""/></div>
			<div class="graph24_chart_line">
				<div class="graph24_hdr">
					<p class="graph24_day">今日 12/31（木）</p>
					<ul>
						<li class="graph24_back"><a href="#"><img src="images/graph/graph_arrow_blue_back.png" width="12" height="19" alt=""/></a></li>
						<li class="graph24_next"><a href="#"><img src="images/graph/graph_arrow_blue_next.png" width="12" height="19" alt=""/></a></li>
					</ul>
					<div class="graph24_calendar">
						<a id="def-html" class="box" data-tooltip="#graph24_cal_select"><img src="images/graph/graph_btn_calender_off.png" width="90" height="41" alt=""/></a>
						<!-- カレンダー表示内容 -->
						<div id="graph24_cal_select" style="display:none;">
							<div class="graph24_cal_selectInner">
							<ul class="graph24_cal_head clearfix">
								<li class="graph24_cal_back"><span>&lt;</span></li>
								<li class="graph24_cal_thisMonth"><span class="slide_btn">2月 2016</span>
									<div class="graph24_cal_otherMonth">
										<p class="pdt20 pdb10">年月を選択してください</p>
										<div class="common_select">
											<select>
												<option value="">2012年</option>
												<option value="">2013年</option>
												<option value="">2014年</option>
												<option value="">2015年</option>
												<option value="" selected>2016年</option>
											</select>
										</div>
										<div class="common_select mgt15 mgb20">
											<select>
												<option value="">1月</option>
												<option value="">2月</option>
												<option value="">3月</option>
												<option value="">4月</option>
												<option value="">5月</option>
												<option value="">6月</option>
												<option value="">7月</option>
												<option value="">8月</option>
												<option value="">9月</option>
												<option value="">10月</option>
												<option value="">11月</option>
												<option value="">12月</option>
											</select>
										</div>
										<span class="slide_btn_back btn_red mgb10">OK</span>
										<span class="slide_btn_back btn_text">キャンセル</span>
									</div>
								</li>
								<li class="graph24_cal_next"><span>&gt;</span></li>
							</ul>



							<table class="graph24_cal_table">
								<thead>
									<tr>
										<th role="columnheader" aria-label="日曜日">日</th>
										<th role="columnheader" aria-label="月曜日">月</th>
										<th role="columnheader" aria-label="火曜日">火</th>
										<th role="columnheader" aria-label="水曜日">水</th>
										<th role="columnheader" aria-label="木曜日">木</th>
										<th role="columnheader" aria-label="金曜日">金</th>
										<th role="columnheader" aria-label="土曜日">土</th>
									</tr>
								</thead>
								<tbody>
											<tr>
												<td class="graph24_cal-prevday"><span>31</span></td>
												<td class="graph24_cal-active"><span>1</span></td>
												<td class="graph24_cal-active"><span>2</span></td>
												<td class="graph24_cal-active"><span>3</span></td>
												<td class="graph24_cal-active"><span>4</span></td>
												<td class="graph24_cal-active"><span>5</span></td>
												<td class="graph24_cal-active"><span>6</span></td>
											</tr>
											<tr>
												<td class="graph24_cal-active"><span>7</span></td>
												<td class="graph24_cal-active"><span>8</span></td>
												<td class="graph24_cal-active"><span>9</span></td>
												<td class="graph24_cal-active"><span>10</span></td>
												<td class="graph24_cal-active"><span>11</span></td>
												<td class="graph24_cal-active"><span>12</span></td>
												<td class="graph24_cal-active"><span>13</span></td>
											</tr>
											<tr>
												<td class="graph24_cal-active"><span>14</span></td>
												<td class="graph24_cal-active"><span>15</span></td>
												<td class="graph24_cal-active"><span>16</span></td>
												<td class="graph24_cal-active graph24_cal-selected"><span>17</span></td>
												<td class="graph24_cal-active graph24_cal-today"><span>18<br>今日</span></td>
												<td class="graph24_cal-active"><span>19</span></td>
												<td class="graph24_cal-active"><span>20</span></td>
											</tr>
											<tr>
												<td class="graph24_cal-active"><span>21</span></td>
												<td class="graph24_cal-active"><span>22</span></td>
												<td class="graph24_cal-active"><span>23</span></td>
												<td class="graph24_cal-active"><span>24</span></td>
												<td class="graph24_cal-active"><span>25</span></td>
												<td class="graph24_cal-active"><span>26</span></td>
												<td class="graph24_cal-active"><span>27</span></td>
											</tr>
											<tr>
												<td class="graph24_cal-active"><span>28</span></td>
												<td class="graph24_cal-active"><span>29</span></td>
												<td class="graph24_cal-nextday"><span>1</span></td>
												<td class="graph24_cal-nextday"><span>2</span></td>
												<td class="graph24_cal-nextday"><span>3</span></td>
												<td class="graph24_cal-nextday"><span>4</span></td>
												<td class="graph24_cal-nextday"><span>5</span></td>
											</tr>
											<tr>
												<td class="graph24_cal-nextday"><span>6</span></td>
												<td class="graph24_cal-nextday"><span>7</span></td>
												<td class="graph24_cal-nextday"><span>8</span></td>
												<td class="graph24_cal-nextday"><span>9</span></td>
												<td class="graph24_cal-nextday"><span>10</span></td>
												<td class="graph24_cal-nextday"><span>11</span></td>
												<td class="graph24_cal-nextday"><span>12</span></td>
											</tr>
										</tbody>
							</table>
						
						
							<div class="graph24_btnArea">
							<button class="btn_text" type="button">今日</button>
							</div>
						</div>
						</div>
						<!-- /カレンダー表示内容 --> 
					</div>
				</div>
				<div class="graph24_lineArea"><img src="images/graph/graph_sample.gif" width="720" height="378" alt=""/> </div>
			</div>
			<!-- /24時間グラフ --> 
		</section>
		<!-- /content end --> 
		
		<!-- aide start -->
		<aside id="aside_userDate">
			<div class="aside_container">
				<div class="clearfix">
					<p class="aside_title">基本データ</p>
					<div class="aside_btn_edit"><a href="#attention_01" rel="shadowbox[cont]" class="btn_text">編集</a></div>
				</div>
				<div class="aside_photo"><div class="aside_photoInner"><img src="images/user/sample.jpg" width="179" height="179" alt=""/></div></div>
				
				<dl class="aside_userDetail clearfix">
					<dt><img src="images/common/user_icon_birth.png" width="17" alt="生年月日"/></dt>
					<dd>1920年3月9日（95歳）</dd>
					<dt><img src="images/common/user_icon_blood.png" width="19" alt="血液型"/></dt>
					<dd>O型</dd>
					<dt><img src="images/common/user_icon_address.png" width="19" alt="住所"/></dt>
					<dd>静岡市××××3F</dd>
					<dt><img src="images/common/user_icon_phone.png" width="19" alt="生年月日"/></dt>
					<dd>054-280-7340</dd>
					<dt><img src="images/common/user_icon_mobile.png" width="9" alt="生年月日"/></dt>
					<dd>090-1111-2222</dd>
				</dl>
				
				
				<!-- 緊急連絡先 -->
				<div class="aside_emergency">
					<h3><img src="images/common/user_icon_emergency.png" width="17" alt=""/> 緊急連絡先</h3>
					<ul>
						<li>
							<dl>
								<dt>斉藤雅和</dt>
								<dd>018-882-2016<br>
080-1813-4139</dd>
							</dl>
						</li>
						<li>
							<dl>
								<dt>斉藤雅和</dt>
								<dd>018-882-2016<br>
080-1813-4139</dd>
							</dl>
						</li>
					</ul>
				</div>
				<!-- /緊急連絡先 -->
				
				
				<!-- 連絡共有 -->
				<div class="aside_share">
					<h3><img src="images/common/user_icon_share.png" width="32" alt=""/> 連絡共有</h3>
					<div class="aside_shareInner">
						<ul class="scroll_area">
							<li>川島　永嗣</li>
							<li>長友　佑都</li>
							<li>森重　真人</li>
							<li>内田　篤人</li>
							<li>吉田　麻也</li>
							<li>長谷部　誠</li>
							<li>川島　永嗣</li>
							<li>長友　佑都</li>
							<li>森重　真人</li>
							<li>内田　篤人</li>
							<li>吉田　麻也</li>
							<li>長谷部　誠</li>
						</ul>
					</div>
				</div>
				<!-- /連絡共有 -->
				
			</div>
		</aside>
		<!-- /aide end --> 
	</div>
</main>