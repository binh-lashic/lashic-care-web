	<div class="clearfix content"> 
		<!-- content start -->
		<section id="contentBox">
			<h1 class="content_h1 report_title_icon">確認・報告</h1>
			<h2 class="content_h2">情報を確認・報告してください</h2>
			
			<!-- 情報ソート -->
			<div id="report_sort">
				<dl class="clearfix">
					<dt>カテゴリー</dt>
					<dd>
						<input type="checkbox" id="i2">
						<label for="i2" class="checkbox">予定</label>
						<input type="checkbox" id="i3">
						<label for="i3" class="checkbox">起床</label>
						<input type="checkbox" id="i4">
						<label for="i4" class="checkbox">就寝</label>
						<input type="checkbox" id="i5">
						<label for="i5" class="checkbox">未行動</label>
						<input type="checkbox" id="i6" checked="checked">
						<label for="i6" class="checkbox">緊急</label>
					</dd>
					<dt>管理者確認</dt>
					<dd>
						<a href="/user/report?confirm_status=&corresponding_status=<?php echo $corresponding_status; ?>" class="report_sort_<?php echo !isset($confirm_status) || $confirm_status === "" ? "on" : "off"; ?>">すべて</a>
						<a href="/user/report?confirm_status=0&corresponding_status=<?php echo $corresponding_status; ?>" class="report_sort_<?php echo ($confirm_status === "0") ? "on" : "off"; ?>">未確認</a>
						<a href="/user/report?confirm_status=1&corresponding_status=<?php echo $corresponding_status; ?>" class="report_sort_<?php echo ($confirm_status === "1") ? "on" : "off"; ?>">確認済み</a>
					</dd>
				</dl>
				<a href="#" class="report_btn">表示変更</a>
			</div>
			<!-- /情報ソート --> 
			
			<form action="/user/report_save" method="post" name="alerts" id="alerts">			
<?php
if(isset($alert_count)) {
?>				
			<!-- ページ操作 -->
			<div class="report_pageBox clearfix">
				<div class="report_operation">
					<div class="report_select common_select clearfix">
						<select name="confirm_status" class="confirm_status_top">
							<option value="">選択項目一括操作</option>
							<option value="0">未対応にする</option>
							<option value="1">対応済みにする</option>
						</select>
					</div>
					<div class="report_btn_apply"><a href="javascript:void(0)" onclick="document.alerts.submit();return false;" class="btn_text">適用</a></div>
				</div>
				
				<div class="report_pager">
					<span class="report_pager_num"><?php echo $alert_count; ?>項目</span>
					<a href="/user/report?page=1&confirm_status=&corresponding_status=<?php echo $corresponding_status; ?>" class="report_pager_navspan btn_back_last report_true">&lt;&lt;</a> 
<?php
if(isset($page) && $page > 1) {
?>
					<a href="/user/report?page=<?php echo isset($prev_page) ? $prev_page : ""; ?>&confirm_status=&corresponding_status=<?php echo $corresponding_status; ?>" class="report_pager_navspan btn_back report_true">&lt;</a> 
<?php
} else {
?>
					<span class="report_pager_navspan btn_back report_false">&lt;</span> 
<?php
}
?>
					<input type="text" value="<?php echo isset($page) ? $page : 1; ?>"> / <span class="report_pager_pages"><?php echo $page_count; ?></span>
<?php
if(isset($page) && $page != $page_count) {
?>	
					<a href="/user/report?page=<?php if(isset($next_page) && $next_page <= $page_count) echo $next_page; ?>&confirm_status=&corresponding_status=<?php echo $corresponding_status; ?>" class="report_pager_navspan btn_next  report_true">&gt;</a> 
<?php
} else {
?>				
					<span class="report_pager_navspan btn_next  report_false">&gt;</span> 
<?php
}
?>
					<a href="/user/report?page=<?php echo $page_count; ?>&confirm_status=&corresponding_status=<?php echo $corresponding_status; ?>" class="report_pager_navspan btn_next_last report_true">&gt;&gt;</a> 
				</div>
				<!-- css説明：ページネーションのspanに.report_falseでボタン効かないデザインに変更 -->
			</div>
			<!-- /ページ操作 -->
<?php
}
?>						
			<!-- ページリスト -->
			<table class="report_pageList_table">
					<thead>
						<tr>
							<td><input type="checkbox" id="checkAll"><label for="checkAll" class="checkbox"></label></td>
							<th>日付</th>
							<th>カテゴリー</th>
							<th>発生時間</th>
							<th>内容確認状況</th>
							<th>最終確認者</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
