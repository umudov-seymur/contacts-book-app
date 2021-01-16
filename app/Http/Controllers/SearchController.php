<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $data = request()->validate(
            ['query' => 'required']
        );

        $contacts = Contact::search($data['query'])->get();
        return ContactResource::collection($contacts);
    }
}
