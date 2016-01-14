<?php

namespace XTAIN\Bundle\UnitConverterBundle\Twig\Extension;

use XTAIN\UnitConverter\UnitConverter;

class UnitFormatter extends \Twig_Extension
{
    /**
     * @var UnitConverter
     */
    private $converter;

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter(
                'unit_formatter', array($this, 'unitFormatter'), array(
                    'is_safe' => array('html'), 'needs_environment' => true
                )
            ),
            new \Twig_SimpleFilter(
                'unit_converter', array($this, 'unitConverter'), array(
                    'is_safe' => array('html'), 'needs_environment' => true
                )
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'unit_formatter';
    }

    /**
     * @param UnitConverter $converter
     * @return UnitFormatter
     */
    public function setConverter($converter)
    {
        $this->converter = $converter;
        return $this;
    }

    public function unitFormatter(\Twig_Environment $env, $number, $unit, $format_args = array()) {
        return $env->render("XTAINUnitConverterBundle::unit_formatter.html.twig", array(
            "number" => $number,
            'unit' => $unit,
            'format_args' => $format_args
        ));
    }

    public function unitConverter(\Twig_Environment $env, $number, $input_unit, $output_unit, $format_args = array()) {
        if (isset($this->converter)) {
            $number = $this->converter->convert($number, $input_unit, $output_unit);
        }
        return $this->unitFormatter($env, $number, $output_unit, $format_args);
    }
}