<?php
if(isset($alerts)) {
	foreach($alerts as $alert) {
		$key = $alert['id'];
		$corresponding_statuses = array("未対応", "対応済", "対応予定", "対応不要");
?>
						<tr>
							<th><input type="checkbox" class="alert_check" id="check<?php echo $key; ?>" name="alerts[]" value="<?php echo $alert['id']; ?>"><label for="check<?php echo $key; ?>" class="checkbox"></label></th>
							<td><?php echo date("m/d", strtotime($alert['date'])); ?>（<?php echo Util::format_week(date("w", strtotime($alert['date']))); ?>）</td>
							<td>
<?php
if($alert['category'] === "night") {
?>
								<span class="report_category_shushin">夜間</span>
<?php
} else if($alert['category'] === "humidity") {
?>
								<span class="report_category_mikoudou">湿度</span>
<?php
} else if($alert['category'] === "wake_up") {
?>
								<span class="report_category_kishou">起床</span>
<?php
} else {
?>
								<span class="report_category_kinkyu">【緊急】</span>
<?php
}
?>
							</td>
							<td><?php echo date("H:i", strtotime($alert['date'])); ?></td>
							<td>
<?php
if($alert['confirm_status'] == 1) {
?>
								<span class="report_state_taiouzumi">対応済み</span>
<?php
} else {
?>
								<span class="report_state_mitaiou">未対応</span>
<?php
} 
?>
							</td>
							<td><?php if($alert['confirm_user']) echo $alert['confirm_user']['name']; ?></td>
							<td>
								<a name="1"></a>
								<span class="toggle" id="toggle_on<?php echo $key; ?>"><a href="javascript:show_body('<?php echo $key; ?>')" class="btn_text">確認・報告</a></span>
								<span class="toggle hide_btn" id="toggle_off<?php echo $key; ?>"><a href="javascript:hide_body('<?php echo $key; ?>')" class="btn_text">確認・報告</a></span>
							</td>
						</tr>
						<tr id="body<?php echo $key; ?>" class="hide_onload report_itemSet" style="display:none">
							<td colspan="7">
								<div class="report_arrow"></div>
								<div class="report_itemInner">
									<strong class="large"><?php echo date("m/d", strtotime($alert['date'])); ?>（<?php echo Util::format_week(date("w", strtotime($alert['date']))); ?>）</strong><br><?php echo $alert['description']; ?>
									<div class="clearfix mgt20">
												<div class="floatL common_select mgr20">
													<select id="confirm<?php echo $key; ?>">
														<option value="0"<?php if($alert['confirm_status'] == 0) { echo "selected=\"selected\""; } ?>>未確認</option>
														<option value="1"<?php if($alert['confirm_status'] == 1) { echo "selected=\"selected\""; } ?>>確認済み</option>
													</select>
												</div>
												　
												<div class="floatL common_select">
													<select id="expiration_hour<?php echo $key; ?>">
														<option value="">今すぐ</option>
														<option value="1">1時間後</option>
														<option value="2">2時間後</option>
														<option value="3">3時間後</option>
														<option value="4">4時間後</option>
														<option value="5">5時間後</option>
														<option value="6">6時間後</option>
														<option value="7">7時間後</option>
														<option value="8">8時間後</option>
														<option value="9">9時間後</option>
														<option value="10">10時間後</option>
														<option value="11">11時間後</option>
														<option value="12">12時間後</option>
														<option value="13">13時間後</option>
														<option value="14">14時間後</option>
														<option value="15">15時間後</option>
														<option value="16">16時間後</option>
														<option value="17">17時間後</option>
														<option value="18">18時間後</option>
														<option value="19">19時間後</option>
														<option value="20">20時間後</option>
														<option value="21">21時間後</option>
														<option value="22">22時間後</option>
														<option value="23">23時間後</option>
														<option value="24">24時間後</option>
													</select>
												</div>
												<div class="floatL pdt5">　に見守りを再開する</div>
												　
												<div class="floatR">
													<a class="btn_darkBlue save_alert" data-id="<?php echo $key; ?>">保存</a>
												</div>
											</div>
								</div>
							</td>
						</tr>
<?php
	}
}
?>
					</tbody>
			</table>
			<!-- /ページリスト -->
			
			
<?php
if(isset($alert_count)) {
?>
			<!-- ページ操作 -->
			<div class="report_pageBox clearfix">
				<div class="report_operation">
					<div class="report_select common_select clearfix">
						<select name="confirm_status" class="confirm_status_bottom">
							<option value="">選択項目一括操作</option>
							<option value="0">未対応にする</option>
							<option value="1">対応済みにする</option>
						</select>
					</div>
					<div class="report_btn_apply"><a href="javascript:void(0)" onclick="document.alerts.submit();return false;" class="btn_text">適用</a></div>
				</div>
				
				<div class="report_pager">
					<span class="report_pager_num"><?php echo $alert_count; ?>項目</span>
					<a href="/user/report?page=1" class="report_pager_navspan btn_back_last report_true">&lt;&lt;</a> 
<?php
if(isset($page) && $page > 1) {
?>
					<a href="/user/report?page=<?php echo isset($prev_page) ? $prev_page : ""; ?>" class="report_pager_navspan btn_back report_true">&lt;</a> 
<?php
} else {
?>
					<span class="report_pager_navspan btn_back report_false">&lt;</span> 
<?php
}
?>
					<input type="text" value="<?php echo isset($page) ? $page : 1; ?>"> / <span class="report_pager_pages"><?php echo $page_count; ?></span>
<?php
if(isset($page) && $page != $page_count) {
?>	
					<a href="/user/report?page=<?php if(isset($next_page) && $next_page <= $page_count) echo $next_page; ?>" class="report_pager_navspan btn_next  report_true">&gt;</a> 
<?php
} else {
?>				
					<span class="report_pager_navspan btn_next  report_false">&gt;</span> 
<?php
}
?>
					<a href="/user/report?page=<?php echo $page_count; ?>" class="report_pager_navspan btn_next_last report_true">&gt;&gt;</a> 
				</div>
				<!-- css説明：ページネーションのspanに.report_falseでボタン効かないデザインに変更 -->
			</div>
			<!-- /ページ操作 --> 
<?php
}
?>
			</form>
			
			
		</section>
		<!-- /content end --> 