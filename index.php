<?php
require_once 'class/geo.class.php';
$users = Geo::singleton();
$data = $users->get_geo();

error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Taguato Note</title>

    <!-- Bootstrap -->
    <script src="http://cdn.leafletjs.com/leaflet-0.7/leaflet.js"></script>
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7/leaflet.css" />
	<link rel="stylesheet" href="leaflet-gps.css" />
	<script src="leaflet-gps.js"/></script>
	<style type="text/css"> #map {widh: 50px;height: 580px;} </style>
	
    <link href="css/bootstrap.min.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>    
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    
    <link rel="stylesheet" href="css/dashboard.css">

<script type="text/javascript">

$(document).on("click", ".open-EditRow", function () {
     var myBookId = $(this).data('id');
     $(".modal-body #bookId").val( myBookId );
     // As pointed out in comments, 
     // it is superfluous to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});
</script>
<script type="text/javascript">
$(document).ready(function() {
$("#formNew").submit(function(event) {

    /* Stop form from submitting normally */
    event.preventDefault();

    /* Clear result div*/
    $("#result").html('');

    /* Get some values from elements on the page: */
    var valNew = $(this).serialize();

    /* Send the data using post and put the results in a div */
    $.ajax({
        url: 'instancias/insert_geo.php',
        type: 'post',
        data: valNew,
        success: function(){
	$('#myNew').modal('hide');
	alert("Exito!");
        setTimeout(function() {
			
        window.location.href = "index.php";
        }, 2000);


        },
        error:function(){
            alert("Error!");
            //$("#resultado").html('There is error while submit');
        }
    });
});
});
</script>  
    
    <script type="text/javascript">
$(document).ready(function() {
$("#formedit").submit(function(event) {

    /* Stop form from submitting normally */
    event.preventDefault();

    /* Clear result div*/
    $("#result").html('');

    /* Get some values from elements on the page: */
    var values = $(this).serialize();

    /* Send the data using post and put the results in a div */
    $.ajax({
        url: 'instancias/delete_geo.php',
        type: 'post',
        data: values,
        success: function(){
	$('#myModal').modal('hide');
	alert("Registro Borrado!");
        setTimeout(function() {
        window.location.href = "index.php";
        }, 2000);


        },
        error:function(){
            alert("Error en el procesamiento de datos!");
            //$("#resultado").html('There is error while submit');
        }
    });
});
});
</script>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Taguato Note</a>
        </div>
        <div class="navbar-collapse collapse">
          
	  <ul class="nav navbar-nav navbar-right">



         
          </ul>
        </div>
      </div>
    </div>
    <br>
    <div class="container-fluid">
      <div class="row">
        
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-1 main">

      <ul class="nav nav-tabs" role="tablist">
	  <li class="active"><a href="#home" role="tab" data-toggle="tab">Mapa</a></li>	  
	  <li><a href="#messages" role="tab" data-toggle="tab">Puntos de Referencia</a></li>
	  
	</ul>

<!-- Tab panes -->
		<div class="tab-content">
		  <div class="tab-pane active" id="home"><br><div id="map"></div><br><button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#myNew">Registrar</button></div>
<script language="javascript">

var map = L.map('map').setView([-25.5, -54.616667], 13);
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
    maxZoom: 18
}).addTo(map);
L.control.scale().addTo(map);
map.addControl( new L.Control.Gps() );

var popup = L.popup();

function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("Coordenadas " + e.latlng.toString())
        .openOn(map);	     
	     document.getElementById("cu").value=e.latlng.lat.toString();
	     document.getElementById("cd").value=e.latlng.lng.toString();
}

/*map.on('click', function(e) { alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
     var lar=e.latlng.lat;
	console.log(lar); 
	document.getElementById("co").value=lar;

 })*/

map.on('click', onMapClick);


	</script>
		  
		  
		  
		  
		  <div class="tab-pane" id="messages">
		  <br>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Descripcion</th>
                  <th>Latitud</th>
                  <th>Longitud</th>                  
                  <th>Eliminar</th>
                </tr>
              </thead>
              <tbody>
            <?php
            foreach($data as $fila):
            ?>
	        <tr>
									<td id="du<?=$fila['id']?>"><?=$fila['descri']?></td>
									<td id="dd<?=$fila['id']?>"><?=$fila['lat']?></td>
									<td id="dt<?=$fila['id']?>"><?=$fila['lng']?></td>									
									<td id="eliminar"><a class="open-EditRow btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" data-id="<?=$fila['id']?>">
  <span class="glyphicon glyphicon-remove"></span> Eliminar
</a></td>									 								
									</tr>
						
					
					
					<?php
            endforeach;
            ?>
              </tbody>
            </table>
          </div>
		  </div>
		  
		  
		  
		</div>     
	<!-- disponilbe -->
        </div>
      </div>
    </div>



<div class="modal fade" id="myNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Registrar</h4>
      </div>
      <div class="modal-body">
	 <form name="formNew" id="formNew" role="form">
           <div class="form-group">
             <label for="nombrecliente">Descripcion</label>
             <input class="form-control" type="text" name="descri" id="desci" placeholder="Descripcion" required autofocus>		
           </div>
           <div class="form-group">
             <label for="dircliente">Latitud</label>
             <input class="form-control" type="text" name="cu" id="cu" placeholder="Latitud" required>		
           </div>
           <div class="form-group">
             <label for="dircliente">Longitud</label>
             <input class="form-control" type="text" name="cd" id="cd" placeholder="Longitud" required>		
           </div>	
           <div id="resultado"></div>   
             <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
               <button type="submit" class="btn btn-primary">Aceptar</button>
             </div> 
             <input type="hidden" name="Newcli" id="Newcli" value="Newcli" >       
	 </form>
      </div>    
    </div>
  </div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Mensaje</h4>
      </div>
      <div class="modal-body">
        Desea eliminar el registro?
	 <form name="formedit" id="formedit">
          <input type="hidden" name="bookId" id="bookId" value="" >
         	<div id="resultado"></div>   
             <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
               <button type="submit" class="btn btn-primary">Aceptar</button>
             </div>        
	 </form>
      </div>    
    </div>
  </div>
</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
    
    <script src="js/tab.js"></script>
  
  </body>
</html>

