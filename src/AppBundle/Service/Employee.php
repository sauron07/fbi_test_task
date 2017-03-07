<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category AppBundle
 * @package  AppBundle\Service
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */

namespace AppBundle\Service;


use AppBundle\Exception\EmployeeNotFound;
use AppBundle\Repository\EmployeeRepository;

/**
 * Employee service.
 *
 * @category AppBundle
 * @package  AppBundle\Service
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */
class Employee implements EmployeeInterface
{
    /**
     * Employee repository.
     *
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * Employee constructor.
     *
     * @param EmployeeRepository $employeeRepository Employee repository.
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Load all active employees.
     *
     * @return array
     */
    public function loadEmployees()
    {
        return $this->employeeRepository->loadListOfEmployees();
    }

    /**
     * Load employee by id.
     *
     * @param int $id Employee id.
     *
     * @return null|object
     *
     * @throws EmployeeNotFound
     */
    public function loadEmployee($id)
    {
        $employee = $this->employeeRepository->findOneBy(
            [
                'id' => $id,
                'isRemoved' => false
            ]
        );
        if (!$employee) {
            throw new EmployeeNotFound(
                sprintf(
                    'Employee with id %s was not found.', $id
                )
            );
        }
        return $employee;
    }

    /**
     * Mark employee as removed.
     *
     * @param int $id Employee id.
     *
     * @return void
     */
    public function removeEmployee(int $id)
    {
        $employee = $this->loadEmployee($id);
        $employee->remove();
    }
}