<x-app-layout :assets="$assets ?? []">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card  ">
                        <div class="card-body">
                        {{--    <div id="calendar1" class="calendar-s"></div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<div class="modal fade" id="date-event" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formTitle">Ajouter une reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="main_form">
                    <div class="col-md-12">
                        <label class="form-label" for="r_time">Heure de debut: </label>
                        <input type="time" class="form-control"  id="r_time">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="btn-continue">
                    Continuer
                </button>
            </div>
        </div>
    </div>
</div>
