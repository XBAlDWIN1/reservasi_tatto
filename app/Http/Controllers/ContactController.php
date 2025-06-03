<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'message' => 'required',
        ]);

        $whatsappNumber = '+6285252630364'; // ganti dengan nomor tujuan
        $name = urlencode($request->name);
        $message = urlencode($request->message);

        $text = "Halo, saya $name. $message";

        return redirect()->away("https://wa.me/$whatsappNumber?text=$text");
    }
}
