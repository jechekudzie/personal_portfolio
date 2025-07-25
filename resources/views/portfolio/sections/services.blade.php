<section id="services" class="services section section-dark">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-subtitle">What I offer</span>
            <h2 class="section-title">Services</h2>
        </div>
        
        <div class="services-grid">
            @php
                $services = [
                    [
                        'icon' => 'fa-laptop-code',
                        'title' => 'Custom Software Development',
                        'description' => 'Building tailor-made software solutions that perfectly align with your business needs, from enterprise systems to mobile applications.'
                    ],
                    [
                        'icon' => 'fa-globe',
                        'title' => 'Web Development & Design',
                        'description' => 'Creating stunning, responsive websites that not only look great but perform exceptionally with modern technologies.'
                    ],
                    [
                        'icon' => 'fa-shopping-cart',
                        'title' => 'E-Commerce Solutions',
                        'description' => 'Developing secure, scalable online stores with integrated payment systems that enhance customer experience.'
                    ],
                    [
                        'icon' => 'fa-chart-line',
                        'title' => 'Digital Business Consultancy',
                        'description' => 'Strategic guidance to navigate your digital transformation journey and optimize your business operations.'
                    ],
                    [
                        'icon' => 'fa-cogs',
                        'title' => 'System Analysis & Integration',
                        'description' => 'Comprehensive analysis of existing systems and seamless integration of new solutions for optimal workflow.'
                    ],
                    [
                        'icon' => 'fa-database',
                        'title' => 'Database Design & Management',
                        'description' => 'Robust database solutions that handle your data efficiently with proper design, optimization, and security.'
                    ]
                ];
            @endphp
            
            @foreach($services as $index => $service)
                <div class="service-card" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="service-icon">
                        <i class="fas {{ $service['icon'] }}"></i>
                    </div>
                    <h3>{{ $service['title'] }}</h3>
                    <p>{{ $service['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>