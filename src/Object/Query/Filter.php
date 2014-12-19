<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Filter extends qinq\Object\Statement {
        /**
         * Filters array values
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $fn = $this->getCallback();
            
            $args = $this->getArguments();
            
            if(is_callable($fn)) {
                return $this->filter($arr,$fn,$args);
            } else {
                return array_filter($arr);
            }
        }
        
        /**
         * Performs filtering with callback function
         * This function ensures key is provided as second argument
         * unlike default array_filter
         * @param array $arr
         * @param callable $fn
         * @param array $args
         * @return array
         */
        public function filter($arr, $fn, array $args = []) {
            foreach($arr as $k=>$v) {
                $keep = call_user_func_array($fn, array_merge([$v,$k],$args));

                if(!$keep) {
                    unset($arr[$k]);
                }
            }

            return $arr;
        }
    }
}
