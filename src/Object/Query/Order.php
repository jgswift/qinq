<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Order extends qinq\Object\Statement {
        /**
         * Sorts array values using callable filter
         * @return array
         */
        public function execute() {
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
                    $inequation = -1;
                } else {
                    $inequation = 1;
                }
                
                $sortFn = $this->getSortFn($fn, $inequation);
                
                usort($arr,$sortFn);
            }
            
            return $arr;
        }
        
        protected function getSortFn($fn,$inequation) {
            return function($a,$b)use($fn,$inequation) {
                $aR = $fn($a);
                $bR = $fn($b);
                if($aR == $bR) {
                    return 0;
                } elseif($inequation === -1 && $aR > $bR) {
                    return -1;
                } elseif($inequation === 1 && $aR < $bR) {
                    return -1;
                } else {
                    return 1;
                }
            };
        }
    }
}