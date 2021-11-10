<?php
namespace App\Controller;
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response

    {      $repo=$this->getDoctrine()->getRepository(Product::class);
           $products=$repo->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
     /**
     * @Route("/product/add", name="add")
     */
    public function add(): Response

    {   $manager=$this->getDoctrine()->getManager();
        $product = new Product();
        $product->setLibelle("lib_test")
        ->setPrixu(500)
        ->setDescription("description de l'article")
        ->setImage("http://placehold.it/350*150");
        $manager->persist($product);
        $manager->flush();
        return new Response("ajout validé " . $product->getId());
    } 
        /**
     * @Route("/product/detail{id}", name="detail")
     */
    public function detail($id): Response

    {   $repo=$this->getDoctrine()->getRepository(Product::class);
        $product=$repo->find($id);
        return $this->render('product/detail.html.twig', ['product' => $product]);       
    } 
    
        /**
     * @Route("/product/delete{id}", name="delete")
     */
    public function delete($id): Response

    {   $repo=$this->getDoctrine()->getRepository(Product::class);
        $product=$repo->find($id);
        $manager=$this->getDoctrine()->getManager(Product::class);
        $manager->remove($product);
        $manager -> flush();
        #return $this->render('product/detail.html.twig', ['product' => $product]);       
        return new Response("suppression validé");
    } 
      /**
     * @Route("/product/add2", name="add2")
     */
    public function new(Request $request): Response
    {
        $prod = new Product();
    
        $form = $this->createForm(ProductType::class,$prod);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original $task variable has also been updated
           //$prod = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($prod);
             $entityManager->flush();

            return $this->redirectToRoute('product');
        }

        return $this->renderForm('product/new.html.twig', [
            'formpro' => $form,

        ]);
    }
}