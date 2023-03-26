<?php

namespace App\Http\Controllers;

use App\DataTables\AccessoireDataTable;
use App\DataTables\GroupLocalDataTable;
use App\DataTables\JourFerieDataTable;
use App\DataTables\LocalDataTable;
use App\DataTables\PeriodeDataTable;
use App\DataTables\TypeJourDataTable;
use App\DataTables\TypeSalleDataTable;
use App\Helpers\AuthHelper;
use App\Models\Gestionnaire;
use App\Models\GroupLocal;
use App\Models\JourFerie;
use App\Models\Local;
use App\Models\Periode;
use App\Models\TypeAccessoire;
use App\Models\TypeJour;
use App\Models\TypeSalle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param LocalDataTable $dataTable
     * @return Response
     */
    public function indexlocal(LocalDataTable $dataTable)
    {
       /* if (!auth()->user()->hasRole("admin")||!auth()->user()->hasRole("super_admin")) {
            return redirect(route('dashboard'))->withErrors(['message'=>'You are not authorized to view admin local.']);
        }*/
        $pageTitle = "Liste du locaux";
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="#" class="btn btn-sm btn-primary" role="button" data-app-title="Ajouter un local" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="' . route('config.createlocal') . '"><i class="fa fa-plus"></i>Ajouter</a>';
        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }
    /**
     * Display a listing of the resource.
     *
     * @param LocalDataTable $dataTable
     * @return Response
     */
    public function indexjourferie(JourFerieDataTable $dataTable)
    {
        $pageTitle = "Congés & feriés";
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="#" class="btn btn-sm btn-primary" role="button" data-app-title="Ajouter un ferié" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="' . route('config.createjourferie') . '"><i class="fa fa-plus"></i>Ajouter</a>';
        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }
    /**
     * Display a listing of the resource.
     *
     * @param LocalDataTable $dataTable
     * @return Response
     */
    public function indextypejour(TypeJourDataTable $dataTable)
    {
        $pageTitle = "Liste des types de jours";
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="#" class="btn btn-sm btn-primary" role="button" data-app-title="Ajouter un type jour" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="' . route('config.createtypejour') . '"><i class="fa fa-plus"></i>Ajouter</a>';
        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }
    /**
     * Display a listing of the resource.
     *
     * @param LocalDataTable $dataTable
     * @return Response
     */
    public function indextypesalle(TypeSalleDataTable $dataTable)
    {
        $pageTitle = "Liste des type de salle";
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="#" class="btn btn-sm btn-primary" data-app-title="Ajouter un type salle" role="button" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="' . route('config.createtypesalle') . '"><i class="fa fa-plus"></i>Ajouter</a>';
        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }
    /**
     * Display a listing of the resource.
     *
     * @param LocalDataTable $dataTable
     * @return Response
     */
    public function indextypeaccessoire(AccessoireDataTable $dataTable)
    {
        $pageTitle = "Type d'accessoires";
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="#" class="btn btn-sm btn-primary" data-app-title="Ajouter un type accessoire" role="button" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="' . route('config.createtypeaccessoire') . '"><i class="fa fa-plus"></i>Ajouter</a>';
        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }
    /**
     * Display a listing of the resource.
     *
     * @param GroupLocalDataTable $dataTable
     * @return Response
     */
    public function indexgrouplocal(GroupLocalDataTable $dataTable)
    {
        $pageTitle = "Liste des Groupes locals";
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="#" class="btn btn-sm btn-primary" data-app-title="Ajouter un groupe local" role="button" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="meduim" data--href="' . route('config.creategrouplocal') . '"><i class="fa fa-plus"></i>Ajouter</a>';
        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }
    /**
     * Display a listing of the resource.
     *
     * @param GroupLocalDataTable $dataTable
     * @return Response
     */
    public function indexperiode(PeriodeDataTable $dataTable)
    {
        $pageTitle = "Liste des Periodes";
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="#" class="btn btn-sm btn-primary" data-app-title="Ajouter une periode" role="button" data-bs-toggle="tooltip" data-modal-form="form" data-icon="person_add" data-size="small" data--href="' . route('config.createperiode') . '"><i class="fa fa-plus"></i>Ajouter</a>';
        return $dataTable->render('global.datatable', compact('pageTitle', 'auth_user', 'assets', 'headerAction'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createtypejour(Request $request)
    {
        $app_title="text";
        $view = view('administration.form-typejour',compact('app_title'))->render();
        return response()->json(['data' => $view, 'status' => true]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createjourferie(Request $request)
    {
        $app_title="text";
        $view = view('administration.form-jourferie',compact('app_title'))->render();
        return response()->json(['data' => $view, 'status' => true]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createtypesalle(Request $request)
    {
        $view = view('administration.form-typesalle')->render();
        return response()->json(['data' => $view, 'status' => true]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createtypeaccessoire(Request $request)
    {
        $view = view('administration.form-type-accessoire')->render();
        return response()->json(['data' => $view, 'status' => true]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createlocal(Request $request)
    {
        $data = $request->all();
        $values=GroupLocal::all()->pluck('libelle','id');
        $view = view('administration.form-local',compact('values'))->render();
        return response()->json(['data' => $view, 'status' => true]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createperiode(Request $request)
    {
        $data = $request->all();
        $view = view('administration.form-periode')->render();
        return response()->json(['data' => $view, 'status' => true]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function creategrouplocal(Request $request)
    {
        $salles=TypeSalle::all()->pluck('type','id');
        $jours=TypeJour::all()->pluck('type','id');
        $view = view('administration.form-grouplocal',compact('salles','jours'))->render();
        return response()->json(['data' => $view, 'status' => true]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function groupelocalgestionnaire($id,Request $request)
    {
        $groupe = GroupLocal::query()->find($id);
        $gestionnaires=Gestionnaire::query()->leftJoin('users','users.id','=','gestionnaire.id')->pluck('users.first_name','gestionnaire.id');

        if ($request->method()=="POST"){
            $groupe->gestionnaires()->sync($request->gestionnaire);
            $b_ool = $groupe->save();
            if ($b_ool) {
                return redirect()->route('groupelocalgestionnaire',['id'=>$id])->withSuccess(__('Save success', ['name' => __('users.store')]));
            } else {
                return redirect()->route('groupelocalgestionnaire',['id'=>$id])->withErrors(__('update', ['name' => __('users.store')]));
            }
        }

        return view('administration.groupelocalgestionnaire', [
            'groupe'=>$groupe,
            'gestionnaires'=>$gestionnaires,
            'groupe_gestionnaires'=>$groupe->gestionnaires
        ]);
    }
    /**
     * Delete ressource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function groupelocaldelete($id,Request $request)
    {
        $groupe = GroupLocal::query()->find($id);
        $b_ool =$groupe->delete();
        if ($b_ool) {
            return redirect()->route('config.indexgrouplocal')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('config.indexgrouplocal')->withErrors(__('update', ['name' => __('users.store')]));
        }
    }
    /**
     * Delete ressource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function typesalledelete($id,Request $request)
    {
        $groupe = TypeSalle::query()->find($id);
        $b_ool =$groupe->delete();
        if ($b_ool) {
            return redirect()->route('config.indextypesalle')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('config.indextypesalle')->withErrors(__('Delete', ['name' => __('users.store')]));
        }
    }
    /**
     * Delete ressource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function typeaccessoiredelete($id,Request $request)
    {
        $groupe = TypeSalle::query()->find($id);
        $b_ool =false;
        if ($b_ool) {
            return redirect()->route('config.indextypeaccessoire')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('config.indextypeaccessoire')->withErrors(__('Delete', ['name' => __('users.store')]));
        }
    }
    /**
     * Delete ressource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function congeferiedelete($id,Request $request)
    {
        $groupe = TypeSalle::query()->find($id);
        $b_ool =$groupe->delete();
        if ($b_ool) {
            return redirect()->route('config.indexjourferie')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('config.indexjourferie')->withErrors(__('Delete', ['name' => __('users.store')]));
        }
    }
    public function localdelete($id,Request $request)
    {
        $groupe = TypeSalle::query()->find($id);
        $b_ool =$groupe->delete();
        if ($b_ool) {
            return redirect()->route('config.indexlocal')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('config.indexlocal')->withErrors(__('Delete', ['name' => __('users.store')]));
        }
    }
    public function localedit($id,Request $request){
        $local=Local::query()->find($id);
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
        $values=GroupLocal::all()->pluck('libelle','id');
        $exitgroup=$local->group_locals;
        return view('administration.edit_local', [
            'values'=>$values,
            'local'=>$local,
            'exit_group'=>$exitgroup
        ]);
    }
    public function periodeedit($id,Request $request){
        $periode=Periode::query()->find($id);
        if ($request->method()=="POST"){
            $periode->libelle = $request->libelle;
            $periode->save();

            $b_ool = $periode->update();
            if ($b_ool) {
                return redirect()->route('config.indexperiode')->withSuccess(__('Save success', ['name' => __('users.store')]));
            } else {
                return redirect()->route('config.indexperiode')->withErrors(__('message.msg_added', ['name' => __('users.store')]));
            }
        }
        return view('administration.edit_periode', [
            'periode'=>$periode,
        ]);
    }
    public function typeaccessoireedit($id,Request $request){
        $local=TypeAccessoire::query()->find($id);
        if ($request->method()=="POST"){

            $b_ool = $local->update([
                'libelle'=>$request->libelle,
                'quantite'=>$request->quantite
            ]);
            if ($b_ool) {
                return redirect()->route('config.indextypeaccessoire')->withSuccess(__('Save success', ['name' => __('users.store')]));
            } else {
                return redirect()->route('config.indextypeaccessoire')->withErrors(__('message.msg_added', ['name' => __('users.store')]));
            }
        }
        return view('administration.edit_typeaccessoire', [
            'local'=>$local,
        ]);
    }
    public function congeferieedit($id,Request $request){
        $local=JourFerie::query()->find($id);
        if ($request->method()=="POST"){

            $b_ool = $local->update([
                'libelle'=>$request->libelle,
                'date_debut'=>$request->datedebut,
                'date_fin'=>$request->datefin,
                'active'=>$request->active,
            ]);
            if ($b_ool) {
                return redirect()->route('config.indexjourferie')->withSuccess(__('Save success', ['name' => __('users.store')]));
            } else {
                return redirect()->route('config.indexjourferie')->withErrors(__('message.msg_added', ['name' => __('users.store')]));
            }
        }
        return view('administration.edit_congeferie', [
            'local'=>$local,
        ]);
    }
    public function typesalleedit($id,Request $request){

        if ($request->method()=="POST"){
            $typesalle=TypeSalle::query()->find($id);
            $b_ool = $typesalle->update([
                'type'=>$request->type
            ]);
            if ($b_ool) {
                return redirect()->route('config.indextypesalle')->withSuccess(__('Save success', ['name' => __('users.store')]));
            } else {
                return redirect()->route('config.indextypesalle')->withErrors(__('message.msg_added', ['name' => __('users.store')]));
            }
        }$typesalle=TypeSalle::query()->find($id);
        return view('administration.edit_typesalle', [
            'typesalle'=>$typesalle,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storegrouplocal(Request $request)
    {
        $groupe = new GroupLocal();
        $groupe->type_salle_id = $request->type_salle;
        $groupe->type_jour_id = $request->type_jour;
        $groupe->libelle = $request->libelle;
        $groupe->horaire_reservation = $request->horaire_reservation;
        $b_ool = $groupe->save();
        if ($b_ool) {
            return redirect()->route('config.indexgrouplocal')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('config.indexgrouplocal')->withErrors(__('Delete', ['name' => __('users.store')]));
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storejourferie(Request $request)
    {
        $local = new JourFerie();
        $local->libelle = $request->libelle;
        $local->date_debut = $request->datedebut;
        $local->date_fin = $request->datefin;
        $local->active = $request->active="on"?true:false;
        $local->save();
        $b_ool = $local->save();
        if ($b_ool) {
            return redirect()->route('config.indexjourferie')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('config.indexjourferie')->withErrors(__('message.msg_added', ['name' => __('users.store')]));
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storelocal(Request $request)
    {
        $local = new Local();
        $local->libelle = $request->libelle;
        $local->save();
        $local->group_locals()->sync($request->group_locals);
        $b_ool = $local->save();
        if ($b_ool) {
            return redirect()->route('config.indexlocal')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('config.indexlocal')->withErrors(__('message.msg_added', ['name' => __('users.store')]));
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storetypejour(Request $request)
    {
        $typejour = new TypeJour();
        $typejour->type = $request->type;
        $b_ool = $typejour->save();
        if ($b_ool) {
            return redirect()->route('config.indextypejour')->withSuccess("Save success");
        } else {
            return redirect()->route('config.indextypejour')->withErrors(__('Echec save', ['name' => __('users.store')]));
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storetypesalle(Request $request)
    {
        $typesalle = new TypeSalle();
        $typesalle->type = $request->type;
        $b_ool = $typesalle->save();
        if ($b_ool) {
            return redirect()->route('config.indextypesalle')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('config.indextypesalle')->withErrors(__('message.msg_added', ['name' => __('users.store')]));
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeperiode(Request $request)
    {
        $periode = new Periode();
        $periode->libelle = $request->libelle;
        $b_ool = $periode->save();
        if ($b_ool) {
            return redirect()->route('config.indexperiode')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('config.indexperiode')->withErrors(__('message.msg_added', ['name' => __('users.store')]));
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storetypeaccessoire(Request $request)
    {
        $typeaccessoire = new TypeAccessoire();
        $typeaccessoire->libelle = $request->libelle;
        $typeaccessoire->quantite = $request->quantite;
        //$typeaccessoire->quantite_restante = $request->quantite;
        $b_ool = $typeaccessoire->save();
        if ($b_ool) {
            return redirect()->route('config.indextypeaccessoire')->withSuccess(__('Save success', ['name' => __('users.store')]));
        } else {
            return redirect()->route('config.indextypeaccessoire')->withErrors(__('message.msg_added', ['name' => __('users.store')]));
        }

    }
}
