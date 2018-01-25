<?php
namespace Brandlive\CMS\Model\Layout\Update;

use Magento\Framework\Config\Dom\UrnResolver;
use Magento\Framework\Config\DomFactory;

class Validator extends \Magento\Framework\View\Model\Layout\Update\Validator
{
    const LAYOUT_SCHEMA_PAGE_HANDLE = 'page_layout';

    const LAYOUT_SCHEMA_MERGED = 'layout_merged';

    /**
     * @param DomFactory $domConfigFactory
     * @param UrnResolver $urnResolver
     */
    public function __construct(
        DomFactory $domConfigFactory,
        UrnResolver $urnResolver
    ) {
        parent::__construct($domConfigFactory, $urnResolver);
        $this->_xsdSchemas = [
            self::LAYOUT_SCHEMA_PAGE_HANDLE => $urnResolver->getRealPath(
                'urn:brandlive:module:Brandlive_CMS:etc/page_layout.xsd'
            ),
            self::LAYOUT_SCHEMA_MERGED => $urnResolver->getRealPath(
                'urn:magento:framework:View/Layout/etc/layout_merged.xsd'
            )
        ];
    }
}