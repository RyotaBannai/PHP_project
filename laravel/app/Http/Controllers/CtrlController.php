<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CtrlController extends Controller
{
    public function plain(){
        return response('Hello', 200)->header('Content-Type', 'text/plain');
        //response architect text, status, headers
    }

    public function header(){
        return response()
        ->view('ctrl.header', ['msg'=>'view + header!'], 200)
        ->header('Content-Type', 'text/xml');
        //response architect text, status, headers

        /*複数のheaderを返したいときは, withHeaders([
            'Content-Type', 'text/xml',
            ...
        ])*/
    }
    public function outJson(){
        return response()
        ->json([
            'name'=>'Yoshihiro, YAMADA',
            'sex'=>'male',
            'age'=>18,
        ]);
        //->withCallback('callback'); // for json-p
    }
    
    //ファイルをダウンロードする.
    public function outCSV(){
        
        return response()
        /*
        ->download('directory', 'downloard,csv', 
        ['content-type'=>'text/csv']);

        //指定されたファイルをそのままスクリーンに表示する.
        ->file('directory', ['content-type'=>'image/png']); 
        */
        ->streamDownLoad(function(){
            print(
                "1,2019/10/1,123\n".
                "2,2019/10/2,116\n".
                "3,2019/10/3.98\n"
            );
        }, 'download.csv', ['content-type'=>'text/csv']);
    }

    public function redirectBasic(){
        //return redirect('ctrl.outJson'); // path name
        return redirect()->route('outJson'); // route name

        //return redirect()->route('outJson', ['id'=>10]); // route name with param

        //return redirect()->action('CtrlController@outJson', ['id'=>10]);

        //return redirect()->away('other web page url');
    }
}
