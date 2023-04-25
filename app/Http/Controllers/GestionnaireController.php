<?php

namespace App\Http\Controllers;

use App\DataTables\GestionnaireDataTable;
use App\DataTables\PersonnelDataTable;
use App\Helpers\AuthHelper;
use App\Models\Gestionnaire;
use App\Models\GroupLocal;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PersonnelDataTable $dataTable
     * @return Response
     */
    public function index(GestionnaireDataTable $dataTable)
    {
        /*if (! auth()->user()->hasRole("super_admin")||! auth()->user()->hasRole("admin")) {
            return redirect(route('dashboard'))->withFlashDanger('You are not authorized to view admin dashboard.');
        }*/
        $pageTitle = "Liste des gestionnaires";
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="#" data-app-title="Ajouter un gestionnaire" data-size="meduim" class="btn btn-sm btn-primary" role="button" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="'. route('gestionnaires.create') .'"><i class="fa fa-plus"></i>Ajouter</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $groups=GroupLocal::all()->pluck('libelle','id');
        $view = view('administration.form-gestionnaire',compact('groups'))->render();
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
        $account->user_type="manager";
        $account->password=bcrypt('12345');
        $account->username=$request->email;
        $account->save();
        $personnel=new Gestionnaire();
        $personnel->address=$request->address;
        $personnel->account()->associate($account);
        $b_ool=$personnel->save();
        if ($b_ool){
            return redirect()->route('gestionnaires.index')->withSuccess("Operation executée avec success");
        }else{
            return redirect()->route('gestionnaires.index')->withErrors(__('message.msg_added',['name' => __('users.store')]));
        }

    }
    public function gestionnairedit($id,Request $request){
        $gestionnaire=Gestionnaire::query()->find($id);
        if ($request->method()=="POST"){
            $user=User::query()->find($gestionnaire->user_id);
            $user->update([
                'first_name'=>$request->request->get('first_name'),
                'phone_number'=>$request->request->get('phone_number'),
                'email'=>$request->request->get('email'),
                'last_name'=>$request->request->get('last_name'),
            ]);
            $b_ool = $gestionnaire->update(
                [   'address'=>$request->request->get('address'),
                ]

            );
            if ($b_ool) {
                return redirect()->route('gestionnaires.index')->withSuccess(__('Save success', ['name' => __('users.store')]));
            } else {
                return redirect()->route('gestionnaires.index')->withErrors(__('message.msg_added', ['name' => __('users.store')]));
            }
        }
        return view('administration.edit_gestionnaire', [
            'gestionnaire'=>$gestionnaire,
        ]);
    }
}
