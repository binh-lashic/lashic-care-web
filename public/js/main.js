$(function(){
    var apiUrl = "http://infic.azurewebsites.net/api/";
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
		console.log("login");
		var params = {
			'username': $("#username").val(),
			'password': $("#password").val()
		};
		api("user/login", params, function(data){
			console.log(data);
		});
		return false;
	});
});