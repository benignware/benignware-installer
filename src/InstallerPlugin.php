<?php

namespace Benignware\BenignwareInstaller;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PreFileDownloadEvent;

use Dotenv\Dotenv;

if (file_exists(getcwd() . DIRECTORY_SEPARATOR . '.env')) {
  $dotenv = new Dotenv(getcwd());
  $dotenv->load();
}

class InstallerPlugin implements PluginInterface, EventSubscriberInterface
{
    protected const HUB_URL = 'https://hub.benignware.com';

    protected $composer;
    protected $io;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }

    public static function getSubscribedEvents()
    {
      return array(
        PluginEvents::PRE_FILE_DOWNLOAD => 'preFileDownload',
        PackageEvents::PRE_PACKAGE_INSTALL => 'packageInstall',
        PackageEvents::PRE_PACKAGE_UPDATE => 'packageInstall'
      );
    }

    public function isBenignwarePackageUrl($url) {
      return !!$url && (strpos($url, self::HUB_URL) !== false);
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

    public function preFileDownload(PreFileDownloadEvent $event)
    {
        $url = $event->getProcessedUrl();

        if ($this->isBenignwarePackageUrl($url)) {
          $package = $event->getContext();
          $version = $package->getPrettyVersion();

          $url = $this->buildUrl($url, [
            'key' => getenv('BENIGNWARE_LICENSE_KEY'),
            'ref' => $version
          ]);

          $event->setProcessedUrl($url);
        }
    }

    public function packageInstall(PackageEvent $event)
    {
      $operation = $event->getOperation();
      $package = method_exists($operation, 'getPackage')
        ? $operation->getPackage()
        : $operation->getTargetPackage();

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
