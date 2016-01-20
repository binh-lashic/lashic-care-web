$(function(){
    console.log("hoge");
    var apiUrl = "http://infic.azurewebsites.net/api";
    // ユーザ定義関数
    function api(action, params, callback){
	    $.post(
	      apiUrl + action,
	      params, 
	      callback,
	      "json"
	    );
    }

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