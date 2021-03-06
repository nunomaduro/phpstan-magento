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

namespace PHPStan\Magento\Type;

use bitExpert\PHPStan\Magento\Type\ObjectManagerDynamicReturnTypeExtension;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Testing\TestCase;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPUnit\Util\Type;

class ObjectManagerDynamicReturnTypeExtensionUnitTest extends TestCase
{
    /**
     * @var ObjectManagerDynamicReturnTypeExtension
     */
    private $extension;

    protected function setUp(): void
    {
        $this->extension = new ObjectManagerDynamicReturnTypeExtension();
    }

    /**
     * @return mixed[]
     */
    public function isMethodSupportedDataprovider(): array
    {
        return [
            ['create', true],
            ['get', true],
            ['foo', false],
            ['bar', false],
        ];
    }
    /**
     * @test
     * @dataProvider isMethodSupportedDataprovider
     * @param string $method
     * @param bool $expectedResult
     */
    public function checkIfMethodIsSupported(string $method, bool $expectedResult): void
    {
        $methodReflection = $this->createMock(MethodReflection::class);
        $methodReflection->method('getName')->willReturn($method);

        self::assertSame($expectedResult, $this->extension->isMethodSupported($methodReflection));
    }

    /**
     * @test
     */
    public function returnsMixedTypeForZeroArgumentCalls(): void
    {
        $methodReflection = $this->createMock(MethodReflection::class);
        $scope = $this->createMock(Scope::class);
        $methodCall = $this->createMock(MethodCall::class);
        $methodCall->args = [];

        $resultType = $this->extension->getTypeFromMethodCall($methodReflection, $methodCall, $scope);

        self::assertInstanceOf(MixedType::class, $resultType);
    }
}
