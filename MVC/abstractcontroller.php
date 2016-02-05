<?php
namespace Lily\MVC;
use Lily\Registry\Registry;
use Lily\Template\Template;

/**
 * Abstract Controller
 * @author fox
 *
 */
abstract class AbstractController
{

    /**
     * Controller Name
     *
     * @var string
     */
    protected $_controller;

    /**
     * Acion Name
     *
     * @var string
     */
    protected $_action;

    /**
     * Regisry object reference
     *
     * @var Registry
     */
    protected $_registry;

    /**
     * Data array used to keep track of
     * all data passed to the view
     *
     * @var array
     */
    protected $_data = array();

    /**
     * URL extracted parameters
     * which could be used for
     * any action
     *
     * @var array
     */
    protected $_params = array();
    
    /**
     * A template instance
     * @var Template
     */
    protected $_template;
    
    /**
     * Controller name setter
     *
     * @param string $controller            
     */
    public function setController ($controller)
    {
        $this->_controller = strtolower($controller);
    }

    /**
     * Acion Name setter
     *
     * @param string $action            
     */
    public function setAction ($action)
    {
        $this->_action = strtolower($action);
    }

    /**
     * Parameters array setter
     *
     * @param array $params            
     */
    public function setParams (array $params)
    {
        $this->_params = (object) $params;
    }

    /**
     * Registry object setter
     *
     * @param Registry $registry
     */
    public function setRegistry (Registry $registry)
    {
        $this->_registry = $registry;
    }
    
    /**
     * Set the template property to a Template instance
     * @param Template $template
     */
    public function setTemplate(Template $template)
    {
        $this->_template = $template;
    }
    

    /**
     * Global setter is used to
     * set any new dynamic attribute
     * in the registry object
     *
     * @param string $key            
     * @param mixed $value            
     */
    public function __set ($key, $value)
    {
        $this->_registry->$key = $value;
    }

    /**
     * Global getter is used to
     * get a given value by key
     * from the registry object
     *
     * @param string $key            
     */
    public function __get ($key)
    {
        return $this->_registry->$key;
    }

    /**
     * @return object
     */
    public function param ()
    {
        return $this->_params;
    }

    /**
     * Renders the appropriate view
     * based on the defined controller
     * and action.
     * It users the controller
     * name as a folder name and the action
     * as a reference to the view file name
     */
    protected function _render ()
    {
        $viewFile = VIEWS_PATH . DS . $this->_controller . DS . $this->_action .
                 '.view.php';
        $this->_template->setData($this->_data);
        $this->_template->setLang($this->lang->getDictionary());
        $this->_template->setView($viewFile);
        $this->_template->setRegistry($this->_registry);
        $this->_template->drawTemplate();
    }
    
    protected function extractErrors(array $errors)
    {
        foreach ($errors as $key => $value) {
            $this->_data[$key] = $value;
        }
    }
}