<?php
 
namespace Brandlive\ModalOverlay\Block;
 
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
 
/**
 * Class ModalOverlay
 */
class ModalOverlay extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
 
    /**
     * ModalOverlay constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Context $context,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
 
        parent::__construct($context, $data);
    }
 
    /**
     * Retrieve modal overlay text
     *
     * @param $identifier
     * @return bool|string
     */
    public function getTexts()
    {

        try {
            $texts=[
                "title_text" =>$this->scopeConfig->getValue('modaloverlay/text/title_text', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                "placeholder_text"=>$this->scopeConfig->getValue('modaloverlay/text/placeholder_text', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                "validation_text"=>$this->scopeConfig->getValue('modaloverlay/text/validation_text', \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
                "button_text"=>$this->scopeConfig->getValue('modaloverlay/text/button_text', \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
            ];

            return $texts;

        } catch (LocalizedException $e) {
            return false;
        }
        
    }
}