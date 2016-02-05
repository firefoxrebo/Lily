<?php
namespace Lily\Core\Validation;

/**
 * Class AlphaValidator
 * @package Lily\Core\Validation
 * Validates a string alphabet set of characters
 */
class AlphaValidator implements ValidationInterface
{

    /**
     * @var array
     * Validation options array is created
     * upon instantiation after validating
     * supplied options array
     */
    private $_validateOptions = array();

    /**
     * @var array
     * Available validator options
     */
    private $_preDefinedOptions = array(
        'allowWhiteSpaces',
        'allowUnderscore',
        'allowDash'
    );

    /**
     * @var string
     * The basic regular expression pattern
     * to match against
     */
    private $_patternComponents = 'a-zA-Z';

    /**
     * @var string
     * The final regular expression pattern
     * which is built upon supplied options
     */
    private $_pattern = '';

    public function __construct(array $options = array())
    {
        if (!empty($options)) {
            foreach ($options as $option) {
                if (!in_array($option, $this->_preDefinedOptions)) {
                    trigger_error('The validation option ' . $option . ' is not a valid option', E_USER_ERROR);
                }
            }
        }
        $this->_validateOptions = $options;
        $this->prepareRegexPattern();
    }

    /**
     * Build the final regular expression pattern
     * after checking the supplied options
     */
    public function prepareRegexPattern ()
    {
        if(in_array('allowWhiteSpaces', $this->_validateOptions)) {
            $this->_patternComponents .= '\s';
        }

        if(in_array('allowUnderscore', $this->_validateOptions)) {
            $this->_patternComponents .= '_';
        }

        if(in_array('allowDash', $this->_validateOptions)) {
            $this->_patternComponents .= '\-';
        }

        $this->_pattern = '/[^' . $this->_patternComponents . ']/imu';
    }

    /**
     * Validates the given data against the alphabet regular expression
     * @param mixed $data
     * @return bool
     */
    public function isValid($data)
    {
        return !preg_match($this->_pattern, $data);
    }
}