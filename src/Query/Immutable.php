<?php
namespace qinq\Query {
    use qinq;
    
    class Immutable extends Mutable{
        /**
         * Query execution immutable
         * source will not be modified
         * @return \qinq\Collection
         */
        function execute() {
            $result = new qinq\Collection();
            $oldCollection = $this->collection;
            
            $this->collection = $result;
            
            parent::execute();
            
            $this->collection = $oldCollection;
                        
            if(!is_null($result)) {
                return $result;
            }
            
            return $this->collection;
        }
    }
}
