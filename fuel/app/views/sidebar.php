<?php
if(!empty($client)) {
?>	
		<!-- aide start -->
		<aside id="aside_userDate">
			<div class="aside_container">
				<div class="clearfix">
					<p class="aside_title"><?php echo __('sidebar.basic_data'); ?></p>
					<div class="aside_btn_edit"><a href="/user/info" class="btn_text"><?php echo __('edit'); ?></a></div>
				</div>
				<div class="aside_photo"><div class="aside_photoInner"><img src="<?php echo $client['profile_image']; ?>" width="179" height="179" alt=""/></div></div>
				
				<dl class="aside_userDetail clearfix">
				<dt><img src="/images/common/user_icon_birth.png" width="17" alt="<?php echo __('sidebar.birthday'); ?>"/></dt>
					<dd><?php echo date(__('date.format.ymd'), strtotime($client['birthday'])); ?><?php echo __('sidebar.age_format', ['age' => $client['age']]); ?></dd>
					<dt><img src="/images/common/user_icon_blood.png" width="19" alt="<?php echo __('sidebar.blood_type'); ?>"/></dt>
					<dd><?php echo __('sidebar.blood_type_format', ['blood_type' => $client['blood_type']]); ?></dd>
					<dt><img src="/images/common/user_icon_address.png" width="19" alt="<?php echo __('sidebar.address'); ?>"/></dt>
					<dd><?php echo $client['address']; ?></dd>
					<dt><img src="/images/common/user_icon_phone.png" width="19" alt="<?php echo __('sidebar.phone_number_1'); ?>"/></dt>
					<dd><?php echo $client['phone']; ?></dd>
					<dt><img src="/images/common/user_icon_phone.png" width="19" alt="<?php echo __('sidebar.phone_number_2'); ?>"/></dt>
					<dd><?php echo $client['cellular']; ?></dd>
				</dl>
<?php
if(!empty($client['emergency_name_1']) || !empty($client['emergency_name_2'])) {
?>
				<!-- 緊急連絡先 -->
				<div class="aside_emergency">
					<h3><img src="/images/common/user_icon_emergency.png" width="17" alt=""/> <?php echo __('sidebar.emergency_contact'); ?></h3>
					<ul>
<?php
if(!empty($client['emergency_name_1'])) {
?>
						<li>
							<dl>
								<dt><?php echo isset($client['emergency_name_1']) ? $client['emergency_name_1'] : ""; ?></dt>
								<dd><?php echo isset($client['emergency_phone_1']) ? $client['emergency_phone_1'] : ""; ?><br>
									<?php echo isset($client['emergency_cellular_1']) ? $client['emergency_cellular_1'] : ""; ?></dd>
							</dl>
						</li>
<?php
}
if(!empty($client['emergency_name_2'])) {
?>
						<li>
							<dl>
								<dt><?php echo isset($client['emergency_name_2']) ? $client['emergency_name_2'] : ""; ?></dt>
								<dd><?php echo isset($client['emergency_phone_2']) ? $client['emergency_phone_2'] : ""; ?><br>
									<?php echo isset($client['emergency_cellular_2']) ? $client['emergency_cellular_2'] : ""; ?></dd>
							</dl>
						</li>
<?php
}
?>
					</ul>
				</div>
				<!-- /緊急連絡先 -->
<?php
}
?>
				<!-- 連絡共有 -->
				<div class="aside_share">
				<h3><img src="/images/common/user_icon_share.png" width="32" alt=""/> <?php echo __('sidebar.contact_sharing'); ?><div class="aside_btn_edit"><a href="/user/info_option_form#share" class="btn_text"><?php echo __('edit'); ?></a></div></h3>
					<div class="aside_shareInner">
						<ul class="scroll_area">
<?php
if(!empty($admins)) {
	foreach($admins as $admin) {
?>
							<li><?php echo $admin['name']; ?></li>
<?php
	}
}
?>
						</ul>
					</div>
				</div>
				<!-- /連絡共有 -->
				
			</div>
		</aside>
<?php
}
?>
