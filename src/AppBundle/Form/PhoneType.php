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
 * @package  AppBundle\Form
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */

namespace AppBundle\Form;


use AppBundle\Entity\Phone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class Phone form.
 *
 * @category AppBundle
 * @package  AppBundle\Form
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */
class PhoneType extends AbstractType
{
    /**
     * Build phone form.
     *
     * @param FormBuilderInterface $builder Symfony from builder instance.
     * @param array                $options Form options.
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add(
                'number',
                TextType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            );
    }

    /**
     * Configure default options.
     *
     * @param OptionsResolver $resolver Configure options resolver.
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Phone::class]);
    }
}