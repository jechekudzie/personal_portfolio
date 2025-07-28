// ===== GLOBAL VARIABLES =====
let lastScrollTop = 0;
const navbar = document.getElementById('navbar');
const navToggle = document.getElementById('nav-toggle');
const navMenu = document.getElementById('nav-menu');
const loadingScreen = document.getElementById('loading-screen');

// ===== LOADING SCREEN =====
window.addEventListener('load', () => {
    setTimeout(() => {
        loadingScreen.classList.add('hidden');
        
        // Initialize AOS after loading
        setTimeout(() => {
            AOS.init({
                duration: 1000,
                easing: 'ease-out-cubic',
                once: true,
                offset: 100
            });
        }, 500);
    }, 2000);
});

// ===== NAVIGATION FUNCTIONALITY =====
// Mobile menu toggle
navToggle.addEventListener('click', () => {
    navToggle.classList.toggle('active');
    navMenu.classList.toggle('active');
    document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : 'auto';
});

// Close mobile menu when clicking nav links
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        navToggle.classList.remove('active');
        navMenu.classList.remove('active');
        document.body.style.overflow = 'auto';
    });
});

// Navbar scroll effect
window.addEventListener('scroll', () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    // Add/remove scrolled class
    if (scrollTop > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
    
    lastScrollTop = scrollTop;
});

// ===== ACTIVE NAVIGATION LINK =====
const sections = document.querySelectorAll('section');
const navLinks = document.querySelectorAll('.nav-link');

function updateActiveNavLink() {
    let current = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        
        if (pageYOffset >= sectionTop - 150) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
}

window.addEventListener('scroll', updateActiveNavLink);

// ===== TYPEWRITER EFFECT =====
const typewriterElement = document.getElementById('typewriter');
const texts = [
    'Full Stack Developer',
    'Digital Consultant',
    'Tech Entrepreneur',
    'Innovation Leader',
    'Laravel Expert',
    'Vue.js Specialist'
];

let textIndex = 0;
let charIndex = 0;
let isDeleting = false;
let typingSpeed = 100;

function typeWriter() {
    const currentText = texts[textIndex];
    
    if (isDeleting) {
        typewriterElement.textContent = currentText.substring(0, charIndex - 1);
        charIndex--;
        typingSpeed = 50;
    } else {
        typewriterElement.textContent = currentText.substring(0, charIndex + 1);
        charIndex++;
        typingSpeed = 100;
    }
    
    if (!isDeleting && charIndex === currentText.length) {
        setTimeout(() => {
            isDeleting = true;
        }, 2000);
    } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        textIndex = (textIndex + 1) % texts.length;
    }
    
    setTimeout(typeWriter, typingSpeed);
}

// Start typewriter effect after loading
window.addEventListener('load', () => {
    setTimeout(typeWriter, 3000);
});

// ===== PORTFOLIO FILTER =====
const filterButtons = document.querySelectorAll('.filter-btn');
const portfolioItems = document.querySelectorAll('.portfolio-item');

filterButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Remove active class from all buttons
        filterButtons.forEach(btn => btn.classList.remove('active'));
        // Add active class to clicked button
        button.classList.add('active');
        
        const filterValue = button.getAttribute('data-filter');
        const portfolioGrid = document.querySelector('.portfolio-grid');
        
        // Separate visible and hidden items
        const visibleItems = [];
        const hiddenItems = [];
        
        portfolioItems.forEach(item => {
            if (filterValue === 'all' || item.classList.contains(filterValue)) {
                visibleItems.push(item);
                item.classList.remove('hidden');
                item.style.opacity = '1';
                item.style.transform = 'scale(1)';
            } else {
                hiddenItems.push(item);
                item.style.opacity = '0';
                item.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    item.classList.add('hidden');
                }, 300);
            }
        });
        
        // Reorder items: visible items first, then hidden items
        setTimeout(() => {
            visibleItems.forEach(item => {
                portfolioGrid.appendChild(item);
            });
            hiddenItems.forEach(item => {
                portfolioGrid.appendChild(item);
            });
        }, 300);
    });
});

// ===== AUTO-SCROLL TO CONTACT SECTION AFTER FORM SUBMISSION =====
document.addEventListener('DOMContentLoaded', function() {
    // Check for success or error messages (indicating form was submitted)
    const hasAlert = document.querySelector('.alert');
    const urlParams = new URLSearchParams(window.location.search);
    const scrollTo = urlParams.get('scrollTo');
    
    if (hasAlert || scrollTo === 'contact') {
        setTimeout(() => {
            const contactSection = document.getElementById('contact');
            if (contactSection) {
                const headerOffset = 80;
                const elementPosition = contactSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        }, 500);
    }
});


// ===== SMOOTH SCROLLING FOR ANCHOR LINKS =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
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

// ===== FLOATING SHAPES ANIMATION =====
function createFloatingShape() {
    const shape = document.createElement('div');
    shape.className = 'floating-particle';
    shape.style.cssText = `
        position: absolute;
        width: ${Math.random() * 6 + 2}px;
        height: ${Math.random() * 6 + 2}px;
        background: rgba(0, 212, 170, ${Math.random() * 0.5 + 0.1});
        border-radius: 50%;
        pointer-events: none;
        z-index: 1;
    `;
    
    return shape;
}

// Add floating particles to hero section
const heroSection = document.querySelector('.hero');
if (heroSection) {
    for (let i = 0; i < 20; i++) {
        const particle = createFloatingShape();
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.animation = `float ${Math.random() * 10 + 5}s ease-in-out infinite`;
        particle.style.animationDelay = Math.random() * 5 + 's';
        heroSection.querySelector('.hero-background').appendChild(particle);
    }
}

// ===== INTERSECTION OBSERVER FOR ANIMATIONS =====
const animatedElements = document.querySelectorAll('.highlight-item, .service-card, .project-card');

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
        }
    });
}, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
});

