<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TCGplayer;

class CardWiki extends Controller
{
    public function __construct(TCGPlayer $TCGplayerRepo)
    {
        $this->TCGplayerRepo = $TCGplayerRepo;
    }

    public function index()
    {
        return view('home.index', ['categories' => ['Magic', 'Force of Will']]);
    }

    public function showCard()
    {
        return view('card.show');
    }

    public function testForceOfWill()
    {
        $this->TCGplayerRepo->forceOfWill();
    }

    public function testDatabase()
    {
        $this->TCGplayerRepo->buildDatabase();
    }
}
