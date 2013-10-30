<?php

namespace Skwal {

    interface CorrelatableReference
    {
        /**
         * @return string
         */
        function getCorrelationName();

        function acceptCorrelatableVisitor(\Skwal\Visitor\Correlatable $visitor);
    }

}