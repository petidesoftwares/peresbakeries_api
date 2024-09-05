<?php
    namespace App\Analytics;

    class Util{

        public function findLargestArraySize($arr_1, $arr_2, $arr_3){
            $maxSize = count($arr_1); 
            if($arr_3 != null){
                if($maxSize < count($arr_2)){
                    $maxSize = count($arr_2);
                }
                elseif($maxSize < count($arr_3)) {
                    $maxSize = count($arr_3);
                }
            }else{
                if($maxSize < count($arr_2)){
                    $maxSize = count($arr_2);
                }
            }

            return $maxSize;
        }
    }