<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Union extends Unique {
        /**
         * Performs native array union operation
         * @return array
         */
        function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $args = $this->getArguments();
            
            $fn = $this->getCallback();
            
            $arr1 = null;
            if(empty($fn) && count($args) === 1) {
                if(is_array($args[0])) {
                    $arr1 = new qinq\Collection($args[0]);
                } elseif($args[0] instanceof qinq\Interfaces\Collection) {
                    $arr1 = $args[0];
                }
                
                if($arr1 instanceof qinq\Interfaces\Collection) {
                    $result = array_keys(array_flip($arr) + array_flip($arr1->toArray()));
                    asort($result);
                    return $result;
                }
            }
            
            return parent::execute();
        }
    }
}