<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Keys extends qinq\Object\Statement\Immutable {
        /**
         * Retrieve all keys of collection
         * @return array
         */
        public function execute() {
            $arr = $this->getCollection()->toArray();
            
            return array_keys($arr);
        }
    }
}
