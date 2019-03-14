<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="/js/monthlyreport.js"></script>
<script type="text/javascript">
    var user_id = <?php echo $client['id']; ?>;
    var year = <?php echo $year; ?>;
    var month = <?php echo $month; ?>;
</script>
<style>
#loading{
    padding:15px;
    position: fixed;
    top:50%;
    left:50%;
}
#loading {
    text-align:center;
    padding-top:100px;
    width:100px;
    background-image:url("/images/common/loading.gif");
    background-position: center top;
    background-repeat: no-repeat;
}
#sleep_timeline  {
    width: 753px;
    height: 346px;
}
</style>
		<!-- content start -->
		<section id="contentBox">
			<h1 class="content_h1 monthly_title_icon"><?php echo __('user.index.user_state_of', ['user_name' => $client['last_name'].$client['first_name']]); ?></h1>
			<p><?php echo __('user.monthly.subtitle'); ?></p>
			<p class="montly_period"><?php echo $month_first; ?> -  <?php echo $month_last; ?></p>
			
			<!-- 傾向と対策 -->
			<section id="monthly_keikou">
				<h2 class="monthly_keikou_h2"><?php echo __('user.monthly.trend_and_countermeasures'); ?></h2>
				<ul class="monthly_keikou_list">
					<li>
						<dl>
							<dt><img src="/images/monthly/monthly_tit_undou.png" width="64" height="64" alt=""/></dt>
							<dd><span id="activity"></dd>
						</dl>
					</li>
					<li>
						<dl>
							<dt><img src="/images/monthly/monthly_tit_suimin.png" width="64" height="64" alt="運動"/></dt>
							<dd><span id="sleep"></dd>
						</dl>
					</li>
					<li>
						<dl>
							<dt><img src="/images/monthly/monthly_tit_kankyo.png" width="64" height="64" alt="睡眠"/></dt>
							<dd><span id="environment"></dd>
						</dl>
					</li>
					<li>
						<dl>
							<dt><img src="/images/monthly/monthly_tit_sonota.png" width="64" height="64" alt="その他"/></dt>
							<dd><span id="dementia"></dd>
						</dl>
					</li>
				</ul>
			</section>
			<!-- /傾向と対策 -->
			
			
			
			
			
			
			<!-- 運動量 -->
			<section id="monthly_undou">
				<h2 class="monthly_undou_h2 monthly_tit"><?php echo __('user.monthly.momentum'); ?></h2>
				<h3 class="content_h3"><?php echo __('user.monthly.monthly_trends'); ?></h3>
				<div id="activity_linechart" class="monthly_graph clearfix"></div>
				<h3 class="content_h3"><?php echo __('user.monthly.historical_average'); ?></h3>
				<div id="activity_columnchart" class="monthly_graph2 clearfix center"></div>
			</section>
			<!-- 運動量 -->
			
			
			
			
			
			
			<!-- 睡眠時間 -->
			<section id="monthly_suimin">
				<h2 class="monthly_suimin_h2 monthly_tit"><?php echo __('user.monthly.sleep_time'); ?></h2>
				<h3 class="content_h3"><?php echo __('user.monthly.monthly_trends'); ?></h3>
				<p class="right small mgb15"><span class="monthly_suimin_icon"><img src="/images/monthly/monthly_suimin_asai.png" width="20" height="5" alt=""/></span> <?php echo __('user.monthly.sleep'); ?></p>
				<div id="sleep_timeline" class="monthly_graph clearfix"></div>
				<h3 class="content_h3"><?php echo __('user.monthly.historical_average'); ?></h3>
				<div id="sleep_columnchart" class="monthly_graph2 clearfix center"></div>
			</section>
			<!-- 睡眠時間 -->
			
			
			
			
			
			
			<!-- 気温・湿度 -->
			<section id="monthly_kion">
				<h2 class="monthly_kion_h2 monthly_tit"><?php echo __('user.monthly.average_daily');?></h2>
				<h3 class="content_h3"><?php echo __('user.monthly.monthly_trends'); ?></h3>
				
				<div class="clearfix">
					<div class="monthly_kion_midashi">
						<h4 class="monthly_kion_h4 monthly_kion_h4_icon"><span><?php echo __('user.monthly.temperature'); ?></span></h4>
					</div>
					<div id="temperature_linechart" class="monthly_kion_graph"></div>
				</div>
				<p class="right small mgt10 mgb15"><span class="monthly_suimin_icon"><img src="/images/monthly/monthly_kion_line01.png" width="20" height="5" alt=""/></span><?php echo __('user.monthly.data_of', ['month' => $month]); ?></p>
				
				
				
				<div class="clearfix mgt30">
					<div class="monthly_kion_midashi">
						<h4 class="monthly_kion_h4 monthly_shitsudo_h4_icon"><span><?php echo __('user.monthly.humidity'); ?></span></h4>
					</div>
					<div id="humidity_linechart" class="monthly_kion_graph"></div>
				</div>
				<p class="right small mgt10 mgb15"><span class="monthly_suimin_icon"><img src="/images/monthly/monthly_shitsudo_line01.png" width="20" height="5" alt=""/></span> <?php echo __('user.monthly.data_of', ['month' => $month]); ?></p>
			</section>
			<!-- 気温・湿度 -->
			
			
			
			<!-- 異常通知 -->
<!--			<section id="monthly_ijou">
				<h2 class="monthly_ijou_h2 monthly_tit">異常通知</h2>
				<h3 class="content_h3">通知数</h3>
				<table width="100%" class="monthly_table">
					<tbody>
						<tr>
							<th scope="col">&nbsp;</th>
							<th scope="col">3ヶ月前</th>
							<th scope="col">2ヶ月前</th>
							<th scope="col">1ヶ月前</th>
							<th scope="col">今月</th>
						</tr>
						<tr>
							<td>運動</td>
							<td>3回</td>
							<td>2回</td>
							<td>1回</td>
							<td><strong>0回</strong></td>
						</tr>
						<tr>
							<td>室温</td>
							<td>0回</td>
							<td>1回</td>
							<td>2回</td>
							<td><strong>3回</strong></td>
						</tr>
						<tr>
							<td>湿度</td>
							<td>0回</td>
							<td>1回</td>
							<td>2回</td>
							<td><strong>3回</strong></td>
						</tr>
						<tr>
							<td>行動</td>
							<td>0回</td>
							<td>1回</td>
							<td>2回</td>
							<td><strong>3回</strong></td>
						</tr>
					</tbody>
				</table>
			</section>-->
			<!-- 異常通知 -->
		</section>
		<!-- /content end --> 
