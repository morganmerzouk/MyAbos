$(document).ready(function(){
    map = new OpenLayers.Map("map");
	
    var mapnik = new OpenLayers.Layer.OSM();
	
	var layer_cloud = new OpenLayers.Layer.XYZ(
	        "clouds",
	        "http://${s}.tile.openweathermap.org/map/clouds/${z}/${x}/${y}.png",
	        {
	            isBaseLayer: false,
	            opacity: 0.5,
	            sphericalMercator: true
	        }
	    );

    var layer_temp = new OpenLayers.Layer.XYZ(
	        "temperature",
	        "http://${s}.tile.openweathermap.org/map/temp/${z}/${x}/${y}.png",
	        {
	            isBaseLayer: false,
	            opacity: 0.7,
	            sphericalMercator: true
	        }
	    );	    
    var layer_pressure = new OpenLayers.Layer.XYZ(
	        "wind",
	        "http://${s}.tile.openweathermap.org/map/pressure/${z}/${x}/${y}.png",
	        {
	            isBaseLayer: false,
	            opacity: 0.3,
	            sphericalMercator: true
	        }
	    );
    var layer_wind = new OpenLayers.Layer.XYZ(
		        "wind",
		        "http://${s}.tile.openweathermap.org/map/wind/${z}/${x}/${y}.png",
		        {
		            isBaseLayer: false,
		            opacity: 0.3,
		            sphericalMercator: true
		        }
		    );
    layer_cloud.setVisibility(false);
    layer_wind.setVisibility(false);
    layer_pressure.setVisibility(false);
    layer_temp.setVisibility(false);
	map.addLayers([mapnik, layer_cloud, layer_wind, layer_pressure, layer_temp]);  	

	var lat = 15.0000, lon = -70.2000;
	var centre = new OpenLayers.LonLat(lon, lat);
	centre.transform(
	    new OpenLayers.Projection("EPSG:4326"),
	    new OpenLayers.Projection("EPSG:900913")
	);
    map.setCenter( centre, 5);

    $(".square-wind").on("click", function() {
    	$(".square-wind, .square-temperature, .square-cloud, .square-pressure").removeClass('active');
    	$(this).addClass("active");
        layer_cloud.setVisibility(false);
        layer_pressure.setVisibility(false);
        layer_temp.setVisibility(false);
        layer_wind.setVisibility(true);
    });
    $(".square-temperature").on("click", function() {
    	$(".square-wind, .square-temperature, .square-cloud, .square-pressure").removeClass('active');
    	$(this).addClass("active");
        layer_cloud.setVisibility(false);
        layer_pressure.setVisibility(false);
        layer_wind.setVisibility(false);
        layer_temp.setVisibility(true);
    });
    $(".square-cloud").on("click", function() {
    	$(".square-wind, .square-temperature, .square-cloud, .square-pressure").removeClass('active');
    	$(this).addClass("active");
        layer_pressure.setVisibility(false);
        layer_wind.setVisibility(false);
        layer_temp.setVisibility(false);
        layer_cloud.setVisibility(true);
    });
    $(".square-pressure").on("click", function() {
    	$(".square-wind, .square-temperature, .square-cloud, .square-pressure").removeClass('active');
    	$(this).addClass("active");
        layer_cloud.setVisibility(false);
        layer_wind.setVisibility(false);
        layer_temp.setVisibility(false);
        layer_pressure.setVisibility(true);
    });
    
});

