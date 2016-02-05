<?php
namespace Lily\Core\Form;
/**
 * Factory Input Class is used to build 
 * an instance of an input type. Refer to the 
 * valid input types constants to select the input
 * type you want to istantiate. For more information please
 * refer to the documentation.
 * @author Mohammed Yehia
 *
 */
class Input
{

    /**
     * Input type button
     *
     * @var string
     */
    const INPUT_TYPE_BUTTON = 'InputButton';

    /**
     *
     * @var unknown
     */
    const INPUT_TYPE_CHECKBOX = 'InputCheckbox';

    const INPUT_TYPE_COLOR = 'InputColor';

    const INPUT_TYPE_DATE = 'InputDate';

    const INPUT_TYPE_DATETIME = 'InputDateTime';

    const INPUT_TYPE_DATETIMELOCAL = 'InputDateTimeLocal';

    const INPUT_TYPE_EMAIL = 'InputEmail';

    const INPUT_TYPE_FILE = 'InputFile';

    const INPUT_TYPE_HIDDEN = 'InputHidden';

    const INPUT_TYPE_IMAGE = 'InputImage';

    const INPUT_TYPE_MONTH = 'InputMonth';

    const INPUT_TYPE_NUMBER = 'InputNumber';

    const INPUT_TYPE_PASSWORD = 'InputPassword';

    const INPUT_TYPE_RADIO = 'InputRadio';

    const INPUT_TYPE_RANGE = 'InputRange';

    const INPUT_TYPE_RESET = 'InputReset';

    const INPUT_TYPE_SEARCH = 'InputSearch';

    const INPUT_TYPE_SUBMIT = 'InputSubmit';

    const INPUT_TYPE_TEXT = 'InputText';

    const INPUT_TYPE_TIME = 'InputTime';

    const INPUT_TYPE_URL = 'InputURL';

    const INPUT_TYPE_WEEK = 'InputWeek';

    /**
     * Gloabl INPUT attributes *
     */
    protected $_accept;

    protected $_autoComplete;

    protected $_autoFocus;

    protected $_disabled;

    protected $_form;

    protected $_formNoValidate;

    protected $_list;

    protected $_max;

    protected $_maxLength;

    protected $_min;

    protected $_multiple;

    protected $_pattern;

    protected $_placeholder;

    protected $_readonly;

    protected $_required;

    protected $_size;

    protected $_step;

    protected $_value;

    protected $_attributes = array();

    protected $_globalAttributes = array();

    protected $_inputAttributesString;

    /**
     * General Required Attributes
     */
    protected $_name;

    protected $_label;

    protected $_class;

    protected $_id;

    public function buildInput (array $data)
    {
        if(!array_key_exists('type', $data)) {
            trigger_error('You need to specify a valid input type', E_USER_ERROR);
        }
        $inputClass = __NAMESPACE__ . '\\' . $data['type'];
        $input = new $inputClass ();
        
        if (array_key_exists('attributes', $data)) {
            $input->_attributes = $data['attributes'];
        } else {
            trigger_error(
                    'You need to provide the attributes array with at least name and label attributes', 
                    E_USER_ERROR);
        }
        
        if (array_key_exists('global', $data)) {
            $input->_globalAttributes = $data['global'];
        }
        
        $input->_prepareAttributList();
        $input->_buildInputAttributesString();
        
        return $input;
    }

    /**
     *
     * @return the $_accept
     */
    public function getAccept ()
    {
        return $this->_accept;
    }

    /**
     *
     * @return the $_autoComplete
     */
    public function getAutoComplete ()
    {
        return $this->_autoComplete;
    }

    /**
     *
     * @return the $_autoFocus
     */
    public function getAutoFocus ()
    {
        return $this->_autoFocus;
    }

    /**
     *
     * @return the $_disabled
     */
    public function getDisabled ()
    {
        return $this->_disabled;
    }

    /**
     *
     * @return the $_form
     */
    public function getForm ()
    {
        return $this->_form;
    }

    /**
     *
     * @return the $_formNoValidate
     */
    public function getFormNoValidate ()
    {
        return $this->_formNoValidate;
    }

    /**
     *
     * @return the $_list
     */
    public function getList ()
    {
        return $this->_list;
    }

    /**
     *
     * @return the $_max
     */
    public function getMax ()
    {
        return $this->_max;
    }

    /**
     *
     * @return the $_maxLength
     */
    public function getMaxLength ()
    {
        return $this->_maxLength;
    }

    /**
     *
     * @return the $_min
     */
    public function getMin ()
    {
        return $this->_min;
    }

