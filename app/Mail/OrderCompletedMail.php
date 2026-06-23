<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OrderCompletedMail extends Mailable
{
    public $order;

    // ✅ 注文データを受け取る
    public function __construct($order)
    {
        $this->order = $order;
    }

    // ✅ メールの設定
    public function build()
    {
        return $this
            ->subject('【ご注文ありがとうございます】') // 件名
            ->view('emails.order_completed');   // メールのHTML
    }
}

