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

namespace Ebizmarts\MandrillSmtp\Model\Config;

use Exception;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\Filesystem\Directory\ReadFactory;

class ModuleVersion
{
    const COMPOSER_FILE_NAME = 'composer.json';
    /**
     * @var ComponentRegistrarInterface
     */
    private $componentRegistrar;
    /**
     * @var ReadFactory
     */
    private $readFactory;

    /**
     * ModuleVersion constructor.
     * @param ComponentRegistrarInterface $componentRegistrar
     * @param ReadFactory $readFactory
     */
    public function __construct(ComponentRegistrarInterface $componentRegistrar, ReadFactory $readFactory) {
        $this->componentRegistrar = $componentRegistrar;
        $this->readFactory = $readFactory;
    }
    public function getModuleVersion($moduleName)
    {
        $path = $this->componentRegistrar->getPath(
            ComponentRegistrar::MODULE,
            $moduleName
        );

        try {
            $directoryRead = $this->readFactory->create($path);
            $composerJsonData = $directoryRead->readFile('composer.json');

            if ($composerJsonData) {
                $data = json_decode($composerJsonData);
                return !empty($data->version) ? $data->version : __('Unknown');
            }
        } catch (Exception $e) {
            return __('Unknown');
        }

        return __('Unknown');
    }
}
