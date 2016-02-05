<?php
namespace Lily\Core\Form;
use Lily\Models as Models;

/**
 * Form builder Class will help you 
 * build a html form with teh required 
 * input fields and validate them based 
 * on a given Abstract model 
 * @author Mohammed Yehia 
 *
 */
final class FormBuilder
{

    /**
     * Form html content.
     * This property holds all the html
     * content of the form to be rendered
     *
     * @var string
     */
    private $_formHTML = '';

    /**
     * Form components are different
     * elements used to construct the form
     *
     * @var array
     */
    private $_components = array();

    /**
     * Form default charset attribute
     *
     * @var string
     */
    private $_acceptCharset;

    /**
     * Form Action attribute
     *
     * @var string
     */
    private $_action;

    /**
     * Form autocomplete attribute (on|off)
     *
     * @var string
     */
    private $_autoComplete;

    /**
     * Form enctype attribute
     *
     * @var string
     */
    private $_enctype;

    /**
     * Form method attribute
     *
     * @var string
     */
    private $_method;

    /**
     * Form name attribute
     *
     * @var string
     */
    private $_name;

    /**
     * Form novalidate attribute (value="novalidate")
     *
     * @var string
     */
    private $_novalidate;

    /**
     * Form target attribute
     *
     * @var string
     */
    private $_target;

    /**
     * Other HTML form attributes
     *
     * @var array
     */
    private $_attributes = array();

    /**
     * The errors array is built on
     * input validation
     *
     * @var array
     */
    private $_errors = array();

    /**
     * The model object is used to extract
     * the form input types
     *
     * @var AbstractModel
     */
    private $_model;

    /**
     * Form entype value 'text/plain'
     *
     * @var string
     */
    const FORM_ENCTYPE_TEXT = 'text/plain';

    /**
     * Form enctype value 'application/x-www-form-urlencoded'
     *
     * @var string
     */
    const FORM_ENCTYPE_APPLICATION = 'application/x-www-form-urlencoded';

    /**
     * Form enctype value 'multipart/form-data'
     *
     * @var string
     */
    const FORM_ENCTYPE_MULTIPART = 'multipart/form-data';

    /**
     * Form method value 'post'
     *
     * @var string
     */
    const FORM_METHOD_POST = 'post';

    /**
     * Form method value 'get'
     *
     * @var string
     */
    const FORM_METHOD_GET = 'get';

    /**
     * Form target value '_blank'
     *
     * @var string
     */
    const FORM_TARGET_BLANK = '_blank';

    /**
     * Form target value '_self'
     *
     * @var string
     */
    const FORM_TARGET_SELF = '_slef';

    /**
     * Form target value '_parent'
     *
     * @var string
     */
    const FORM_TARGET_PARENT = '_parent';

    /**
     * Form target value '_top'
     *
     * @var string
     */
    const FORM_TARGET_TOP = '_top';

    /**
     * Form autocomplete value 'on'
     *
     * @var string
     */
    const FORM_AUTOCOMPLETE_ON = 'on';

    /**
     * Form autofocus value 'autofocus'
     *
     * @var string
     */
    const FORM_AUTOFOCUS = 'autofocus';

    /**
     * Form input attribute disabled value 'disabled'
     *
     * @var unknown
     */
    const FORM_INPUT_DISABLED = 'disabled';

    /**
     * Form input attribute readonly value 'readonly'
     *
     * @var string
     */
    const FORM_INPUT_READONLY = 'readonly';

    /**
     * Form input attribute multiple value 'multiple'
     *
     * @var string
     */
    const FORM_INPUT_MULTIPLE = 'multiple';

    /**
     * Form input attribute required value 'required'
     * 
     * @var string
     */
    const FORM_INPUT_REQUIRED = 'required';

    /**
     * Form autocomplete value 'off'
     *
     * @var string
     */
    const FORM_AUTOCOMPLETE_OFF = 'off';

    /**
     * Form novalidate value 'novalidate'
     *
     * @var string
     */
    const FORM_NOVALIDATE = 'novalidate';

    /**
     * Form default charset is 'utf-8' and
     * can be modified later
     *
     * @var string
     */
    const FORM_DEFAULT_CHARSET = 'utf-8';

    /**
     * Form default method is 'post'
     * and can be modified later
     *
     * @var string
     */
    const FORM_DEFAULT_METHOD = 'post';

    /**
     * Form default enctype is 'application/x-www-form-urlencoded'
     * and can be modified later
     *
     * @var string
     */
    const FORM_DEFAULT_ENCTYPE = 'application/x-www-form-urlencoded';

    /**
     * Form default target is '_blank'
     * and can be modified later
     *
     * @var string
     */
    const FORM_DEFAULT_TARGET = 'blank';

