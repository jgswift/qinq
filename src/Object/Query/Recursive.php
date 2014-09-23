<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Recursive extends qinq\Object\Statement {
        /**
         * maps multidimensional array content given callable mapping function
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $fn = $this->getCallback();
            
            if(empty($fn)) {
                return $arr;
            }
            
            return $this->recurse($arr,$fn);
        }
        
        /**
         * Recursively maps array values
         * @param array $array
         * @param callable $callback
         * @return array
         */
        protected function recurse(array $array, callable $callback) {
            foreach ($array as $key => $value) {
                if (is_array($array[$key])) {
                    $array[$key] = $this->recurse($array[$key], $callback);
                } else {
                    $array[$key] = call_user_func($callback, $array[$key]);
                }
            }
            return $array;
        }
    }
}
