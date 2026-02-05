document.addEventListener('DOMContentLoaded', function () {
    const sliderItems = document.querySelectorAll('.slider-item');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');
    let currentIndex = 0;
    function showSlide(index) { // Shfaq sliden aktual
        sliderItems.forEach((item, i) => {
            item.classList.remove('active');
            if (i === index) {
                item.classList.add('active');
            }
        });
    }
    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : sliderItems.length - 1;
        showSlide(currentIndex);//shfaq slide e meparshem
    });
    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex < sliderItems.length - 1) ? currentIndex + 1 : 0;
        showSlide(currentIndex);   // Shfaq slajdin e radhës
    });
    function autoSlide() {
        setInterval(() => {
            currentIndex = (currentIndex < sliderItems.length - 1) ? currentIndex + 1 : 0;
            showSlide(currentIndex);
        }, 6000); // Ndryshon slide auto
    }
    showSlide(currentIndex);
    autoSlide();
});

// Funksioni për navbar që mbetet i fixuar gjatë rrokullisjes
const header = document.querySelector('header');
function fixedNavbar() {
    header.classList.toggle('scrolled', window.pageYOffset > 0);
}

// Aktivizimi i funksionit të navbar-it të fixuar
fixedNavbar();
window.addEventListener('scroll', fixedNavbar);

// Funksioni për menunë dhe kutinë e përdoruesit
let menu = document.querySelector('#menu-btn');
let userBtn = document.querySelector('#user-btn');

// Aktivizimi i menut përmes klikimit
menu.addEventListener('click', function() {
    let nav = document.querySelector('.navbar');
    nav.classList.toggle('active');
});

// Aktivizimi i kutisë së përdoruesit përmes klikimit
userBtn.addEventListener('click', function() {
    let userBox = document.querySelector('.user-box');
    userBox.classList.toggle('active');
});

// Funksioni për mbylljen e formularit të përditësimit
const closeBtn = document.querySelector('#close-form');

closeBtn.addEventListener('click', () => {
    document.querySelector('.update-container').style.display = 'none';
});