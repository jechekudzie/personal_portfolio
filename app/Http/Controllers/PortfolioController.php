<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class PortfolioController extends Controller
{
    /**
     * Display the portfolio homepage
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $projects = $this->getProjects();
        $services = $this->getServices();
        $highlights = $this->getWebsiteHighlights();
        
        return view('portfolio.index', compact('projects', 'services', 'highlights'));
    }
    
    /**
     * Handle contact form submission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);
        
        try {
            // Send email notification to nigel@jeche.dev
            Mail::to('nigel@jeche.dev')->send(new ContactFormMail($validated));
            
            // Also log the contact for backup
            \Log::info('Contact form submission sent to nigel@jeche.dev:', $validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! I\'ll get back to you soon.'
            ]);
        } catch (\Exception $e) {
            // Log the error and the contact details for manual follow-up
            \Log::error('Contact form email failed: ' . $e->getMessage());
            \Log::info('IMPORTANT - Manual follow-up required for contact form submission:', [
                'contact_data' => $validated,
                'timestamp' => now(),
                'error' => $e->getMessage(),
                'follow_up_required' => true
            ]);
            
            // Still show success to user but log for manual processing
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! I\'ll get back to you soon.',
                'note' => 'Message logged for manual processing'
            ]);
        }
    }
    
    /**
     * Get projects data
     *
     * @return array
     */
    private function getProjects()
    {
        return [
            [
                'id' => 1,
                'category' => 'healthcare',
                'title' => 'EHPCZ Management System',
                'description' => 'Comprehensive management information system for Zimbabwe\'s Environmental Health Practitioners Council.',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL'],
                'features' => ['Practitioner Registration', 'CPD Tracking', 'Payment Processing'],
                'image' => null,
                'url' => null,
                'year' => 2023
            ],
            [
                'id' => 2,
                'category' => 'government',
                'title' => 'CyberSafe Ministry App',
                'description' => 'Mobile application for the Ministry of ICT to enhance cybersecurity awareness among citizens.',
                'technologies' => ['React Native', 'Node.js', 'MongoDB'],
                'features' => ['Mobile App', 'Backend Analytics', 'Real-time Monitoring'],
                'image' => null,
                'url' => null,
                'year' => 2022
            ],
            [
                'id' => 3,
                'category' => 'fintech',
                'title' => 'E-SHAGI Credit Platform',
                'description' => 'Comprehensive credit management platform providing accessible financial solutions.',
                'technologies' => ['Laravel', 'Vue.js', 'Payment APIs'],
                'features' => ['Credit Management', 'Mobile Interface', 'Payment Integration'],
                'image' => null,
                'url' => null,
                'year' => 2023
            ],
            [
                'id' => 4,
                'category' => 'conservation',
                'title' => 'Resource Africa Platform',
                'description' => 'Wildlife management system supporting sustainable natural resource management in rural communities.',
                'technologies' => ['PHP/Laravel', 'Flutter', 'Mobile App'],
                'features' => ['Wildlife Management', 'Community Platform', 'Conservation Tools'],
                'image' => null,
                'url' => null,
                'year' => 2023
            ],
            [
                'id' => 5,
                'category' => 'education',
                'title' => 'SmartStudent Portal',
                'description' => 'Integrated school management system improving educational administration and student engagement.',
                'technologies' => ['Laravel', 'Vue.js', 'Education'],
                'features' => ['Student Management', 'Academic Tracking', 'Parent Portal'],
                'image' => null,
                'url' => null,
                'year' => 2022
            ],
            [
                'id' => 6,
                'category' => 'government',
                'title' => 'Sentinel Fraud Detection',
                'description' => 'AI-powered fraud detection system for agricultural subsidy programs protecting government investments.',
                'technologies' => ['Machine Learning', 'Laravel', 'Analytics'],
                'features' => ['Fraud Detection', 'AI Analytics', 'Real-time Monitoring'],
                'image' => null,
                'url' => null,
                'year' => 2022
            ],
        ];
    }
    
    /**
     * Get services data
     *
     * @return array
     */
    private function getServices()
    {
        return [
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
    }
    
    /**
     * Get website highlights data
     *
     * @return array
     */
    private function getWebsiteHighlights()
    {
        return [
            [
                'url' => 'https://leadingdigital.africa',
                'title' => 'Leading Digital',
                'description' => 'Corporate website showcasing digital transformation services',
                'category' => 'corporate'
            ],
            [
                'url' => 'https://rockboltint.com',
                'title' => 'Rockbolt International',
                'description' => 'International business solutions platform',
                'category' => 'business'
            ],
            [
                'url' => 'https://upgrade.lummii.energy',
                'title' => 'Lummii Energy',
                'description' => 'Energy sector digital solutions',
                'category' => 'energy'
            ],
            [
                'url' => 'https://oneminutechemical.co.zw',
                'title' => 'One Minute Chemical',
                'description' => 'Chemical industry e-commerce platform',
                'category' => 'ecommerce'
            ],
            [
                'url' => 'https://oneminutepharm.com',
                'title' => 'One Minute Pharm',
                'description' => 'Pharmaceutical e-commerce solution',
                'category' => 'healthcare'
            ],
            [
                'url' => 'https://pantera-group.netlify.app',
                'title' => 'Pantera Group',
                'description' => 'Corporate group portfolio website',
                'category' => 'corporate'
            ],
            [
                'url' => 'https://dynamicfloors.co.zw',
                'title' => 'Dynamic Floors',
                'description' => 'Flooring solutions business website',
                'category' => 'business'
            ],
            [
                'url' => 'https://felymas.com',
                'title' => 'Felymas',
                'description' => 'Business services platform',
                'category' => 'business'
            ],
            [
                'url' => 'https://alexclassics.co.zw',
                'title' => 'Alex Classics',
                'description' => 'Classic products e-commerce site',
                'category' => 'ecommerce'
            ],
            [
                'url' => 'https://orangehealth.co.zw',
                'title' => 'Orange Health',
                'description' => 'Healthcare services platform',
                'category' => 'healthcare'
            ]
        ];
    }
}