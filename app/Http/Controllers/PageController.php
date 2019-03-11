<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('erole:employee,admin', ['except'=> ['homePage']]);
        $this->middleware('erole:admin', ['only'=> ['adminUsersPage', 'adminUserPage', 'companyPage', 'branchPage']]);
    }
    
    public function homePage()
    {
        return view('home');
    }

    public function branchPage()
    {
        return view('branch');
    }

    public function companyPage()
    {
        return view('company');
    }

    public function reportsPage()
    {
        return view('reports');
    }
    

    public function reportPage()
    {
        return view('report');
    }

    public function adminUsersPage()
    {
        return view('adminusers');
    }

    public function adminUserPage()
    {
        return view('adminuser');
    }
}
