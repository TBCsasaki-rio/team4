<?php
namespace App\Http\Controllers;

use App\Models\User;    // DB関係のファイル
use Illuminate\Http\Request;    // ユーザからの入力を扱うためのツール
use Illuminate\Support\Facades\Auth;    // ユーザの状態を管理・チェックする
use Illuminate\Support\Facades\Hash;    // パスワードのハッシュ化

class AccountController extends Controller
{
    // ================================================
    // ログイン機能
    // ================================================

    // ログイン画面を表示する
    public function index()
    {
        // 入力値は空でビューを表示
        return view('login', [
            'name' => '',
            'password' => ''
        ]);
    }

    // ログイン処理
    public function login(Request $request)
    {
        // エラーメッセージ配列
        $errorList = [];

        // 入力値を取得
        $name = $request->input('name');
        $password = $request->input('password');

        // 入力チェック
        if(empty($name)) {
            // 未入力チェック
            $errorList[] = '名前を入力してください';
        }
        if(empty($password)) {
            // 未入力チェック
            $errorList[] = 'パスワードを入力してください';
        }
        
        // 名前とパスワードが入力されている場合のみ、パスワードの照合を行う
        if(empty($errorList)) {
            // パスワードの照合
            $credentails = ['name' => $name, 'password' => $password];

            //Auth::attemptは成否を true / false で返す
            if(!Auth::attempt($credentails)) {
                // パスワードが間違っていた場合
                $errorList[] = 'ユーザ名またはパスワードが正しくありません';
            }
        }

        // エラーが発生していた場合
        if (!empty($errorList)) {
            //エラーメッセージと、入力された名前を保持してログイン画面に戻る
            return view('login', [
                'errorList' => $errorList,
                'name' => $name
            ]);
        }

        // ログイン成功時：セッションの再作成
        $request->session()->regenerate();

        // ログイン後、商品一覧画面に遷移
        return redirect()->route('products');
    }


    // ================================================
    // 会員新規登録機能
    // ================================================

    // 会員新規登録画面の表示
    public function signUp()
    {
        // 入力値は空でビューを表示
        return view('accountform', [
            'errorList' => [],
            'name' => '',
            'password' => ''
        ]);
    }

    // 会員新規登録の処理
    public function createUser(Request $request)
    {
        // エラーメッセージ配列
        $errorList = [];

        // 入力値を取得
        $name = $request->input('name', '');
        $password = $request->input('password', '');

        // 入力値チェック
        if (empty($name)) {
            $errorList[] = '名前を入力してください';
        }
        if (empty($password)) {
            $errorList[] = 'パスワードを入力してください';
        }

        // エラーがある場合
        if (!empty($errorList)) {
            // エラーリストと入力された値を連想配列にまとめる
            $data = [
                'errorList' => $errorList,
                'name' => $name,
                'password' => $password 
            ];

            // 入力画面に戻る
            return view('login', $data);
        }

        // データベースに登録
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        // 登録と同時に自動ログイン
        Auth::Login($user);

        // 商品一覧画面に遷移
        return redirect()->route('products');
    }



    // ================================================
    // ログアウト処理
    // ================================================
    public function logout(Request $request)
    {
        // ログアウトを実行
        Auth::logout();

        //現在のセッションを無効化
        $request->session()->invalidate();

        // CSRFトークンの再作成
        $request->session()->regenerateToken();

        // ログアウト後、ログイン画面に遷移
        return redirect()->route('login');
    }
}
?>