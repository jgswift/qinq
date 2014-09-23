<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Reduce extends qinq\Object\Statement {
        /**
         * Iteratively reduce the array to a single value using a callback function
         * @return array
         */
        public function execute() {
            $arr = $this->getCollection()->toArray();
            
            $fn = $this->getCallback();
            
            $args = $this->getArguments();
            
            $initial = null;
            if(!empty($args)) {
                $initial = $args[0];
            }
            
            return [array_reduce($arr, $fn, $initial)];
        }
    }
}
