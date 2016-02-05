<?php
namespace Lily\Core;

class Language 
{
    private $_dictionary = array();
    
    public function load($dictionary)
    {
        $lang = DEFAULT_LANGUAGE;
        if(isset($_SESSION['lang'])) {
            $lang = $_SESSION['lang'];
        }
        $languageFile = LANGUAGE_PATH . DS . $lang . DS . (str_replace('|', DS, $dictionary)) . '.lang.php';
        if(file_exists($languageFile)) {
            require $languageFile;
            if(isset($_) && is_array($_)) {
                foreach ($_ as $textLabel => $textValue) {
                    $this->_dictionary[$textLabel] = $textValue;
                }
            }
        } else {
            trigger_error('the language file ' . $dictionary . ' does not exists');
        }
    }
    
    public function get($dictionary, $key = false, $replace = array()) {
        $lang = DEFAULT_LANGUAGE;
        if(isset($_SESSION['lang'])) {
            $lang = $_SESSION['lang'];
        }
        $languageFile = LANGUAGE_PATH . DS . $lang . DS . (str_replace('|', DS, $dictionary)) . '.lang.php';
        if(file_exists($languageFile)) {
            require $languageFile;
            if(isset($_) && is_array($_)) {
                if(false !== $key) {
                    if(!empty($replace)) {
                        $values = array($_[$key]);
                        foreach($replace as $replacment) {
                            $values[] = $replacment;
                        }
                        return call_user_func_array('sprintf', $values);
                    } else {
                        return $_[$key];
                    }
                } else {
                    return $_;
                }
            }
        } else {
            trigger_error('the language file ' . $dictionary . ' does not exists', E_USER_WARNING);
        }
    }
    
    public function getDictionary()
    {
        return $this->_dictionary;
    }
}