<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Search extends qinq\Object\Statement {
        /**
         * Searches multidimensional array values
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $fn = $this->getCallback();
            
            $args = $this->getArguments();
            
            if(is_callable($fn)) {
                return $this->recurse($arr,$fn,$args);
            } else {
                return array_filter($arr);
            }
        }
        
        /**
         * Recursively searches array
         * @param array $array
         * @param callable $fn
         * @param array $args
         * @return array
         */
        protected function recurse(array $array, callable $fn, array $args) {
            foreach($array as $key => $value) {
                if(\qtil\ArrayUtil::isIterable($value)) {
                    $array[$key] = $this->recurse($value,$fn,$args);
                } elseif(!$this->search($fn,array_merge([$value,$key],$args))) {
                    unset($array[$key]);
                }
            }
            
            return $array;
        }
        
        /**
         * Performs search callback
         * @param callable $fn
         * @param array $args
         * @return boolean
         */
        protected function search(callable $fn, array $args) {
            return call_user_func_array($fn, $args);
        }
    }
}