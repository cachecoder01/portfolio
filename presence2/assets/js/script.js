/*==== hamburger menu ====*/
const toggleBtn = document.getElementById('menu-toggle');
const sideMenu = document.getElementById('side-menu');
const closeBtn = document.getElementById('close-btn');

toggleBtn.addEventListener('click', () => {
  toggleBtn.classList.toggle('open');
  sideMenu.classList.toggle('open');
  document.body.classList.toggle('noscroll'); // disable/enable scroll
});

closeBtn.addEventListener('click', () => {
  toggleBtn.classList.remove('open');
  sideMenu.classList.remove('open');
  document.body.classList.remove('noscroll'); // re-enable scroll
});
/*==== /hamburger menu ====*/

