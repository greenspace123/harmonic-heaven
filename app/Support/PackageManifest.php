<?php

namespace App\Support;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\PackageManifest as BasePackageManifest;

class PackageManifest extends BasePackageManifest
{
    /**
     * The manifest path.
     *
     * @var string
     */
    public $manifestPath;
    
    /**
     * Create a new package manifest instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $manifestPath
     * @param  string  $appPath
     * @return void
     */
    public function __construct(Filesystem $files, $manifestPath, $appPath)
    {
        parent::__construct($files, $manifestPath, $appPath);
    }
}
