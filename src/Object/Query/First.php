<?php
namespace qinq\Object\Query {
    class First extends At {
        /**
         * Update collection to only contain first item
         * @return array
         */
        public function execute() {
            $this->arguments[] = 0;
            return parent::execute();
        }
    }
}
