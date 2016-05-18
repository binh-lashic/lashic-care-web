		<!-- content start グラフ設定値変更 -->
		<section id="contentBoxLarge">
			<form class="form">
				<h1 class="contentLarge_h1">グラフ設定値変更</h1>
				<p>変更したい内容を入力してください。</p>
				<!-- 設定値 -->
				<div class="form_set_container graph_form">
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th>再通知設定</th>
										<td colspan="2">
											<label for="snooze" class="floatL pdt5">スヌーズ期間　</label>
											<div class="common_select floatL">
												<select name="snooze" id="snooze">
													<option value="0分" >0分</option>
													<option value="10分" >10分</option>
													<option value="20分" >20分</option>
													<option value="30分" >30分</option>
													<option value="40分" >40分</option>
													<option value="50分" >50分</option>
													<option value="60分" selected>60分</option>
												</select>
												</div>
											<label for="snoozeTimes" class="floatL pdt5">　繰り返し回数　</label>
											<div class="common_select floatL">
												<select name="snoozeTimes" id="snoozeTimes">
													<option value="1回" >1回</option>
													<option value="2回" >2回</option>
													<option value="3回" >3回</option>
													<option value="4回" >4回</option>
													<option value="5回" selected>5回</option>
													<option value="6回" >6回</option>
													<option value="7回" >7回</option>
													<option value="8回" >8回</option>
													<option value="9回" >9回</option>
													<option value="10回" >10回</option>
												</select>
												</div>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:();" class="mail_on">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
										<th>目盛り5つ</th>
										<td colspan="2">
											<label class="dispayNone">範囲0～100、目盛り5つ class="rangeNo05"</label>
											<input type="range" min="0" max="4" value="2" list="scale" class="rangeNo05" />
											<table class="rangeCount">
												<tr>
													<td>感度：最弱</td>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
													<td>感度：最強</td>
												</tr>
										</table>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:();" class="mail_on">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
										<th>目盛り3つ<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="1" list="scale" class="rangeNo03" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:();" class="mail_on">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
										<th rowspan="2">起床判断設定<br>
