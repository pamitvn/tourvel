// require('./bootstrap');
import _ from 'lodash';
import '@splidejs/splide/css';
import Splide from '@splidejs/splide';

function mobileMenu() {
   const menuBox = document.getElementById('mainMenuMobile');
   const overlay = document.querySelector('.mainMenu--mobile__overlay');
   const toggle = document.getElementById('toggleMobileMenuButton');

   const handleCloseMenu = (e) => {
      if (e.target !== overlay) return;

      menuBox.classList.add('hidden');
      menuBox.removeEventListener('click', handleCloseMenu);
   };

   const handleOpenMenu = () => {
      menuBox.classList.remove('hidden');
      menuBox.addEventListener('click', handleCloseMenu);
   };

   toggle.addEventListener('click', handleOpenMenu);
}

function zaloQR() {
   const zaloIcon = document.getElementById('zaloQR-icon');
   const zaloBlock = document.getElementById('zaloQR-block');

   let isHover = false;

   const handleZaloIconMouseenter = _.debounce(function(e) {
      if (isHover) return;

      zaloBlock.classList.remove('scale-0');
      zaloBlock.classList.add('scale-100');
      zaloBlock.style.display = 'inline-block';
   }, 50);

   zaloIcon.addEventListener('mouseenter', handleZaloIconMouseenter);

   zaloIcon.addEventListener('mouseleave', _.debounce(function() {
      if (isHover) return;

      zaloBlock.classList.remove('scale-100');
      zaloBlock.classList.add('scale-0');
      zaloBlock.style.display = 'none';
   }, 50));

   zaloBlock.addEventListener('mouseenter', () => {
      isHover = true;
   });
   zaloBlock.addEventListener('mouseleave', () => {
      if (!isHover) return;

      isHover = false;

      zaloBlock.classList.remove('scale-100');
      zaloBlock.classList.add('scale-0');
      zaloBlock.style.display = 'none';
   });
}

function homeSlider() {
   const splide = new Splide('.home-splide');
   splide.mount();
}

window.addEventListener('DOMContentLoaded', function() {
   mobileMenu();
   zaloQR();
   homeSlider();
});
