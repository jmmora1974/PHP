//Cuando cargue la ventana completamente
window.addEventListener('load',function(){
	var figuras = document.querySelectorAll('.gallery figure');
	
	//para cada figura de la galeria
	for (let figura of figuras) {
		figura.onclick = function(){  // tratamiento del evento click
			//cloa la figura en la que se ha hecho click y su contenido
			var nuevaFigura = this.cloneNode(true);
			
			nuevaFigura.className = 'grande';  //pone la clase grande (para CSS)
			
			//hace que se cierre la nueva figura al haceer click
			nuevaFigura.onclick = function(){
				this.remove();
			}
			
			document.body.appendChild(nuevaFigura);  //colocarla en el body
		}
		
	}
	
});