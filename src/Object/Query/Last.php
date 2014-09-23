<?php
namespace qinq\Object\Query {
    class Last extends At {
        /**
         * Update collection to only contain last item
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $this->arguments[] = count($collection)-1;
            return parent::execute();
        }
    }
}
