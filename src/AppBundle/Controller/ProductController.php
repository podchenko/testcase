<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Action;
use AppBundle\Entity\Product;
use AppBundle\Entity\SpecialPrice;
use AppBundle\Form\ProductType;
use AppBundle\Model\ActionManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new product entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $product = new Product();
        $form = $this->createForm(new ProductType(), $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $request = $request->request->all();

            if (!empty($request['appbundle_product']['specialPrices'])) {
                $specialPricesArray = $request['appbundle_product']['specialPrices'];

                foreach($specialPricesArray as $specialPricesItem) {
                    $specialPrices = new SpecialPrice();

                    if (empty($specialPricesItem['price'])) {
                        $specialPricesItem['price'] = 0;
                    }

                    $specialPrices->setPrice($specialPricesItem['price']);
                    $action = $em->getRepository('AppBundle:Action')->find($specialPricesItem['action']);

                    if ($action instanceof Action) {
                        $specialPrices->setAction($action);
                        $specialPrices->setProduct($product);
                        $product->addSpecialPrice($specialPrices);

                    }
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        $actions = $em->getRepository('AppBundle:Action')->findAll();

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'actions' => $actions,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function editAction(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm(new ProductType(), $product);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $request = $request->request->all();

            if (!empty($request['appbundle_product']['specialPrices'])) {

                $specialPricesArray = $request['appbundle_product']['specialPrices'];

                foreach($specialPricesArray as $specialPricesItem) {
                    $action = $em->getRepository('AppBundle:Action')->find($specialPricesItem['action']);
                    $specialPrices = $em->getRepository('AppBundle:SpecialPrice')->findOneBy(['product' => $product, 'action' => $action]);

                    if (empty($specialPricesItem['price'])) {
                        $specialPricesItem['price'] = 0;
                    }

                    if (!($specialPrices instanceof SpecialPrice)) {
                        $specialPrices = new SpecialPrice();


                        $specialPrices->setPrice($specialPricesItem['price']);

                        if ($action instanceof Action) {
                            $specialPrices->setAction($action);
                            $specialPrices->setProduct($product);
                            $product->addSpecialPrice($specialPrices);

                        }
                    } else {
                        $specialPrices->setPrice($specialPricesItem['price']);
                        $product->addSpecialPrice($specialPrices);

                    }
                }

            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        $actions = $em->getRepository('AppBundle:Action')->findAll();
        $specialPrices = [];

        foreach($actions as $action) {
            $price = $em->getRepository('AppBundle:SpecialPrice')->findOneBy(['action' => $action, 'product' => $product]);

            if ($price instanceof SpecialPrice) {
                $specialPrices[] = ['action' => $action, 'price' => $price->getPrice()];
            } else {
                $specialPrices[] = ['action' => $action, 'price' => 0];
            }
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'specialPrices' => $specialPrices
        ));
    }

    /**
     * Deletes a product entity.
     *
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
