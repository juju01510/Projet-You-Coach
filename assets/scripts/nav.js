// Ajout du background de couleur si scroll Y est supérieur à 0
const navBar = document.querySelector('#nav');

window.addEventListener('scroll', () => {
    if (window.scrollY > 0) {
        navBar.classList.add('nav-bg-color');
    } else {
        navBar.classList.remove('nav-bg-color');
    }
});

//Menu burger, ajout de la class mobile-menu à l'élément nav-links
const menuBurger = document.querySelector(".menu-burger")
const navLinks = document.querySelector(".nav-links")

menuBurger.addEventListener('click',()=>{
    console.log('zeub')
    navLinks.classList.toggle('mobile-menu')
})

//Désactivation du scroll lorsque le menu burger est visible
navLinks.addEventListener('wheel', preventScroll, {passive: false});
function preventScroll(e) {
    e.preventDefault();
    e.stopPropagation();

    return false;
}