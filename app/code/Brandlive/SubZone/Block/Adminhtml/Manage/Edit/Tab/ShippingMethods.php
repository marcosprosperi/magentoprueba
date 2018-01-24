<?php

namespace Brandlive\SubZone\Block\Adminhtml\Manage\Edit\Tab;

class ShippingMethods extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

  

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('pointofsale');

        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Shipping Methods')]);

        $fieldset->addField(
            'store_pickup',
            'checkbox',
            [
                'label' => __('Store Pickup'),
                'name' => 'store_pickup',
                'data-form-part' => $this->getData('target_form')
            ]
        )->setIsChecked($model->getStorePickup());

        $fieldset->addField(
            'car_pickup',
            'checkbox',
            [
                'label' => __('Car Pickup'),
                'name' => 'car_pickup',
                'data-form-part' => $this->getData('target_form')
            ]
        )->setIsChecked($model->getCarPickup());

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return __('Shipping Methods');
    }

    public function getTabTitle()
    {
        return __('Shipping Methods');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}
