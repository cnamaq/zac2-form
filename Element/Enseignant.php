<?php
/**
 * @author Denis Fohl
 */

namespace Zac2\Form\Element;

class Enseignant extends ElementAbstract
{

    public function __construct(array $config, array $params)
    {
        parent::__construct($config, $params);

        $this->formElement = new \Zend_Form_Element_Select('enseignant_code');

        $dic = $this->getContainer();

        $enseignantAnnee = $dic->get('entitymanager.enseignantannee');

        $this->formElement->setLabel('enseignant');
        $this->formElement->setMultiOptions(array(null => '-- votre choix --') + $enseignantAnnee->getMultiOptions($this->getFiltre($params)));
    }

}
