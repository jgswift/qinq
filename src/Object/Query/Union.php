<?php
namespace qinq\Object\Query {
    use qinq;
    use qtil;
    
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
                    $arr1 = $args[0];
                } elseif($args[0] instanceof qtil\Interfaces\Collection) {
                    $arr1 = $args[0]->toArray();
                }
                
                if(is_array($arr1)) {
                    $result = array_keys(array_flip($arr) + array_flip($arr1));
                    asort($result);
                    return $result;
                }
            }
            
            return parent::execute();
        }
    }
}
