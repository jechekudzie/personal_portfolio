<section id="portfolio" class="portfolio section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">My work</span>
            <h2 class="section-title">Featured Projects</h2>
        </div>
        
        <div class="portfolio-filter" data-aos="fade-up" data-aos-delay="200">
            <button class="filter-btn active" data-filter="all">All Projects</button>
            <button class="filter-btn" data-filter="healthcare">Healthcare</button>
            <button class="filter-btn" data-filter="government">Government</button>
            <button class="filter-btn" data-filter="fintech">FinTech</button>
            <button class="filter-btn" data-filter="conservation">Conservation</button>
            <button class="filter-btn" data-filter="education">Education</button>
        </div>
        
        <div class="portfolio-grid">
            @foreach($projects as $index => $project)
                <div class="portfolio-item {{ $project['category'] }}" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="project-card">
                        <div class="project-image">
                            <div class="project-overlay">
                                <div class="project-links">
                                    <a href="#" class="project-link" data-project="{{ Str::slug($project['title']) }}">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="project-tech">
                                @foreach($project['technologies'] as $tech)
                                    <span class="tech-tag">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="project-content">
                            <h3>{{ $project['title'] }}</h3>
                            <p>{{ $project['description'] }}</p>
                            <div class="project-features">
                                @foreach($project['features'] as $feature)
                                    <span>{{ $feature }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>