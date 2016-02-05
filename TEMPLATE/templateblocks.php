<?php
namespace Lily\Template;

final class TemplateBlocks
{

    const TEMPLATE_HEADER_START = 'templateheader.tpl.php';

    const TEPMLATE_HEADER_END = 'templateheaderend.tpl.php';

    const TEMPLATE_FOOTER = 'templatefooter.tpl.php';

    private $_blocks = array();

    private $_headerResources = array(
            'css' => array(),
            'js' => array()
    );

    private $_footerResource = array(
            'js' => array()
    );

    public function __construct (array $blocks, 
            array $headerResources = array('css' => array(), 'js' => array()), 
            array $footerResources = array('js' => array()))
    {
        $this->_blocks = $blocks;
        $this->_headerResources = $headerResources;
        $this->_footerResource = $footerResources;
    }
    
    public function setTemplateBlocks(array $blocks)
    {
        $this->_blocks = $blocks;
    }
    
    public function setTemplateFooterResources($type, array $footerResources)
    {
        $this->_footerResource[$type] = $footerResources;
    }
    
    public function setTemplateHeaderResources($type, array $headerResources)
    {
        $this->_headerResources[$type] = $headerResources;
    }
    
    public function getTemplateBlocks()
    {
        return $this->_blocks;
    }
    
    public function getTemplateHeaderResources()
    {
        return $this->_headerResources;
    }
    
    public function getTemplateFooterResources()
    {
        return $this->_footerResource;
    }
}