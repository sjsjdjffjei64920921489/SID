<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class CollectionController extends Controller
{
    public function index(): View
    {
        $jerseys = [
            ['team' => 'Spain', 'name' => 'Spain Home Jersey', 'image' => 'spain.jpg', 'print_left' => 56, 'print_top' => 54],
            ['team' => 'Croatia', 'name' => 'Croatia Home Jersey', 'image' => 'croatia.jpg', 'print_left' => 50, 'print_top' => 54],
            ['team' => 'DR Congo', 'name' => 'DR Congo Home Jersey', 'image' => 'dr-congo.jpg', 'print_left' => 52, 'print_top' => 54],
            ['team' => 'Manchester City', 'name' => 'Manchester City Jersey', 'image' => 'manchester-city.jpg', 'print_left' => 55, 'print_top' => 53],
            ['team' => 'Inter Milan', 'name' => 'Inter Milan Home Jersey', 'image' => 'inter-milan.jpg', 'print_left' => 50, 'print_top' => 57],
            ['team' => 'Juventus', 'name' => 'Juventus Pink Jersey 01', 'image' => 'juventus.jpg', 'print_left' => 59, 'print_top' => 64],
            ['team' => 'Juventus', 'name' => 'Juventus Pink Jersey 02', 'image' => 'juventus.jpg', 'print_left' => 34, 'print_top' => 38],
            ['team' => 'Manchester United', 'name' => 'Manchester United Home Jersey', 'image' => 'manchester-united.jpg', 'print_left' => 51, 'print_top' => 55],
            ['team' => 'Chelsea', 'name' => 'Chelsea Jersey', 'image' => 'chelsea.jpg', 'print_left' => 54, 'print_top' => 55],
            ['team' => 'Netherlands', 'name' => 'Netherlands Home Jersey', 'image' => 'netherlands.jpg', 'print_left' => 51, 'print_top' => 59],
            ['team' => 'Portugal', 'name' => 'Portugal Jersey', 'image' => 'portugal.jpg', 'print_left' => 56, 'print_top' => 54],
        ];

        return view('home', compact('jerseys'));
    }
}
