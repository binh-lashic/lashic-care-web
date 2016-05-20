$(function(){
    var apiUrl = "http://careeye.jp/api/";

    // ユーザ定義関数
    function api(action, params, callback){
	    $.post(
			apiUrl + action,
			params, 
			callback,
			"json"
	    );
    }

/*
	api("user/login_check", null, function(result){
		console.log(result.data);
	});
*/
/*
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
*/
	if(typeof sensor_id != "undefined") {
		drawGraph();
	}

	$(".graph_checkbox").change(function() {
		drawGraph();
	});

	$(".link_back").click(function() {
		history.back();
	});


	$(".save_alert").click(function() {
		var id = $(this).attr('data-id');
		var confirm = $("#confirm" + id).val();
		var expiration_hour = $("#expiration_hour" + id).val();
		api("alert/save", { id : id, confirm_status : confirm,expiration_hour: expiration_hour}, function(result){
			hide_body(id);
		});
	});

	$("#checkAll").change(function() {
		if($("#checkAll").prop('checked')) {
			$(".alert_check").prop("checked",true);
		}
		
	});

	$(".confirm_status_top").change(function() {
		$(".confirm_status_bottom").val($(".confirm_status_top").val());
	});

	$(".confirm_status_bottom").change(function() {
		$(".confirm_status_top").val($(".confirm_status_bottom").val());
	});

	$(".calendar_year_select").change(function() {
		console.log($(".calendar_year_select").val());
	});

	$(".calendar_month_select").change(function() {
		console.log($(".calendar_month_select option:selected").val());
	});

	$(".graph_setting").click(function() {
		//センサーの設定
		var params = {
			id:$('#sensor_id').val(),
			temperature_level:$('#temperature_level').val(),
			fire_level:$('#fire_level').val(),
			heatstroke_level:$('#heatstroke_level').val(),
			mold_mites_level:$('#mold_mites_level').val(),
			humidity_level:$('#humidity_level').val(),
			illuminance_daytime_level:$('#illuminance_daytime_level').val(),
			illuminance_night_level:$('#illuminance_night_level').val(),
			wake_up_level:$('#wake_up_level').val(),
			sleep_level:$('#sleep_level').val(),
			abnormal_behavior_level:$('#abnormal_behavior_level').val(),
			active_non_detection_level:$('#active_non_detection_level').val(),
			active_night_level:$('#active_night_level').val(),
		};
		api("sensor/save", params, function(result){
			console.log("sensor success");
		});

		//ユーザごとの設定
		var params = {
			user_id:$('#user_id').val(),
			sensor_id:$('#sensor_id').val(),
			temperature_alert:$('#temperature_alert').hasClass("mail_on") ? 1 : 0,
			fire_alert:$('#fire_alert').hasClass("mail_on") ? 1 : 0,
			heatstroke_alert:$('#heatstroke_alert').hasClass("mail_on") ? 1 : 0,
			mold_mites_alert:$('#mold_mites_alert').hasClass("mail_on") ? 1 : 0,
			humidity_alert:$('#humidity_alert').hasClass("mail_on") ? 1 : 0,
			illuminance_daytime_alert:$('#illuminance_daytime_alert').hasClass("mail_on") ? 1 : 0,
			illuminance_night_alert:$('#illuminance_night_alert').hasClass("mail_on") ? 1 : 0,
			wake_up_alert:$('#wake_up_alert').hasClass("mail_on") ? 1 : 0,
			sleep_alert:$('#sleep_alert').hasClass("mail_on") ? 1 : 0,
			abnormal_behavior_alert:$('#abnormal_behavior_alert').hasClass("mail_on") ? 1 : 0,
			active_non_detection_alert:$('#active_non_detection_alert').hasClass("mail_on") ? 1 : 0,
			active_night_alert:$('#active_night_alert').hasClass("mail_on") ? 1 : 0,
		};
		api("/user/sensor/save", params, function(result){
			console.log("user sensor success");
		});
	});
	function drawGraph() {
		api("data/graph?sensor_id=" + sensor_id + "&type=temperature&span=10&date=" + date, null, function(result){
			console.log("drawGraph");
			var values = [];
			var graphs = [];
			if($("#graph_wake_up_time").prop('checked') || $("#graph_sleep_time").prop('checked')) {
				api("data/dashboard?sensor_id=" + sensor_id + "&date=" + date, null, function(result){
					/*
					if($("#graph_wake_up_time").prop('checked')) {
						graphs.push({
						        "valueAxis": "wake_up_time",
						        "bullet": "round",
						        "bulletBorderAlpha": 1,
						        "bulletSize": 8,
						        "bulletColor": "#FFFFFF",
						        "title": "湿度",
						        "valueField": "humidity",
								"fillAlphas": 0
							});							
					}*/
				});
			}		
			if($("#graph_temperature").prop('checked')) {
				values.push({
				        "id":"temperature",
				        "color": "#FF9900",
				        "gridAlpha": 0,
				        "axisAlpha": 0,
				        "position": "left"
				    });
				graphs.push({
				        "valueAxis": "temperature",
				        "lineColor": "#FF9900",
				        "lineThickness": 2,
				        "title": "室温",
				        "connect": false,
				        "valueField": "temperature",
					});			
			}
			if($("#graph_humidity").prop('checked')) {
				values.push({
				        "id":"humidity",
				        "axisColor": "#88D3F5",
				        "axisThickness": 2,
				        "gridAlpha": 0,
				        "axisAlpha": 1,
				        "position": "left",
       					"offset": values.length * 50,
				    });
				graphs.push({
				        "valueAxis": "humidity",
				        "lineColor": "#88D3F5",
				        "lineThickness": 2,
				        "title": "湿度",
				        "connect": false,
				        "valueField": "humidity",
					});			
			}
			if($("#graph_illuminance").prop('checked')) {
				values.push({
				        "id":"illuminance",
				        "axisColor": "#DED31C",
				        "axisThickness": 2,
				        "gridAlpha": 0,
				        "axisAlpha": 1,
				        "position": "left",
       					"offset": values.length * 50,
				    });
				graphs.push({
				        "valueAxis": "illuminance",
				        "lineColor": "#DED31C",
				        "lineThickness": 2,
				        "title": "照度",
				        "connect": false,
				        "valueField": "illuminance",
					});			
			}
			if($("#graph_active").prop('checked')) {
				values.push({
				        "id":"active",
				        "axisColor": "#EB71B6",
				        "axisThickness": 2,
				        "gridAlpha": 0,
				        "axisAlpha": 1,
				        "position": "left",
       					"offset": values.length * 50,
				    });    
				graphs.push({
						"valueAxis": "active",
						"lineColor": "#EB71B6",
				        "columnWidth": 1,
				        "fillAlphas": 1,
				        "title": "運動量",
				        "type": "column",
				        "connect": false,
				        "valueField": "active",
				    });			
			}
			var chart = AmCharts.makeChart("graph", {
			    "type": "serial",
			    "theme": "light",
			    "legend": {
			        "useGraphSettings": true
			    },
			    "dataProvider": result.data,
			    "valueAxes": values,
			    "graphs": graphs,
			    "chartCursor": {
			        "cursorPosition": "mouse"
			    },
			    "categoryField": "label",
			    "categoryAxis": {
			        "parseDates": false,
			        "axisColor": "#DADADA",
			        "minorGridEnabled": true
			    },
			});
		});			

	}
});