    /**
     * Instantiate a form object with the
     * most required attributes (model, method, enctype, action)
     *
     * @param AbstractModel $model            
     * @param string $method            
     * @param string $enctype            
     * @param string $action            
     */
    public function __construct (Models\AbstractModel $model, 
            $method = self::FORM_DEFAULT_METHOD, $enctype = self::FORM_DEFAULT_ENCTYPE, $action = '')
    {
        $this->_model = $model;
        $this->setMethod($method);
        $this->setEnctype($enctype);
        $this->setAction($action);
    }

    /**
     * action setter
     *
     * @param string $action
     *            <p>The path to the action either relative or absolute</p>
     */
    public function setAction ($action)
    {
        $this->_action = $action;
    }

    /**
     * action getter
     *
     * @return string
     */
    public function getAction ()
    {
        return $this->_action;
    }

    /**
     * formHTML getter
     *
     * @return the $_formHTML
     */
    public function getFormHTML ()
    {
        return $this->_formHTML;
    }

    /**
     * form components getter
     *
     * @return the $_components
     */
    public function getComponents ()
    {
        return $this->_components;
    }

    /**
     * form acceptCharset getter
     *
     * @return the $_acceptCharset
     */
    public function getAcceptCharset ()
    {
        return $this->_acceptCharset;
    }

    /**
     * form autocomplete getter
     *
     * @return the $_autoComplete
     */
    public function getAutoComplete ()
    {
        return $this->_autoComplete;
    }

    /**
     * form enctype getter
     *
     * @return the $_enctype
     */
    public function getEnctype ()
    {
        return $this->_enctype;
    }

    /**
     * form method getter
     *
     * @return the $_method
     */
    public function getMethod ()
    {
        return $this->_method;
    }

    /**
     * form name getter
     *
     * @return the $_name
     */
    public function getName ()
    {
        return $this->_name;
    }

    /**
     * form novalidate getter
     *
     * @return the $_novalidate
     */
    public function getNovalidate ()
    {
        return $this->_novalidate;
    }

    /**
     *
     * @return the $_target
     */
    public function getTarget ()
    {
        return $this->_target;
    }

    /**
     * form components setter
     *
     * @param array $_components            
     */
    public function setComponents (array $_components)
    {
        $this->_components = $_components;
    }

    /**
     * form acceptCharset setter
     *
     * @param string $_acceptCharset            
     */
    public function setAcceptCharset (
            $_acceptCharset = self::FORM_DEFAULT_CHARSET)
    {
        $this->_acceptCharset = $_acceptCharset;
    }

    /**
     * form autocomplete setter
     *
     * @param string $_autoComplete
     *            <p>There are only 2 values valid for this attribute either
     *            on or off. Please use one of the following constants
     *            <strong>FORM_AUTOCOMPLETE_ON</strong> or
     *            <strong>FORM_AUTOCOMPLETE_OFF</strong>.</p>
     */
    public function setAutoComplete ($_autoComplete)
    {
        if ($_autoComplete === self::FORM_AUTOCOMPLETE_OFF ||
                 $_autoComplete === self::FORM_AUTOCOMPLETE_ON) {
            $this->_autoComplete = $_autoComplete;
        } else {
            trigger_error('Invalid value given for autocomplete attribute', 
                    E_USER_ERROR);
        }
    }

    /**
     * Form enctype setter
     *
     * @param string $_enctype
     *            <p>Valid values for this attribute are
     *            application/x-www-form-urlencoded or text/plain or
     *            multipart/form-data. Please use one of the following constants
     *            to set the proper value for this attribute
     *            <ul>
     *            <li>FORM_ENCTYPE_TEXT</li>
     *            <li>FORM_ENCTYPE_APPLICATION</li>
     *            <li>FORM_ENCTYPE_MULTIPART</li>
     *            </ul>
     *            </p>
     */
    public function setEnctype ($_enctype = self::FORM_DEFAULT_ENCTYPE)
    {
        if ($_enctype === self::FORM_ENCTYPE_TEXT ||
                 $_enctype === self::FORM_ENCTYPE_APPLICATION ||
                 $_enctype === self::FORM_ENCTYPE_MULTIPART) {
            $this->_enctype = $_enctype;
        } else {
            trigger_error('Invalid value for attribute enctype', E_USER_ERROR);
        }
    }

    /**
     * Form method setter
     *
     * @param string $_method
     *            <p>In this version of the class we use only 2 valid methods:
     *            post and get. Please use on of the following constants to set
     *            the proper value of the method attribute:
     *            <strong>FORM_METHOD_POST</strong> or
     *            <strong>FORM_METHOD_GET</strong>.</p>
     */
    public function setMethod ($_method)
    {
        if ($_method === self::FORM_METHOD_GET ||
                 $_method === self::FORM_METHOD_POST) {
            $this->_method = $_method;
        } else {
            trigger_error('Invalid value for attribute method', E_USER_ERROR);
        }
    }

