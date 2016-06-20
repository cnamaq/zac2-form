<?php
/**
 * @author Denis Fohl
 */

namespace Zac2\Form;


use Zac2\Common\Renderable;

abstract class FormComponentDecorator implements Renderable
{
    
    /**
     * @var mixed
     */
    protected $formComponent;

    /**
     * HTML
     * @return string
     */
    abstract public function render($data = null);

    /**
     * @param mixed $formComponent
     */
    public function setFormComponent($formComponent)
    {
        $this->formComponent = $formComponent;
    }

    /**
     * @return mixed
     */
    public function getFormComponent()
    {
        return $this->formComponent;
    }

}