<!DOCTYPE html>
<html>
  <head>  <!-- www.techstrikers.com -->
    <meta name="viewport" content="width = device-width, initial-scale = 1.0">
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Add Landmark Form</title>
    <style type="text/css">
    

    </style>
    </head>

    <?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $db = "ogf";
    $conn = mysqli_connect($server, $user, $pass, $db);
    mysqli_set_charset($conn,"utf8");
    ?>
    <body>
    <div class="col-xs-1 col-lg-12 bg" id="map" style="width:100%;height:500px;float: left;"></div>
    <div class="col-xs-4 ">
    	<form name="addlandmarkform" id="addlandmarkform" action="" method="post">
    	<table align="" name = "addlandmark" id="addlandmark"  border="0" cellpadding="2" cellspacing="5">
    		<tr>
    		<td border = "0">
    		Add Landmark Form
    		</td>
    		</tr>
    		<tr>
    		<td >
    			<select name="branchid" id="branchid" onchange="seeid()">
    			<option value="">เลือกสำนักงาน</option>
    				<?php
    				$sql = "SELECT branch_id,branch_name FROM `branch` ORDER BY branch_id";
    				$res = mysqli_query($conn,$sql);
    					if($res){
      						while ($rec= mysqli_fetch_array($res,MYSQLI_ASSOC)) {
    					?>
   					<option value="<?php echo $rec['branch_name'] ?>"><?php  echo $rec['branch_id']." - ".$rec['branch_name'] ?></option>
    				<?php
    				}
    				}
    				?>
    			</select>
    		</td>
    		<td>
    			<input type="text" name="name of branch" id="branchname" value="" readonly>
    		</td>
    		</tr>
    		<tr>
    		<td>
    			ชื่อสถานที่
    		</td>
    		<td>
    			<input type="text" name="locationname" id="locationname" value="">
    		</td>
    		</tr>
    		<tr>
    		<td>
    			เกี่ยวกับสถานที่ 	    			
    		</td>
    		<td>
    			<textarea rows="4" cols="22"></textarea>
    		</td>    			
    		</tr>
    		<tr>
    			<td>
    				ละติจูด
    			</td>
    			<td>
    				<input type="text" name="lat_location" value="" id="lat_location" readonly>
    			</td>
    		</tr>
    		<tr>
    			<td>
    				ลองติจูด
    			</td>
    			<td>
    				<input type="text" name="lng_location" value="" id="lng_location" readonly>
    			</td>
    		</tr>
    	</table>
    	<button name="clear" type="reset" value="reset">clear</button>
    	<input type="submit" name="add" value="add" disabled="disabled" id="add">
    	</form>
        <a href="dootook.php"><input type="button" value="กด"></a>
    </div>
    <script type="text/javascript">
    var lat;
    var lng;
    var location_lat;
    var location_lng;
    var markers = [];
    var infowindow;
    var geocoder;

    lat = 7.90608272245317;
    lng = 98.36664140224457;

    function myMap() {
  	var mapCanvas = document.getElementById("map");
  	var myCenter=new google.maps.LatLng(lat,lng);
  	var mapOptions = {center: myCenter, zoom: 13};
  	var map = new google.maps.Map(mapCanvas, mapOptions);
  	geocoder = new google.maps.Geocoder;
  	infowindow = new google.maps.InfoWindow;

  	google.maps.event.addListener(map, 'click', function(event) {
    	placeMarker(geocoder,map, event.latLng,infowindow);
  		});
	}

 	function geocodeLatLng(geocoder, map, infowindow) {
        var input = document.getElementById('latlng').value;
        var latlngStr = input.split(',', 2);
        var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              map.setZoom(11);
              var marker = new google.maps.Marker({
                position: latlng,
                map: map
              });
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      }

	function placeMarker(geocoder,map, location,infowindow) {
  	var marker = new google.maps.Marker({
    position: location,
    map: map
  		});
  	var infowindow = new google.maps.InfoWindow({
    content: 'Latitude: ' + location.lat() +
    '<br>Longitude: ' + location.lng()
	});
	markers.push(marker);
	infowindow.open(map,marker);

	location_lat = marker.getPosition().lat();
	location_lng = marker.getPosition().lng();

	document.getElementById('lat_location').value = location_lat;
	document.getElementById('lng_location').value = location_lng;

	//console.log(markers.length);
	  if(markers.length>1){
        clearMarkers();
       	markers = [];
       	document.getElementById('lat_location').value ="" ;
		document.getElementById('lng_location').value = "";
        }

}

function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
              markers[i].setMap(map);
            }
          }

        function clearMarkers() {
          setMapOnAll(null);
        }

    function seeid(){
    	var branchlatlng;
    	branchlatlng =document.getElementById('branchname').value = document.getElementById('branchid').value;
    	console.log(branchlatlng);
    	if(branchlatlng=="ภูเก็ต"){
    		lat = 7.90608272245317;
    		lng = 98.36664140224457;
    		myMap();
    		document.getElementById('lat_location').value ="" ;
			document.getElementById('lng_location').value = "";
    	}
    	else if(branchlatlng =="หาดใหญ่"){
    		lat = 7.006341665683104;
    		lng = 100.4985523223877;
    		myMap();
    		document.getElementById('lat_location').value ="" ;
			document.getElementById('lng_location').value = "";
    	}
    	else if(branchlatlng == "อยุธยา"){
    		lat = 14.343238520299131;
    		lng = 100.60918271541595;
    		myMap();
    		document.getElementById('lat_location').value ="" ;
			document.getElementById('lng_location').value = "";

    	}
    	else if(branchlatlng == "สุราษฯ"){
    		lat = 9.11065637716888;
    		lng = 99.30181503295898;
    		myMap();
    		document.getElementById('lat_location').value ="" ;
			document.getElementById('lng_location').value = "";

    	}
    	else if(branchlatlng == "ศรีราชา"){
    		lat = 13.168317602040103;
    		lng = 100.93120604753494;
    		myMap();
    		document.getElementById('lat_location').value ="" ;
			document.getElementById('lng_location').value = "";

    	}
    	//myMap();
    }

    if(document.getElementById('lat_location').value ==''){
    	document.getElementByName('add').disabled = false;

    }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHlC_bwi0D_b86YE0ZN1hnymItuDb_5N0&callback=myMap"></script>
    <?php

    	//$sqlinsert = "INSERT INTO `branch_destination`(branch_destination_id,branch_destination_name,branch_id,lat_destination,lng_destination) VALUES (NULL,)"
    	//echo "i sis".$_GET['locationname'];
    	if(isset($_POST['branchid'])==false){

    	}
    	else {
    		$id;
    		if($_POST['branchid']== "ภูเก็ต"){
    			$id = 1;
    		}
    		else if($_POST['branchid']== "หาดใหญ่"){
    			$id = 2;

    		}
    		elseif ($_POST['branchid']== "อยุธยา") {
    			$id = 3;
    			# code...
    		}
    		elseif ($_POST['branchid']== "สุราษฯ") {
    			$id = 4;
    			# code...
    		}
    		else if($_POST['branchid']== "ศรีราชา"){
    			$id = 5;

    		}

    		$sqlinsert = "INSERT INTO `branch_destination`(branch_destination_id,branch_destination_name,branch_id,lat_destination,lng_destination) VALUES (NULL,'".$_POST['locationname']."',".$id.",'".$_POST['lat_location']."','".$_POST['lng_location']."')";
    		$insertres = mysqli_query($conn,$sqlinsert);
    		if($insertres){

    		}
    		else{
    			echo "add fail";
    		}

    	}
    ?>
    </body>
    </html>
