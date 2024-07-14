<?php

declare(strict_types=1);

namespace Template;

use App\AppEvent;
use Assetic\AssetManager;
use Assetic\AssetWriter;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;

use function realpath;

use const DIRECTORY_SEPARATOR;

final class AssetListener extends AbstractListenerAggregate
{
    private const AUTOLOAD_PATH = __DIR__ . '/../../../config/autoload';
    private const CSS_PATH      = 'css/*.css';
    private const SCRIPT_PATH   = 'scripts/*.js';
    private const WEB_PATH      = __DIR__ . '/../../../public/themes/default';

    public function __construct(
        private AssetManager $am,
        private array $config
    ) {
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(AppEvent::EVENT_BOOTSTRAP, [$this, 'onBootstrap']);
    }

    public function onBootstrap(AppEvent $event)
    {
        $webPath = realpath(self::WEB_PATH);
        if (! isset($this->config['assets'])) {
            $writer = new AssetWriter($webPath);
            $writer->writeManagerAssets($this->am);
        }
    }
}
