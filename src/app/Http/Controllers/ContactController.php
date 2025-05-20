<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\StreamedResponse;
use symforny\Component\HttpFoundation\Rsponse;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }


    public function confirm(ContactRequest $request)
    {
        $contact = $request->only([
            'last_name', 'first_name', 'email', 'gender','address','building','detail', 'category_id']);

        $contact['tel1'] = $request->input('tel1');
        $contact['tel2'] = $request->input('tel2');
        $contact['tel3'] = $request->input('tel3');
        $contact['tel'] = $contact['tel1'] . $contact['tel2'] . $contact['tel3'];

        $contact['category'] = Category::find($request->input('category_id'));

        return view('confirm', compact('contact'));
    }

    public function store(ContactRequest $request)
    {
        // dd($request->all());
        $contact = $request->only(['first_name','last_name', 'email', 'tel', 'gender','address','building','detail', 'category_id','content']);

        $contact['tel1'] = $request->input('tel1');
        $contact['tel2'] = $request->input('tel2');
        $contact['tel3'] = $request->input('tel3');
        $contact['tel'] = $contact['tel1'] . $contact['tel2'] . $contact['tel3'];

        $genderMap = ['男性' => 1, '女性' => 2, 'その他' => 3];
        $contact['gender'] = $genderMap[$contact['gender']];

        $contact['category'] = Category::find($request->input('category_id'));

        Contact::create($contact);

        return view('thanks');
    }


    public function thanks()
    {
        return view('thanks');
    }


    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function admin()
    {
        $contacts = Contact::with('category')->Paginate(7);
        $categories = Category::all();
        $csvData = Contact::all();

        return view('admin', compact('contacts', 'categories', 'csvData'));

    }

    public function destroy(Request $request)
    {
        Contact::find($request->id)->delete();
        return redirect('admin');
    }

    public function search(Request $request)
    {
        if ($request->has('reset')) {
            return redirect('admin')->withInput();
        }
        $query = Contact::query();
        $query = $this->getSearchQuery($request, $query);

        $contacts = $query->paginate(7);
        $csvData = $query->get();
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories', 'csvData'));
    }

    public function export(Request $request)
    {
        $query = Contact::query();//クエリビルダ（検索準備）のインスタンスを代入
        $query = $this->getSearchQuery($request, $query);//条件を追加（まだSQL未発行）
        $csvData = $query->get()->toArray();//$queryに対してSQL発行し、検索条件に合ったデータ全て取得。戻り値はlaravel独自のcollectionオブジェクト。これを配列に変換し外部処理（ネイティブPHP関数）でも扱いやすくなる形式に整えている。foreachしやすくなる。
        $csvHeader = [
            'id',
            'category_id',
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'detail',
            'created_at',
            'updated_at',
        ];//csvのタイトル行　テーブルやカラム定義とは無関係
        $response = new StreamedResponse(function()use ($csvHeader, $csvData) {//StreamedResponse（csvファイルをストリーム(分割順次処理でダウンロード)としてブラウザに直接返すためのlravelにあるクラス。function内でデータを書き出す処理を自分で定義可）のインスタンスをnew。use()の無名関数でその場で定義。$csvHeader, $csvData変数を関数の中に持ち込んで使用可能にする。

            $createCsvFile = fopen('php://output', 'w');//fopen(PHPの組み込み関数、ファイルやストリームを開く関数）fopen(ファイル名, モード)。'php://output'はブラウザに直接出力するための仮想ファイル（出力用ストリーム：標準出力）'w'は書き込みモード。＊出力ストリームを開いてそのファイルポインタを$createCsvFileに代入。

            mb_convert_variables('SJIS-win', 'UTF-8', $csvHeader);//PHP標準関数。csvはSJIS-winで作成するため（UTF-8でエクセルで開くと文字化け）mb_convert_variables('変換先', '変換元', $変換対象の変数)←元の変数を直接変更。$createCsvFileには関係ない。

            fputcsv($createCsvFile, $csvHeader);//csv形式で１行書き込む。fputcsv(ファイルポインタ, 配列);　$createCsvFile を「書き込み先」として、$csvHeaderの中身を１行書き込む。

            foreach ($csvData as $csv) {
                $csv['created_at'] = Date::make($csv['created_at'])->setTimezone('Asia/tokyo')->format('Y/m/d H:i:s');
                $csv['updated_at'] = Date::make($csv['updated_at'])->setTimezone('Asia/tokyo')->format('Y/m/d H:i:s');
                fputcsv($createCsvFile, $csv);
            }//csvDataの中身を１行ずつ出力。＊headerは$csvHeaderの並びで出力される。＄csvDataはその配列の並びで出力されるので、$csvHeaderの並びを実データに合わせるか、記述で一致させる処理して出力（安全再利用性高 notion参照）しないとヘッダーと実データがズレる可能性あり。
            fclose($createCsvFile);//開いていた出力ストリーム（php://output＝ブラウザへの出力をファイルのように扱っている）を明示的に閉じることでメモリを解放し確実に全ての出力が完了したことを宣言


        }, 200, [
            'Content-Type' => 'text_csv',//レスポンスの中身の種類を指定
            'Content-Disposition' => 'attachment; filename="contacts.csv"',
        ]);//第２引数はリクエストの処理結果をクライアント側に返すHTTPステータスコード。200成功をブラウザへ通知。失敗の時はlaravelが500など返す。第３引数でHTTPヘッダー情報を明示しブラウザに正しく認識・処理させる。Content-Dispositionで画面表示かダウンロードか指定。attachmentで保存用と指定（inlineはブラウザで開く）。filename="contacts.csv"でダウンロード時のデフォルトのファイル名を指定。＊Content-Disposition ＝> <処理方法>; <追加情報>

        return $response;//ブラウザでダウンロード
    }

    private function getSearchQuery($request, $query)
    {
        // dd($request->all());
        if(!empty($request->keyword)) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword. '%');

            });
        }
        if (!empty($request->gender)) {
            $query->where('gender', '=', $request->gender);
        }
        if (!empty($request->category_id)) {
            $query->where('category_id', '=', $request->category_id);
        }
        if (!empty($request->date)) {
            $query->whereDate('created_at', '=', $request->date);
        }

        return $query;
    }
};