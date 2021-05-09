<?php
namespace App\Http\Controller\Pages;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class HomeController
 * @package App\Http\Controller\Pages
 * @author jaures kano <ruddyjaures@gmail.com>
 */
class HomeController extends AbstractController
{

    /**
     * @Route("/" , name="index")
     * @return Response
     */
    public function index(){

        return $this->render('pages/pages_index.html.twig', [
            'demo' => 'le controller principale'
        ]);
    }

}