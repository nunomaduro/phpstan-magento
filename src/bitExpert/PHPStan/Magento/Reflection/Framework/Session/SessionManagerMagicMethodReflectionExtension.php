<?php

/*
 * This file is part of the phpstan-magento package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace bitExpert\PHPStan\Magento\Reflection\Framework\Session;

use bitExpert\PHPStan\Magento\Reflection\AbstractMagicMethodReflectionExtension;
use PHPStan\Reflection\ClassReflection;

class SessionManagerMagicMethodReflectionExtension extends AbstractMagicMethodReflectionExtension
{
    /**
     * @param ClassReflection $classReflection
     * @param string $methodName
     * @return bool
     */
    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        return $classReflection->isSubclassOf('Magento\Framework\Session\SessionManager') &&
            in_array(substr($methodName, 0, 3), ['get', 'set', 'uns', 'has']);
    }
}
