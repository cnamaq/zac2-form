<?php
/**
 * @author Denis Fohl
 */

namespace Zac2\Form;

use \Zend_Form as Form;


class ZF1 extends FormComponentDecorator
{

    /**
     * ZF1 constructor.
     * @param \Zend_Form $formComponent
     */
    public function __construct(Form $formComponent = null)
    {
        $this->formComponent = $formComponent;
    }

    /**
     * @param \Zend_Form $formComponent
     */
    public function setFormComponent(Form $formComponent)
    {
        $this->formComponent = $formComponent;
    }

    /**
     * @return \Zend_Form
     */
    public function getFormComponent()
    {
        return $this->formComponent;
    }

    /**
     * @return string
     */
    public function render($data = null)
    {
        return $this->getFormComponent()->__toString();
    }

    /**
     * @return array
     */
    public function getActualValues()
    {
        $result = array();
        foreach ($this->getFormComponent()->getValues() as $key => $value) {
            if ($value && $key != 'submit') {
                $result[$key] = $value;
            }
        }
        
        return $result;
    }

}