animatedElements.forEach(element => {
    observer.observe(element);
});

// ===== PARALLAX EFFECT =====
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('.floating-shapes');
    
    parallaxElements.forEach(element => {
        const speed = 0.5;
        element.style.transform = `translateY(${scrolled * speed}px)`;
    });
});

// ===== CURSOR TRAIL EFFECT =====
const cursor = document.createElement('div');
cursor.className = 'cursor-trail';
cursor.style.cssText = `
    position: fixed;
    width: 20px;
    height: 20px;
    background: radial-gradient(circle, rgba(0, 212, 170, 0.8) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
    z-index: 9999;
    transition: all 0.1s ease;
    transform: translate(-50%, -50%);
`;

document.body.appendChild(cursor);

document.addEventListener('mousemove', (e) => {
    cursor.style.left = e.clientX + 'px';
    cursor.style.top = e.clientY + 'px';
});

// Hide cursor trail on mobile
if (window.innerWidth <= 768) {
    cursor.style.display = 'none';
}

// ===== FORM LABEL ANIMATIONS =====
const formInputs = document.querySelectorAll('.form-group input, .form-group textarea');

formInputs.forEach(input => {
    input.addEventListener('focus', () => {
        const label = input.nextElementSibling;
        animateLabel(label, true);
    });
    
    input.addEventListener('blur', () => {
        const label = input.nextElementSibling;
        if (!input.value) {
            animateLabel(label, false);
        }
    });
    
    // Check if input has value on page load
    if (input.value) {
        const label = input.nextElementSibling;
        animateLabel(label, true);
    }
});

function animateLabel(label, isFocused) {
    if (isFocused) {
        label.style.top = '-0.5rem';
        label.style.left = '0.5rem';
        label.style.fontSize = '0.8rem';
        label.style.color = 'var(--primary-color)';
        label.style.background = 'var(--bg-dark)';
        label.style.padding = '0 0.5rem';
    } else {
        label.style.top = '1rem';
        label.style.left = '1rem';
        label.style.fontSize = '1rem';
        label.style.color = 'var(--text-light)';
        label.style.background = 'transparent';
        label.style.padding = '0';
    }
}

// ===== SCROLL TO TOP BUTTON =====
const scrollToTopButton = document.createElement('button');
scrollToTopButton.innerHTML = '<i class="fas fa-arrow-up"></i>';
scrollToTopButton.className = 'scroll-to-top';
scrollToTopButton.style.cssText = `
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    background: var(--gradient-primary);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1000;
    box-shadow: 0 4px 15px rgba(0, 212, 170, 0.3);
`;

document.body.appendChild(scrollToTopButton);

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        scrollToTopButton.style.opacity = '1';
        scrollToTopButton.style.visibility = 'visible';
    } else {
        scrollToTopButton.style.opacity = '0';
        scrollToTopButton.style.visibility = 'hidden';
    }
});

scrollToTopButton.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// ===== PROJECT MODAL (Optional Enhancement) =====
const projectLinks = document.querySelectorAll('.project-link');

projectLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const projectId = link.getAttribute('data-project');
        showProjectModal(projectId);
    });
});

function showProjectModal(projectId) {
    // This is a placeholder for project modal functionality
    // You can implement detailed project views here
    console.log(`Opening ${projectId} project details...`);
}

// ===== PERFORMANCE OPTIMIZATIONS =====
// Debounce scroll events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Apply debouncing to scroll events
const debouncedScrollHandler = debounce(() => {
    updateActiveNavLink();
}, 10);

window.addEventListener('scroll', debouncedScrollHandler);

// ===== EASTER EGG =====
let konamiCode = [];
const konamiSequence = [
    'ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown',
    'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight',
    'KeyB', 'KeyA'
];

document.addEventListener('keydown', (e) => {
    konamiCode.push(e.code);
    
    if (konamiCode.length > konamiSequence.length) {
        konamiCode.shift();
    }
    
    if (konamiCode.join(',') === konamiSequence.join(',')) {
        triggerEasterEgg();
        konamiCode = [];
    }
});

function triggerEasterEgg() {
    // Add some fun animation or effect
    document.body.style.animation = 'rainbow 2s ease-in-out';
    console.log('🎉 Konami Code activated! You found the easter egg!');
    
    setTimeout(() => {
        document.body.style.animation = '';
    }, 2000);
}

// Add rainbow animation to CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes rainbow {
        0% { filter: hue-rotate(0deg); }
        25% { filter: hue-rotate(90deg); }
        50% { filter: hue-rotate(180deg); }
        75% { filter: hue-rotate(270deg); }
        100% { filter: hue-rotate(360deg); }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);

// ===== INITIALIZE EVERYTHING =====
document.addEventListener('DOMContentLoaded', () => {
    console.log('🚀 Portfolio website loaded successfully!');
    console.log('Built with ❤️ by Kudzai Nigel Jeche');
});