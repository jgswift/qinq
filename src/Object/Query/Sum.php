<?php
namespace qinq\Object\Query {
    class Sum extends Map {
        /**
         * Adds all array values together
         * @return integer
         */
        public function execute() {
            return array_sum(parent::execute());
        }
    }
}