<?php
namespace Lily\Template;

/**
 * Template Engine 
 * @author fox
 *
 */
final class Template
{
    
    use TemplateHelper;

    /**
     * TemplateBlock instance used to
     * collect the template building blocks
     * and resources to draw the template
     *
     * @var TemplateBlocks
     */
    private $_templateBlocks;

    /**
     * The required view which
     * will be injected to the
     * template.
     *
     * @var string
     */
    private $_view;

    /**
     * The controller data to
     * make it available for the
     * whole template building blocks
     *
     * @var array
     */
    private $_data;

    /**
     * The language array
     * holds all the required
     * language dictionaries that
     * is used in conjnction with the
     * template blocks
     *
     * @var array
     *
     */
    private $_lang;

    /**
     * The Registry objects
     * contains all the required
     * objects and data for the template
     * to process successfully
     *
     * @var \Lily\Core\Registry
     */
    private $_registry;

    /**
     * Instantiate a new template object and
     * pass the tempBlocks TemplateBlocks instance
     * to set up the template building blocks
     *
     * @param TemplateBlocks $tempBlocks            
     */
    public function __construct (TemplateBlocks $tempBlocks)
    {
        $this->_templateBlocks = $tempBlocks;
    }

    /**
     * Controller data setter
     *
     * @param array $data            
     */
    public function setData (array $data)
    {
        $this->_data = $data;
    }
    
    public function setLang(array $lang)
    {
        $this->_lang = $lang;
    }
    
    public function setRegistry(\Lily\Core\Registry $registry)
    {
        $this->_registry = $registry;
    }

    /**
     * Sets the view path to inject in the template
     *
     * @param string $view            
     */
    public function setView ($view)
    {
        $this->_view = $view;
    }

    /**
     * Adds the template header file which includes
     * doctype declaration and general meta data.
     * This file
     * comes with basic markup which can be customized upon your
     * need.
     */
    private function _addTemplateHeader ()
    {
        if (! empty($this->_data))
            extract($this->_data);
        if (! empty($this->_lang))
            extract($this->_lang);
        require TEMPLATE_PATH . DS . TemplateBlocks::TEMPLATE_HEADER_START;
    }

    /**
     * Adds a template header close tags
     */
    private function _closeTemplateHeader ()
    {
        if (! empty($this->_data))
            extract($this->_data);
        if (! empty($this->_lang))
            extract($this->_lang);
        require TEMPLATE_PATH . DS . TemplateBlocks::TEPMLATE_HEADER_END;
    }

    /**
     * Adds a template footer close tags
     */
    private function _addTemplateFooter ()
    {
        if (! empty($this->_data))
            extract($this->_data);
        if (! empty($this->_lang))
            extract($this->_lang);
        require TEMPLATE_PATH . DS . TemplateBlocks::TEMPLATE_FOOTER;
    }

    /**
     * Injects template building blocks according to its
     * precedence.
     */
    private function _injectTemplateBlocks ()
    {
        if (! empty($this->_data))
            extract($this->_data);
        if (! empty($this->_lang))
            extract($this->_lang);
        $templateBlocks = $this->_templateBlocks->getTemplateBlocks();
        foreach ($templateBlocks as $blockName => $block) {
            if ($blockName == ':view') {
                if(file_exists($this->_view)) {
                    require $this->_view;
                } else {
                    require VIEWS_PATH . DS . 'notfound' . DS . 'default.view.php';
                }
            } else {
                $fileName = TEMPLATE_PATH . DS . $block . '.tpl.php';
                if (! file_exists($fileName)) {
                    trigger_error('template file not found', E_USER_ERROR);
                }
                require TEMPLATE_PATH . DS . $block . '.tpl.php';
            }
        }
    }

    /**
     * Injects a template building block in a given positions.
     *
     * @param string $blockKey
     *            the array key of the new building block
     * @param string $path
     *            the file name of the template building block
     * @param string $afterBlock
     *            the array key of the building blocks that preceeds the new
     *            building block
     * @throws Exception when the required file doesn't exists
     */
    public function injectTemplateBlock ($blockKey, $path, $afterBlock)
    {
        $templateBlocks = $this->_templateBlocks->getTemplateBlocks();
        if (empty($templateBlocks)) {
            $templateBlocks = array(
                    $blockKey => $path
            );
        } else {
            if (array_key_exists($afterBlock, $templateBlocks)) {
                $key = array_search($afterBlock, array_keys($templateBlocks));
                $templateBlocks = array_slice($templateBlocks, 0, ++ $key) + array(
                        $blockKey => $path
                ) + array_slice($templateBlocks, $key);
            } else {
                throw new Exception(
                        'given resource name does not exists in the template building blocks');
            }
        }
        $this->_templateBlocks->setTemplateBlocks($templateBlocks);
    }

    /**
     * Excludes a template building block to prevent it from rendering
     *
     * @param string $blockKey
     *            the array key of the excluded building block
     * @throws Exception if the building block doesn't exists
     */
    public function execludeTemplateBlock ($blockKey)
    {
        $templateBlocks = $this->_templateBlocks->getTemplateBlocks();
        if (array_key_exists($blockKey, $templateBlocks)) {
            $templateBlocks[$blockKey] = false;
        } else {
            throw new Exception(
                    'block ' . $blockKey .
                             ' is not defined as a template block. Check your templateconfig file');
        }
        $templateBlocks = array_filter($templateBlocks);
        $this->_templateBlocks->setTemplateBlocks($templateBlocks);
    }

