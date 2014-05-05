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
                return array_filter($arr,$fn);
            } else {
                return array_filter($arr);
            }
        }
    }
}