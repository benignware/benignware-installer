<?php

namespace Benignware\BenignwareInstaller;

use Composer\Config;
use Composer\IO\IOInterface;

/**
 * A composer remote filesystem for ACF PRO
 *
 * Makes it possible to copy files from a modified file url
 */
class RemoteFilesystem extends \Composer\Util\RemoteFilesystem
{
    /**
     * The file url that should be used instead of the given file url in copy
     *
     * @access protected
     * @var string
     */
    protected $benignwareFileUrl;

     /**
     * Constructor
     *
     * @access public
     * @param string $benignwareFileUrl The url that should be used instead of fileurl
     * @param IOInterface $io The IO instance
     * @param Config $config The config
     * @param array $options The options
     * @param bool $disableTls
     */
    public function __construct(
        $benignwareFileUrl,
        IOInterface $io,
        Config $config = null,
        array $options = [],
        $disableTls = false
    ) {
        $this->benignwareFileUrl = $benignwareFileUrl;
        parent::__construct($io, $config, $options, $disableTls);
    }

     /**
     * Copy the remote file in local
     *
     * Use $benignwareFileUrl instead of the provided $fileUrl
     *
     * @param string $originUrl The origin URL
     * @param string $fileUrl   The file URL (ignored)
     * @param string $fileName  the local filename
     * @param bool   $progress  Display the progression
     * @param array  $options   Additional context options
     *
     * @return bool true
     */
    public function copy(
        $originUrl,
        $fileUrl,
        $fileName,
        $progress = true,
        $options = []
    ) {
        return parent::copy(
            $originUrl,
            $this->benignwareFileUrl,
            $fileName,
            $progress,
            $options
        );
    }
}
