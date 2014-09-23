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
                $fn = $this->getDefaultSorter($args[0]);
            }
            
            if(is_callable($fn)) {
                usort($arr, $fn);
            }
            
            return $arr;
        }
        
        /**
         * Helper method to provide default filtering callables
         * @param integer $order
         * @return \Closure
         */
        protected function getDefaultSorter($order) {
            $fn = function($n) {
                return $n;
            };
            
            return $this->computeInequality($fn, $order);
        }
        
        /**
         * Helper method to compute inequality and retrieve sorting method
         * @param callable $fn
         * @param integer $order
         * @return \Closure
         */
        protected function computeInequality($fn, $order) {
            if($order === qinq\Order::DESCENDING) {
                $inequation = -1;
            } else {
                $inequation = 1;
            }

            return $this->getSortFn($fn, $inequation);
        }
        
        /**
         * Default helper to compute sorting
         * @param callable $fn
         * @param int $inequation
         * @return \Closure
         */
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