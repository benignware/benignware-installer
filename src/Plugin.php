<?php

namespace Benignware\BenignwareInstaller;

use Composer\Composer;
use Composer\EventDispatcher\Event;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\DependencyResolver\Operation\OperationInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PluginInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\Plugin\PreFileDownloadEvent;
use Symfony\Component\Console\Helper\Table;

use Benignware\BenignwareInstaller\RemoteFilesystem;

use Dotenv\Dotenv;

if (file_exists(getcwd() . DIRECTORY_SEPARATOR . '.env')) {
    $dotenv = new Dotenv(getcwd());
    $dotenv->load();
}

class Plugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var IOInterface
     */
    protected $io;

    const DOWNLOAD_BASE = 'http://my.benignware.com/packages';

    /**
     * @param Composer $composer
     * @param IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;


    }

    /**
     * @return array
     */

    public static function getSubscribedEvents()
    {
        return [
          PluginEvents::INIT => 'init',
          PluginEvents::PRE_FILE_DOWNLOAD => 'preFileDownload',
          PackageEvents::PRE_PACKAGE_INSTALL => 'packageInstall',
          PackageEvents::PRE_PACKAGE_UPDATE => 'packageInstall'
        ];
    }

    protected function getPackageFromOperation(OperationInterface $operation)
    {
        if ($operation->getJobType() === 'update') {
            return $operation->getTargetPackage();
        }
        return $operation->getPackage();
    }

    public function isBenignwarePackageUrl($url) {
      return (strpos($url, self::DOWNLOAD_BASE) !== false);
    }

    public function buildUrl($url, $params = []) {
      $urlinfo = parse_url($url);

      if (!$urlinfo) {
        return $url;
      }

      $query = isset($urlinfo['query']) ? $urlinfo['query'] : '';

      parse_str($query, $url_params);

      $params = array_merge(
        $url_params,
        $params
      );

      $query = http_build_query($params);

      $scheme = isset($urlinfo['scheme']) ? $urlinfo['scheme'] : 'http';
      $host = isset($urlinfo['host']) ? $urlinfo['host'] : '';
      $path = isset($urlinfo['path']) ? $urlinfo['path'] : '';

      $url = sprintf('%s://%s%s%s', $scheme, $host, $path, $query ? '?' . $query : '');

      return $url;
    }

    /**
     * @param Event $event
     */
    public function init(Event $event)
    {

    }

    public function preFileDownload(PreFileDownloadEvent $event)
    {
        $url = $event->getProcessedUrl();

        if ($this->isBenignwarePackageUrl($url)) {

          $this->io->write(PHP_EOL . '<options=bold>PREFILE' . $url . '</>');
          $url = $this->buildUrl($url, [
            'key' => getenv('BENIGNWARE_LICENSE_KEY')
          ]);

          $rfs = $event->getRemoteFilesystem();
          $acfRfs = new RemoteFilesystem(
              $url,
              $this->io,
              $this->composer->getConfig(),
              $rfs->getOptions(),
              $rfs->isTlsDisabled()
          );
          $event->setRemoteFilesystem($acfRfs);

          $this->io->write(PHP_EOL . '<options=bold>Thanks for using benignware!</>' . PHP_EOL);
        }
    }

    public function packageInstall(PackageEvent $event)
    {

        $package = $this->getPackageFromOperation($event->getOperation());
        list($vendor, $name) = explode('/', $package->getName());

        if ($vendor === 'benignware') {
          $version = $package->getPrettyVersion();
          $distUrl = $package->getDistUrl();

          if ($this->isBenignwarePackageUrl($distUrl)) {
            $distUrl = $this->buildUrl($distUrl, [
              'ref' => $version
            ]);
            $package->setDistUrl($distUrl);
          }
        }
    }
}
