<?php
/**
 * @author Denis Fohl
 */

namespace Zac2\Form;


use Zac2\Common\DicAware;

class ZF1Factory extends DicAware
{

    /**
     * @param array $config
     * @param array $params
     * @return ZF1
     */
    public function create(array $config, array $params)
    {
        $form = new ZF1();
        $formComponent = new \Zend_Form();
        $formComponent->setOptions($config['form']);
        foreach ($this->getActiveGroups($config['groups'], $params) as $groupConfig) {
            foreach ($groupConfig['elements'] as $elementConfig) {
                $element = $this->getDic()->get('form.element.zf1factory')->create($elementConfig, $params);
                $formComponent->addElement($element);
            }
        }
        $form->setFormComponent($formComponent);

        return $form;
    }

    /**
     * @param array $config
     * @param array $params
     * @return array
     */
    protected function getActiveGroups(array $config, array $params)
    {
        $result = array();
        foreach ($config as $group => $configGroup) {
            if (!$configGroup['previousgroup'] || $this->isActiveGroup($configGroup, $params)) {
                $result[$group] = $configGroup;
            }
        }

        return $result;
    }

    /**
     * @param $configGroup
     * @param array $params
     * @return bool
     */
    protected function isActiveGroup($configGroup, array $params)
    {
        foreach ($configGroup['previouselementsrequired'] as $element) {
            if ($params[$element]) {
                return true;
            }
        }

        return false;
    }

}
