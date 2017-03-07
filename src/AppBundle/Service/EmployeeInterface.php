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

/**
 * Employee service Interface
 *
 * @category AppBundle
 * @package  AppBundle\Service
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */
interface EmployeeInterface
{
    /**
     * Load all active employees.
     *
     * @return array
     */
    public function loadEmployees();

    /**
     * Load employee by id.
     *
     * @param int $id Employee id.
     *
     * @return null|object
     *
     * @throws EmployeeNotFound
     */
    public function loadEmployee($id);

    /**
     * Mark employee as removed.
     *
     * @param int $id Employee id.
     *
     * @return void
     */
    public function removeEmployee(int $id);
}