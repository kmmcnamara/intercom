<?php

namespace Drinks\Services;

use PHPUnit\Framework\TestCase;
use Drinks\Domain\Customer;
use Drinks\Domain\Location;

class CustomerLoaderTest extends TestCase {

    /**
     * @var CustomerLoader
     */
    private $customerLoader;

    public function setUp(){
        $mockFileHandler = $this->getMockBuilder(FileHandler::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockFileHandler->expects($this->at(0))->method('getNextLine')
            ->willReturn('{"latitude": "52.833502", "user_id": 25, "name": "David Behan", "longitude": "-8.522366"}');
        $mockFileHandler->expects($this->at(0))->method('getNextLine')
            ->willReturn(false);

        $mockFileHandler->method('closeFile');
        $this->customerLoader = new CustomerLoader($mockFileHandler);
    }

    public function testLoadCustomers() {
        $customer = current($this->customerLoader->loadCustomers());

        $expectedCustomer = new Customer(25, 'David Behan', new Location(52.833502, -8.522366));
        $this->assertEquals($expectedCustomer, $customer);
    }
}