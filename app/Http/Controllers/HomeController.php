<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    // actions
    public function index()
    {
        $slides = [
            [
                'image' => 'https://via.placeholder.com/800x500',
                'title' => '<span>No restocking fee ($35 savings)</span> M75 Sport Watch',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.',
                'price' => '320.99',
                'link' => '#',
            ],
            [
                'image' => 'https://via.placeholder.com/800x500',
                'title' => '<span>Big Sale Offer</span> Get the Best Deal on CCTV Camera',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.',
                'price' => '200.00',
                'link' => '#',
            ],
            [
                'image' => 'https://via.placeholder.com/800x500',
                'title' => '<span>Big Offer</span> Get the Best Deal on Camera',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.',
                'price' => '100.59',
                'link' => '#',
            ],
        ];

        return view('front.index', [
            'title' => 'Shop Home',
            'slides' => $slides,
        ]);
    }

    public function show($slug)
    {
        if ( !View::exists("front.pages.$slug") ) {
            abort(404);
        }

        return view("front.pages.$slug");
    }
}
