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

namespace Ebizmarts\MandrillSmtp\Plugin\Mail;

use Closure;
use Ebizmarts\MandrillSmtp\Helper\Data as HelperData;
use Magento\Framework\Mail\TransportInterface;
use Zend\Mail\Transport\SmtpOptions;
use Ebizmarts\MandrillSmtp\Model\Transport\Smtp as MandrillSmtp;


class TransportPlugin
{
    private $helper;
    private $options;

    public function __construct(
        HelperData $helper,
        SmtpOptions $options
    )
    {
        $this->helper = $helper;
        $this->options = $options;
    }

    public function aroundSendMessage(
        TransportInterface $subject,
        Closure $proceed
    )
    {
        if ($this->helper->isEnabled()) {
            $smtp = new MandrillSmtp($this->helper);
            $smtp->sendMessage($subject->getMessage());
        } else {
            $proceed();
        }
    }
}