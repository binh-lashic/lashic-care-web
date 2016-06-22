		<!-- content start グラフ設定値変更 -->
		<section id="contentBoxLarge">
				<h1 class="contentLarge_h1">アラート通知設定変更</h1>
				<p>変更したい内容を入力してください。</p>
				<!-- 設定値 -->
				<div class="form_set_container graph_form">
						<input type="hidden" name="user_id" id="user_id" value="<?php echo $user['id']; ?>" />
						<input type="hidden" name="sensor_id" id="sensor_id" value="<?php echo $sensor['sensor_id']; ?>" />
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th>再通知設定</th>
										<td colspan="2">
											<label for="snooze" class="floatL pdt5">スヌーズ期間　</label>
											<div class="common_select floatL">
												<select name="snooze_interval" id="snooze_interval">
<?php
for($i = 0; $i <= 6; $i++) {
	$time = $i * 10;
?>
													<option value="<?php echo $time; ?>"  <?php if($sensor['snooze_interval'] == $time) { echo "selected=\"selected\""; } ?>><?php echo $time; ?>分</option>
<?php
}
?>												</select>
												</div>
											<label for="snoozeTimes" class="floatL pdt5">　繰り返し回数　</label>
											<div class="common_select floatL">
												<select name="snooze_times" id="snooze_times">
