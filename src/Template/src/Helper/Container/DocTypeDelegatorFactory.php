<?php

declare(strict_types=1);

namespace Template\Helper\Container;

use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Laminas\View\Helper\Doctype;
use Psr\Container\ContainerInterface;

final class DocTypeDelegatorFactory implements DelegatorFactoryInterface
{

    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null)
    {
        $config  = $container->get('config');
        /** @var Doctype */
        $docType = $callback();
        if (! isset($config['template_helper_config'])) {
            return $docType;
        }
        $config = $config['template_helper_config'];
        if (isset($config['doctype'])) {
            $docType->setDocType($config['doctype']);
        }
        return $docType;
    }

}