    /**
     * Form name attribute setter
     *
     * @param string $_name            
     */
    public function setName ($_name)
    {
        $this->_name = $_name;
    }

    /**
     * Form novalidate setter
     *
     * @param string $_novalidate
     *            <p>Valid values for this attribute is only 'novalidate'.</p>
     */
    public function setNovalidate ()
    {
        $this->_novalidate = self::FORM_NOVALIDATE;
    }

    /**
     * Form target setter
     *
     * @param string $_target
     *            <p>Valid values for this attribute are
     *            _blank, _self, _parent or _top. Please use
     *            one of the following constants
     *            to set the proper value for this attribute
     *            <ul>
     *            <li>FORM_TARGET_BLANK</li>
     *            <li>FORM_TARGET_SELF</li>
     *            <li>FORM_TARGET_PARENT</li>
     *            <li>FORM_TARGET_TOP</li>
     *            </ul>
     *            </p>
     */
    public function setTarget ($_target)
    {
        if ($_target === self::FORM_TARGET_BLANK ||
                 $_target === self::FORM_TARGET_SELF ||
                 $_target === self::FORM_TARGET_PARENT ||
                 $_target === self::FORM_TARGET_TOP) {
            $this->_target = $_target;
        } else {
            trigger_error('Invalid value for attribute target', E_USER_ERROR);
        }
    }

    /**
     * Form other html attributes setter
     *
     * @param array $attributes            
     */
    public function setAttributes (array $attributes)
    {
        $this->_attributes = $attributes;
    }

    /**
     * Add an error text to a specific input field
     *
     * @param string $inputName            
     * @param string $error            
     */
    public function addErrors ($inputName, $error)
    {
        $this->_errors[$inputName] = $_error;
    }

    /**
     * The form open tag builder
     */
    private function _openForm ()
    {
        $this->_formHTML .= '<form ';
        
        if (null !== $this->_action) {
            $this->_formHTML .= ' action="' . $this->getAction() . '"';
        }
        
        if (null !== $this->_acceptCharset) {
            $this->_formHTML .= ' accept-charset="' . $this->getAcceptCharset() .
                     '"';
        }
        
        if (null !== $this->_autoComplete) {
            $this->_formHTML .= ' autocomplete="' . $this->getAutoComplete() .
                     '"';
        }
        
        if (null !== $this->_enctype) {
            $this->_formHTML .= ' enctype="' . $this->getEnctype() . '"';
        }
        
        if (null !== $this->_method) {
            $this->_formHTML .= ' method="' . $this->getMethod() . '"';
        }
        
        if (null !== $this->_name) {
            $this->_formHTML .= ' name="' . $this->getName() . '"';
        }
        
        if (null !== $this->_novalidate) {
            $this->_formHTML .= ' novalidate="' . $this->getNovalidate() . '"';
        }
        
        if (null !== $this->_target) {
            $this->_formHTML .= ' target="' . $this->getTarget() . '"';
        }
        
        if (! empty($this->_attributes)) {
            foreach ($this->_attributes as $attribute => $value) {
                $this->_formHTML .= ' ' . $attribute . '="' . $value . '"';
            }
        }
        
        $this->_formHTML .= '>';
    }

    private function _closeForm ()
    {
        $this->_formHTML .= '<form>';
    }

    private function _prepareComponents ()
    {
        $form = $this->_model->form();
        if (! empty($form)) {
            foreach ($form as $inputName => $data) {
                $formInput = new Input();
                $formInput = $formInput->buildInput($data);
                $this->_addFormComponent($inputName, $formInput);
            }
        }
    }

    private function _buildComponents ()
    {
        if (! empty($this->_components)) {
            $this->_formHTML .= '<table>';
            $error = null;
            foreach ($this->_components as $input) {
                $error = isset($this->_errors[$input->getName()]) ? $this->_errors[$input->getName()] : null;
                $this->_formHTML .= '
                    <tr>
						<td><label for="' . $input->getName() . '">' . $input->getLabel() . '</label></td>
					</tr>
					<tr>
						<td>' . $input->inputHTML() .
                         (isset($error) ? '<p class"">' . $error . '</p>' : '') . '</td>
					</tr>';
            }
            
            $this->_formHTML .= '</table>';
        }
    }

    public function process ()
    {
        $data = array();
        $data = ($this->getMethod() === self::FORM_METHOD_POST) ? $_POST : $_GET;
        var_dump($data);
    }

    private function _addFormComponent ($inputName, Input $component)
    {
        $this->_components[$inputName] = $component;
    }

    public function drawForm ()
    {
        $this->_prepareComponents();
        $this->_openForm();
        $this->_buildComponents();
        $this->_closeForm();
        return $this->getFormHTML();
    }
} 