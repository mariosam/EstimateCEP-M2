<?php
/**
 * Class EstimateCepViewModel
 * 
 * @author      MarioSAM <eu@mariosam.com.br>
 * @version     1.0.0
 * @date        2020/12
 * @copyright   Blog do Mario SAM
 * 
 * This class collect the data to show them in frontend.
 */
namespace MarioSAM\EstimateCep\ViewModel;

class EstimateCepViewModel implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    protected $_scopeConfig;
    protected $_cookieManager;
    protected $_registry;
    
    /**
     * EstimateCepViewModel constructor.
     *
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Registry $registry
    )
    {
        $this->_scopeConfig = $scopeConfig;
        $this->_cookieManager = $cookieManager;
        $this->_registry = $registry;

        //parent::__construct($context);
    }

    /***************************************************************************
     *  GENERAL CONFIG
     */
    
    /**
     * Check if this module is active or not.
     * 
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_load_values/enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * 
     * @return type
     */
    public function getCepOrigin()
    {
        return $this->_scopeConfig->getValue('shipping/origin/postcode', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * 
     * @return type
     */
    public function getCepModes()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_load_values/list_codes', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * 
     * @return type
     */
    public function getCepFree()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_load_values/cep_free', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * 
     * @return type
     */
    public function getCepFreeOverPrice()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_load_values/cep_free_value', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * 
     * @return type
     */
    public function getCepFreeDays()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_load_values/cep_free_days', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * 
     * @return type
     */
    public function getProductWeight()
    {
        $currentProduct = $this->_registry->registry('current_product');
        
        return $currentProduct->getWeight();
    }

    /**
     * CSS place to insert the message in product detail page
     * 
     * @return text
     */
    public function getCepPosition()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_load_values/cep_position', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Get cookie session and send to frontend.
     * 
     * @return cookie session
     */
    public function getCookieManager()
    {
        return $this->_cookieManager;
    }
    
    /**
     * Get the price value of Product page detail
     *
     * @return double
     */
    public function getProductPrice()
    {
        $currentProduct = $this->_registry->registry('current_product');

        //seria melhor usar uma constante nativa, mas nao encontrei.
        if ('configurable' == $currentProduct->getTypeId()) {
            return $currentProduct->getPriceInfo()->getPrice('regular_price')->getMinRegularAmount()->getValue();
        }

        if ('bundle' == $currentProduct->getTypeId()) {
            return $currentProduct->getPriceInfo()->getPrice('regular_price')->getMinimalPrice()->getValue();
        }

        if ('grouped' == $currentProduct->getTypeId()) {
            $regularPrice = 0;
            $usedProds = $currentProduct->getTypeInstance(true)->getAssociatedProducts($currentProduct);            
            foreach ($usedProds as $child) {
                if ($child->getId() != $currentProduct->getId()) {
                    $regularPrice += $child->getPrice();
                }
            }
            return $regularPrice;
        }

        return $currentProduct->getFinalPrice();
    }
    
    /**
     * 
     * @return type
     */
    public function getProductType()
    {
        $currentProduct = $this->_registry->registry('current_product');

        return $currentProduct->getTypeId();
    }
    
    /**
     * Get custom css code to improve frontend product page.
     * 
     * @return textarea
     */
    public function getCssCustomCalculateCep()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_load_values/css_cep', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Get custom javascript code to improve frontend product page.
     * 
     * @return textarea
     */
    public function getJsCustomCalculateCep()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_load_values/js_cep', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /***************************************************************************
     *  CUSTOM SEND CONFIGURATION
     */
    
    /**
     * 
     * @return type
     */
    public function getCepEmpresa()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_send_config/cep_nCdEmpresa', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * 
     * @return type
     */
    public function getCepSenha()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_send_config/cep_sDsSenha', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * 
     * @return type
     */
    public function getCepComprimento()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_send_config/cep_nVlComprimento', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * 
     * @return type
     */
    public function getCepDiametro()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_send_config/cep_nVlDiametro', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * 
     * @return type
     */
    public function getCepAltura()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_send_config/cep_nVlAltura', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * 
     * @return type
     */
    public function getCepLargura()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_send_config/cep_nVlLargura', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * 
     * @return type
     */
    public function getCepFormato()
    {
        return $this->_scopeConfig->getValue('estimatecep/cep_send_config/cep_nCdFormato', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
