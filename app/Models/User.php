<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * ユーザー情報を管理するクラス
 * Authenticatableを継承することで、LaravelのAuth機能（ログインチェック等）が使用可能になる
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * 複数代入（Mass Assignment）を許可する属性
     * コントローラ側から　User::create([...])でデータベースに一括保存したい項目をここに登録する
     * @var list<string>
     */
    protected $fillable = [
        'name',     // 名前
        'password',     // パスワード
    ];

    public $timestamps = false;
    /**
     * The attributes that should be hidden for serialization.
     *　配列等に変更する際に非表示にする属性
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    /**
     * Get the attributes that should be cast.
     * データの型変換を指定する属性
     * データベースから値を取り出す際、自動で指定のデータ型に変更してくれる
     * @return array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',     // パスワードがハッシュ化されていることをLaravelに通知
    ];
    
}
