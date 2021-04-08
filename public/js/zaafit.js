// menu Burger Repas

const menuBurgerBtn = document.querySelector('.menuburgerbtn');
const menuCache = document.querySelector('.navmenuburgerfoodandsport');
const masqueMenu = document.querySelector('.masquemenu');
const afficheMenu = document.querySelector('.displayMenu');
const containerHomeUser = document.querySelector('.containerFoodAndSportUser');

function addOrRemoveClass(element, classElement) {
  const listOfClass = element.className.split(' ');
  let hasClass = 0;
  listOfClass.forEach(c => {
    if (c === classElement) hasClass = 1;
  });
  if (hasClass === 1) element.classList.remove(classElement);
  else element.classList.add(classElement);
}

menuBurgerBtn.onclick = function() {
  addOrRemoveClass(masqueMenu, 'displayNone');
  addOrRemoveClass(menuCache, 'displayNone');
  addOrRemoveClass(containerHomeUser, 'marginleft200');
  addOrRemoveClass(displayMenu, 'displayBlock');
};
