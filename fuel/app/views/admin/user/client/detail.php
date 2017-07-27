<style>
.modal {
  position:absolute;
  width:100%;
  height:100vh;
  top:0;
  left:0;
  display:none;
}
.overLay {
  position:absolute;
  top:0;
  left:0;
  background-color:rgba(0,0,0,0.50);
  width:100%;
  height:120%;
  z-index:1;
}
.modal .inner {
  position:absolute;
  z-index:2;
  top:50%;
  left:50%;
  height:130px;
  width:260px;
  padding:20px;
  background:#fff;
  transform:translate(-50%,-50%);
}
</style>
<script>
$(function(){
    $(".modalOpen").click(function(){
        $("#modal").fadeIn();
        $(this).addClass("open");
        return false;
    });
 
    $(".modalClose").click(function(){
        $(this).parents(".modal").fadeOut();
        $(".modalOpen").removeClass("open");
        return false;
    });
});
</script>
<div class="row">
	<div class="col-sm-12">
		<h2>見守られユーザ:<?php echo $user['last_name']; ?><?php echo $user['first_name']; ?></h2>
    <ul class="nav nav-tabs">
      <li role="presentation" class="active"><a href="/admin/user/client/detail?id=<?php echo $user['id']; ?>&parent_id=<?php echo $parent_id; ?>">詳細</a></li>
      <li role="presentation"><a href="/admin/user/client/sensor?id=<?php echo $user['id']; ?>&parent_id=<?php echo $parent_id; ?>">センサー機器割当</a></li>
    </ul>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">

		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr>
					<td class="info col-sm-3 text-right">システムID</td>
					<td class="col-sm-9">
						<?php echo $user['id']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">名前</td>
					<td>
						<?php echo $user['last_name']; ?><?php echo $user['first_name']; ?>(<?php echo $user['last_kana']; ?><?php echo $user['first_kana']; ?>)
					</td>
				</tr>
				<tr>
					<td class="info text-right">Eメール</td>
					<td>
						<?php echo $user['email']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">郵便番号</td>
					<td>
						<?php echo $user['zip_code']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">都道府県</td>
					<td>
						<?php echo $user['prefecture']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">住所</td>
					<td>
						<?php echo $user['address']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">電話番号1</td>
					<td>
						<?php echo $user['phone']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">電話番号2</td>
					<td>
						<?php echo $user['cellular']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">生年月日</td>
					<td>
						<?php echo $user['birthday']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">性別</td>
					<td>
						<?php echo $user['gender']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">流入元</td>
					<td>
						<?php echo $user['affiliate']; ?>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<button type="submit" class="btn btn-danger btn-sm modalOpen">
					  		<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> 削除する
						</button>
					</td>

				</tr>
			</table>
		</div>
	</div>

</div>
<div class="modal" id="modal">
    <div class="overLay modalClose"></div>
 
    <div class="inner" align="center">
    <?php echo Form::open(['action' => '/admin/user/client_delete', 'method' => 'post']); ?>
    <?php echo Form::hidden('id', $user['id']); ?>
    本当に削除しますか？<br /><br /><br />
    <?php echo Form::button('ok', '　OK　', ['class' => 'btn btn-default', 'type' => 'submit']);?>　
    <?php echo Form::button('ng', '　NG　', ['class' => 'modalClose btn btn-default']);?>
    <?php echo Form::close(); ?>
    </div>
</div>