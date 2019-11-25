<?php

namespace App\View\Helper;

use Cake\View\Helper\FormHelper as CakeFormHelper;
use Cake\Utility\Hash;
use Cake\View\View;
use Cake\Utility\Inflector;

class FormHelper extends CakeFormHelper {

    private $templates = [
        'button' => '<button{{attrs}}>{{text}}</button>',
        'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
        'checkboxFormGroup' => '{{label}}',
        'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
        'dateWidget' => '<div class="form-group">{{label}} {{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}</div>',
        'error' => '<span class="help-block">{{content}}</span>',
        'errorList' => '<ul>{{content}}</ul>',
        'errorItem' => '<li>{{text}}</li>',
        'file' => '<input type="file" name="{{name}}"{{attrs}}>',
        'fieldset' => '<fieldset{{attrs}}>{{content}}</fieldset>',
        'formStart' => '<form{{attrs}}>',
        'formEnd' => '</form>',
        'formGroup' => '{{label}}<div class=" col-md-7">{{prepend}}{{input}}{{append}}</div>',
        'hiddenBlock' => '<div style="display:none;">{{content}}</div>',
        'control' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>',
        'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>',
        'inputSubmit' => '<input type="{{type}}"{{attrs}}/>',
        'inputContainer' => '<div class="form-group input {{type}}{{required}}">{{content}}</div>',
        'inputContainerError' => '<div class="input {{type}}{{required}} has-error">{{content}}{{error}}</div>',
        'label' => '<label class="control-label col-md-4" {{attrs}}>{{text}}</label>',
        'nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>',
        'legend' => '<legend>{{text}}</legend>',
        'multicheckboxTitle' => '<legend>{{text}}</legend>',
        'multicheckboxWrapper' => '<fieldset{{attrs}}>{{content}}</fieldset>',
        'option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
        'optgroup' => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>',
        'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
        'selectMultiple' => '<select name="{{name}}[]" multiple="multiple"{{attrs}}>{{content}}</select>',
        'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
        'radioWrapper' => '<div class="radio">{{label}}</div>',
        'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>',
        'submitContainer' => '<div class="box-footer {{required}}">{{content}}</div>'
    ];

    private $templates_inline = [
        'formGroup' => '{{label}}{{prepend}}{{input}}{{append}}',
        'label' => '<label class="control-label" {{attrs}}>{{text}}</label>',        
    ];

    public function __construct(View $View, array $config = [])
    {
        $this->_defaultConfig['templates'] = array_merge($this->_defaultConfig['templates'], $this->templates);
        parent::__construct($View, $config);
    }

    public function create($context = null, array $options = [])
    {
        $options += ['role' => 'form'];
        if (isset($options['class']) and $options['class']=='form-inline') {
            $options['templates'] = $this->templates_inline + $this->templates;
        }

        return parent::create($context, $options);
    }

    public function button($title, array $options = array())
    {
        $options += ['escape' => false, 'secure' => false, 'class' => 'btn'];
        // $options += ['escape' => false, 'secure' => false, 'class' => 'btn btn-success'];
        $options['text'] = $title;
        return $this->widget('button', $options);
    }

    public function submit($caption = null, array $options = array())
    {
        // $options += ['class' => 'btn'];
        $options += ['class' => 'btn btn-success'];
        return parent::submit($caption, $options);
    }

    public function input($fieldName, array $options = [])
    {

        $_options = [];

        if (!isset($options['type'])) {
            $options['type'] = $this->_inputType($fieldName, $options);
        }

        switch($options['type']) {
            case 'checkbox':
            case 'radio':
            case 'date':
                break;
            default:
                $_options = ['class' => 'form-control'];
                break;

        }

        $options += $_options;

        ///////////
        $prepend = $this->_extractOption('prepend', $options, false) ;
        unset($options['prepend']);
        $append = $this->_extractOption('append', $options, false) ;
        unset($options['append']);
        if ($prepend || $append) {
            $prepend = $this->prepend(null, $prepend);
            $append  = $this->append(null, $append);
        } 
        $options['_data'] = [
            'prepend' => $prepend,
            'append' => $append
        ];               
        /////////////



        return parent::input($fieldName, $options);
    }
	public function control($fieldName, array $options = [])
	{

		$_options = [];

		if (!isset($options['type'])) {
			$options['type'] = $this->_inputType($fieldName, $options);
		}

		switch($options['type']) {
			case 'checkbox':
			case 'radio':
			case 'date':
				break;
			default:
				$_options = ['class' => 'form-control'];
				break;

		}

		$options += $_options;

		return parent::control($fieldName, $options);
    }
    


//以下の　関数は全て　custom
public function prepend ($input, $prepend) {
    if ($prepend) {
        if (is_string($prepend)) {
            $prepend = '<span class="input-group-'.($this->_matchButton($prepend) ? 'btn' : 'addon').'">'.$prepend.'</span>' ;
        }
        else if ($prepend !== false) {
            $prepend = '<span class="input-group-btn">'.implode('', $prepend).'</span>' ;
        }
    }
    if ($input === null) {
        return '<div class="input-group">'.$prepend ;
    }
    return $this->_wrap($input, $prepend, null);
}

public function append ($input, $append) {
    if (is_string($append)) {
        $append = '<span class="input-group-'.($this->_matchButton($append) ? 'btn' : 'addon').'">'.$append.'</span>' ;
    }
    else if ($append !== false) {
        $append = '<span class="input-group-btn">'.implode('', $append).'</span>' ;
    }
    if ($input === null) {
        return $append.'</div>' ;
    }
    return $this->_wrap($input, null, $append);
}

public function wrap ($input, $prepend, $append) {
    return $this->prepend(null, $prepend).$input.$this->append(null, $append);
}

protected function _wrap ($input, $prepend, $append) {
    return '<div class="input-group">'.$prepend.$input.$append.'</div>' ;
}

/**
 *
 * Try to match the specified HTML code with a button or a input with submit type.
 *
 * @param $html The HTML code to check
 *
 * @return true if the HTML code contains a button
 *
**/
protected function _matchButton ($html) {
    return strpos($html, '<button') !== FALSE || strpos($html, 'type="submit"') !== FALSE ;
}
    

/**
 * Generates an group template element
 *
 * @param array $options The options for group template
 * @return string The generated group template
 */
protected function _groupTemplate($options) {
    $groupTemplate = $options['options']['type'] . 'FormGroup';
    if (!$this->templater()->get($groupTemplate)) {
        $groupTemplate = 'formGroup';
    }
    $data = [
        'input' => isset($options['input']) ? $options['input'] : [],
        'label' => $options['label'],
        'error' => $options['error']
    ];
    if (isset($options['options']['_data'])) {
        //custom
        // foreach ($options['options']['_data'] as $value) {
            // if($value !== false){
                // $data[] = $value;
            // }
//                 
        // }
        
        $data = array_merge($data, $options['options']['_data']);
       ////////////
        unset($options['options']['_data']);
    }
    return $this->templater()->format($groupTemplate, $data);
}

/**
 * Generates an input element
 *
 * @param string $fieldName the field name
 * @param array $options The options for the input element
 * @return string The generated input element
 */
protected function _getInput($fieldName, $options) {
    unset($options['_data']);
    return parent::_getInput($fieldName, $options);
}        
}
