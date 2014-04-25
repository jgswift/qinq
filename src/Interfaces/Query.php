<?php
namespace qinq\Interfaces {
    interface Query extends \IteratorAggregate {
        
        /**
         * @return \qinq\Interfaces\Collection
         */
        public function getCollection();
    }
}