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
		var subtotal_price = 0;
		var tax = 0;
		api("shopping/get_plans", {}, function(result){
			if(result.data.plans != null) {
				$(".plan_message").css('display', 'block');
				$.each(result.data.plans, function(index, plan) {
					console.log(plan);
					if(plan['span'] > 0) {
						quantity = plan['span'];
					} else {
						quantity = 1;
					}
					$("#plans").append("<tr><td>" + plan['title'] + "</td>" + 
						               "<td class=\"right\">" + parseInt(plan['options'][0]['unit_price']).toLocaleString() + "円（税抜）</td>" + 
						               "<td class=\"center\">" + quantity + "</td>" + 
						               "<td class=\"right\">" + plan['price'].toLocaleString() + "円（税抜）</td></tr>");
					subtotal_price += parseInt(plan['price']);
				});
				tax = Math.floor(subtotal_price * 0.08);
				total_price = subtotal_price + tax;
			}
			$("#tax").html(tax.toLocaleString());
			$("#total_price").html(total_price.toLocaleString());
			$(".plan_total").css('display', 'table');
		});
	}
});