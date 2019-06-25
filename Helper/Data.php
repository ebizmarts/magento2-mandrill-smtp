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

namespace Ebizmarts\MandrillSmtp\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Store\Model\ScopeInterface;
use \Magento\Framework\Encryption\Encryptor;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const USERNAME  = 'mandrillsmtp/general/user';
    const APIKEY    = 'mandrillsmtp/general/apikey';
    const ENABLED   = 'mandrillsmtp/general/active';

    const PORT = 587;
    const HOST = 'smtp.mandrillapp.com';
    const SSL = 'tls';
    const AUTH = 'login';
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var Encryptor
     */
    private $encyptor;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        Encryptor $encryptor
    )
    {
        $this->storeManager = $storeManager;
        $this->scopeConfig  = $context->getScopeConfig();
        $this->encyptor     = $encryptor;
        parent::__construct($context);
    }

    /**
     * @param $path
     * @param null $storeId
     * @param null $scope
     * @return mixed
     */
    public function getConfigValue($path, $storeId = null, $scope = null)
    {
        if ($scope) {
            $value = $this->scopeConfig->getValue($path, $scope, $storeId);
        } else {
            $value = $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORES, $storeId);
        }
        return $value;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreUrl()
    {
        $url = $this->storeManager->getStore()->getBaseUrl();
        return parse_url($url,PHP_URL_HOST);
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getUsername()
    {
        return $this->getConfigValue(self::USERNAME, $this->storeManager->getStore()->getId());
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getApiKey()
    {
        $encryptedApiKey = $this->getConfigValue(self::APIKEY,$this->storeManager->getStore()->getId());
        try {
            $apiKey = $this->encyptor->decrypt($encryptedApiKey);
        } catch(\Exception $e) {
            $apiKey = '';
        }
        return $apiKey;
    }
    public function isEnabled()
    {
        return $this->getConfigValue(self::ENABLED, $this->storeManager->getStore()->getId());
    }
}
