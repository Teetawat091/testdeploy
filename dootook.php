<!DOCTYPE html>
<html>
  <head>  <!-- www.techstrikers.com -->
  <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
  <!--<script type="text/javascript" src="js/html2canvas.js"></script>-->
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <title>Draggable directions</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
        float: left;
        width: 100%;

      }
      #floating-panel {
        position: absolute;
        top: 0px;
        left: 0%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 0px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
      #right-panel {
        float: right;
        width: 19%;
        height: 100%;
      }
      #right-panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }

      #right-panel select, #right-panel input {
        font-size: 15px;
      }

      #right-panel select {
        width: 100%;
      }

      #right-panel i {
        font-size: 12px;
      }

      .panel {
        height: 100%;
        overflow: auto;
      }

    </style>

    <div id="floating-panel">
    <form  action="todb.php" method="post">
    <?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $db = "ogf";
    $conn = mysqli_connect($server, $user, $pass, $db);
    mysqli_set_charset($conn,"utf8");
    ?>

    <strong>ประเภทของยานภาหนะ </strong>
    <select name="select" id="vihicle">
      <option value="car">รถยนต์</option>
      <option value="motercycle" selected="selected">มอเตอไซค์</option>
    </select>

    <select name="campus" id="campus" onchange="changecampus(this.selectedIndex)" >
    <option value="" selected="selected">สาขา</option>
      <?php
    $sql = "SELECT branch_name,branch_lat,branch_lng FROM `branch` ORDER BY branch_id";
    $res = mysqli_query($conn,$sql);
    if($res){
      while ($rec= mysqli_fetch_array($res,MYSQLI_ASSOC)) {
      $category = $rec['name'];
    ?>
   <option value="<?php echo $rec['branch_lat'].",".$rec['branch_lng'] ?>"><?php  echo $rec['branch_name'] ?></option>
    <?php
    }
    }
    ?>
    </select>
    <input type="submit" name="submit" value="Go" onclick="d()" id="takeshot" >
    <div id="subcats" align="left">
    <strong id="textselect" style="display:none">เลือกสถานที่ที่ต้องการจะไป</strong>

    <select id="Phuket" name="subcategory" style="display:none" onchange="ending(this.id)">
    <option value="" selected="selected">ต้องการจะไปที่</option>
    <?php
    $sqlphuket = "SELECT branch_destination_name,lat_destination,lng_destination FROM `branch_destination` WHERE branch_id = 1  ";
    $phuketres = mysqli_query($conn,$sqlphuket);
    if($phuketres){
      while ($pkrec= mysqli_fetch_array($phuketres,MYSQLI_ASSOC)) {
    ?>
   <option value="<?php echo $pkrec['lat_destination'].",".$pkrec['lng_destination'] ?>"><?php  echo $pkrec['branch_destination_name'] ?></option>
    <?php
    }
    }
    ?>
    </select>

    </select>
    <select  id="Hatyai" name="subcategory" style="display:none" onchange="ending(this.id)">
      <option value="">ไปยัง</option>
      <?php
    $sqlhatyai = "SELECT branch_destination_name,lat_destination,lng_destination FROM `branch_destination` WHERE branch_id = 2 ";
    $hatyaires = mysqli_query($conn,$sqlhatyai);
    if($hatyaires){
      while ($hrec= mysqli_fetch_array($hatyaires,MYSQLI_ASSOC)) {
    ?>
   <option value="<?php echo $hrec['lat_destination'].",".$hrec['lng_destination'] ?>"><?php  echo $hrec['branch_destination_name'] ?></option>
    <?php
    }
    }
    ?>
    </select>

    <select  id="Ayuthaya" name="subcategory" style="display:none" onchange="ending(this.id)">
      <option value="">ไปยัง</option>
      <?php
    $sqlayuthaya = "SELECT branch_destination_name,lat_destination,lng_destination FROM `branch_destination` WHERE branch_id = 3 ";
    $ayuthayares = mysqli_query($conn,$sqlayuthaya);
    if($ayuthayares){
      while ($arec= mysqli_fetch_array($ayuthayares,MYSQLI_ASSOC)) {
    ?>
   <option value="<?php echo $arec['lat_destination'].",".$arec['lng_destination'] ?>"><?php  echo $arec['branch_destination_name'] ?></option>
    <?php
    }
    }
    ?>
    </select>

    <select  id="Surat" name="subcategory" style="display:none" onchange="ending(this.id)">
      <option value="">ไปยัง</option>
     <?php
    $sqlsurat = "SELECT branch_destination_name,lat_destination,lng_destination FROM `branch_destination` WHERE branch_id = 4 ";
    $suratres = mysqli_query($conn,$sqlsurat);
    if($suratres){
      while ($srec= mysqli_fetch_array($suratres,MYSQLI_ASSOC)) {
    ?>
   <option value="<?php echo $srec['lat_destination'].",".$srec['lng_destination'] ?>"><?php  echo $srec['branch_destination_name'] ?></option>
    <?php
    }
    }
    ?>
    </select>

    <select  id="Sriraja" name="subcategory" style="display:none" onchange="ending(this.id)">
      <option value="">ไปยัง</option>
      <?php
    $sqlsiraja = "SELECT branch_destination_name,lat_destination,lng_destination FROM `branch_destination` WHERE branch_id = 5 ";
    $sirajares = mysqli_query($conn,$sqlsiraja);
    if($sirajares){
      while ($sirec= mysqli_fetch_array($sirajares,MYSQLI_ASSOC)) {
    ?>
   <option value="<?php echo $sirec['lat_destination'].",".$sirec['lng_destination'] ?>"><?php  echo $sirec['branch_destination_name'] ?></option>
    <?php
    }
    }
    ?>
    </select>

    </div>
      <input type="hidden" name="or" value="" id="or">
      <input type="hidden" name="en" value="" id="en">
      <input type="hidden" name="cam" value="" id="cam">
      <input type="hidden" name="total" value="" id="total">
      <input type="hidden" name="dyroute" value="" id = "dyroute">
      <input type="hidden" name="datetime" value="" id="datetime">

    </form>
    </div>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHlC_bwi0D_b86YE0ZN1hnymItuDb_5N0&callback=initMap"
        async defer></script>
        <script>
        var markers = [];
        var directionsDisplay;
        var directionsService;
        var campus;
        var lat_lng;
        var lat;
        var lng;
        var dynamicroute = [] ;

        lat_lng = {lat:7.90608272245317,lng:98.36664140224457};

        function initMap() {
          var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: lat_lng
          });
          google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(map, event.latLng);
          });
          directionsService = new google.maps.DirectionsService;
          directionsDisplay = new google.maps.DirectionsRenderer({
            draggable: true,
            map: map,
            panel: document.getElementById('right-panel')

          });
          directionsDisplay.addListener('directions_changed', function() {
            computeTotalDistance(directionsDisplay.getDirections());
          });
          var currentdate = new Date();
        var month = currentdate.getMonth();
          if(month<10){
            month = "0"+month;
          }
          var day = currentdate.getDay();
          if(day<10){
            day = "0"+day;
          }
          datetime = currentdate.getFullYear() + "-"+month
          + "-" + day + " "
          + currentdate.getHours() + ":"
          + currentdate.getMinutes() + ":" + currentdate.getSeconds();
          document.getElementById('datetime').value = datetime;
        }

        function displayRoute(origin, destination, service, display) {
          service.route({
            origin: origin,
            destination: destination,
            waypoints: [],
            travelMode: google.maps.TravelMode.DRIVING,
            avoidTolls: true
          }, function(response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
              display.setDirections(response);
            } else {
              //alert('Could not display directions due to: ' + status);
            }
          });
        }
        function placeMarker(map, location) {
          var marker = new google.maps.Marker({
            position: location,
            map: map,
          });
          markers.push(marker);
           lat = marker.getPosition().lat();
           lng = marker.getPosition().lng();
           seten(lat,lng);
        }

        /*function take_screenshot()
        {
        html2canvas(document.body, {
        onrendered: function(canvas)
        {
        var img = canvas.toDataURL()
        $.post("save_screenshot.php", {data: img}, function (file){
        window.location.href =  "save_screenshot.php?file="+ file
              });
            }
          });

        }*/

        function ending(id){
          var a= document.getElementById('en').value = document.getElementById(id).value;
          //alert(a);
          displayRoute(''+document.getElementById('or').value+'',''+a+'',directionsService,
            directionsDisplay);
          clearMarkers();
          markers = [];

          //document.getElementById('en').value = "";
        }

        function seten(lat,lng){
          var e = document.getElementById('en').value = lat+","+lng;
          //alert(typeof(e)+''+e+'');
          displayRoute(''+document.getElementById('or').value+'',''+e+'',directionsService,
            directionsDisplay);
          clearMarkers();
          markers = [];
          //document.getElementById('en').value = "";
        }

        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
              markers[i].setMap(map);
            }
          }

        function clearMarkers() {
          setMapOnAll(null);
        }

        function d(){
          //document.getElementById('vihicle').value =  document.getElementById('vihicle').value;
          document.getElementById('cam').value;
          document.getElementById('en').value ;
          var snap = "<?php echo snapshot();?>";

        }
        function changecampus(selectNo){
          document.getElementById('or').value = document.getElementById('campus').value;

          var sels = document.getElementById("subcats").getElementsByTagName('SELECT');
            for( var j=0; j<sels.length; j++ ) {
              sels[j].style.display = "none";
                if ( j===(selectNo-1) ) {
                  sels[j].style.display = '';

                }
            }

           if(document.getElementById('campus').value == "7.90608272245317,98.36664140224457"){
            lat_lng = {lat:7.90608272245317,lng:98.36664140224457};
            initMap();
            displayRoute(''+document.getElementById('or').value+'',''+document.getElementById('or').value+'',directionsService,
            directionsDisplay);
            document.getElementById('campus').selectedIndex = 1;
          }//phuket
          else if(document.getElementById('campus').value =="7.006341665683104,100.4985523223877"){
            lat_lng = {lat:7.006341665683104,lng:100.4985523223877};
            initMap();
           displayRoute(''+document.getElementById('or').value+'',''+document.getElementById('or').value+'',directionsService,
            directionsDisplay);
            document.getElementById('campus').selectedIndex = 2;
          }//hatyai
          else if(document.getElementById('campus').value == "13.168317602040103,100.93120604753494"){
            lat_lng = {lat:13.168317602040103,lng:100.93120604753494};
            initMap();
           displayRoute(''+document.getElementById('or').value+'',''+document.getElementById('or').value+'',directionsService,
            directionsDisplay);
            document.getElementById('campus').selectedIndex = 5;
          }//sriraja
          else if(document.getElementById('campus').value == "9.11065637716888,99.30181503295898"){
             lat_lng = {lat:9.11065637716888,lng:99.30181503295898};
            initMap();
            displayRoute(''+document.getElementById('or').value+'',''+document.getElementById('or').value+'',directionsService,
            directionsDisplay);
            document.getElementById('campus').selectedIndex = 4;
          }//surat
          else if(document.getElementById('campus').value == "14.343238520299131,100.60918271541595"){
            lat_lng = {lat:14.343238520299131,lng:100.60918271541595}
            initMap();
            displayRoute(''+document.getElementById('or').value+'',''+document.getElementById('or').value+'',directionsService,
            directionsDisplay);
            document.getElementById('campus').selectedIndex = 3;
          }

          }
          function computeTotalDistance(result) {
          var total = 0;
          var test;
          var myroute = result.routes[0];
          for (var i = 0; i < myroute.legs.length; i++) {
            total += myroute.legs[i].distance.value;
            dynamicroute[i]= JSON.stringify(myroute.legs[i].steps);
            //console.log(dynamicroute[0]);
            //console.log(myroute);
            }
          total = total / 1000;
          document.getElementById('total').value = total;
          console.log(dynamicroute.length);
          document.getElementById('dyroute').value = dynamicroute[0];
          //alert(JSON.stringify(dynamicroute));

          }
         
        </script>
      </head>
      <?php
      
       function snapshot(){
        $img = imagegrabscreen();
        imagepng($img,"img/snapshot.png");
        imagedestroy($img);
        }
      if(isset($_POST['campus'])==true){
        //snapshot();

      }
      else{
       //snapshot();
      }
      ?>
      <body onload="initMap()">
        <div id="map"></div>

        <div id="right-panel"></div>
      </body>
</html>
