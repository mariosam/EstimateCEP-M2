<?php
/**
 * Class registration
 * 
 * @author      MarioSAM <eu@mariosam.com.br>
 * @version     1.0.0
 * @date        2020/12
 * @copyright   Blog do Mario SAM
 * 
 * This class register the new modulo into system.
 */
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(ComponentRegistrar::MODULE, 'MarioSAM_EstimateCep', __DIR__);
