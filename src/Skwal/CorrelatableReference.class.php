<?php

namespace Skwal {

    /**
     * Interface for items serving as parents in correlation-type relationships.
     * @author thibaud
     *
     */
    interface CorrelatableReference extends TableReference
    {
        /**
         * @return string
         */
        function getCorrelationName();
    }

}