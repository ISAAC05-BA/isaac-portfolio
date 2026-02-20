/**
 * Royal Cuts Barbershop - JavaScript
 * Handles smooth scrolling, mobile menu, and scroll animations
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ========================================
    // Mobile Menu Toggle
    // ========================================
    const mobileMenu = document.getElementById('mobile-menu');
    const navMenu = document.querySelector('.nav-menu');
    const navLinks = document.querySelectorAll('.nav-link');

    mobileMenu.addEventListener('click', function() {
        mobileMenu.classList.toggle('active');
        navMenu.classList.toggle('active');
    });

    // Close menu when clicking on a nav link
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileMenu.classList.remove('active');
            navMenu.classList.remove('active');
        });
    });

    // ========================================
    // Smooth Scrolling for Navigation Links
    // ========================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ========================================
    // Navbar Scroll Effect
    // ========================================
    const navbar = document.querySelector('.navbar');

    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // ========================================
    // Active Navigation Link on Scroll
    // ========================================
    const sections = document.querySelectorAll('section[id]');

    function highlightNavLink() {
        const scrollY = window.pageYOffset;

        sections.forEach(section => {
            const sectionHeight = section.offsetHeight;
            const sectionTop = section.offsetTop - 150;
            const sectionId = section.getAttribute('id');
            const navLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);

            if (navLink) {
                if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                    navLink.classList.add('active');
                } else {
                    navLink.classList.remove('active');
                }
            }
        });
    }

    window.addEventListener('scroll', highlightNavLink);

    // ========================================
    // Scroll Animation using Intersection Observer
    // ========================================
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Add fade-in class to sections
    const sectionsToAnimate = document.querySelectorAll('.section, .service-card, .gallery-item, .contact-item');
    
    sectionsToAnimate.forEach(section => {
        section.classList.add('fade-in');
        observer.observe(section);
    });

    // ========================================
    // Gallery Lightbox (Simple Implementation)
    // ========================================
    const galleryItems = document.querySelectorAll('.gallery-item');

    galleryItems.forEach(item => {
        item.addEventListener('click', function() {
            const img = this.querySelector('img');
            const alt = img.alt;
            
            // For a more complete implementation, you could add a lightbox modal here
            console.log('Gallery image clicked:', alt);
        });
    });

    // ========================================
    // Service Card Animation Stagger
    // ========================================
    const serviceCards = document.querySelectorAll('.service-card');

    serviceCards.forEach((card, index) => {
        card.style.transitionDelay = `${index * 0.1}s`;
    });

    // ========================================
    // Header Animation on Page Load
    // ========================================
    const heroContent = document.querySelector('.hero-content');
    
    window.addEventListener('load', function() {
        heroContent.style.animation = 'fadeInUp 1s ease forwards';
    });

    // ========================================
    // WhatsApp Button Tracking (Optional)
    // ========================================
    const whatsappBtn = document.querySelector('.btn-primary');
    
    if (whatsappBtn) {
        whatsappBtn.addEventListener('click', function() {
            console.log('Booking button clicked - WhatsApp link');
        });
    }

    // ========================================
    // Console Welcome Message
    // ========================================
    console.log('%c Royal Cuts Barbershop ', 'background: #d4af37; color: #0a0a0a; font-size: 20px; font-weight: bold; padding: 10px;');
    console.log('%c Welcome to our website! ', 'background: #0a0a0a; color: #d4af37; padding: 5px;');
});
