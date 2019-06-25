<?php
/**
 * Ebizmarts_MandrillSmtp
 *
 * @category    Ebizmarts
 * @package     Ebizmarts_MandrillSmtp
 * @author      Ebizmarts Team <info@ebizmarts.com>
 * @copyright   Ebizmarts (http://ebizmarts.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Ebizmarts\MandrillSmtp\Block\Adminhtml\System\Config\Fieldset;

class Hint extends \Magento\Backend\Block\Template implements \Magento\Framework\Data\Form\Element\Renderer\RendererInterface
{
    protected $_template = 'Ebizmarts_MandrillSmtp::system/config/fieldset/hint.phtml';
    /**
     * @var \Ebizmarts\Mandrill\Model\Config\ModuleVersion
     */
    protected $_moduleVersion;
    /**
     * Hint constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Ebizmarts\MandrillSmtp\Model\Config\ModuleVersion $moduleVersion
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Ebizmarts\MandrillSmtp\Model\Config\ModuleVersion $moduleVersion,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_moduleVersion   = $moduleVersion;
    }

    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->toHtml();
    }
    public function getModuleVersion()
    {
        return $this->_moduleVersion->getModuleVersion($this->getModuleName());
    }
}