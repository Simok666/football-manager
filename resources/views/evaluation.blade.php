@extends('layout.admin')
@section('title', 'Evaluation')    
@section('title_page', 'Evaluation')
@section('desc_page', '')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center" style="margin: 10px;">
                    <h6>Evaluation Table</h6>
                    <div class="input-group w-25">
                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" id="evaluationTableSearch" placeholder="Search in evaluation table...">
                    </div>
                </div>
            </div>
            @include('components.table-pagenation', ['table' => 'evaluation' , 'url' => '/api/v1/getEvaluation', 'headerTitle' => 'Evaluation Table' , 'headers' => [
                "Name",
                "Position",
                "Date Activity",
                "Activity Name",
                "Activity Location",
                "Action"
            ] , 'pagination' => true])
        </div>
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
                <label for="exampleFormControlInput1">Clean Sheets</label>
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
            GetData(req,"evaluation", formatevaluation);
            $('#evaluationTableSearch').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                // Filter table rows
                $('.datatable-evaluation tr').each(function() {
                    
                    const rowText = $(this).text().toLowerCase();
                    
                    // Toggle row visibility based on search term
                    $(this).toggle(rowText.includes(searchTerm));
                });

                // If no rows match, show "No results" message
                if ($('.datatable-evaluation tr:visible').length === 0) {
                    $('.datatable-evaluation').append(`
                        <tr class="no-results">
                            <td colspan="6" class="text-center">
                                No results found for "${searchTerm}"
                            </td>
                        </tr>
                    `);
                } else {
                    // Remove any existing "No results" message
                    $('.datatable-evaluation .no-results').remove();
                }
            });
        });
        
        function formatevaluation(data) {
            var userId = session("idUser");
            var role = session("role");
            var result = "";
                $.each(data, function(index, data) {
                    if(userId == data.user_id && role == "user") {
                        data.schedule_activities.forEach(element => {
                        const dateObj = new Date(element.schedule_date);
                        const formattedDate = dateObj.getFullYear() + 
                                                    '-' + 
                                                    String(dateObj.getMonth() + 1).padStart(2, '0') + 
                                                    '-' + 
                                                    String(dateObj.getDate()).padStart(2, '0');
                    
                        result += `
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user6">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">${data.name}</h6>
                                    </div>
                                    </div>
                                </td>
                                <td>${data.position}</td>
                                <td>${formattedDate}</td>
                                <td>${element.schedule_name}</td>
                                <td>${element.schedule_location}</td>
                                
                                <td>
                                    ${`<a href="#" data-toggle="modal" data-target="#scoringModal" class="btn btn-success btn-icon btn-sm btn-detail" 
                                                    title="edit data" data-training="${element.schedule_name}" data-location="${element.schedule_location}" data-schedule-id="${element.schedule_id}" data-user-id="${data.user_id}">
                                                    <span class="btn-inner--icon"><i class="ni ni-ruler-pencil"></i></span>
                                                    <span class="btn-inner--text">Detail</span>
                                                </a>`}
                                </td>
                            </tr>
                        `
                    });        
                    } else if (role == "admin" || role == "coach") {
                        data.schedule_activities.forEach(element => {
                        const dateObj = new Date(element.schedule_date);
                        const formattedDate = dateObj.getFullYear() + 
                                                    '-' + 
                                                    String(dateObj.getMonth() + 1).padStart(2, '0') + 
                                                    '-' + 
                                                    String(dateObj.getDate()).padStart(2, '0');
                    
                        result += `
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user6">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">${data.name}</h6>
                                    </div>
                                    </div>
                                </td>
                                <td>${data.position}</td>
                                <td>${formattedDate}</td>
                                <td>${element.schedule_name}</td>
                                <td>${element.schedule_location}</td>
                                
                                <td>
                                    ${`<a href="#" data-toggle="modal" data-target="#scoringModal" class="btn btn-success btn-icon btn-sm btn-detail" 
                                                    title="edit data" data-training="${element.schedule_name}" data-location="${element.schedule_location}" data-schedule-id="${element.schedule_id}" data-user-id="${data.user_id}">
                                                    <span class="btn-inner--icon"><i class="ni ni-ruler-pencil"></i></span>
                                                    <span class="btn-inner--text">Detail</span>
                                                </a>`}
                                </td>
                            </tr>
                        `
                    });
                    }
                       
                })
                    
                return result;
        }

        $(document).on('click', '.btn-detail', function() {
            const scheduleId = $(this).data('schedule-id');
            const userId = $(this).data('user-id');
            const scheduleName = $(this).data('training');
            const scheduleLocation = $(this).data('location');

            // Fetch detailed evaluation
            $.ajax({
                url: `${baseUrl}/api/v1/get-detailed-evaluation`,
                method: 'GET',
                data: {
                    schedule_id: scheduleId,
                    user_id: userId
                },
                success: function(resp) {
                    // Disable all form inputs
                    $('#scoring input, #scoring textarea, #scoring select').prop('disabled', true);
                    
                    // Populate modal with detailed information
                    $('#schedule_id').val(scheduleId);
                    $('#user_id').val(userId);

                    // Populate form fields with existing scoring data if available
                    if (resp.scoring) {
                        // Discipline
                        $(`input[name="repeater[0][discipline]"][value="${resp.scoring.discipline}"]`).prop('checked', true);
                        
                        // Attitude
                        $(`input[name="repeater[0][attitude]"][value="${resp.scoring.attitude}"]`).prop('checked', true);
                        
                        // Stamina
                        $(`input[name="repeater[0][stamina]"][value="${resp.scoring.stamina}"]`).prop('checked', true);
                        
                        // Injury
                        $(`input[name="repeater[0][injury]"][value="${resp.scoring.injury}"]`).prop('checked', true);

                        // Numeric fields
                        $('input[name="repeater[0][goals]"]').val(resp.scoring.goals);
                        $('input[name="repeater[0][assists]"]').val(resp.scoring.assists);
                        $('input[name="repeater[0][shots_on_target]"]').val(resp.scoring.shots_on_target);
                        $('input[name="repeater[0][successful_passes]"]').val(resp.scoring.successful_passes);
                        $('input[name="repeater[0][chances_created]"]').val(resp.scoring.chances_created);
                        $('input[name="repeater[0][tackles]"]').val(resp.scoring.tackles);
                        $('input[name="repeater[0][interceptions]"]').val(resp.scoring.interceptions);
                        $('input[name="repeater[0][clean_sheets]"]').val(resp.scoring.clean_sheets);
                        $('input[name="repeater[0][saved]"]').val(resp.scoring.saved);
                        $('input[name="repeater[0][offside]"]').val(resp.scoring.offsides);
                        $('input[name="repeater[0][foul]"]').val(resp.scoring.foul);
                        $('textarea[name="repeater[0][improvement]"]').val(resp.scoring.improvement);
                    }

                    // Update modal title with schedule details
                    $('#exampleModalLabel').text(`Scoring for ${scheduleName} at ${scheduleLocation}`);

                    // Hide save button since inputs are disabled
                    $('.modal-footer button[type="submit"]').hide();
                },
                error: function(xhr) {
                    toast('Failed to load detailed evaluation', 'error');
                    console.error(xhr);
                }
            });
        });
    </script>
@endsection