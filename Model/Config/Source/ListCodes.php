<?php
/**
 * Class ListCodes
 * 
 * @author      MarioSAM <eu@mariosam.com.br>
 * @version     1.0.0
 * @date        2020/12
 * @copyright   Blog do Mario SAM
 * 
 * Give the new options value to config the system module.
 */
namespace MarioSAM\EstimateCep\Model\Config\Source;

class ListCodes implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '04510', 'label' => __('04510 - PAC')],
            ['value' => '41068', 'label' => __('41068 - PAC')],
            ['value' => '41106', 'label' => __('41106 - PAC')],
            ['value' => '04014', 'label' => __('04014 - SEDEX')],
            ['value' => '40010', 'label' => __('40010 - SEDEX')],
            ['value' => '40096', 'label' => __('40096 - SEDEX')],
            ['value' => '40436', 'label' => __('40436 - SEDEX')],
            ['value' => '40444', 'label' => __('40444 - SEDEX')],
            ['value' => '04790', 'label' => __('04790 - SEDEX 10')],
            ['value' => '40215', 'label' => __('40215 - SEDEX 10')],
            ['value' => '04804', 'label' => __('04804 - SEDEX Hoje')],
            ['value' => '40290', 'label' => __('40290 - SEDEX Hoje')],
            ['value' => '40045', 'label' => __('40045 - SEDEX a Cobrar')],
            ['value' => '04782', 'label' => __('04782 - SEDEX 12')],
            ['value' => '81019', 'label' => __('81019 - e-SEDEX')]
        ];
    }
}
