<?php
/**
 * Created by PhpStorm.
 * User: fohl
 * Date: 13/06/16
 * Time: 15:16
 */

namespace Zac2\Form\Element;


class AnneeCivile extends ElementAbstract
{

    public function __construct(array $config, array $params)
    {
        parent::__construct($config, $params);

        $current = date('Y');
        $multiOptions = array();
        for ($i = $current; $i > 2014; $i--) {
            $multiOptions[$i] = $i;
        }

        $this->formElement = new \Zend_Form_Element_Select('annee');
        $this->formElement->setLabel('année civile');
        $this->formElement->setMultiOptions($multiOptions);
    }

}