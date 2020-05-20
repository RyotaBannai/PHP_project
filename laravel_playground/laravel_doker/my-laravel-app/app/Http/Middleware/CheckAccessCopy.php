<?php


namespace App\Http\Middleware;

use Closure;
use \App\Models\User;
// use \App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckAccessCopy
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */

    private $req_user_id = '';
    private $session_id = '';
    private $model_name = '';
    private $model = '';
    const model_name_list = [];

    public function __construct()
    {
        //
    }

    private function modelName(Request $request): string
    {
        if($request->routeIs('copy.user')){
            $this->model = User::class;
            return 'user';
        }
        else{
            return 'another';
        }
    }

    public function handle(Request $request, Closure $next) //: Closure|Response
    {
        if( preg_match('/.*\/users\/[0-9]*\/?/', session()->previousUrl()) ) {

            $this->model_name = $this->modelName($request);
            $this->req_user_id = $request->route($this->model_name)->id;
            $this->session_id = $this->model_name.'_data_'.$this->req_user_id;

            if (\Session::has($this->session_id) &&
                \Session::get($this->session_id) instanceof $this->model) {

                dump(1);
                $request->merge(['is_model_instance_set' => true, 'model_name' => $this->model_name]);
                $response = $next($request);
                return $response;
            }
            else {
                dump(2);
                //return redirect('/');
                return $next($request);
            }
        }
        dump(3);
        return $next($request);
    }


    /**
     * 時にHTTPレスポンスがブラウザに送られた後に、ミドルウェアが何かの作業を行う必要があることもある
     * terminateメソッドをミドルウェアへ追加すれば、ブラウザへレスポンスを送った後、自動的に呼び出す
     * */
    public function terminate(Request $request, Response $response): void
    {
        if (!\Session::has($this->session_id) ||
            (\Session::has($this->session_id) && !(\Session::get($this->session_id) instanceof $this->model))) {

            $model_instance = \Arr::get($response->getOriginalContent()->getData(), $this->model_name, null);

            \Session::put($this->session_id, $model_instance);
            \Session::save();
        }

        // \Log::info(['This is session id', $this->session_id]);
        // \Redis::command('GET', [0]);
        // \Redis::command('SET', [0, 'random text']);
    }
}
