<?php

namespace App\Gates;

class AccessCopyGate
{
    private $value = '';
    public function __construct()
    {
        //
    }

    public function whenValidationError(array $arr){
        /*
         * バリデーションエラーで戻る場合
         * */

        if (count($arr) === 3){
            return true;
        }
        else{
            return false;
        }

    }
    public function fromCreatePage(){
        /*
         * 正式な方法で作成してる場合
         * */
    }

}
