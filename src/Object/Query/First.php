<?php
namespace qinq\Object\Query {
    use qinq;
    
    class First extends At {
        /**
         * Update collection to only contain first item
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $this->arguments[] = 0;
            return parent::execute();
        }
    }
}