<section id="highlights" class="highlights section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">Website Highlights</span>
            <h2 class="section-title">Live Websites We've Built</h2>
            <p>A showcase of live websites and applications that demonstrate our expertise across various industries and technologies.</p>
        </div>
        
        <div class="highlights-grid">
            @foreach($highlights as $highlight)
                <div class="highlight-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="highlight-content">
                        <div class="highlight-header">
                            <div class="highlight-icon">
                                <i class="fas fa-globe"></i>
                            </div>
                            <div class="highlight-category">
                                <span class="category-tag category-{{ $highlight['category'] }}">
                                    {{ ucfirst($highlight['category']) }}
                                </span>
                            </div>
                        </div>
                        
                        <h3>{{ $highlight['title'] }}</h3>
                        <p>{{ $highlight['description'] }}</p>
                        
                        <div class="highlight-url">
                            <span class="url-text">{{ $highlight['url'] }}</span>
                        </div>
                        
                        <div class="highlight-actions">
                            <a href="{{ $highlight['url'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline">
                                <span>Visit Website</span>
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>