<?php
for($i = 1; $i <= 10; $i++) {
?>
													<option value="<?php echo $i; ?>" <?php if($sensor['snooze_times'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?>回</option>
<?php
}
?>
												</select>
												</div>
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<th>室内温度異常アラート<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
<?php
if($sensor['admin'] == 1) {
?>
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="<?php echo $sensor['temperature_level']; ?>" list="scale" class="rangeNo03" id="temperature_level" name="temperature_level" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
<?php
}
?>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['temperature_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="temperature_alert">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
										<th>火事アラート<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
<?php
if($sensor['admin'] == 1) {
?>
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="<?php echo $sensor['fire_level']; ?>" list="scale" class="rangeNo03" id="fire_level" name="fire_level" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
<?php
}
?>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['fire_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="fire_alert">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
									<th>熱中症アラート<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
<?php
if($sensor['admin'] == 1) {
?>
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="<?php echo $sensor['heatstroke_level']; ?>" list="scale" class="rangeNo03" id="heatstroke_level" name="heatstroke_level" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
<?php
}
?>										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['heatstroke_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="heatstroke_alert">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
									<th>室内湿度異常アラート<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
<?php
if($sensor['admin'] == 1) {
?>
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="<?php echo $sensor['humidity_level']; ?>" list="scale" class="rangeNo03" id="humidity_level" name="humidity_level" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
<?php
}
?>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['humidity_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="humidity_alert">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
									<th>カビ・ダニアラート<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
<?php
if($sensor['admin'] == 1) {
?>
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="<?php echo $sensor['mold_mites_level']; ?>" list="scale" class="rangeNo03" id="mold_mites_level" name="mold_mites_level" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
<?php
}
?>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['mold_mites_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="mold_mites_alert">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
									<th>室内照度異常（日中）<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
<?php
if($sensor['admin'] == 1) {
?>
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="<?php echo $sensor['illuminance_daytime_level']; ?>" list="scale" class="rangeNo03" id="illuminance_daytime_level" name="illuminance_daytime_level" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
<?php
}
?>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['illuminance_daytime_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="illuminance_daytime_alert">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
									<th>室内照度異常（深夜）<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
<?php
if($sensor['admin'] == 1) {
?>
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="<?php echo $sensor['illuminance_night_level']; ?>" list="scale" class="rangeNo03" id="illuminance_night_level" name="illuminance_night_level" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
<?php
}
?>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['illuminance_night_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="illuminance_night_alert">メール通知 ON</a></div>
										</td>
									</tr>
<?php
/*
									<th>データ送信エラー<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['data_send_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="data_send_alert">メール通知 ON</a></div>
										</td>
									</tr>
*/
?>
									<th>平均起床時間遅延<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
<?php
if($sensor['admin'] == 1) {
?>
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="<?php echo $sensor['wake_up_level']; ?>" list="scale" class="rangeNo03" id="wake_up_level" name="wake_up_level" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
<?php
}
?>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['wake_up_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="wake_up_alert">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
									<th>平均睡眠時間遅延<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
<?php
if($sensor['admin'] == 1) {
?>
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="<?php echo $sensor['sleep_level']; ?>" list="scale" class="rangeNo03" id="sleep_level" name="sleep_level" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
<?php
}
?>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['sleep_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="sleep_alert">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
									<th>異常行動<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
<?php
if($sensor['admin'] == 1) {
?>
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="<?php echo $sensor['abnormal_behavior_level']; ?>" list="scale" class="rangeNo03" id="abnormal_behavior_level" name="abnormal_behavior_level" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
<?php
}
?>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['abnormal_behavior_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="abnormal_behavior_alert">メール通知 ON</a></div>
										</td>
									</tr>
									<tr>
										<th>一定時間人感センサー未感知<br><p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
<?php
if($sensor['admin'] == 1) {
?>
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="<?php echo $sensor['active_non_detection_level']; ?>" list="scale" class="rangeNo03" id="active_non_detection_level" name="active_non_detection_level" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
<?php
}
?>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['active_non_detection_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="active_non_detection_alert">メール通知 ON</a></div>
										</td>
									</tr>
<?php
/*
									<th>夜間起床回数、夜間人感センサー感知回数<br>
<p class="small text_red txt_normal">※テキスト</p></th>
										<td colspan="2">
											<label class="dispayNone">範囲0～100、目盛り3つ class="rangeNo03"</label>
											<input type="range" min="0" max="2" value="<?php echo $sensor['active_night_level']; ?>" list="scale" class="rangeNo03" id="active_night_level" name="active_night_level" />
											<table class="rangeCount">
												<tr>
													<td>感度：弱</td>
													<td>感度：中</td>
													<td>感度：強</td>
												</tr>
										</table>
										</td>
										<td>
												<div class="mailSetting"><a href="javascript:void(0);" class="<?php if($sensor['active_night_alert'] == "1") { echo "mail_on"; } else { echo "mail_off"; } ?>" id="active_night_alert">メール通知 ON</a></div>
										</td>
									</tr>
*/
?>
									<tr>
										<th>起床判断設定<br>
<p class="small text_red txt_normal">※人感センサーが室内の動きを捉え、起床かどうか判断します。</p></th>
										<td>起床判断開始時間</td>
										<td>
											<div class="common_select floatL">
													<select name="wake_up_start_time" id="wake_up_start_time">
<?php
for($i = 0; $i < 24; $i++) {
?>
														  <option value="<?php echo $i; ?>" <?php if($sensor['wake_up_start_time'] == $i) { echo "selected=\"selected\""; }?>><?php echo $i; ?></option>
<?php	
}
?>
													</select>
											</div>
											<span class="floatL pdt5">&nbsp;&nbsp;時&nbsp;&nbsp;</span>
											<span class="floatL pdt5">&nbsp;&nbsp;〜&nbsp;&nbsp;</span>
											<div class="common_select floatL">
													<select name="wake_up_end_time" id="wake_up_end_time">
<?php
for($i = 0; $i < 24; $i++) {
?>
														  <option value="<?php echo $i; ?>" <?php if($sensor['wake_up_end_time'] == $i) { echo "selected=\"selected\""; }?>><?php echo $i; ?></option>
<?php	
}
?>
													</select>
											</div>
											<span class="floatL pdt5">&nbsp;&nbsp;時&nbsp;&nbsp;</span>
											<div class="clearBoth"><span class="small text_red">※</span><span class="small">デフォルト5時〜9時</span></div>
										</td>
										<td></td>
									</tr>
									<tr>
										<th>就寝判断設定<br>
<p class="small text_red txt_normal">※人感センサーが室内の動きを捉え、就寝したかどうか判断します。</p></th>
										<td>就寝判断開始時間</td>
										<td>
											<div class="common_select floatL">
													<select name="sleep_start_time" id="sleep_start_time">
<?php
for($i = 0; $i < 24; $i++) {
?>
														  <option value="<?php echo $i; ?>" <?php if($sensor['sleep_start_time'] == $i) { echo "selected=\"selected\""; }?>><?php echo $i; ?></option>
<?php	
}
?>
													</select>
											</div>
											<span class="floatL pdt5">&nbsp;&nbsp;時&nbsp;&nbsp;</span>
											<span class="floatL pdt5">&nbsp;&nbsp;〜&nbsp;&nbsp;</span>
											<div class="common_select floatL">
													<select name="sleep_end_time" id="sleep_end_time">
<?php
for($i = 0; $i < 29; $i++) {
?>
														  <option value="<?php echo $i; ?>" <?php if($sensor['sleep_end_time'] == $i) { echo "selected=\"selected\""; }?>><?php echo $i; ?></option>
<?php	
}
?>
													</select>
											</div>
											<span class="floatL pdt5">&nbsp;&nbsp;時&nbsp;&nbsp;</span>
											<div class="clearBoth"><span class="small text_red">※</span><span class="small">デフォルト19時〜26時</span></div>
										</td>
										<td></td>
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
		</section>
		<!-- /content end グラフ設定値変更 --> 

	<div id="settingChange" class="settingContainer" style="display: none; width:400px; height:300px; ">
		<div class="settingInner">
			<p class="mgb20">システム設定値を変更します。よろしいですか？</p>
			<a href="#settingComp" class="fancybox btn_darkBlue graphSettingTrue graph_setting">変更する</a>
			<a href="javascript:$.fancybox.close();" class="btn_lightGray radius20 graphSettingFalse">キャンセル</a>
		</div>
	</div>
	<div id="settingComp" class="settingContainer" style="display: none; width:400px; height:300px; ">
		<div class="settingInner">
			<p class="mgb20">設定を変更しました。</p>
			<a href="javascript:$.fancybox.close();" class="fancybox btn_darkBlue graphSettingTrue">ページへ戻る</a>
		</div>
	</div>
		<!--このページのjs -->
<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="/js/jquery.fancybox.pack.js"></script>
<script type="text/javascript"> 
$(document).ready(function() {
		$(".fancybox").fancybox();
	}); 
$(document).ready(function() {
	$(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
});
</script>
<!-- /このページのjs -->