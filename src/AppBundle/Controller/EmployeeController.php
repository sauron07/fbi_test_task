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
 * @package  AppBundle/Controller
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Employee;
use AppBundle\Exception\EmployeeNotFound;
use AppBundle\Form\EmployeeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Employee controller.
 *
 * @category AppBundle
 * @package  AppBundle\Controller
 * @author   Matvieiev Aleksandr <maal@ciklum.com>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     https://github.com/sauron07
 */
class EmployeeController extends Controller
{
    /**
     * List all employees action. Load only non removed employee.
     *
     * @Route(path="/employee/",
     *     name="employee_list")
     * @Security("has_role('ROLE_WORKER')")
     *
     * @return Response
     */
    public function listAction()
    {
        return $this->render(
            'AppBundle:employee:list.html.twig',
            [
                'employees' => $this->get('employee')->loadEmployees(),
            ]
        );
    }

    /**
     * Edit employee.
     *
     * @param Request $request Symfony request object.
     * @param int     $id      Employer id
     *
     * @Route(path="/employee/edit/{id}",  name="employee_edit")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @return Response
     */
    public function editAction(Request $request, $id)
    {
        $flashBag = $this->get('session')->getFlashBag();
        try {
            $employee = $this->get('employee')->loadEmployee($id);
            $form = $this->createForm(EmployeeType::class, $employee);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                $flashBag->set(
                    'success',
                    sprintf(
                        'Employee %s was updated successfully.',
                        $employee->getId()
                    )
                );
                return $this->redirectToRoute('employee_list');
            }

            return $this->render(
                'AppBundle:employee:edit.html.twig',
                [
                    'form' => $form->createView(),
                ]
            );
        } catch (EmployeeNotFound $exception) {
            $flashBag->set('error', $exception->getMessage());
            return $this->redirectToRoute('employee_list');
        } catch (\Exception $exception) {
            $flashBag->set('error', 'Could not save an employee.');
            return $this->redirectToRoute('employee_list');
        }
    }

    /**
     * Create new employee.
     *
     * @param Request $request Symfony request object.
     *
     * @Route(path="/employee/new",
     *     name="employee_new")
     * @Security("has_role('ROLE_MANAGER')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $flashBag = $this->get('session')->getFlashBag();
        try {
            $employee = new Employee();
            $form = $this->createForm(EmployeeType::class, $employee);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($employee);
                $entityManager->flush();
                $flashBag->set(
                    'success',
                    sprintf(
                        'Employee %s was successfully created',
                        $employee->getId()
                    )
                );
                return $this->redirectToRoute('employee_list');
            }

            return $this->render(
                'AppBundle:employee:new.html.twig',
                [
                    'form' => $form->createView()
                ]
            );
        } catch (\Exception $exception) {
            $flashBag->set('error', 'Could not create an employee.');
            return $this->redirectToRoute('employee_list');
        }
    }

    /**
     * Remove single employee by id.
     *
     * @param int $id Employee id to remove.
     *
     * @Route(path="/employee/remove/{id}",
     *     name="employee_remove")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction($id)
    {
        $flashBag = $this->get('session')->getFlashBag();
        try {
            $this->get('employee')->removeEmployee((int) $id);
            $this->getDoctrine()->getManager()->flush();
            $flashBag->set(
                'success',
                sprintf(
                    'Employee %s was removed successfully',
                    $id
                )
            );
            return $this->redirectToRoute('employee_list');
        } catch (EmployeeNotFound $exception) {
            $flashBag->set('error', $exception->getMessage());
            return $this->redirectToRoute('employee_list');
        } catch (\Exception $exception) {
            $flashBag->set('error', 'Could not remove an employee.');
            return $this->redirectToRoute('employee_list');
        }
    }
}