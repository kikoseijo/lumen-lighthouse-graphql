<?php

namespace App\Http\Controllers;

use App\Interactions\UserCreate;
use App\Interactions\UserUpdate;
use App\Repositories\UserRepository;
use App\Http\Controllers\BaseKrudController;
// Additionals
// use Ksoft\Klaravel\Traits\CanUploadMedia;
// use Ksoft\Klaravel\Traits\CanChangeStatuses;


/**
 * Class UserController
 * @package App\Http\Controllers\UserController
 */
class UserController extends BaseKrudController
{
    // use CanUploadMedia, CanChangeStatuses;
    /**
     * Used to change status with a single click in table rows attrs.
     * field => values
     */
    // protected $changeableStatus = [
    //     'active' => 'bool',
    //     'status' => ['State1', 'State2', 'State3'], // enums
    // ];
    /**
     * Enable middleware here or in your routes.
     * @param UserRepository $repo
     */
    public function __construct(UserRepository $repo)
    {
        // $this->middleware('auth');
        // $this->middleware('admin');
        // $this->middleware('cors');
        $this->createInteraction    = UserCreate::class;
        $this->updateInteraction    = UserUpdate::class;
        $this->repo                 = $repo;
        $this->path              = 'user';
    }

    /**
     * You already got full workin krud!
     *
     * Add here any extra methods you need or overwrite existings from BaseKrudController.
     *
     * just need write tables and fields.
     */

}



