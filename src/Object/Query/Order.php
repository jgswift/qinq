<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Order extends qinq\Object\Statement {
        /**
         * Sorts array values using callable filter
         * @return array
         */
        function execute() {
            $collection = $this->getCollection();
            $arr = $collection->toArray();
            $fn = $this->getCallback();
            $args = $this->getArguments();
            
            if(empty($fn) && !empty($args)) {
                $fn = function($n) {
                    return $n;
                };
            }
            
            if(is_callable($fn)) {
                if(in_array(qinq\Order::Descending,$args)) {
                    $sortFn = function($a,$b)use($fn) {
                        $aR = $fn($a);
                        $bR = $fn($b);
                        if($aR == $bR) {
                            return 0;
                        } elseif($aR > $bR) {
                            return -1;
                        } else {
                            return 1;
                        }
                    };
                } else {
                    $sortFn = function($a,$b)use($fn) {
                        $aR = $fn($a);
                        $bR = $fn($b);
                        if($aR == $bR) {
                            return 0;
                        } elseif($aR < $bR) {
                            return -1;
                        } else {
                            return 1;
                        }
                    };
                }
                
                usort($arr,$sortFn);
            }
            
            return $arr;
        }
    }
}