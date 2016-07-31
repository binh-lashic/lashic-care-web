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
		api("shopping/delete_plans", {}, function(result){
			$('#order_no').html('<p>何も入っていません</p>');
		});
		$('.order_alert').fadeIn(1000).delay().fadeOut(1000);
		return false;
	});

	displayCart();
	function displayCart() {
		var total_price = 0;
		api("shopping/get_plans", {}, function(result){
			if(result.data.plans != null) {
				$(".plan_message").css('display', 'block');
				$.each(result.data.plans, function(index, plan) {
					$("#plans").append("<tr><td>" + plan['title'] + "</td><td class=\"right\">" + plan['price'] + "円（税込）</td><td class=\"center\">" + plan['price'] + "円（税込）</td></tr>");
					total_price += parseInt(plan['price']);
				});
			}
			$("#total_price").html(total_price);
			$(".plan_total").css('display', 'table');
		});
	}
});