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
					<dt>状態</dt>
					<dd><a href="/user/report?confirm_status=<?php echo $confirm_status; ?>&corresponding_status=" class="report_sort_<?php echo !isset($corresponding_status) || $corresponding_status === "" ? "on" : "off"; ?>">すべて</a>
						<a href="/user/report?confirm_status=<?php echo $confirm_status; ?>&corresponding_status=0" class="report_sort_<?php echo ($corresponding_status === "0") ? "on" : "off"; ?>">未対応</a>
						<a href="/user/report?confirm_status=<?php echo $confirm_status; ?>&corresponding_status=1" class="report_sort_<?php echo ($corresponding_status === "1") ? "on" : "off"; ?>">対応済み</a>
						<a href="/user/report?confirm_status=<?php echo $confirm_status; ?>&corresponding_status=2" class="report_sort_<?php echo ($corresponding_status === "2") ? "on" : "off"; ?>">対応予定</a>
						<a href="/user/report?confirm_status=<?php echo $confirm_status; ?>&corresponding_status=3" class="report_sort_<?php echo ($corresponding_status === "3") ? "on" : "off"; ?>">対応不要</a></dd>
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
			
			
<?php
if(isset($alert_count)) {
?>				
			<!-- ページ操作 -->
			<div class="report_pageBox clearfix">
				<div class="report_operation">
					<div class="report_select common_select clearfix">
						<select>
							<option value="">選択項目一括操作</option>
							<!-- <option value="">ゴミ箱に入れる</option>-->
							<option value="">未対応にする</option>
							<option value="">対応済みにする</option>
							<option value="">対応不要にする</option>
						</select>
					</div>
					<div class="report_btn_apply"><a href="#" class="btn_text">適用</a></div>
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
							<th>対応予定時間</th>
							<th>担当者</th>
							<th>管理者確認</th>
							<th>状態</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
<?php
if(isset($alerts)) {
	foreach($alerts as $alert) {
		$corresponding_statuses = array("未対応", "対応済", "対応予定", "対応不要");
?>
						<tr>
							<th><input type="checkbox" id="check20"><label for="check20" class="checkbox"></label></th>
							<td><?php echo date("m/d", strtotime($alert['date'])); ?>（<?php echo Util::format_week(date("w", strtotime($alert['date']))); ?>）</td>
							<td><span class="report_category_kinkyu">【緊急】</span></td>
							<td><?php echo date("H:i", strtotime($alert['date'])); ?></td>
							<td>12/28 （木） 08:30</td>
							<td>服部</td>
							<td><?php if($alert['confirm_status'] == 1) { echo "済"; } else { echo "未"; } ?></td>
							<td><span class="report_state_taiouhuyou"><?php echo $corresponding_statuses[(int)$alert['corresponding_status']]; ?></span></td>
							<td><!--<a href="#" class="btn_text">ゴミ箱</a>&nbsp;&nbsp;-->
								<a href="/user/report?id=<?php echo $alert['id']; ?>" class="btn_text">確認・報告</a></td>
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
						<select>
							<option value="">選択項目一括操作</option>
							<option value="">ゴミ箱に入れる</option>
							<option value="">未対応にする</option>
							<option value="">対応済みにする</option>
							<option value="">対応不要にする</option>
						</select>
					</div>
					<div class="report_btn_apply"><a href="#" class="btn_text">適用</a></div>
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
			
			
			
		</section>
		<!-- /content end --> 