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

namespace Ebizmarts\MandrillSmtp\Model\Transport;

use Magento\Framework\Exception\MailException;
use Magento\Framework\Phrase;
use Zend\Mail\Message;
use Zend\Mail\Transport\SmtpOptions;
use Ebizmarts\MandrillSmtp\Helper\Data as HelperData;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Magento\Framework\Mail\EmailMessageInterface;


class Smtp extends SmtpTransport
{
    /**
     * @var HelperData
     */
    private $helper;

    /**
     * Smtp constructor.
     * @param HelperData $helper
     * @param SmtpOptions $options
     */
    public function __construct(
        HelperData $helper
    )
    {
        $this->helper   = $helper;
        parent::__construct();
    }

    /**
     * @param EmailMessageInterface $message
     * @throws MailException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function sendMessage(EmailMessageInterface $message)
    {
        $options = new SmtpOptions();
        $options->setPort(HelperData::PORT);
        $options->setHost(HelperData::HOST);
        $options->setName($this->helper->getStoreUrl());
        $options->setConnectionClass(HelperData::AUTH);
        $connectionConfig = [
            'username'  => $this->helper->getUsername(),
            'password'  => $this->helper->getApiKey(),
            'ssl'       => HelperData::SSL
        ];
        try {
            $options->setConnectionConfig($connectionConfig);
            $this->setOptions($options);
            $zm = Message::fromString($message->getRawMessage());
            $this->send($zm);
        } catch(\Exception $e) {
            throw new MailException(
                new Phrase($e->getMessage()),
                $e
            );
        }

    }
}
