<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $whyChooseUs = [
            [
                'title' => 'High Quality Prints',
                'description' => 'Studio-quality lighting and professional DSLR cameras ensure your guests look their best.',
            ],
            [
                'title' => 'Custom Props',
                'description' => 'A huge variety of fun, quirky, and themed props tailored for your specific event.',
            ],
            [
                'title' => 'Instant Sharing',
                'description' => 'Share photos instantly via email or QR code direct from the photobooth screen.',
            ],
        ];

        return view('home', compact('whyChooseUs'));
    }

    public function about()
    {
        return view('about');
    }

    public function services()
    {
        $packages = [
            [
                'name' => 'Basic Snap',
                'price' => 'Rp 1.500.000',
                'duration' => '/2 hours',
                'header_bg' => 'bg-secondary',
                'header_text' => 'text-white',
                'border_class' => 'border-0 shadow-sm',
                'feature_text' => 'text-muted',
                'btn_class' => 'btn-outline-dark',
                'btn_text' => 'Choose Basic',
                'is_popular' => false,
                'features' => [
                    'Unlimited Prints (2x6)',
                    'Standard Backdrop',
                    'Fun Props Set',
                    'Online Gallery',
                ],
            ],
            [
                'name' => 'Premium Joy',
                'price' => 'Rp 2.500.000',
                'duration' => '/4 hours',
                'header_bg' => 'bg-warning',
                'header_text' => 'text-dark',
                'border_class' => 'border-warning shadow border-2',
                'feature_text' => 'text-dark fw-medium',
                'btn_class' => 'btn-warning text-dark fw-bold shadow-sm',
                'btn_text' => 'Choose Premium',
                'is_popular' => true,
                'features' => [
                    'Unlimited Premium Prints (4x6)',
                    'Custom Premium Backdrop',
                    'Themed High-End Props',
                    'Boomerang & GIF Creation',
                    'Scrapbook Station',
                ],
            ],
            [
                'name' => 'Wedding VIP',
                'price' => 'Rp 4.000.000',
                'duration' => '/6 hours',
                'header_bg' => 'bg-dark',
                'header_text' => 'text-warning',
                'border_class' => 'border-0 shadow-sm',
                'feature_text' => 'text-muted',
                'btn_class' => 'btn-outline-dark',
                'btn_text' => 'Choose VIP',
                'is_popular' => false,
                'features' => [
                    'Everything in Premium',
                    '360 Video Booth Included',
                    'Custom Photo Template Design',
                    'Instant Social Media Sharing Kiosk',
                    'Idle Time (1 hour free)',
                ],
            ],
        ];

        return view('services', compact('packages'));
    }

    public function contact()
    {
        return view('contact');
    }
}
