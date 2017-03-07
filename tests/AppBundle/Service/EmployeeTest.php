<?php

namespace AppBundle\Tests\Service;


use AppBundle\Entity\Employee;
use AppBundle\Repository\EmployeeRepository;
use AppBundle\Service\Employee as EmployeeService;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{

    /**
     * Test load valid employee.
     *
     * @return void
     */
    public function testLoadValidEmployee()
    {
        $employee = $this->createMock(Employee::class);

        $employeeRepository = $this->getMockBuilder(EmployeeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employeeRepository->method('findOneBy')
            ->will($this->returnValue($employee));

        /** @var EmployeeRepository $employeeRepository */
        $employeeService = new EmployeeService($employeeRepository);

        $result = $employeeService->loadEmployee(1);

        $this->assertInstanceOf(Employee::class, $result);
    }

    /**
     * Test loading not existing employee.
     *
     * @expectedException \AppBundle\Exception\EmployeeNotFound
     *
     * @return void
     */
    public function testLoadInvalidEmployee()
    {
        $employeeRepository = $this->getMockBuilder(EmployeeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employeeRepository->method('findOneBy')
            ->will($this->returnValue(null));

        /** @var EmployeeRepository $employeeRepository */
        $employeeService = new EmployeeService($employeeRepository);
        $employeeService->loadEmployee(1);
    }

    /**
     * Test removing employee.
     */
    public function testRemoveEmployee()
    {
        $employee = new Employee();

        $employeeRepository = $this->getMockBuilder(EmployeeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employeeRepository->method('findOneBy')
            ->will($this->returnValue($employee));

        /** @var EmployeeRepository $employeeRepository */
        $service = new EmployeeService($employeeRepository);
        $service->removeEmployee(1);

        $this->assertTrue($employee->isRemoved());
    }

    /**
     * Try to remove not existing employee.
     *
     * @expectedException \AppBundle\Exception\EmployeeNotFound
     *
     * @return void
     */
    public function testRemoveNotExistingEmployee()
    {
        $employeeRepository = $this->getMockBuilder(EmployeeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employeeRepository->method('findOneBy')
            ->will($this->returnValue(null));

        /** @var EmployeeRepository $employeeRepository */
        $service = new EmployeeService($employeeRepository);
        $service->removeEmployee(1);
    }

}