<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;

class BirthdaysController extends Controller
{
    public function index()
    {
        return ContactResource::collection(
            request()
                ->user()
                ->contacts()
                ->birthdays()
                ->get()
        );
    }
}
