<?php
namespace qinq\Object\Query {
    class Min extends Map {
        /**
         * Retrieves item of smallest value
         * @return integer
         */
        public function execute() {
            return min(parent::execute());
        }
    }
}