<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Except extends qinq\Object\Statement {
        /**
         * Compute difference between collection and given array
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $args = $this->getArguments();
            
            if(!empty($args)) {
                $except = $args[0];
                foreach($arr as $k => $n) {
                    if(in_array($n,$except)) {
                        unset($arr[$k]);
                    }
                }
                
                return $arr;
            }
        }
    }
}