<?php
use Zend\Session\SessionManager;
use Zend\Session\Service\SessionManagerFactory;
use Zend\Session\Config\ConfigInterface;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Service\SessionConfigFactory;
use Zend\Session\Storage\SessionArrayStorage;
use Fgsl\Mock\Db\Adapter\Mock;

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    // ...
    'service_manager' => [
        'factories' => [
            'DbAdapter' => function(){
                return new Mock();
            },
            SessionManager::class => SessionManagerFactory::class,
            ConfigInterface::class => SessionConfigFactory::class
	   ]
    ],
    'session_manager' => [
        'config' => [
            'class' => SessionConfig::class,
            'options' => [
                'name' => 'myapp',
            ],
        ],
	],
	'session_config' => [],
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ]
];
