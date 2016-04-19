$(function(){
    var apiUrl = "http://infic.papaikuji.info/api/";
    
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

	$(".save_alert").click(function() {
		var id = $(this).attr('data-id');
		var confirm = $("#confirm" + id).val();
		var expiration_hour = $("#expiration_hour" + id).val();
		api("alert/save", { id : id, confirm_status : confirm,expiration_hour: expiration_hour}, function(result){
			hide_body(id);
		});
	});

	function drawGraph() {

		api("data/graph?sensor_id=" + sensor_id + "&type=temperature&span=10&date=" + date, null, function(result){
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
				        "valueField": "active"
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