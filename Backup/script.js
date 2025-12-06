document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Nova lógica para diminuir o menu ao rolar-----------------------------------------------------------------
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) { // Ajuste '50' para a distância de rolagem que você deseja
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});
// Menu em Hamburer--------------------------------------------------------------------------------------
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        // Fechar o menu mobile ao clicar em um link
        const navLinks = document.querySelector('.nav-links');
        const hamburgerMenu = document.querySelector('.hamburger-menu');
        if (navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
            hamburgerMenu.classList.remove('active');
        }

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Nova lógica para diminuir o menu ao rolar (já existente)
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    // Ajuste '50' para a distância de rolagem que você deseja para o menu diminuir
    if (window.scrollY > 50) { 
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Lógica do menu hambúrguer
document.addEventListener('DOMContentLoaded', function() {
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    const navLinks = document.querySelector('.nav-links');

    hamburgerMenu.addEventListener('click', function() {
        navLinks.classList.toggle('active');
        hamburgerMenu.classList.toggle('active');
    });

    // Fechar o menu quando um link é clicado (já tratamos isso na primeira função, mas reforço aqui)
    navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function() {
            if (navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
                hamburgerMenu.classList.remove('active');
            }
        });
    });
});