    /**
     * Prepares the resources list which should be injected in the head
     * section of the template such as CSS and JavaScript resources.
     */
    private function _injectHeadResources ()
    {
        $resources = '';
        $headerResources = $this->_templateBlocks->getTemplateHeaderResources();
        if (array_key_exists('css', $headerResources)) {
            $cssResources = $headerResources['css'];
            foreach ($cssResources as $cssFile) {
                $resources .= '<link rel="stylesheet" href="' . $cssFile . '">' .
                         "\n\r";
            }
        }
        if (array_key_exists('js', $headerResources)) {
            $jsResources = $headerResources['js'];
            foreach ($jsResources as $jsFile) {
                $resources .= '<script src="' . $jsFile . '"></script>' . "\n\r";
            }
        }
        echo $resources;
    }

    /**
     * Prepares the resources list which should be injected in the footer
     * section of the template before the end of the body tag such as JavaScript
     * resources.
     */
    private function _injectFooterResources ()
    {
        $resources = '';
        $footerResources = $this->_templateBlocks->getTemplateFooterResources();
        if (array_key_exists('js', $footerResources)) {
            $jsResources = $footerResources['js'];
            foreach ($jsResources as $jsFile) {
                $resources .= '<script src="' . $jsFile . '"></script>' . "\n\r";
            }
        }
        echo $resources;
    }

    /**
     * Injects a header resource in a specified position
     *
     * @param string $resourceKey
     *            the array key of the new resource
     * @param string $type
     *            either CSS or JS (values 'js', 'css')
     * @param string $path
     *            the path to the new resource
     * @param string $afterResource
     *            the array key of the resource that preceeds the new resource
     * @throws Exception if the resource that preceeds the new resource doesn't
     *         exists
     */
    public function injectHeaderResource ($resourceKey, $type, $path, 
            $afterResource)
    {
        $headerResources = $this->_templateBlocks->getTemplateHeaderResources()[$type];
        if (empty($headerResources)) {
            $newHeaderResources = array();
            $newHeaderResources[$type] = array(
                    $resourceKey => $path
            );
        } else {
            if (array_key_exists($afterResource, $headerResources)) {
                $key = array_search($afterResource, 
                        array_keys($headerResources));
                $newHeaderResources = array();
                $newHeaderResources = array_slice($headerResources, 0, ++ $key) + array(
                        $resourceKey => $path
                ) + array_slice($headerResources, $key);
            } else {
                throw new Exception(
                        'given resource name does not exists in the template footer resources list');
            }
        }
        $this->_templateBlocks->setTemplateHeaderResources($type, 
                $newHeaderResources);
    }

    /**
     * Injects a footer resource in a specified position
     * 
     * @param string $resourceKey
     *            the array key of the new resource
     * @param string $path
     *            js is the default resources that goes to the footer
     * @param string $afterResource
     *            the array key of the resource that preceeds the new resource
     * @throws Exception if the resource that preceeds the new resource doesn't
     *         exists
     */
    public function injectFooterResource ($resourceKey, $path, $afterResource)
    {
        $footerResources = $this->_templateBlocks->getTemplateFooterResources()['js'];
        if (empty($footerResources)) {
            $newFooterResources = array(
                    $resourceKey => $path
            );
        } else {
            if (array_key_exists($afterResource, $footerResources)) {
                $key = array_search($afterResource, 
                        array_keys($footerResources));
                $newFooterResources = array_slice($footerResources, 0, ++ $key) + array(
                        $resourceKey => $path
                ) + array_slice($footerResources, $key);
            } else {
                throw new Exception(
                        'given resource name does not exists in the template footer resources list');
            }
        }
        $this->_templateBlocks->setTemplateFooterResources('js', 
                $newFooterResources);
    }

    public function execludeHeaderResource ($type, $resourceKey)
    {
        $headerResources = $this->_templateBlocks->getTemplateHeaderResources()[$type];
        if (array_key_exists($resourceKey, $headerResources)) {
            $headerResources[$resourceKey] = false;
        } else {
            throw new Exception(
                    'no resource found in ' . $type . ' head resources');
        }
        $headerResources = array_filter($headerResources);
        $this->_templateBlocks->setTemplateHeaderResources($type, 
                $headerResources);
    }

    public function execludeFooterResource ($resourceKey)
    {
        $footerResources = $this->_templateBlocks->getTemplateFooterResources()['js'];
        if (array_key_exists($resourceKey, $footerResources)) {
            $footerResources[$resourceKey] = false;
        } else {
            throw new Exception('no resource found in js footer resources');
        }
        $footerResources = array_filter($footerResources);
        $this->_templateBlocks->setTemplateFooterResources('js', 
                $footerResources);
    }

    public function drawTemplate ()
    {
        $this->_addTemplateHeader();
        $this->_injectHeadResources();
        $this->_closeTemplateHeader();
        $this->_injectTemplateBlocks();
        $this->_injectFooterResources();
        $this->_addTemplateFooter();
        ob_end_flush();
    }
}