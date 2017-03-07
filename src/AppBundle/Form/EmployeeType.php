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
 * @package  AppBundle/Form
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */

namespace AppBundle\Form;


use AppBundle\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Employee form.
 *
 * @category AppBundle
 * @package  AppBundle\Exception
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */
class EmployeeType extends AbstractType
{
    /**
     * Build employee form.
     *
     * @param FormBuilderInterface $builder Form builder interface.
     * @param array                $options Form options.
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'lastName',
                TextType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'gender',
                ChoiceType::class, [
                    'choices' => [
                        'Male' => Employee::GENDER_MALE,
                        'Female' => Employee::GENDER_FEMALE
                    ],
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'comment',
                TextareaType::class, [
                    'attr' => [
                        'class' => 'form-control',
                        'rows' => '3'
                    ]
                ]
            )
            ->add(
                'salary',
                NumberType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add('dateOfBirth')
            ->add('isActive', CheckboxType::class)
            ->add(
                'addresses',
                CollectionType::class, [
                    'entry_type' => AddressType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
            ->add(
                'phones',
                CollectionType::class, [
                    'entry_type' => PhoneType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            )
            ->add(
                'save',
                SubmitType::class, [
                    'label' => 'Save',
                    'attr' => [
                        'class' => 'btn btn-primary'
                    ]
                ]
            );
    }

    /**
     * Configure default options.
     *
     * @param OptionsResolver $resolver Form resolver instance.
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Employee::class,
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
            ]
        );
    }
}