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
 * @package  AppBundle\Repository
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */
namespace AppBundle\Repository;


use AppBundle\Entity\Employee;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;

/**
 * Address repository.
 *
 * @category AppBundle
 * @package  AppBundle\Repository
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */
class EmployeeRepository extends EntityRepository
{
    /**
     * Get list of all non removed employees. Ordered descendingly by id.
     *
     * @return Employee[]
     */
    public function loadListOfEmployees()
    {
        $queryBuilder = $this->createQueryBuilder('employee');
        $queryBuilder->select('employee')
            ->where('employee.isRemoved = :removeFlag')
            ->setParameter('removeFlag', false)
            ->orderBy('employee.id', Criteria::DESC);
        return $queryBuilder->getQuery()->getResult();
    }
}
