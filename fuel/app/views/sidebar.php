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
			</div>
		</aside>
<?php
}
?>
