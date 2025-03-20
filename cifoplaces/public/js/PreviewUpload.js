/** 
 *  Función que muestra la imagen previa antes de subirla
 * 
 * Requiere el siguiente codigo en el HTML
 * 
 		
		//este div muestra el preview de la imagen

		<div id="previewcanvascontainer">
		<canvas id="previewcanvas">
		</canvas>
		</div>
		
		//Este form contiene el <input File> y lleva la accion a otra pagina php.
		
		<form action="/uploadfile.php" enctype="multipart/form-data" method="post">
		   <input type="file" id="foto" onchange="return ShowImagePreview( this.files );" />
		  
</form>
*/

function ShowImagePreview( files )
{
    if( !( window.File && window.FileReader && window.FileList && window.Blob ) )
    {
      alert('Esta API no esta soportada en su navegdor.');
      return false;
    }

    if( typeof FileReader === "undefined" )
    {
        alert( "Filereader no definido!" );
        return false;
    }

    var file = files[0];

    if( !( /image/i ).test( file.type ) )
    {
        alert( "El fichero no es una imagen." );
        return false;
    }

    reader = new FileReader();
    reader.onload = function(event) 
            { var img = new Image; 
              img.onload = UpdatePreviewCanvas; 
              img.src = event.target.result;  }
    reader.readAsDataURL( file );
}

function UpdatePreviewCanvas()
{
    var img = this;
    var canvas = document.getElementById( 'previewcanvas' );

    if( typeof canvas === "undefined" 
        || typeof canvas.getContext === "undefined" )
        return;

    var context = canvas.getContext( '2d' );

    var world = new Object();
    world.width = canvas.offsetWidth;
    world.height = canvas.offsetHeight;

    canvas.width = world.width;
    canvas.height = world.height;

    if( typeof img === "undefined" )
        return;

    var WidthDif = img.width - world.width;
    var HeightDif = img.height - world.height;

    var Scale = 0.0;
    if( WidthDif > HeightDif )
    {
        Scale = world.width / img.width;
    }
    else
    {
        Scale = world.height / img.height;
    }
    if( Scale > 1 )
        Scale = 1;

    var UseWidth = Math.floor( img.width * Scale );
    var UseHeight = Math.floor( img.height * Scale );

    var x = Math.floor( ( world.width - UseWidth ) / 2 );
    var y = Math.floor( ( world.height - UseHeight ) / 2 );

    context.drawImage( img, x, y, UseWidth, UseHeight );  
}