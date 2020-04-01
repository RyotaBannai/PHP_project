<?php
class Food{
    private $foods = array(
        'bacon',
        'eggs',
        'tomato',
        );
    public function show_foods(){
        foreach($this->foods as $food){
            echo $food, PHP_EOL;
        }
    }
}