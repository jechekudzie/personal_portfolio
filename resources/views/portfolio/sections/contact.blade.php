<section id="contact" class="contact section section-dark">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Get in touch</span>
            <h2 class="section-title">Let's Build Something Amazing Together</h2>
        </div>
        
        <div class="contact-content">
            <div class="contact-info" data-aos="fade-right">
                <div class="contact-intro">
                    <h3>Ready to Transform Your Business?</h3>
                    <p>I'm here to help turn your vision into reality with cutting-edge digital solutions. Let's discuss your project and see how we can drive your business forward.</p>
                </div>
                
                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="method-content">
                            <h4>Email</h4>
                            <a href="mailto:jechekudzie@gmail.com">jechekudzie@gmail.com</a>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="method-content">
                            <h4>Phone</h4>
                            <a href="tel:+263774685884">+263 774 685 884</a>
                            <a href="tel:+263718887994">+263 718 887 994</a>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="method-content">
                            <h4>Location</h4>
                            <span>97 Baines Avenue, CBD<br>Harare, Zimbabwe</span>
                        </div>
                    </div>
                </div>
                
                <div class="social-links">
                    <a href="https://linkedin.com/in/kudzai-nigel-jeche" class="social-link" target="_blank">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://github.com/kudzainigeljeche" class="social-link" target="_blank">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://twitter.com/kudzainigeljeche" class="social-link" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
            
            <div class="contact-form" data-aos="fade-left">
                <form id="contact-form" class="form" action="{{ route('portfolio.contact') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" id="name" name="name" required>
                        <label for="name">Your Name</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="email" id="email" name="email" required>
                        <label for="email">Your Email</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" id="subject" name="subject" required>
                        <label for="subject">Subject</label>
                    </div>
                    
                    <div class="form-group">
                        <textarea id="message" name="message" rows="5" required></textarea>
                        <label for="message">Your Message</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <span>Send Message</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>