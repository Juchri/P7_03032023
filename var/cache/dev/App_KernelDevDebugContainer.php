<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerMbYnDSy\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerMbYnDSy/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerMbYnDSy.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerMbYnDSy\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerMbYnDSy\App_KernelDevDebugContainer([
    'container.build_hash' => 'MbYnDSy',
    'container.build_id' => '9fc5effb',
    'container.build_time' => 1681391312,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerMbYnDSy');
