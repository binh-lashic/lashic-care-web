$(function(){
    var apiUrl = "http://infic.papaikuji.info/api/";
    //var apiUrl = "http://infic.garoo.jp/api/";
    
    // ユーザ定義関数
    function api(action, params, callback){
	    $.post(
			apiUrl + action,
			params, 
			callback,
			"json"
	    );
    }

	api("user/login_check", null, function(result){
		console.log(result.data);
	});

    $("#login").submit(function() {
		var params = {
			'username': $("#username").val(),
			'password': $("#password").val()
		};
		api("user/login", params, function(result){
			if(result.data) {
				console.log(result.data);
				location.href = "/user/";
			}
		});
		return false;
	});
});