<?php

namespace App\Http\Controllers;

use App\DataTables\PersonnelDataTable;
use App\Helpers\AuthHelper;
use App\Models\Account;
use App\Models\Gestionnaire;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PersonnelDataTable $dataTable
     * @return Response
     */
    public function index(PersonnelDataTable $dataTable)
    {
        /*if (! auth()->user()->hasRole("super_admin")||! auth()->user()->hasRole("admin")) {
            return redirect(route('dashboard'))->withFlashDanger('You are not authorized to view admin dashboard.');
        }*/
        $pageTitle = "Liste des administrateurs";
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="#" data-app-title="Ajouter un administrateur" data-size="meduim" class="btn btn-sm btn-primary" role="button" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="'. route('personnels.create') .'"><i class="fa fa-plus"></i>Ajouter</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $view = view('administration.form-personnel')->render();
        return response()->json(['data' =>  $view, 'status'=> true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $account=new User();
        $account->first_name=$request->first_name;
        $account->last_name=$request->last_name;
        $account->email=$request->email;
        $account->phone_number=$request->phone_number;
        $account->user_type=$request->user_type;
        $account->password="12345";
        $account->username=$request->email;
        $account->save();
        $personnel=new Gestionnaire();
        $personnel->address=$request->address;
        $personnel->account()->associate($account);
         $b_ool=$personnel->save();
        if ($b_ool){
            return redirect()->route('personnels.index')->withSuccess("Operation executée avec success");
        }else{
            return redirect()->route('personnels.index')->withErrors(__('message.msg_added',['name' => __('users.store')]));
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function edit($id,Request $request)
    {
        $local=User::query()->find($id);
        if ($request->method()=="POST"){

            $local->libelle = $request->libelle;
            $local->save();
            $local->group_locals()->sync($request->group_locals);

            $b_ool = $local->update();
            if ($b_ool) {
                return redirect()->route('config.indexlocal')->withSuccess(__('Save success', ['name' => __('users.store')]));
            } else {
                return redirect()->route('config.indexlocal')->withErrors(__('message.msg_added', ['name' => __('users.store')]));
            }
        }
        return view('administration.edit_personnel', [

        ]);

    }
    public function delete($id,Request $request)
    {
        $user = User::query()->find($id);
        $b_ool =$user->delete();
        if ($b_ool) {
            return redirect()->route('personnels.index')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('personnels.index')->withErrors(__('update', ['name' => __('users.store')]));
        }
    }
}
