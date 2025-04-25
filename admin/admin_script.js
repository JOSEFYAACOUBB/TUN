// script.js
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du sidebar mobile
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.createElement('button');
    
    sidebarToggle.className = 'btn btn-primary sidebar-toggle d-lg-none position-fixed';
    sidebarToggle.style.bottom = '20px';
    sidebarToggle.style.left = '20px';
    sidebarToggle.style.zIndex = '1000';
    sidebarToggle.innerHTML = '<i class="fas fa-bars"></i>';
    
    sidebarToggle.addEventListener('click', function() {
      sidebar.classList.toggle('show');
    });
    
    document.body.appendChild(sidebarToggle);
  
    // Animation des cartes
    const animateCards = () => {
      const cards = document.querySelectorAll('.card');
      cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in');
      });
    };
  
    // Highlight du menu actif
    const setActiveMenu = () => {
      const currentPage = window.location.pathname.split('/').pop();
      const navLinks = document.querySelectorAll('#sidebar .nav-link');
      
      navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
          link.classList.add('active');
        }
      });
    };
  
    // Initialisation
    animateCards();
    setActiveMenu();
  
    // Gestion des messages flash
    const flashMessages = document.querySelectorAll('.alert');
    flashMessages.forEach(message => {
      setTimeout(() => {
        message.classList.add('fade-out');
        setTimeout(() => message.remove(), 300);
      }, 5000);
    });
  });