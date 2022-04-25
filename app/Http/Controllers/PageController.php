<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
   public function policy()
   {
      return view('pages.policy');
   }

   public function contact()
   {
      return view('pages.contact');
   }
}
