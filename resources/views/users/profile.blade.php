<x-app-layout :assets="$assets ?? []">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <div class="d-flex flex-wrap align-items-center justify-content-between">
                  <div class="d-flex flex-wrap align-items-center">
                     <div class="profile-img position-relative me-3 mb-3 mb-lg-0">
                        <img src="{{asset('images/user.jpg')}}" alt="User-Profile" class="theme-color-default-img img-fluid rounded-pill avatar-100">
                        <img src="{{asset('images/user.jpg')}}" alt="User-Profile" class="theme-color-purple-img img-fluid rounded-pill avatar-100">
                        <img src="{{asset('images/user.jpg')}}" alt="User-Profile" class="theme-color-blue-img img-fluid rounded-pill avatar-100">
                        <img src="{{asset('images/user.jpg')}}" alt="User-Profile" class="theme-color-green-img img-fluid rounded-pill avatar-100">
                        <img src="{{asset('images/user.jpg')}}" alt="User-Profile" class="theme-color-yellow-img img-fluid rounded-pill avatar-100">
                        <img src="{{asset('images/user.jpg')}}" alt="User-Profile" class="theme-color-pink-img img-fluid rounded-pill avatar-100">
                     </div>
                     <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                        <h4 class="me-2 h4">{{ $data->full_name ?? 'Austin Robertson'  }}</h4>
                        <span class="text-capitalize"> - {{ str_replace('_',' ',auth()->user()->user_type) ?? 'Marketing Administrator' }}</span>
                     </div>
                  </div>
                  <ul class="d-flex nav nav-pills mb-0 text-center profile-tab" data-toggle="slider-tab" id="profile-pills-tab" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active show" data-bs-toggle="tab" href="#profile-feed" role="tab" aria-selected="false">Profil</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile-activity" role="tab" aria-selected="false">Password</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-12">
         <div class="profile-content tab-content">
         <div id="profile-feed" class="tab-pane fade active show">
            <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between pb-4">
                   <div class="header-title">
                       <h4 class="card-title">Mon profil</h4>
                   </div>
                {{--  <div class="header-title">
                     <div class="d-flex flex-wrap">
                        <div class="media-support-user-img me-3">
                           <img class="rounded-pill img-fluid avatar-60 bg-soft-danger p-1 ps-2" src="{{asset('images/avatars/02.png')}}" alt="">
                        </div>
                        <div class="media-support-info mt-2">
                           <h5 class="mb-0">Anna Sthesia</h5>
                           <p class="mb-0 text-primary">colleages</p>
                        </div>
                     </div>
                  </div>
                  <div class="dropdown">
                     <span class="dropdown-toggle" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                     29 mins
                     </span>
                     <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton7">
                        <a class="dropdown-item " href="javascript:void(0);">Action</a>
                        <a class="dropdown-item " href="javascript:void(0);">Another action</a>
                        <a class="dropdown-item " href="javascript:void(0);">Something else here</a>
                     </div>
                  </div>--}}
               </div>
               <div class="card-body p-3">
                   {{ Form::open(['url' => 'users/profil/'.$data->id,'method' => 'post']) }}
                   <div class="row">
                       <div class="form-group col-md-6">
                           <label class="form-label">First name</label>
                           {{ Form::text('first_name', old('first_name',$data->first_name), ['class' => 'form-control','id' => 'firstname', 'placeholder' => '', 'required']) }}
                       </div>
                       <div class="form-group col-md-6">
                           <label class="form-label">Last name</label>
                           {{ Form::text('last_name', old('last_name',$data->last_name), ['class' => 'form-control','id' => 'lastname', 'placeholder' => '', 'required']) }}
                       </div>
                       <div class="form-group col-md-6">
                           <label class="form-label">Phone</label>
                           {{ Form::text('phone_number', old('phone_number',$data->phone_number), ['class' => 'form-control','id' => 'phone_number', 'placeholder' => '', 'required']) }}
                       </div>
                       <div class="form-group col-md-6">
                           <label class="form-label">Adresse</label>
                           {{ Form::text('address', old('address',$data->address), ['class' => 'form-control','id' => 'address', 'placeholder' => '', 'required']) }}
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-4">
                           <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                           <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                       </div>

                   </div>
                   {{ Form::close() }}
               </div>
            </div>
         </div>
         <div id="profile-activity" class="tab-pane fade">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Changer mot de passe</h4>
                  </div>
               </div>
               <div class="card-body">
                   {{ Form::open(['url' => 'users/changepasse','method' => 'post']) }}
                   <div class="row">
                       <div class="form-group col-md-6">
                           <label class="form-label" for="pass">Ancien mot de passe:</label>
                           {{ Form::password('oldpassword', ['class' => 'form-control', 'placeholder' => 'Old Password']) }}
                       </div>
                       <div class="form-group col-md-6">
                           <label class="form-label">Nouveau mot de passe</label>
                           {{ Form::password('newpassword', ['class' => 'form-control', 'required','placeholder' => 'New Password']) }}
                       </div>

                   </div>
                   <div class="row">
                       <div class="col-md-4">
                           <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                           <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                       </div>

                   </div>
                   {{ Form::close() }}
               </div>
            </div>
         </div>
      </div>
      </div>
   </div>

   @include('partials.components.share-offcanvas')
</x-app-layout>
