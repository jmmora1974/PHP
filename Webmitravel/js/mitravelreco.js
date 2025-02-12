
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





//Ponemos en marcha el carrusel
const interval = setInterval(correCarrusel, 5000);
window.correCarrusel();