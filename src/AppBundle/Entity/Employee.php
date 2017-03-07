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
 * @package  AppBundle_Entity
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Employee entity.
 *
 * @category AppBundle
 * @package  AppBundle/Entity
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 *
 * @ORM\Table(name="employee")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeRepository")
 */
class Employee
{
    /**
     * Gender type
     */
    const GENDER_MALE = 'm',
        GENDER_FEMALE = 'f';

    /**
     * Employee id.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id",
     *     type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * First name.
     *
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * Last name.
     *
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * Gender.
     *
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255)
     */
    private $gender;

    /**
     * Date of birth.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="date")
     */
    private $dateOfBirth;

    /**
     * Employee Phone numbers. Reference to Phone entity.
     *
     * @var Collection|array
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Phone",
     *     cascade={"persist", "remove"})
     *
     * @ORM\JoinTable(name="employee_phones",
     *     joinColumns={@ORM\JoinColumn(name="employee_id",
     *          referencedColumnName="id",
     *          onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="phonenumber_id",
     *          referencedColumnName="id",
     *          unique=true,
     *          onDelete="CASCADE")}
     *     )
     */
    private $phones;

    /**
     * Employee Addresses. Reference to Address entity.
     *
     * @var Collection|array
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Address",
     *     cascade={"persist", "remove"})
     *
     * @ORM\JoinTable(name="employee_addresses",
     *     joinColumns={@ORM\JoinColumn(name="employee_id",
     *          referencedColumnName="id",
     *          onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(
     *          name="address_id",
     *          referencedColumnName="id",
     *          unique=true,
     *          onDelete="CASCADE")}
     *     )
     */
    private $addresses;

    /**
     * Employee comment.
     *
     * @var PersistentCollection
     *
     * @ORM\Column(name="comment", type="text", nullable=true, nullable=true)
     */
    private $comment;

    /**
     * Salary amount.
     *
     * @var float
     *
     * @ORM\Column(name="salary",
     *     type="decimal",
     *     precision=10,
     *     scale=2,
     *     nullable=true)
     */
    private $salary;

    /**
     * Is active flag. By default all employees are active.
     *           1 => active.
     *           0 => non active.
     *
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive = 1;

    /**
     * Is deleted employee flag. By default all employees are not deleted.
     *           1 - deleted employee.
     *           0 - non deleted employee.
     *
     * @var bool
     *
     * @ORM\Column(name="is_removed", type="boolean")
     */
    private $isRemoved = 0;

    /**
     * Employee constructor.
     */
    public function __construct()
    {
        $this->phones = new ArrayCollection();
        $this->addresses = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName First name
     *
     * @return Employee
     */
    public function setFirstName($firstName): Employee
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName Employee lase name.
     *
     * @return Employee
     */
    public function setLastName($lastName): Employee
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string Employee lase name.
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set gender.
     *
     * @param string $gender Employee gender.
     *
     * @return Employee
     */
    public function setGender(string $gender): Employee
    {
        if (!in_array($gender, array(self::GENDER_MALE, self::GENDER_FEMALE))) {
            throw new \InvalidArgumentException('Invalid gender.');
        }
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birth date.
     *
     * @param \DateTime $dateOfBirth Birth date.
     *
     * @return Employee
     */
    public function setDateOfBirth($dateOfBirth): Employee
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get birth date.
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Add phone.
     *
     * @param Phone $phone Phone number.
     *
     * @return void
     */
    public function addPhone(Phone $phone)
    {
        $this->phones->add($phone);
    }

    /**
     * Remove phone.
     *
     * @param Phone $phone Employee phone.
     *
     * @return void
     */
    public function removePhone(Phone $phone)
    {
        $this->phones->removeElement($phone);
    }

    /**
     * Get phone numbers.
     *
     * @return Collection|array
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    /**
     * Add addresses.
     *
     * @param Address $address Employee address.
     *
     * @return void
     */
    public function addAddress(Address $address)
    {
        $this->addresses->add($address);
    }

    /**
     * Remove address.
     *
     * @param Address $address Employee address.
     *
     * @return void
     */
    public function removeAddress(Address $address)
    {
        $this->addresses->removeElement($address);
    }

    /**
     * Get addresses
     *
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * Set employee comment.
     *
     * @param string $comment Employee comment.
     *
     * @return Employee
     */
    public function setComment($comment): Employee
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set salary.
     *
     * @param string $salary Salary value.
     *
     * @return Employee
     */
    public function setSalary($salary): Employee
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary.
     *
     * @return string
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Is employee is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool) $this->isActive;
    }

    /**
     * Activate employee.
     *
     * @return Employee
     */
    public function activate(): Employee
    {
        $this->isActive = true;
        return $this;
    }

    /**
     * Deactivate employee.
     *
     * @return Employee
     */
    public function deactivate(): Employee
    {
        $this->isActive = false;
        return $this;
    }

    /**
     * Check that employee is removed.
     *
     * @return bool
     */
    public function isRemoved(): bool
    {
        return (bool) $this->isRemoved;
    }

    /**
     * Remove employee.
     *
     * @return Employee
     */
    public function remove(): Employee
    {
        $this->isRemoved = 1;
        return $this;
    }

    /**
     * Undo employee removing.
     *
     * @return Employee
     */
    public function undoRemove(): Employee
    {
        $this->isRemoved = 0;
        return $this;
    }
}