<?php
namespace qinq\Object\Statement {
    use qinq\Object\Statement;
    
    class Immutable extends Statement {
        /**
         * Immutable statements are immutable statements
         * @return boolean
         */
        function getMutable() {
            return false;
        }
    }
}
