<?php
namespace qinq\Object\Query {
    class Max extends Map {
        /**
         * Retrieves item of largest value
         * @return integer
         */
        public function execute() {
            return max(parent::execute());
        }
    }
}
