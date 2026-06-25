<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCompletedMail; // ← ★これ重要！

class MailController extends Controller
{
    public function complete(Request $request)
    {
        $order = (object)[
            'id' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'total' => 1000,
            'items' => []
        ];

        Mail::to($order->email)
            ->send(new OrderCompletedMail($order));

        return view('ordercomp');
    }
}