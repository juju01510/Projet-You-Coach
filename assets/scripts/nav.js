// Ajout du background de couleur si scroll Y est supérieur à 0
const navBar = document.querySelector('#nav');

// Écouteur d'événement pour le scroll de la fenêtre
window.addEventListener('scroll', () => {
    if (window.scrollY > 0) {
        // Ajoute la classe 'nav-bg-color' à l'élément avec l'ID 'nav'
        navBar.classList.add('nav-bg-color');
    } else {
        // Supprime la classe 'nav-bg-color' de l'élément avec l'ID 'nav'
        navBar.classList.remove('nav-bg-color');
    }
});

// Menu burger, ajout de la class 'mobile-menu' à l'élément avec la classe 'nav-links'
const menuBurger = document.querySelector(".menu-burger")
const navLinks = document.querySelector(".nav-links")

// Écouteur d'événement pour le clic sur le menu burger
menuBurger.addEventListener('click', () => {
    // Ajoute ou supprime la classe 'mobile-menu' à l'élément avec la classe 'nav-links'
    navLinks.classList.toggle('mobile-menu')
})

// Désactivation du scroll lorsque le menu burger est visible
navLinks.addEventListener('wheel', preventScroll, { passive: false });
function preventScroll(e) {
    e.preventDefault(); // Empêche le comportement par défaut du défilement
    e.stopPropagation(); // Arrête la propagation de l'événement
    return false;
}
