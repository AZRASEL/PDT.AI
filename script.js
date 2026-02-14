// Language Translation System
let currentLang = 'en';

function setLanguage(lang) {
    currentLang = lang;
    localStorage.setItem('preferredLanguage', lang);
    
    // Update button states
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    const activeBtn = document.getElementById(`lang-${lang}`);
    if (activeBtn) activeBtn.classList.add('active');
    
    // Update all translatable elements
    document.querySelectorAll('[data-en]').forEach(element => {
        const translation = element.getAttribute(`data-${lang}`);
        if (translation) {
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                element.placeholder = translation;
            } else {
                element.textContent = translation;
            }
        }
    });

    // Update images alt text
    document.querySelectorAll('img[data-en-alt]').forEach(img => {
        const altText = img.getAttribute(`data-${lang}-alt`);
        if (altText) {
            img.alt = altText;
        }
    });

    // Update active modal content if open
    const modal = document.getElementById('article-modal');
    if (modal && modal.classList.contains('active')) {
        const modalBody = document.getElementById('modal-body');
        modalBody.querySelectorAll('[data-en]').forEach(el => {
            const translation = el.getAttribute(`data-${lang}`);
            if (translation) el.textContent = translation;
        });
        
        // Update modal title too if possible
        // Note: This requires finding the source section again, which is slightly complex.
        // For now, modal content update is the priority.
    }
}

// Load saved language preference
window.addEventListener('DOMContentLoaded', () => {
    const savedLang = localStorage.getItem('preferredLanguage') || 'en';
    setLanguage(savedLang);
    
    // Initialize mobile menu
    initMobileMenu();
    
    // Initialize FAQ accordions
    initFAQ();
    
    // Initialize contact form
    initContactForm();
    
    // Highlight active menu
    highlightActiveMenu();
    
    // Initialize Brand Link
    initBrandLink();

    // Initialize Animations
    initAnimations();

    // Initialize Hero Slideshow
    initHeroSlideshow();

    // Initialize Read More buttons
    initReadMore();
});

// Read More / Modal functionality
function initReadMore() {
    const modal = document.getElementById('article-modal');
    if (!modal) return;

    const modalTitle = document.getElementById('modal-title');
    const modalBody = document.getElementById('modal-body');
    const closeBtn = modal.querySelector('.modal-close');
    const overlay = modal.querySelector('.modal-overlay');

    const openModal = (btn) => {
        const contentDiv = btn.previousElementSibling;
        const sectionTitle = btn.parentElement.querySelector('.section-title');
        
        if (contentDiv && contentDiv.classList.contains('expand-content')) {
            // Set Title
            modalTitle.textContent = sectionTitle.getAttribute(`data-${currentLang}`) || sectionTitle.textContent;
            
            // Clone content to modal body
            modalBody.innerHTML = contentDiv.innerHTML;
            
            // Ensure translations inside modal body are correct
            modalBody.querySelectorAll('[data-en]').forEach(el => {
                const translation = el.getAttribute(`data-${currentLang}`);
                if (translation) el.textContent = translation;
            });

            // Show modal
            modal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent background scroll
        }
    };

    const closeModal = () => {
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Restore scroll
    };

    document.querySelectorAll('.read-more-btn').forEach(btn => {
        btn.addEventListener('click', () => openModal(btn));
    });

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (overlay) overlay.addEventListener('click', closeModal);

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
}

// Mobile Menu Toggle
function initMobileMenu() {
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            // Animate hamburger lines if needed, handled by CSS mostly
        });
        
        // Close menu when clicking on a link
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navMenu.contains(e.target) && !hamburger.contains(e.target) && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
            }
        });
    }
}

// FAQ Accordion
function initFAQ() {
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const faqItem = question.parentElement;
            const answer = faqItem.querySelector('.faq-answer');
            
            // Close other open FAQs
            document.querySelectorAll('.faq-item').forEach(item => {
                if (item !== faqItem) {
                    item.classList.remove('active');
                    const otherAnswer = item.querySelector('.faq-answer');
                    if (otherAnswer) otherAnswer.classList.remove('active');
                }
            });
            
            // Toggle current FAQ
            faqItem.classList.toggle('active');
            if (answer) answer.classList.toggle('active');
        });
    });
}

// Contact Form Handling
function initContactForm() {
    const contactForm = document.getElementById('contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Show success message
            alert(currentLang === 'en' 
                ? 'Thank you for your message! We will contact you soon.' 
                : 'আপনার বার্তার জন্য ধন্যবাদ! আমরা শীঘ্রই আপনার সাথে যোগাযোগ করব।'
            );
            
            // Reset form
            contactForm.reset();
        });
    }
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Scroll Animations
function initAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); // Only animate once
            }
        });
    }, observerOptions);

    document.querySelectorAll('[data-animate]').forEach(el => {
        observer.observe(el);
    });
}

function highlightActiveMenu() {
    const path = window.location.pathname;
    const page = path.split("/").pop();
    // Default to index.html if empty path
    const target = (page === "" || page === "/") ? "index.html" : page;

    const menuLinks = document.querySelectorAll('.nav-menu a');
    menuLinks.forEach(link => {
        const href = link.getAttribute('href');
        link.classList.remove('active'); // Remove active from all first
        if (href === target) {
            link.classList.add('active');
        }
    });
}

function initBrandLink() {
    const brand = document.querySelector('.nav-brand');
    if (brand) {
        brand.addEventListener('click', () => {
            window.location.href = 'index.html';
        });
    }
}

// Hero Slideshow
function initHeroSlideshow() {
    const slides = document.querySelectorAll('.slide');
    if (slides.length === 0) return;

    let currentSlide = 0;
    const intervalTime = 5000; // 5 seconds

    setInterval(() => {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }, intervalTime);
}
