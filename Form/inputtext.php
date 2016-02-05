<?php
namespace Lily\Core\Form;

class InputText extends Input implements InputInterface
{
    
    public function inputHTML()
    {
        return '<input type="text"' . $this->_inputAttributesString . ' />';
    }
}