<p class="small text_red txt_normal">※人感センサーが室内の動きを捉え、起床かどうか判断します。</p></th>
										<td>起床判断開始時間</td>
										<td>
											<div class="common_select floatL">
													<select name="kisho-kaishi-h" id="kisho-kaishi-h">
														<option value="00">00</option>
														  <option value="01">01</option>
														  <option value="02">02</option>
														  <option value="03">03</option>
														  <option value="04">04</option>
														  <option value="05">05</option>
														  <option value="06">06</option>
														  <option value="07">07</option>
														  <option value="08">08</option>
														  <option value="09">09</option>
														  <option value="10">10</option>
														  <option value="11">11</option>
														  <option value="12">12</option>
														  <option value="13">13</option>
														  <option value="14">14</option>
														  <option value="15">15</option>
														  <option value="16">16</option>
														  <option value="17">17</option>
														  <option value="18">18</option>
														  <option value="19">19</option>
														  <option value="20">20</option>
														  <option value="21">21</option>
														  <option value="22">22</option>
														  <option value="23">23</option>
													</select>
											</div>
											<span class="floatL pdt5">&nbsp;&nbsp;時&nbsp;&nbsp;</span>
											<div class="common_select floatL">
													<select name="snoozeTimes" id="snoozeTimes">
														<option value="00">00</option>
														  <option value="01">01</option>
														  <option value="02">02</option>
														  <option value="03">03</option>
														  <option value="04">04</option>
														  <option value="05">05</option>
														  <option value="06">06</option>
														  <option value="07">07</option>
														  <option value="08">08</option>
														  <option value="09">09</option>
														  <option value="10">10</option>
														  <option value="11">11</option>
														  <option value="12">12</option>
														  <option value="13">13</option>
														  <option value="14">14</option>
														  <option value="15">15</option>
														  <option value="16">16</option>
														  <option value="17">17</option>
														  <option value="18">18</option>
														  <option value="19">19</option>
														  <option value="20">20</option>
														  <option value="21">21</option>
														  <option value="22">22</option>
														  <option value="23">23</option>
														  <option value="24">24</option>
														  <option value="25">25</option>
														  <option value="26">26</option>
														  <option value="27">27</option>
														  <option value="28">28</option>
														  <option value="29">29</option>
														  <option value="30">30</option>
														  <option value="31">31</option>
														  <option value="32">32</option>
														  <option value="33">33</option>
														  <option value="34">34</option>
														  <option value="35">35</option>
														  <option value="36">36</option>
														  <option value="37">37</option>
														  <option value="38">38</option>
														  <option value="39">39</option>
														  <option value="40">40</option>
														  <option value="41">41</option>
														  <option value="42">42</option>
														  <option value="43">43</option>
														  <option value="44">44</option>
														  <option value="45">45</option>
														  <option value="46">46</option>
														  <option value="47">47</option>
														  <option value="48">48</option>
														  <option value="49">49</option>
														  <option value="50">50</option>
														  <option value="51">51</option>
														  <option value="52">52</option>
														  <option value="53">53</option>
														  <option value="54">54</option>
														  <option value="55">55</option>
														  <option value="56">56</option>
														  <option value="57">57</option>
														  <option value="58">58</option>
														  <option value="59">59</option>
													</select>
											</div>
											<span class="floatL pdt5">&nbsp;&nbsp;分&nbsp;&nbsp;〜&nbsp;&nbsp;</span>
											<div class="common_select floatL">
													<select name="kisho-kaishi-h" id="kisho-kaishi-h">
														<option value="00">00</option>
														  <option value="01">01</option>
														  <option value="02">02</option>
														  <option value="03">03</option>
														  <option value="04">04</option>
														  <option value="05">05</option>
														  <option value="06">06</option>
														  <option value="07">07</option>
														  <option value="08">08</option>
														  <option value="09">09</option>
														  <option value="10">10</option>
														  <option value="11">11</option>
														  <option value="12">12</option>
														  <option value="13">13</option>
														  <option value="14">14</option>
														  <option value="15">15</option>
														  <option value="16">16</option>
														  <option value="17">17</option>
														  <option value="18">18</option>
														  <option value="19">19</option>
														  <option value="20">20</option>
														  <option value="21">21</option>
														  <option value="22">22</option>
														  <option value="23">23</option>
													</select>
											</div>
											<span class="floatL pdt5">&nbsp;&nbsp;時&nbsp;&nbsp;</span>
											<div class="common_select floatL">
													<select name="snoozeTimes" id="snoozeTimes">
														<option value="00">00</option>
														  <option value="01">01</option>
														  <option value="02">02</option>
														  <option value="03">03</option>
														  <option value="04">04</option>
														  <option value="05">05</option>
														  <option value="06">06</option>
														  <option value="07">07</option>
														  <option value="08">08</option>
														  <option value="09">09</option>
														  <option value="10">10</option>
														  <option value="11">11</option>
														  <option value="12">12</option>
														  <option value="13">13</option>
														  <option value="14">14</option>
														  <option value="15">15</option>
														  <option value="16">16</option>
														  <option value="17">17</option>
														  <option value="18">18</option>
														  <option value="19">19</option>
														  <option value="20">20</option>
														  <option value="21">21</option>
														  <option value="22">22</option>
														  <option value="23">23</option>
														  <option value="24">24</option>
														  <option value="25">25</option>
														  <option value="26">26</option>
														  <option value="27">27</option>
														  <option value="28">28</option>
														  <option value="29">29</option>
														  <option value="30">30</option>
														  <option value="31">31</option>
														  <option value="32">32</option>
														  <option value="33">33</option>
														  <option value="34">34</option>
														  <option value="35">35</option>
														  <option value="36">36</option>
														  <option value="37">37</option>
														  <option value="38">38</option>
														  <option value="39">39</option>
														  <option value="40">40</option>
														  <option value="41">41</option>
														  <option value="42">42</option>
														  <option value="43">43</option>
														  <option value="44">44</option>
														  <option value="45">45</option>
														  <option value="46">46</option>
														  <option value="47">47</option>
														  <option value="48">48</option>
														  <option value="49">49</option>
														  <option value="50">50</option>
														  <option value="51">51</option>
														  <option value="52">52</option>
														  <option value="53">53</option>
														  <option value="54">54</option>
														  <option value="55">55</option>
														  <option value="56">56</option>
														  <option value="57">57</option>
														  <option value="58">58</option>
														  <option value="59">59</option>
													</select>
											</div>
											<span class="floatL pdt5">&nbsp;&nbsp;分</span>
											<div class="clearBoth"><span class="small text_red">※</span><span class="small">デフォルト5時00分〜9時00分</span></div>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:();" class="mail_on">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
										<td>目盛り4つ</td>
										<td>
											<div class="floatL">
											<label class="dispayNone">範囲0～100、目盛り4つ class="rangeNo04"</label>
											<input type="range" min="0" max="3" value="1" list="scale" class="rangeNo04" />
												<table class="rangeCount">
													<tr>
														<td>0</td>
														<td>1</td>
														<td>2</td>
														<td>3</td>
													</tr>
												</table>
											</div>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:();" class="mail_on">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
										<th>あいうえお</th>
										<td>目盛り6つ</td>
										<td>
											<label class="dispayNone">範囲0～100、目盛り6つ class="rangeNo04"</label>
											<input type="range" min="0" max="5" value="1" list="scale" class="rangeNo06" />
												<table class="rangeCount">
													<tr>
														<td>0</td>
														<td>1</td>
														<td>2</td>
														<td>3</td>
														<td>4</td>
														<td>5</td>
													</tr>
												</table>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:();" class="mail_on">メール通知 ON</a></div>
										</td>
									</tr>
								</tbody>
							</table>
					</div>
				</div>
				<!-- /設定値 --> 
				
				<div class="set_container">
					<div class="left_container"></div>
					<div class="center_container"><a class="fancybox btn_darkBlue" href="#settingChange">変更する</a>
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end グラフ設定値変更 --> 