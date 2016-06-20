<?php
/**
 * @author Denis Fohl
 */

namespace Zac2\Form\Element;


use Zac2\Common\DicAware;

class ZF1Factory extends DicAware
{

    /**
     * @param array $config
     * @param array $params
     * @return \Zend_Form_Element
     */
    public function create(array $config, array $params)
    {
        if ($config['class']) {
            $className = $config['class'];
            $element   = new $className($config, $params);
            return $element->getFormElement();
        }

        $class = '\Zend_Form_Element_' . ucfirst($config['type']);
        $element = new $class($config['options']);
        if (isset($config['lookup'])) {
            $multiOptions = $this->getMultiOptions($config['lookup'], $params);
            if ($element->getAttrib('multiple')) {
                $element->setOptions(array('multioptions' => $multiOptions));
                $element->setRegisterInArrayValidator(false);
            } else {
                $element->setOptions(array('multioptions' => array('' => '-- veuillez choisir --') + $multiOptions));
            }
        }
        if (isset($params[$config['options']['name']])) {
            $element->setValue($params[$config['options']['name']]);
        }

        return $element;
    }

    /**
     * @param array $config
     * @param array $params
     * @return array
     * @throws \Exception
     */
    protected function getMultiOptions(array $config, array $params)
    {
        $entityManager  = $this->getDic()->get($config['service']);
        $entityManager->getDataRequestAdapter()->from($config['table']);
        if (isset($config['order'])) {
            $entityManager->getDataRequestAdapter()->order($this->getOrder($config['order']));
        }
        $data           = $entityManager->getArrayData($config['table'], $this->getFiltre($config, $params));

        $multiOptions = array();
        foreach ($data as $row) {
            $label = array();
            foreach ($config['captionField'] as $field) {
                $label[] = $row[$field];
            }
            $separator = (isset($config['captionSeparator'])) ? $config['captionSeparator'] : ' ';
            $multiOptions[$row[$config['valueField']]] = implode($separator, $label);
        }

        return $multiOptions;
    }

    /**
     * @param array $config
     * @param array $params
     * @return null|\Zac2\Filter\Multi\Multi
     * @throws \Exception
     */
    protected function getFiltre(array $config, array $params)
    {
        if (isset($config['filtre'])) {
            $filtreFactory = $this->getDic()->get('filtermulti.factory');
            $filtre = $filtreFactory->create($config['filtre']);
            $filtre->setValues($params);

            return $filtre;
        }

        return null;
    }

    /**
     * @param null|string|array $config
     * @return array|null
     */
    protected function getOrder($config = null)
    {
        if (is_null($config)) {
            return null;
        }

        if (!is_array($config)) {
            $config = array($config => 'ASC');
        }

        $order = array();
        foreach ($config as $key => $sens) {
            $order[] = $key . ' ' . $sens;
        }

        return $order;
    }

}