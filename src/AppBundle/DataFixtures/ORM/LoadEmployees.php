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
 * @package  AppBundle_DataFixtures
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */
namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Address;
use AppBundle\Entity\Employee;
use AppBundle\Entity\Phone;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Load employees fixtures.
 *
 * @category AppBundle
 * @package  AppBundle\DataFixtures\ORM
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */
class LoadEmployees extends AbstractFixture implements FixtureInterface
{
    /**
     * Array of available genders.
     *
     * @var array
     */
    private $genders = [
        Employee::GENDER_FEMALE,
        Employee::GENDER_MALE
    ];

    /**
     * Load data fixtures for employees.
     *
     * @param ObjectManager $manager Doctrine entity manager.
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        for ($iterator = 0; $iterator < 60; $iterator++) {
            $employee = new Employee();

            $employee->setGender($this->genders[array_rand($this->genders, 1)]);
            $employee->setSalary(sprintf('%s.%s', $iterator * 5, $iterator));
            $employee->setDateOfBirth(new \DateTime('now'));
            $employee->setComment(sprintf('%s_%s', $iterator, uniqid()));
            $employee->setLastName(sprintf('%s_last_name', $iterator));
            $employee->setFirstName(sprintf('%s_first_name', $iterator));

            $addressCount = rand(1, 5);
            while ($addressCount > 0) {
                $employee->addAddress(
                    (new Address())
                        ->setCity(sprintf('City_%s', $addressCount))
                        ->setStreet(sprintf('Street_%s', $addressCount))
                        ->setPostcode(
                            sprintf(
                                '%s-%s',
                                $iterator,
                                str_pad(
                                    $addressCount,
                                    5,
                                    '0'
                                )
                            )
                        )
                );
                $addressCount--;
            }

            $phonesCount = rand(1, 2);
            while ($phonesCount > 0) {
                $employee->addPhone(
                    (new Phone())->setNumber(
                        sprintf(
                            '%s-%s-%s',
                            str_pad(
                                $iterator,
                                2,
                                STR_PAD_LEFT
                            ),
                            str_pad(
                                $phonesCount,
                                3,
                                STR_PAD_LEFT
                            ),
                            str_pad(
                                '0',
                                5,
                                STR_PAD_LEFT
                            )
                        )
                    )
                        ->setTitle(sprintf('Phone_%s', $phonesCount))
                );
                $phonesCount--;
            }

            if ($iterator % 2) {
                $employee->deactivate();
            }

            if ($iterator % 3) {
                $employee->remove();
            }

            $manager->persist($employee);
            if ($iterator % 10) {
                $manager->flush();
            }
        }
    }
}