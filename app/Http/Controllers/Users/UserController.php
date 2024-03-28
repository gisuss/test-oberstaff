<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Responsable\Users\{ UserShowResponsable, UserDestroyResponsable, UserIndexResponsable, UserStoreResponsable };

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param mixed $userIndexResponsable
     * @return void
     */
    public function index(UserIndexResponsable $userIndexResponsable)
    {
        return $userIndexResponsable;
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param mixed $userStoreResponsable
     * @return void
     */
    public function store(UserStoreResponsable $userStoreResponsable)
    {
        return $userStoreResponsable;
    }

    /**
     * Display the specified resource.
     * 
     * @param string $search
     * @return void
     */
    public function show(string $search)
    {
        return new UserShowResponsable($search);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @return void
     */
    public function update()
    {
        
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param string $search
     * @return void
     */
    public function destroy(string $search)
    {
        return new UserDestroyResponsable($search);
    }
}
