<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Shuffle extends qinq\Object\Statement {
        /**
         * Shuffles collection randomly
         * @return array
         */
        public function execute() {
            $arr = $this->getCollection()->toArray();
            shuffle($arr);
            return $arr;
        }
    }
}
