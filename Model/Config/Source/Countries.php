<?php
/**
 * Class Countries
 * 
 * @author      MarioSAM <eu@mariosam.com.br>
 * @version     1.0.0
 * @date        2020/12
 * @copyright   Blog do Mario SAM
 * 
 * Give the new options value to config the system module.
 */
namespace MarioSAM\EstimateCep\Model\Config\Source;

class Countries implements \Magento\Framework\Option\ArrayInterface
{ 
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            'brazil'    => __('Brazil')
        ];
    }
}
