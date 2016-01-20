$(function(){
    console.log("hoge");
    var url = "http://infic.azurewebsites.net/";
    // ユーザ定義関数
    function api(action, params, callback){
	    $.post(
	      url + action,
	      params, 
	      callback(data),
	      "json"
	    );
    }

    $("#login").submit(function() {
//		console.log("login");
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