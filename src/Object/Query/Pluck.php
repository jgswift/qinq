<?php
namespace qinq\Object\Query {
    use qtil;
    
    class Pluck extends Values {
        /**
         * Retrieves values by an array field or object property
         * @return array
         */
        public function execute() {
            $arr = $this->getCollection()->toArray();
            
            $args = $this->getArguments();
            
            $field = null;
            if(count($args) === 1) {
                $field = $args[0];
            }
            
            
            if(is_string($field)) {
                $result = [];
                foreach($arr as $item) {
                    if(is_object($item) && isset($item->$field)) {
                        $result[] = $item->$field;
                    } elseif((is_array($item) || $item instanceof \ArrayAccess) &&
                             isset($item[$field])) {
                        $result[] = $item[$field];
                    }
                }
                
                return $result;
            } 
            
            return parent::execute();
        }
    }
}