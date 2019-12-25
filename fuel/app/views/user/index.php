<?php
if(isset($client)) {
	$graph_btn_calender_image = '/images/graph/graph_btn_calender_off.png';
	if ($current_language !== 'ja') {
		$graph_btn_calender_image = '/images/graph/graph_btn_calender_en_off.png';
	}
?>
	<script type="text/javascript">
	var sensor_id         = "<?php echo !empty($sensor['id']) ? $sensor['id'] : ""; ?>";
	var bedsensor_id      = "<?php echo !empty($bedsensor['id']) ? $bedsensor['id'] : ""; ?>";
        var client_user_id    = "<?php echo $client['id']; ?>";
	var date              = "<?php echo $date; ?>";
	var wake_up_time_data = "";
	var sleep_time_data   = "";
        var graph_error_message = "<?php echo __('user.index.no_data'); ?>";
        var graph24_error_message = "<?php echo __('user.index.no_data'); ?>";
	</script>
		<!-- content start -->
		<section id="contentBox">
			<h1 class="content_h1 graph_title_icon"><?php echo __('user.index.user_state_of', ['user_name' => $client['last_name'].$client['first_name']]); ?></h1>
			
			<!-- 現在のグラフ -->
			<h2 class="content_h2"><?php echo __('user.index.current_graph'); ?></h2>
                            <ul class="graph_list">
                               <?php if(isset($bedsensor) && $bedsensor) : ?>
                               <!-- ベッドセンサー -->
                                <li class="bedSensorGraph">
                                    <ul class="clearfix">
                                        <li>
                                            <div class="graph_set bed_now">
                                                <h3 class="h3_bed"><img width="22" height="16" alt="" src="/images/graph/graph_title_bed.png" /><?php echo __('user.index.user_state_by_bed'); ?></h3>
                                                <div class="clearfix" id="bed-sensor-status">
                                                    <div class="graph_icon_bed">
                                                        <div class="graph_bed_text" >
                                                            <p id="bedsensor_status"></p>
                                                        </div>
                                                        <p class="center"><?php echo __('user.index.status'); ?></p>
                                                    </div>
                                                    <div class="graph_icon_heart">
                                                        <div class="graph_bed_text">
                                                            <p><span id="bedsensor_pulse"></span> <?php echo __('user.index.times_minute'); ?></p>
                                                        </div>
                                                        <p class="center"><?php echo __('user.index.pulse'); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="graph_set">
                                                <div class="graph_chart">
                                                    <div class="myStat" data-dimension="153" data-text="" data-info="" data-width="30" data-bordersize="30" data-fontsize="38" data-percent="" data-fgcolor="#ffaf61" data-bgcolor="#dcdcdc"></div>
                                                </div>
                                                <div class="graph_icon_watch">
                                                    <img width="35" height="35" alt="" src="/images/graph/graph_icon_watch.png" />
                                                </div>
                                                <p class="graph_sleepIconText"><?php echo __('user.index.total_sleeping_time'); ?></p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="graph_set">
                                                <div class="graph_chart">
                                                    <div class="myStat" data-dimension="153" data-text="" data-info="" data-width="30" data-bordersize="30" data-fontsize="38" data-percent="" data-fgcolor="#ffaf61" data-bgcolor="#dcdcdc"></div>
                                                </div>
                                                <div class="graph_icon_watch">
                                                    <img width="30" height="35" alt="" src="/images/graph/graph_icon_sleep.png" />
                                                </div>
                                                <p class="graph_sleepIconText"><?php echo __('user.index.sleep_comfort_level'); ?></p>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <!-- ベッドセンサー -->
                                <?php endif; ?>
				<li class="graph_tile">
					<div class="graph_set">
						<p class="graph_rank">    </p>
						<p class="graph_text"><?php echo __('sensor_data.titles.time_of_awakening_abbr'); ?> <span class="graph_number" id="data_wake_up_time"></span></p>
						<p class="graph_text_gray">（<?php echo __('sensor_data.titles.average_time_of_awakening'); ?> <span id="data_wake_up_time_average"></span>）</p>
						<hr>
						<p class="graph_rank">     </p>
						<p class="graph_text"><?php echo __('sensor_data.titles.time_of_sleep_abbr'); ?> <span class="graph_number" id="data_sleep_time"></span></p>
						<p class="graph_text_gray">（<?php echo __('sensor_data.titles.average_time_of_sleep'); ?> <span id="data_sleep_time_average"></span>）</p>
					</div>
				</li>
				<li class="graph_tile">
					<div class="graph_set">
						<p class="graph_rank">     </p>
						<div class="graph_chart">
							<div class="myStat" id="data_temperature" data-dimension="153" data-text="" data-info="" data-width="30" data-bordersize="30" data-fontsize="38" data-percent="" data-fgcolor="#ffaf61" data-bgcolor="#dcdcdc"></div>
						</div>
						<div class="graph_title right"><img src="/images/graph/graph_icon_temperature.png" width="17" height="42" alt=""/>
							<p><?php echo __('sensor_data.titles.temperature'); ?></p>
						</div>
					</div>
				</li>
				<li class="graph_tile">
					<div class="graph_set">
						<p class="graph_rank">   </p>
						<div class="graph_chart">
							<div class="myStat" id="data_humidity" data-dimension="153" data-text="" data-percent="" data-info="" data-width="30" data-bordersize="30" data-fontsize="38" data-fgcolor="#81cef2" data-bgcolor="#dcdcdc"></div>
						</div>
						<div class="graph_title right"><img src="/images/graph/graph_icon_humidity.png" width="26" height="42" alt=""/>
							<p><?php echo __('sensor_data.titles.humidity'); ?></p>
						</div>
					</div>
				</li>
				<li class="graph_tile">
					<div class="graph_set">
						<p class="graph_rank"> </p>
						<div class="graph_chart">
							<div class="myStat" id="data_active" data-dimension="153" data-text="" data-percent="" data-info="" data-width="60" data-bordersize="30" data-fontsize="38" data-fgcolor="#eb71b6" data-bgcolor="#dcdcdc" ></div>
						</div>
						<div class="graph_title right"><img src="/images/graph/graph_icon_motion.png" width="19" height="37" alt=""/>
							<p><?php echo __('sensor_data.titles.amount_of_exercise'); ?></p>
						</div>
					</div>
				</li>
				<li class="graph_tile">
					<div class="graph_set">
						<p class="graph_rank">     </p>
						<div class="graph_chart">
							<div class="myStat" id="data_illuminance" data-dimension="153" data-text="" data-percent="" data-info="" data-width="60" data-bordersize="30" data-fontsize="38" data-fgcolor="#ffef00" data-bgcolor="#dcdcdc" ></div>
						</div>
						<div class="graph_title right"><img src="/images/graph/graph_icon_light.png" width="22" height="38" alt=""/>
							<p><?php echo __('sensor_data.titles.illuminance'); ?></p>
						</div>
					</div>
				</li>

				<li id="wbgtPanel" class="graph_tile" style="<?php echo $is_wbgt_month ? '' : 'display: none;'?>">
					<div class="graph_set">
						<p class="graph_rank">    </p>
						<div class="graph_chart">
							<div class="myStat" id="data_wbgt" data-dimension="153" data-text="" data-percent="" data-info="" data-width="60" data-bordersize="30" data-fontsize="38" data-fgcolor="#2baa3f" data-bgcolor="#dcdcdc" ></div>
						</div>
						<div class="graph_title right"><img src="/images/graph/graph_icon_comfortable.png" width="31" height="31" alt=""/>
							<p><?php echo __('sensor_data.titles.risk_of_heatstroke'); ?></p>
						</div>
					</div>
				</li>

				<li id="coldPanel" class="graph_tile" style="<?php echo !$is_wbgt_month ? '' : 'display: none;'?>">
					<div class="graph_set">
						<p class="graph_rank">    </p>
						<div class="graph_chart">
							<div class="myStat" id="data_cold" data-dimension="153" data-text="" data-percent="" data-info="" data-width="60" data-bordersize="30" data-fontsize="38" data-fgcolor="#2baa3f" data-bgcolor="#dcdcdc" ></div>
						</div>
						<div class="graph_title right"><img src="/images/graph/graph_icon_comfortable.png" width="31" height="31" alt=""/>
							<p><?php echo __('sensor_data.titles.risk_of_cold'); ?></p>
						</div>
					</div>
				</li>

<?php
/* 不快指数
				<li class="graph_tile">
					<div class="graph_set">
						<p class="graph_rank">    </p>
						<div class="graph_chart">
							<div class="myStat" id="data_discomfort" data-dimension="153" data-text="" data-percent="" data-info="" data-width="60" data-bordersize="30" data-fontsize="38" data-fgcolor="#2baa3f" data-bgcolor="#dcdcdc" ></div>
						</div>
						<div class="graph_title"><img src="/images/graph/graph_icon_comfortable.png" width="31" height="31" alt=""/>
							<p>不快指数</p>
						</div>
					</div>
				</li>
*/
?>
                                <li class="graph_error">
                                    <div id="graph_error"></div>
                                </li>
			</ul>
                        
			<!-- /現在のグラフ --> 
			
			<!-- 24時間グラフ -->
			<h2 class="content_h2"><?php echo __('user.index.24_hour_graph'); ?></h2>
			<table class="graph24_select lazy">
				<tr>
					<th><?php echo __('user.index.item_selection'); ?></th>
					<td class="clearfix"><input type="checkbox" id="graph_temperature" class="graph_checkbox">
						<label for="graph_temperature" class="checkbox"><?php echo __('sensor_data.titles.temperature'); ?> <img src="/images/graph/graph_select_01.png" width="25" height="9" alt=""/></label>
						<input type="checkbox" id="graph_humidity" class="graph_checkbox">
						<label for="graph_humidity" class="checkbox"><?php echo __('sensor_data.titles.humidity'); ?> <img src="/images/graph/graph_select_02.png" width="25" height="9" alt=""/></label>
						<input type="checkbox" id="graph_active" class="graph_checkbox">
						<label for="graph_active" class="checkbox"><?php echo __('sensor_data.titles.amount_of_exercise'); ?> <img src="/images/graph/graph_select_03.png" width="25" height="15" alt=""/></label>
						<input type="checkbox" id="graph_illuminance" class="graph_checkbox">
						<label for="graph_illuminance" class="checkbox"><?php echo __('sensor_data.titles.illuminance'); ?> <img src="/images/graph/graph_select_04.png" width="25" height="9" alt=""/></label>
						<br>
						<input type="checkbox" id="graph_wake_up_time" class="graph_checkbox">
						<label for="graph_wake_up_time" class="checkbox"><?php echo __('sensor_data.titles.time_of_awakening'); ?> <img src="/images/graph/graph_select_06.png" width="15" height="15" alt=""/></label>
						<input type="checkbox" id="graph_sleep_time" class="graph_checkbox">
						<label for="graph_sleep_time" class="checkbox"><?php echo __('sensor_data.titles.time_of_sleep'); ?> <img src="/images/graph/graph_select_07.png" width="15" height="15" alt=""/></label></td>
				</tr>
			</table>
			<div class="graph24_select_arrow"><img src="/images/graph/graph_select_arrow.png" width="21" height="16" alt=""/></div>

			<div class="graph24_chart_line">
				<div class="graph24_hdr">
					<p class="graph24_day"><?php echo __('date.today'); ?> <span id="today"></span>（<span id="today_week"></span>）</p>
					<ul>
						<li class="graph24_back"><a id="prev_date" class="change_date" href="javascript:void(0)" data-date=""><img src="/images/graph/graph_arrow_blue_back.png" width="12" height="19" alt=""/></a></li>
						<li class="graph24_next"><a id="next_date" class="change_date" href="javascript:void(0)" data-date=""><img src="/images/graph/graph_arrow_blue_next.png" width="12" height="19" alt=""/></a></li>
					</ul>
					<div class="graph24_calendar">
						<a id="def-html" class="box" data-tooltip="#graph24_cal_select"><img src="<?php echo $graph_btn_calender_image; ?>" width="90" height="41" alt=""/></a>
						<!-- カレンダー表示内容 -->
						<div id="graph24_cal_select" style="display:none;">
							<div class="graph24_cal_selectInner">
							<ul class="graph24_cal_head clearfix">
								<li class="graph24_cal_back"><span>&lt;</span></li>
								<li class="graph24_cal_thisMonth"><span class="slide_btn calendar_year_month"></span>
									<div class="graph24_cal_otherMonth">
										<p class="pdt0 pdb"><?php echo __('user.index.choose_the_year_month'); ?></p>
										<div class="common_select">
											<select class="calendar_year_select">
												<option value="2016" selected>2016<?php echo __('date.prompts.year'); ?></option>
												<option value="2017">2017<?php echo __('date.prompts.year'); ?></option>
												<option value="2018">2018<?php echo __('date.prompts.year'); ?></option>
												<option value="2019">2019<?php echo __('date.prompts.year'); ?></option>
											</select>
										</div>
										<div class="common_select mgt15 mgb20">
											<select name="calendar_month_select" class="calendar_month_select">
												<option value="1"><?php  echo __('date.abbr_month_names.jan'); ?></option>
												<option value="2"><?php  echo __('date.abbr_month_names.feb'); ?></option>
												<option value="3"><?php  echo __('date.abbr_month_names.mar'); ?></option>
												<option value="4"><?php  echo __('date.abbr_month_names.apr'); ?></option>
												<option value="5"><?php  echo __('date.abbr_month_names.may'); ?></option>
												<option value="6"><?php  echo __('date.abbr_month_names.jun'); ?></option>
												<option value="7"><?php  echo __('date.abbr_month_names.jul'); ?></option>
												<option value="8"><?php  echo __('date.abbr_month_names.aug'); ?></option>
												<option value="9"><?php  echo __('date.abbr_month_names.sep'); ?></option>
												<option value="10"><?php echo __('date.abbr_month_names.oct'); ?></option>
												<option value="11"><?php echo __('date.abbr_month_names.nov'); ?></option>
												<option value="12"><?php echo __('date.abbr_month_names.dec'); ?></option>
											</select>
										</div>
										<span class="slide_btn_back btn_red mgb10 slide_btn_ok"><?php echo __('ok'); ?></span>
										<span class="slide_btn_back btn_text"><?php echo __('cancel'); ?></span>
									</div>
								</li>
								<li class="graph24_cal_next"><span>&gt;</span></li>
							</ul>



							<table class="graph24_cal_table">
								<thead>
									<tr>
										<th role="columnheader" aria-label="<?php echo __('date.day_names.sun'); ?>"><?php echo __('date.abbr_day_names.sun'); ?></th>
										<th role="columnheader" aria-label="<?php echo __('date.day_names.mon'); ?>"><?php echo __('date.abbr_day_names.mon'); ?></th>
										<th role="columnheader" aria-label="<?php echo __('date.day_names.tue'); ?>"><?php echo __('date.abbr_day_names.tue'); ?></th>
										<th role="columnheader" aria-label="<?php echo __('date.day_names.wed'); ?>"><?php echo __('date.abbr_day_names.wed'); ?></th>
										<th role="columnheader" aria-label="<?php echo __('date.day_names.thu'); ?>"><?php echo __('date.abbr_day_names.thu'); ?></th>
										<th role="columnheader" aria-label="<?php echo __('date.day_names.fri'); ?>"><?php echo __('date.abbr_day_names.fri'); ?></th>
										<th role="columnheader" aria-label="<?php echo __('date.day_names.sat'); ?>"><?php echo __('date.abbr_day_names.sat'); ?></th>
									</tr>
								</thead>
								<tbody class="calendar_body"></tbody>
							</table>
						
						
							<!--
							<div class="graph24_btnArea">
							<button class="btn_text graph24_cal_today" type="button"><?php echo __('date.today'); ?></button>
							</div>
							-->
						</div>
						</div>
						<!-- /カレンダー表示内容 --> 
					</div>
				</div>
				<div class="graph24_lineArea" id="graph" style="min-width: 720px; height: 328px; margin: 0 auto"></div>
			</div>
			<!-- /24時間グラフ --> 
                        <div id="graph24_error"></div> 
		</section>
		<!-- /content end --> 
<?php
}
?>
