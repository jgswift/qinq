<?php
namespace qinq\Object\Query {
    class Pluck extends Values {
        /**
         * Retrieves values by an array field or object property
         * @return array
         */
        public function execute() {
            $args = $this->getArguments();
            
            $field = null;
            if(count($args) === 1) {
                $field = $args[0];
            }
            
            if(is_string($field)) {
                return $this->computeRelatedFields($field);
            } 
            
            return parent::execute();
        }
        
        /**
         * Helper method to compute result from array or object list
         * @param string $field
         * @return \ArrayAccess
         */
        private function computeRelatedFields($field) {
            $arr = $this->getCollection()->toArray();
            
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
    }
}
