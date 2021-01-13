<?php
/**
 * Class SendFormats
 * 
 * @author      MarioSAM <eu@mariosam.com.br>
 * @version     1.0.0
 * @date        2020/12
 * @copyright   Blog do Mario SAM
 * 
 * Give the new options value to config the system module.
 */
namespace MarioSAM\EstimateCep\Model\Config\Source;

class SendFormats implements \Magento\Framework\Option\ArrayInterface
{ 
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            '1' => __('Box / Package'),
            '2' => __('Roll / Prism'),
            '3' => __('Envelope')
        ];
    }
}
