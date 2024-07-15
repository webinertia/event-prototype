<?php

declare(strict_types=1);

namespace Template\Container;

use Assetic\AssetManager;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\AssetReference;
use Assetic\Asset\AssetCache;
use Assetic\Asset\GlobAsset;
use Assetic\FilterManager;
use Assetic\Filter\CssMinFilter;
use Assetic\Filter\UglifyJs3Filter;
use Psr\Container\ContainerInterface;

use function realpath;

use const DIRECTORY_SEPARATOR;

final class AssetManagerFactory
{
    private const ASSET_BASE_PATH  = __DIR__ . '/../../assets/';
    private const ASSET_CACHE_PATH = __DIR__ . '/../../../../data/cache/assets';
    private const CSS_PATH      = 'css/style.css';
    private const SCRIPT_PATH   = 'scripts/*.js';
    private const WEB_PATH      = __DIR__ . '/../../../public/themes/default';

    public function __invoke(ContainerInterface $container): AssetManager
    {
        $path = realpath(self::ASSET_BASE_PATH) . DIRECTORY_SEPARATOR;
        $am = new AssetManager();
        $css = new GlobAsset(
            $path . 'css' . DIRECTORY_SEPARATOR . '*',
        );
        $css->setTargetPath(self::CSS_PATH);
        $am->set('css', $css);
        //$am->set('script', new GlobAsset($path . 'scripts' . DIRECTORY_SEPARATOR . '*'));
        return $am;
    }
}
