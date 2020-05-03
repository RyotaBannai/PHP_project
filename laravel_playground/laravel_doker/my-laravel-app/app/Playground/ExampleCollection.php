<?php
namespace App\Playground;
use Illuminate\Support\Collection;

class ExampleCollection
{
    public function main(){
        $data = collect([1,2,3,4,5,6,7,8]);
        $data2 = collect([
            [1,2,3],
            [4,5,6],
            ]);
        $data3 = collect([10,25,50]);

        $collection = collect([
           ['product'=> 'apple', 'price'=> 59],
           ['product'=> 'apple', 'price'=> 69],
           ['product'=> 'banana', 'price'=> 54],
           ['product'=> 'banana', 'price'=> 94],
        ]);


        $new = $data->mapInto(Converter::class)
            ->map(function($items){
               return $items->toCentimeters();
            });


        $new = $data->chunk(2) //get data by a chunk of two.
        ->mapSpread(function($first, $second){ // use data by the chunk
            return $first * $second;
        });

        // $new = $collection->mapToDictionary(function($item){
        $new = $collection->mapToGroups(function($item){
           return [$item['product'] => $item['price']];
        })->map(function($item){
            return $item->max(); // return max value in values
        });

        $new = $collection->where('price', '54'); // whereStrict makes it ===, where makes it ==
        $new = $data2->collapse(); // the opposite of chunk method. // collapse spread only first layer.

        $new = $collection->filter(function($item){
            return $item['product'] == 'apple';
        });

        $new = $data3->diffUsing([.1, .25], function($a, $b){
            return $a === (int)($b*100) ? 0 : -1;
        });

        $Array1 = [1,2,3,4];
        $Array2 = [5,6,7,8];
        // dump(self::everyThree($Array1, $Array2, [10,11,12,13]));
        $collection->pluck('product')->dump();

        return true;
    }
    //public function everyThree($collection1, $collection2)
    public function everyThree(...$collection)
    {
//        if(is_array($collection1)){
//            $collection1 = collect($collection1);
//        }
//        if(is_array($collection2)){
//            $collection2 = collect($collection2);
//        }

//        return Collection::wrap($collection1)->nth(3)
//            ->merge(Collection::wrap($collection2)->nth(3));

        return collect($collection)->flatMap(function($item){
            return Collection::wrap($item)->nth(3);
        });
    }
}

class Converter
{
    private $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }
    public function toCentimeters()
    {
        return $this->amount * 2.54;
    }
}
