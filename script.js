// Marrim elementin header nga HTML
const header = document.querySelector('header');

// Funksion për të ndryshuar navbar-in gjatë scroll-it
function fixedNavbar() {
    // Nëse përdoruesi ka bërë scroll, i shtohet klasa "scrolled"
    header.classList.toggle('scrolled', window.pageYOffset > 0);
}
fixedNavbar();
// Kur përdoruesi bën scroll, funksioni ekzekutohet
window.addEventListener('scroll', fixedNavbar);

// Marrim ikonën e menysë dhe të përdoruesit 
let menu = document.querySelector('#menu-btn');
let userBtn = document.querySelector('#user-btn');

// hapjen/mbylljen e menysë kur klikohet butoni
menu.addEventListener('click', function() {
    let nav = document.querySelector('.navbar'); //marrim navigimet
    nav.classList.toggle('active'); // Ndryshon statusin e menysë (shfaq ose fsheh)
});

// hapjen/mbylljen e user-box 
userBtn.addEventListener('click', function() {
    let userBox = document.querySelector('.user-box'); // Marrim kutinë e përdoruesit
    userBox.classList.toggle('active'); // Ndryshon statusin (shfaq ose fsheh kutinë)
});
const closeBtn = document.querySelector('#close-form');// butoni cancel tek admin product
closeBtn.addEventListener('click', () => {      //myllet faqja
    document.querySelector('.update-container').style.display = 'none';
});