
let slides = document.getElementsByClassName("mySlides");
let dots = document.getElementsByClassName("demo");
let captionText = document.getElementById("caption");

//Carusel de fotos
let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;


  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
} 




/**  paara que se cambien autmaticamente  
*/


let index = 1;
function correCarrusel () {
	plusSlides(index);
	console.log("toi en caro",index);
 
	if (index === slides.length ) {
		index = 1;
		console.log("toi en caro ini");
	  } else {
		index++;
		console.log("toi en caro +",index);
	  }
    showSlides(index);
 
 
};





//Creamos la ventana de chat de soporte


const form = document.getElementById("chat-form");
const inputchatsonic = document.getElementById("chat-input");
const messages = document.getElementById("chat-messages");

const botonchat = document.getElementById("buttonchat");

	//Creamos el listener del chatboot
	form.addEventListener("submit", async (event) => {
		event.preventDefault();
		let message = inputchatsonic.value;
		inputchatsonic.value = "";
		messages.innerHTML += `<div class="message">${message}</div>`;
		const respuestachat = await enviarPreguntaChat(message);

		message = respuestachat['message'];
		console.log("Respuesta chat IA : " + respuestachat['message']);
		messages.innerHTML += `<div class="message">${message}</div>`;
		inputchatsonic.value = "";
		// Llama a la API de Google Maps para mostrar l os resultados en el mapa
		/* const location = message;
		   const geocoder = new google.maps.Geocoder();
		   geocoder.geocode({ address: location }, (results, status) => {
			 if (status === "OK") {
			   mapapepemi.setCenter(results[0].geometry.location);
			   const marker = new google.maps.Marker({
				 map: mapapepemi,
				 position: results[0].geometry.location,
			   });
			 } else {
			   alert("Geocode was not successful for the following reason: " + status);
			 }
		   });
		   */

	});




	botonchat.addEventListener("click", () => {
		const caja = document.getElementById("containerchat");
		if (caja) { caja.resizeTo(20, 20); };
		// console.log("botonchat :"+botonchat.textContent);
		if (botonchat.textContent == "-") {
			slideDown(caja);
			botonchat.textContent = "+";
		}
		else {
			slideUp(caja);
			botonchat.textContent = "-";
		};


	});


	let slideUp = (target, duration = 500) => {
		let containerchat = document.getElementById("chat-container");
		console.log("chatbot maximizado");
		containerchat.style.height = 70 + '%';
		containerchat.style.width = 70 + '%';
		// containerchat.show();
	}

	let slideDown = (target, duration = 500) => {
		let containerchat = document.getElementById("chat-container");
		console.log("chatbot minimizado");

		containerchat.style.height = 30 + 'px';
		containerchat.style.width = 180 + 'px';
		//containerchat.hide();
	}

	let slideToggle = (target, duration = 500) => {

		if (target) {
			if (getComputedStyle(target).display === 'none') {
				return slideDown(target, duration);
			} else {
				return slideUp(target, duration);
			}
		};
	}


	//final widgetsPepemi.

const enviarPreguntaChat = (pregunta) => {
	const optionschat = {
		method: 'POST',
		headers: {
			accept: 'application/json',
			'content-type': 'application/json',
			'X-API-KEY': '54f8de3b-3214-4837-90d2-2af9e1ae3d3d'
		},
		body: JSON.stringify({
			enable_google_results: true,
			enable_memory: true,
			input_text: pregunta,
			history_data: []
		})
	};
	console.log("En la pregunta al chat IA");
	return fetch('https://api.writesonic.com/v2/business/content/chatsonic?engine=premium', optionschat)
		.then(response => response.json())
		.catch(err => console.error);


}


//Forzamos el click para minimizar el chat
document.getElementById("buttonchat").click();

//Ponemos en marcha el carrusel
const interval = setInterval(correCarrusel, 5000);
window.correCarrusel();