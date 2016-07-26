$(function(){
    // ユーザ定義関数
    function api(action, params, callback){
	    $.post(
			"/api/" + action,
			params, 
			callback,
			"json"
	    );
    }

	$('#order_btn_delete').click(function(){
		Cookies.remove("cart_plan_id");
		$('#order_no').html('<p>何も入っていません</p>');
		$('.order_alert').fadeIn(1000).delay().fadeOut(1000);
	});

	if(typeof Cookies.get("cart_plan_id") != 'undefined') {
		var total_price = 0;
		$(".plan_message").css('display', 'block');

		var ids = JSON.parse(Cookies.get("cart_plan_id"));
		$.each(ids, function(index, id){
			$("#cart_form").append("<input type=\"hidden\" name=\"plan_ids[]\" value=\"" + id + "\" />");
			api("plan/get", { id : id }, function(result){
				var plan = result['data'];
				$("#plans").append("<tr><td>" + plan['title'] + "</td><td class=\"right\">" + plan['price'] + "円（税込）</td><td class=\"center\">" + plan['price'] + "円（税込）</td></tr>");
				total_price += parseInt(plan['price']);
				$("#total_price").html(total_price);
			});
		});

		$(".plan_total").css('display', 'table');
	}
});