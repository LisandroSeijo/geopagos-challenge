<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use ATP\Entities\Tournament;

class HomeController extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function index()
    {
        $tournaments = $this->em->getRepository(Tournament::class)->findAll();

        return response()->json($tournaments);
    }

    public function create() {
        $tournaments = new Tournament('Torneo 1');
        $this->em->persist($tournaments);
        $this->em->flush();
        return "ok!";
    }
}
