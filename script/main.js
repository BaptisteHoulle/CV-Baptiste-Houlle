$(document).ready(function () {
  $('#header').parallax("center", 0, 0.1, true);
})


// Menu -----------------------------------------------
const navbar = document.querySelector('nav');

window.addEventListener('scroll', () => {
  if (window.scrollY > 50) {
    navbar.classList.remove('white')
  } else if (window.scrollY < 80) {
    navbar.classList.add('white')
  }
});


window.addEventListener('scroll', event => {
  let navigationLinks = document.querySelectorAll('nav ul li a');
  let fromTop = window.scrollY;
 
  navigationLinks.forEach(link => {
    let section = document.querySelector(link.hash);
   
    if (
      section.offsetTop <= fromTop &&
      section.offsetTop + section.offsetHeight > fromTop
    ) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });
});