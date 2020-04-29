<?php

class OutObj
{
    public function tt()
    {
         $cpu  = 2;
         $inner = function (...$params) use ($cpu){
             return array_sum($params) * $cpu;
         } ;

         $c = $inner(1, 2, 4);
         print_r($c);
         // echo 14
        return $c;
    }


}

test();

function test(){
 // design_java/behavior_type/command/Command.php

    $b = 4;
    $obj = new OutObj();
    $ret =  $obj->tt();

}



