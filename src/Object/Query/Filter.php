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
            
            if(is_callable($fn)) {
                foreach($arr as $k=>$v) {
                    $keep = call_user_func_array($fn, [$v,$k]);
                    
                    if(!$keep) {
                        unset($arr[$k]);
                    }
                }
                
                return $arr;
            } else {
                return array_filter($arr);
            }
        }
    }
}