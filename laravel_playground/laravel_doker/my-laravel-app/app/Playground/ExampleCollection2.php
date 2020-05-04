<?php
namespace App\Playground;
use Illuminate\Support\Collection;
use Str;
use App\Models\User;
use App\Builder\CustomBuilder;

class ExampleCollection2
{
    private $_data;
    public function __construct()
    {
        include 'Warehouse/data.php';
        $this->_data = $__data;
    }

    public function main()
    {
        $data = $this->_data;
        $data["data"]->when(true,
            function ($collection) {
            return $collection->push(4);
        },
            function ($collection){
            return $collection->push(5);
        });

        collect($data["collection"])->mapToGroups(function($item){
            return [$item['product'] => $item['price'] ];
        })->dump()->map(function($item){
           return $item->values()->implode(',');
        })->dump();

        Collection::macro('toUpper', function () {
            return $this->map(function ($value) {
                return Str::upper($value);
            });
        });

        $data["myStr"]->toUpper()->dump();
        User::get()->getOrFail();
    }
}
