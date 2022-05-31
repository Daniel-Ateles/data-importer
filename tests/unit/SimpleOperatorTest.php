<?php
namespace Pimcore\Bundle\DataImporterBundle\Tests;

use Pimcore\Bundle\DataImporterBundle\Exception\InvalidConfigurationException;
use Pimcore\Bundle\DataImporterBundle\Mapping\Operator\Simple\StringReplace;
use Pimcore\Tests\Util\TestHelper;

class SimpleOperatorTest extends \Codeception\Test\Unit
{
    /**
     * @var \Pimcore\Bundle\DataImporterBundle\Tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
        TestHelper::cleanUp();
    }


    public function testStringReplaceProcessFunction() {
        $service = $this->tester->grabService(StringReplace::class);
        $service->setSettings(['search' => 'Test', 'replace' => 'Result']);
        $data = $service->process("Hello Test");

        $this->assertEquals($data, "Hello Result");
    }

    public function testStringReplaceProcessFunctionWithArray() {
        $service = $this->tester->grabService(StringReplace::class);
        $service->setSettings(['search' => 'Test', 'replace' => 'Result']);
        $data = $service->process(["Hello Test", "Test Array", "*Test*"]);

        $this->assertEquals($data[0], "Hello Result");
        $this->assertEquals($data[1], "Result Array");
        $this->assertEquals($data[2], "*Result*");
    }

    public function testStringReplaceEvaluateReturnTypeFunctionWithWrongInputType() {
        $this->expectException(InvalidConfigurationException::class);
        $service = $this->tester->grabService(StringReplace::class);
        $service->setSettings(['search' => 'Test', 'replace' => 'Result']);
        $service->evaluateReturnType("boolean");
    }
}