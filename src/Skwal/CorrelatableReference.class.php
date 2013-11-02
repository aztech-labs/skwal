<?php

namespace Skwal {

    /**
     * Interface for items serving as parents in correlation-type relationships.
     * @author thibaud
     *
     */
    interface CorrelatableReference
    {
        /**
         * @return string
         */
        function getCorrelationName();

        function acceptCorrelatableVisitor(\Skwal\Visitor\Correlatable $visitor);
    }

}