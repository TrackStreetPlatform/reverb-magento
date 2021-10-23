<?php
/**
 * Copyright © TrackStreet, Inc. All rights reserved.
 */
namespace TrackStreet\Core\Block\Adminhtml\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Information
 * @package TrackStreet\Core\Block\Adminhtml\System\Config
 */
class Information extends \Magento\Config\Block\System\Config\Form\Fieldset
{
    /**
     * @var \TrackStreet\Core\Helper\Data
     */
    protected $tsHelper;

    /**
     * @var \Magento\Framework\View\Element\BlockInterface
     */
    protected $fieldRenderer;

    /**
     * Information constructor.
     * @param \Magento\Backend\Block\Context $context
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\View\Helper\Js $jsHelper
     * @param \TrackStreet\Core\Helper\Data $tsHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\View\Helper\Js $jsHelper,
        \TrackStreet\Core\Helper\Data $tsHelper,
        array $data = [])
    {
        parent::__construct($context, $authSession, $jsHelper, $data);
        $this->tsHelper = $tsHelper;
    }

    /**
     * Render fieldset html
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {

        $html = $this->_getWidgetVersion($element);
        $html .= $this->_getEmbedAppSubdomain($element);
        return $html;
    }

    /**
     * @param AbstractElement $fieldset
     *
     * @return string
     */
    private function _getWidgetVersion($fieldset)
    {
        $label = __('Widget File Version');
        return $this->getFieldHtml($fieldset, 'widget_js_version', $label, $this->tsHelper->getScriptVersion());
    }

    /**
     * @param AbstractElement $fieldset
     *
     * @return string
     */
    private function _getEmbedAppSubdomain($fieldset)
    {
        $label = __('Embed App');
        $subdomains = explode('.',trim($this->tsHelper->getAdminUrl(),'//'));
        return $this->getFieldHtml($fieldset, 'embed_app_subdomain', $label, current($subdomains));
    }


    /**
     * @param AbstractElement $fieldset
     * @param string $fieldName
     * @param string $label
     * @param string $value
     *
     * @return string
     */
    protected function getFieldHtml($fieldset, $fieldName, $label = '', $value = '')
    {
        $field = $fieldset->addField($fieldName, 'label', [
            'name'  => 'dummy',
            'label' => $label,
            'after_element_html' => $value,
        ])->setRenderer($this->getFieldRenderer());

        return $field->toHtml();
    }

    /**
     * @return \Magento\Framework\View\Element\BlockInterface
     */
    private function getFieldRenderer()
    {
        if (empty($this->fieldRenderer)) {
            $this->fieldRenderer = $this->_layout->createBlock(
                \Magento\Config\Block\System\Config\Form\Field::class
            );
        }

        return $this->fieldRenderer;
    }
}
