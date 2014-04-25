<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Unique extends qinq\Object\Statement {
        /**
         * Retrieve unique array values with callable
         * @return array
         */
        function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $fn = $this->getCallback();
            
            if(empty($fn)) {
                return array_unique($arr);
            }
            
            return array_unique(array_filter($arr,$fn));
        }
    }
}