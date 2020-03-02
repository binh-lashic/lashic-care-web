<div class="row">
	<div class="col-sm-12">
		<h2>ライセンスコード発行</h2>
	</div>
</div>
<!-- {% if session_get_flash('errors') %}
<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
	<strong>ライセンスコード発行でエラーが発生しました。</strong>
	{% set errors = session_get_flash('errors') %}
	<ul>
	{% for error in errors %}
		<li>{{ error }}</li>
	{% endfor %}
	</ul>
</div>
{% endif %} -->
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<p>
			<!-- <form action="/admin/licenses/create" class="form-horizontal" accept-charset="utf-8" method="post"> -->
            <?php echo Form::open(['action' => '/admin/licenses/create', 'method' => 'post', 'class' => 'form-horizontal']); ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form_quantity">数量</label>
					<div class="col-sm-1">
						<input class="form-control" name="quantity" value="" type="text" id="form_quantity" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form_license_id">種別</label>
					<div class="col-sm-10">
						<select class="col-sm-3 control-label" name="license_id" id="form_license_id">
                            <option value="1">12ヶ月(LASHIC-room)</option>
                            <option value="2">12ヶ月(LASHIC-sleep)</option>
                            <option value="3">12ヶ月(LASHIC-call)</option>
                        </select>
					</div>
				</div>
				<div class="form-group form-inline">
					<label class="col-sm-2 control-label" for="form_shipping_year">出荷日</label>
					<div class="col-sm-8">
						<select class="control-label" name="shipping_year" id="form_shipping_year">
                            <option value="">(未選択)</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                        </select>
						<label class="control-label" for="form_shipping_year">年</label>
						<select class="control-label" name="shipping_month" id="form_shipping_month">
                            <option value="">(未選択)</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
						<label class="control-label" for="form_shipping_month">月</label>
						<select class="control-label" name="shipping_day" id="form_shipping_day">
                            <option value="">(未選択)</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
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
                        </select>
						<label class="control-label" for="form_shipping_day">日</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form_status">ステータス</label>
					<div class="col-sm-10">
						<select class="col-sm-2 control-label" name="status" id="form_status">
                            <option value="0">未出荷</option>
                            <option value="1">出荷済</option>
                            <option value="2">利用済</option>
                        </select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a class="btn btn-default" href="/admin/licenses/all">一覧に戻る</a>
						<input class="btn btn-primary" name="create_license" value="発行" type="submit" id="form_create_license" />
					</div>
				</div>
				<input name="page" value="" type="hidden" id="form_page" />
				<!-- <input name="fuel_csrf_token" value="a60d4190cdd3973853914dc9c99336ebfb40eca63a6480119eed4acc3eb59c6d874d79f4a58c7c0ba8fbd97e89ad09d6b73b663d4e2bedfeb52825ccc7db8398" type="hidden" id="form_fuel_csrf_token" /> -->
            <?php echo Form::csrf() ?>
            <?php echo Form::close(); ?>
			<!-- </form> -->
			</p>
		</div>
	</div>
</div>