    /**
     *
     * @return the $_multiple
     */
    public function getMultiple ()
    {
        return $this->_multiple;
    }

    /**
     *
     * @return the $_pattern
     */
    public function getPattern ()
    {
        return $this->_pattern;
    }

    /**
     *
     * @return the $_placeholder
     */
    public function getPlaceholder ()
    {
        return $this->_placeholder;
    }

    /**
     *
     * @return the $_readonly
     */
    public function getReadonly ()
    {
        return $this->_readonly;
    }

    /**
     *
     * @return the $_required
     */
    public function getRequired ()
    {
        return $this->_required;
    }

    /**
     *
     * @return the $_size
     */
    public function getSize ()
    {
        return $this->_size;
    }

    /**
     *
     * @return the $_step
     */
    public function getStep ()
    {
        return $this->_step;
    }

    /**
     *
     * @return the $_value
     */
    public function getValue ()
    {
        return $this->_value;
    }

    /**
     *
     * @return the $_name
     */
    public function getName ()
    {
        return $this->_name;
    }

    /**
     *
     * @return the $_label
     */
    public function getLabel ()
    {
        return $this->_label;
    }

    /**
     *
     * @param field_type $_accept            
     */
    public function setAccept ($_accept)
    {
        $this->_accept = $_accept;
    }

    /**
     *
     * @param field_type $_autoComplete            
     */
    public function setAutoComplete ($_autoComplete)
    {
        if ($_autoComplete === FormBuilder::FORM_AUTOCOMPLETE_OFF ||
                 $_autoComplete === FormBuilder::FORM_AUTOCOMPLETE_ON) {
            $this->_autoComplete = $_autoComplete;
        } else {
            trigger_error('Invalid value given for autocomplete attribute', 
                    E_USER_ERROR);
        }
    }

    /**
     *
     * @param field_type $_autoFocus            
     */
    public function setAutoFocus ($_autoFocus)
    {
        if ($_autoComplete === FormBuilder::FORM_AUTOFOCUS) {
            $this->_autoFocus = $_autoFocus;
        } else {
            trigger_error('Invalid value given for autofocus attribute', 
                    E_USER_ERROR);
        }
    }

    /**
     *
     * @param field_type $_disabled            
     */
    public function setDisabled ($_disabled)
    {
        if ($_disabled === FormBuilder::FORM_INPUT_DISABLED) {
            $this->_disabled = $_disabled;
        } else {
            trigger_error('Invalid value given for disabled attribute', 
                    E_USER_ERROR);
        }
    }

    /**
     *
     * @param field_type $_form            
     */
    public function setForm ($_form)
    {
        $this->_form = $_form;
    }

    /**
     *
     * @param field_type $_formNoValidate            
     */
    public function setFormNoValidate ($_formNoValidate)
    {
        $this->_formNoValidate = FormBuilder::FORM_NOVALIDATE;
    }

    /**
     *
     * @param field_type $_list            
     */
    public function setList ($_list)
    {
        $this->_list = $_list;
    }

    /**
     *
     * @param field_type $_max            
     */
    public function setMax ($_max)
    {
        $this->_max = $_max;
    }

    /**
     *
     * @param field_type $_maxLength            
     */
    public function setMaxLength ($_maxLength)
    {
        if (filter_var($_maxLength, FILTER_VALIDATE_INT) !== false) {
            $this->_maxLength = abs($_maxLength);
        } else {
            trigger_error('Invalid maxlength attribute value given', 
                    E_USER_ERROR);
        }
    }

    /**
     *
     * @param field_type $_min            
     */
    public function setMin ($_min)
    {
        $this->_min = $_min;
    }

    /**
     *
     * @param field_type $_multiple            
     */
    public function setMultiple ($_multiple)
    {
        $this->_multiple = FormBuilder::FORM_INPUT_MULTIPLE;
    }

    /**
     *
     * @param field_type $_pattern            
     */
    public function setPattern ($_pattern)
    {
        $this->_pattern = $_pattern;
    }

    /**
     *
     * @param field_type $_placeholder            
     */
    public function setPlaceholder ($_placeholder)
    {
        $this->_placeholder = $_placeholder;
    }

    /**
     *
     * @param field_type $_readonly            
     */
    public function setReadonly ($_readonly)
    {
        $this->_readonly = FormBuilder::FORM_INPUT_READONLY;
    }

    /**
     *
     * @param field_type $_required            
     */
    public function setRequired ($_required)
    {
        $this->_required = FormBuilder::FORM_INPUT_REQUIRED;
    }

