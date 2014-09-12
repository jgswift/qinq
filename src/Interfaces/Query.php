<?php
namespace qinq\Interfaces {
    interface Query extends \IteratorAggregate {
        
        /**
         * @return Collection
         */
        public function getCollection();
        
        /**
         * Update query collection
         * @return Collection
         */
        public function setCollection(Collection $collection);
    }
}