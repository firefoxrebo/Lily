<?php

namespace Lily\Core\Validation;

interface ValidationInterface
{

    /**
     * Prepare the regular expression to validate data
     */
    function prepareRegexPattern();

    /**
     * @param $data mixed
     * Validates a given data against a regular expression
     */
    function isValid($data);

}