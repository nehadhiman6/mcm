<?php

namespace App\Http\Controllers;

use App\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
    }

 
    public function create()
    {
        return view('donation.create');
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Donation $donation)
    {
        //
    }

 
    public function edit(Donation $donation)
    {
        //
    }


    public function update(Request $request, Donation $donation)
    {
        //
    }

 
    public function destroy(Donation $donation)
    {
        //
    }
}
