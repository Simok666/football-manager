@extends('layout.admin')
@section('title', 'Attendance Participants')    
@section('title_page', 'Attendance Participants')
@section('desc_page', '')
@section('content')
<div class="row">
<div class="col-12">
    @include('components.table-pagenation', ['table' => 'participantsAttendance' , 'url' => '/api/v1/getSchedule', 'headerTitle' => 'Attendance Participants Table' , 'headers' => [
            "Name Activity",
            "Date Activity",
            "Name Participants",
            "Location",
            "Action"
        ] , 'pagination' => true])
</div>
</div>

<div class="modal fade" id="scoringModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Scoring</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="index.html" id="scoring">
            <div class="form-group  mb-3">
            <b> GENERAL </b><br>
            </div>
            <div class="form-group  mb-3">
                <span class="">Diciplines : </strong></span>
            </div>
            <input type="hidden" name="repeater[0][schedule_id]" id="schedule_id">
            <input type="hidden" name="repeater[0][user_id]" id="user_id">
            <input type="hidden" name="repeater[0][id]" id="scoring_id" data-bind-id value="">

            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio1" value="Selalu hadir dan tidak pernah terlambat" name="repeater[0][discipline]" class="custom-control-input">
                <label class="custom-control-label" for="customRadio1">Selalu hadir dan tidak pernah terlambat</label>
            </div>
            <div class="custom-control custom-radio ">
                <input type="radio" id="customRadio2" value="Selalu hadir namun terlambat" name="repeater[0][discipline]" class="custom-control-input">
                <label class="custom-control-label" for="customRadio2">Selalu hadir namun terlambat</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio3" value="Jarang hadir dan sering terlambat" name="repeater[0][discipline]" class="custom-control-input">
                <label class="custom-control-label" for="customRadio3">Jarang hadir dan sering terlambat</label>
            </div>
            <div class="form-group  mb-3">
                <span class="">Attitude : </strong></span>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio4" value="Dapat menerima arahan pelatih dan bisa bermain dalam tim" name="repeater[0][attitude]" class="custom-control-input">
                <label class="custom-control-label" for="customRadio4">Dapat menerima arahan pelatih dan bisa bermain dalam tim</label>
            </div>
            <div class="custom-control custom-radio ">
                <input type="radio" id="customRadio5" value="Salah satu dari kriteria kurang" name="repeater[0][attitude]" class="custom-control-input">
                <label class="custom-control-label" for="customRadio5">Salah satu dari kriteria kurang</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio6" value="Tidak bisa menerima arahan pelatih dan tidak bisa bermain dalam tim" name="repeater[0][attitude]" class="custom-control-input">
                <label class="custom-control-label" for="customRadio6">Tidak bisa menerima arahan pelatih dan tidak bisa bermain dalam tim</label>
            </div>
            <div class="form-group  mb-3">
                <span class="">Stamina : </strong></span>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio7" value="Durability & Consistency stabil" name="repeater[0][stamina]" class="custom-control-input">
                <label class="custom-control-label" for="customRadio7">Durability & Consistency stabil</label>
            </div>
            <div class="custom-control custom-radio ">
                <input type="radio" id="customRadio8" value="Durability or consistency not stabil" name="repeater[0][stamina]" class="custom-control-input">
                <label class="custom-control-label" for="customRadio8">Durability or consistency not stabil</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio9" value="Durability and consistency low" name="repeater[0][stamina]" class="custom-control-input">
                <label class="custom-control-label" for="customRadio9">Durability and consistency low</label>
            </div>
            <div class="form-group  mb-3">
                <span class="">Injury : </strong></span>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio10" value="Tidak ada cidera dalam 1 bulan" name="repeater[0][injury]" class="custom-control-input">
                <label class="custom-control-label" for="customRadio10">Tidak ada cidera dalam 1 bulan</label>
            </div>
            <div class="custom-control custom-radio ">
                <input type="radio" id="customRadio11" value="Cidera max. 2x sebulan" name="repeater[0][injury]" class="custom-control-input">
                <label class="custom-control-label" for="customRadio11">Cidera max. 2x sebulan</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio12" value="Cidera lebih dari 2x sebulan" name="repeater[0][injury]" class="custom-control-input">
                <label class="custom-control-label" for="customRadio12">Cidera lebih dari 2x sebulan</label>
            </div>
            <div class="form-group  mb-3">
            <b> DEFENSE </b><br>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1">Goals</label>
                <input type="number" name="repeater[0][goals]" class="form-control" placeholder="Goals" aria-label="Goals" data-bind-goals value="" required>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1">Assists</label>
                <input type="number" name="repeater[0][assists]" class="form-control" placeholder="Assist" aria-label="Assist" data-bind-assists value="" required>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1">Shots On Target</label>
                <input type="text" name="repeater[0][shots_on_target]" class="form-control" placeholder="Shots On Target" aria-label="shots_on_target" data-bind-shots_on_target value="" required>
            </div>
            <div class="input-group mb-3">
                <label for="exampleFormControlInput1">Successful passes</label>
                <div class="input-group">
                    <input type="number" name="repeater[0][successful_passes]" class="form-control" placeholder="Successful passes" aria-label="Successful passes" data-bind-successful_passes value="" min="0" max="100" style= "padding:20px 20px 20px;"required>
                    <span class="input-group-text" id="basic-addon2">%</span>
                </div>
                <small class="form-text text-muted">Enter percentage of successful passes (0-100%)</small>
            </div>
            <div class="form-group  mb-3">
            <b> OFFENSE </b><br>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1">Chances created</label>
                <input type="number" name="repeater[0][chances_created]" class="form-control" placeholder="Chances Created" aria-label="Chances Created" data-bind-chances_created value="" required>
            </div>
            <div class="input-group mb-3">
                <label for="exampleFormControlInput1">Tackles</label>
                <div class="input-group">
                    <input type="number" name="repeater[0][tackles]" class="form-control" placeholder="Tackles" aria-label="Tackles" data-bind-tackles value="" min="0" max="100" style= "padding:20px 20px 20px;" required>
                    <span class="input-group-text" id="basic-addon2">%</span>
                </div>
                <small class="form-text text-muted">Enter percentage of successful passes (0-100%)</small>
            </div>
            <div class="mb-3">
                
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1">Interceptions</label>
                <input type="text" name="repeater[0][interceptions]" class="form-control" placeholder="Interceptions" aria-label="Interceptions" data-bind-interceptions value="" required>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1">Clean sheets</label>
                <input type="number" name="repeater[0][clean_sheets]" class="form-control" placeholder="Clean sheets" aria-label="Clean sheets" data-bind-clean_sheets value="" required>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1">Saved</label>
                <input type="number" name="repeater[0][saved]" class="form-control" placeholder="Saved" aria-label="Saved" data-bind-saved value="" required>
            </div>
            <div class="form-group  mb-3">
            <b> RULES </b><br>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1">Offside</label>
                <input type="number" name="repeater[0][offside]" class="form-control" placeholder="Offside" aria-label="Offside" data-bind-offsides value="" required>
                <small class="form-text text-muted offside-note"></small>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1">Foul</label>
                <input type="number" name="repeater[0][foul]" class="form-control" placeholder="Foul" aria-label="Foul" data-bind-foul value="" required>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Improvement</label>
                <textarea class="form-control" name="repeater[0][improvement]" id="exampleFormControlTextarea1" rows="3" data-bind-improvement value="" required></textarea>
            </div>
            

            
        </form>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" form="scoring" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
        <script>
            $(document).ready(function() {
                GetData(req,"participantsAttendance", formatparticipantsattendance);
            });

            function formatparticipantsattendance(data) {
                var result = "";
                $.each(data, function(index, data) {
                    const dateObj = new Date(data.date_activity);
                    const formattedDate = dateObj.getFullYear() + 
                                                '-' + 
                                                String(dateObj.getMonth() + 1).padStart(2, '0') + 
                                                '-' + 
                                                String(dateObj.getDate()).padStart(2, '0');
                    let participatsAdded = data.participants_added;
                    
                    
                    participatsAdded.forEach(function(participant) {
                    
                    result += `
                        <tr>
                            <td>
                                <div class="d-flex px-3 py-1">
                                
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">${data.activity}</h6>
                                </div>
                                </div>
                            </td>
                            <td>${formattedDate}</td>
                            <td>${participant.name}</td>
    
                            <td>${data.location}</td>
        
                            <td>
                                ${`<a href="#" data-toggle="modal" data-target="#scoringModal" class="btn btn-success btn-icon btn-sm btn-scoring" 
                                                title="edit data" data-training="${data.activity}" data-location="${data.location}" data-id="${data.id}" data-user-id="${participant.id}" data-position-id="${participant.id_positions}">
                                                <span class="btn-inner--icon"><i class="ni ni-ruler-pencil"></i></span>
                                                <span class="btn-inner--text">Add / Edit Scoring</span>
                                            </a>`}
                            </td>
                        </tr>
                    `;
               
                });     
                });
                return result;
            }

            $(document).on('click', '.btn-scoring', function() {
                const schedule_id = $(this).data('id');
                const data_user_id = $(this).data('user-id');
                const data_position_id = $(this).data('position-id');
                
                // Disable offside input for specific positions (e.g., goalkeeper)
                if (data_position_id == 1) {
                    $('input[name="repeater[0][offside]"]').prop('disabled', true)
                        .val(0)
                        .closest('.mb-3')
                        .append('<small class="text-muted">Not applicable for this position</small>');
                } else if (data_position_id == 2 || data_position_id == 3 || data_position_id == 4) {
                    $('input[name="repeater[0][saved]"]').prop('disabled', true)
                        .val(0)
                        .closest('.mb-3')
                        .append('<small class="text-muted">Not applicable for this position</small>');
                } 
                
                $('#schedule_id').val($(this).data('id'));
                $('#user_id').val($(this).data('user-id'));
                
                ajaxData(`${baseUrl}/api/v1/getScoring/${data_user_id}`, 'GET', {
                    "schedule_id" : schedule_id
                }
                , function(resp) {
                    if (empty(resp.data)) {
                        toast("Data not found please add data first", 'warning');
                        $('#scoringModal').modal('hide');
                    }
                
                    let result = resp.data[0];
                    $.each(result, function(index, data) {
                        if (index == "image") return;
                        // Handle radio button selections
                        if (index === 'discipline' || index === 'attitude' || index === 'stamina' || index === 'injury') {
                            // Find and check the radio button with matching value
                            $(`input[name="repeater[0][${index}]"][value*="${data}"]`).prop('checked', true);
                        } else {
                            // For other inputs, set value normally
                            $('#scoringModal').find(`[data-bind-${index}]`).val(data).attr('value', data);
                        }
                    });

                },
                function() {
                    setTimeout(function() {
                        $('#scoringModal').modal('hide');
                    }, 1000);
                });

                $('#scoringModal').modal('show');
            });

            // Ensure radio buttons have a value when selected
            $('input[type="radio"]').on('change', function() {
                // Ensure the selected radio button's value is captured
                $(this).prop('checked', true);
            });

            $("#scoringModal").on('hidden.bs.modal', function () {
                // Uncheck all radio buttons
                $('input[type="radio"]').prop('checked', false);
                
                // Reset other form fields
                $('#scoring')[0].reset();
            });

            $("#scoring").submit(function(e) {
                e.preventDefault();
                const url = `${baseUrl}/api/v1/addUpdateScoring`;
                const formData = new FormData(this);

                ajaxDataFile(url, 'POST', formData,
                    function(resp) {
                        toast("Save data success", 'success');
                        $("#scoringModal").modal('hide');
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    },
                    function (xhr) {
                        toast("Save data failed", 'error');
                    }
                );
            }); 
        </script>
@endsection