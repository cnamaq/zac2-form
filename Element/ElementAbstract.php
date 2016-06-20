<?php
/**
 * @author Denis Fohl
 */

namespace Zac2\Form\Element;


use Symfony\Component\DependencyInjection\Container;
use Zac2\Filter\Multi\Multi;

abstract class ElementAbstract
{

    /**
     * @var Multi
     */
    protected $filtre;
    /**
     * @var mixed
     */
    protected $formElement;
    /**
     * @var Container
     */
    protected $container;

    /**
     * @return Container
     */
    protected function getContainer()
    {
        if (is_null($this->container)) {
            $this->container = \Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('dic');
        }

        return $this->container;
    }

    /**
     * @param Multi $filtre
     */
    public function setFiltre(Multi $filtre)
    {
        $this->filtre = $filtre;
    }

    /**
     * @return mixed
     */
    public function getFormElement()
    {
        return $this->formElement;
    }

    /**
     * @param mixed $formElement
     */
    public function setFormElement($formElement)
    {
        $this->formElement = $formElement;
    }

    /**
     * @return Multi
     */
    public function getFiltre()
    {
        return $this->filtre;
    }

    /**
     * ElementAbstract constructor.
     * @param array $config
     * @param array $params
     */
    public function __construct(array $config, array $params)
    {
        if (isset($config['filtre'])) {
            $filtre = $this->getContainer()->get('filtermulti.factory')->create($config['filtre']);
            $filtre->setValues($params);
            $this->setFiltre($filtre);
        }
    }

}
