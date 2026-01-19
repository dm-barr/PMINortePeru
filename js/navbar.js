document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.getElementById("menu-toggle");
  const menuLinks = document.querySelectorAll(".menu a:not(.dropdown-toggle)");
  
  menuLinks.forEach((link) => {
    link.addEventListener("click", function () {
      if (menuToggle) {
        menuToggle.checked = false; 
      }
    });
  });

  const dropdownToggles = document.querySelectorAll(".dropdown-toggle");
  
  dropdownToggles.forEach(toggle => {
      toggle.addEventListener("click", function(e) {
          if (window.innerWidth <= 900) { 
              e.preventDefault(); 
              const parentLi = this.closest('li');
              if (parentLi) {
                  const allDropdowns = document.querySelectorAll('.dropdown-beneficios, .dropdown-certificacion, .dropdown-comunidades');
                  allDropdowns.forEach(d => {
                      if (d !== parentLi) d.classList.remove('active');
                  });
                  parentLi.classList.toggle('active');
              }
          }
      });
  });

  document.addEventListener("click", function (e) {
      if (window.innerWidth <= 900) {
        const navContainer = document.querySelector('.nav-container');
        if (navContainer && !navContainer.contains(e.target)) {
            document.querySelectorAll('.dropdown-beneficios, .dropdown-certificacion, .dropdown-comunidades').forEach(d => {
                d.classList.remove('active');
            });
            if(menuToggle) menuToggle.checked = false;
        }
      }
  });
});