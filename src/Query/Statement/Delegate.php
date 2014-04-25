<?php
namespace qinq\Query\Statement {
    use delegatr;
    
    /**
     * Helper Delegate
     * enables closure serialization
     */
    class Delegate implements \Serializable {
        use delegatr\Serializable;
    }
}