    /**
     *
     * @param field_type $_size            
     */
    public function setSize ($_size)
    {
        if (filter_var($_size, FILTER_VALIDATE_INT) !== false) {
            $this->_size = abs($_size);
        } else {
            trigger_error('Invalid size attribute value given', E_USER_ERROR);
        }
    }

    /**
     *
     * @param field_type $_step            
     */
    public function setStep ($_step)
    {
        if (filter_var($_step, FILTER_VALIDATE_INT) !== false) {
            $this->_step = abs($_step);
        } else {
            trigger_error('Invalid step attribute value given', E_USER_ERROR);
        }
    }

    /**
     *
     * @param field_type $_value            
     */
    public function setValue ($_value)
    {
        $this->_value = $_value;
    }

    /**
     *
     * @param multitype: $_attributes            
     */
    public function setAttributes (array $_attributes)
    {
        $this->_attributes = $_attributes;
    }

    /**
     *
     * @param field_type $_name            
     */
    public function setName ($_name)
    {
        $this->_name = $_name;
    }

    /**
     *
     * @param field_type $_label            
     */
    public function setLabel ($_label)
    {
        $this->_label = $_label;
    }

    protected function _prepareAttributList ()
    {
        if (! empty($this->_attributes)) {
            foreach ($this->_attributes as $attrName => $value) {
                $attributeSetterName = 'set' . ucfirst($attrName);
                if (method_exists($this, $attributeSetterName)) {
                    $this->$attributeSetterName($value);
                }
            }
        }
    }

    protected function _buildInputAttributesString ()
    {
        // Input Attributes
        if (null !== $this->getAccept()) {
            $this->_inputAttributesString .= ' accept="' . $this->getAccept() .
                     '"';
        }
        if (null !== $this->getAutoComplete()) {
            $this->_inputAttributesString .= ' autocomplete="' .
                     $this->getAutoComplete() . '"';
        }
        if (null !== $this->getAutoFocus()) {
            $this->_inputAttributesString .= ' autofocus="' .
                     $this->getAutoFocus() . '"';
        }
        if (null !== $this->getDisabled()) {
            $this->_inputAttributesString .= ' disabled="' . $this->getDisabled() .
                     '"';
        }
        if (null !== $this->getForm()) {
            $this->_inputAttributesString .= ' form="' . $this->getForm() . '"';
        }
        if (null !== $this->getFormNoValidate()) {
            $this->_inputAttributesString .= ' formnovalidate="' .
                     $this->getFormNoValidate() . '"';
        }
        if (null !== $this->getList()) {
            $this->_inputAttributesString .= ' list="' . $this->getList() . '"';
        }
        if (null !== $this->getMax()) {
            $this->_inputAttributesString .= ' max="' . $this->getMax() . '"';
        }
        if (null !== $this->getMaxLength()) {
            $this->_inputAttributesString .= ' maxlength="' .
                     $this->getMaxLength() . '"';
        }
        if (null !== $this->getMin()) {
            $this->_inputAttributesString .= ' min="' . $this->getMin() . '"';
        }
        if (null !== $this->getMultiple()) {
            $this->_inputAttributesString .= ' multiple="' . $this->getMultiple() .
                     '"';
        }
        if (null !== $this->getName()) {
            $this->_inputAttributesString .= ' name="' . $this->getName() . '"';
        }
        if (null !== $this->getPattern()) {
            $this->_inputAttributesString .= ' pattern="' . $this->getPattern() .
                     '"';
        }
        if (null !== $this->getPlaceholder()) {
            $this->_inputAttributesString .= ' placeholder="' .
                     $this->getPlaceholder() . '"';
        }
        if (null !== $this->getReadonly()) {
            $this->_inputAttributesString .= ' readonly="' . $this->getReadonly() .
                     '"';
        }
        if (null !== $this->getRequired()) {
            $this->_inputAttributesString .= ' required="' . $this->getRequired() .
                     '"';
        }
        if (null !== $this->getSize()) {
            $this->_inputAttributesString .= ' size="' . $this->getSize() . '"';
        }
        if (null !== $this->getStep()) {
            $this->_inputAttributesString .= ' step="' . $this->getStep() . '"';
        }
        if (null !== $this->getValue()) {
            $this->_inputAttributesString .= ' value="' . $this->getValue() . '"';
        }
        
        // Global Attributes
        if(!empty($this->_globalAttributes)) {
            foreach ($this->_globalAttributes as $attr => $value) {
                $this->_inputAttributesString .= ' ' . $attr . '="' . $value . '"';
            }
        }
    }
}