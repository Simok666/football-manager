@extends('layout.admin')
@section('title', 'Mark User Attendance')    
@section('title_page', 'Mark User Attendance')
@section('desc_page', '')
@section('content')
<div class="row">
<div class="col-12">
    @include('components.table-pagenation', ['table' => 'userAttendance' , 'url' => '/api/v1/getSchedule', 'headerTitle' => 'User Attendance Table' , 'headers' => [
            "Name Activity",
            "Date Activity",
            "Time Start Activity",
            "Time End Activity",
            "Location",
            "Documentation",
            "Action"
        ] , 'pagination' => true])
</div>
</div>
<div class="modal fade" id="markModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mark Attendance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group  mb-3">
            Apakah anda yakin ingin Hadir untuk schedule ini? <br>
        </div>
        <div class="form-group  mb-3">
        <span class="">Training: <strong id="activity"></strong></span><br>
        </div>
        <div class="form-group  mb-3">
        <span class="">Location: <strong id="location"></strong></span><br>
        </div>
        <div class="form-group  mb-3">
        <span class="">Check Kehadiran : </strong></span>
        </div>

        <div class="custom-control custom-radio mb-3">
            <input type="radio" id="customRadio1" value="true" name="customRadio" class="custom-control-input">
            <label class="custom-control-label" for="customRadio1">Hadir</label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" id="customRadio2" value="false" name="customRadio" class="custom-control-input">
            <label class="custom-control-label" for="customRadio2">Tidak Hadir</label>
        </div>
        <form action="index.html" id="attendance-verify">
            <input type="hidden" name="id" id="schedule_id">
        </form> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="attendance-verify" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Documentation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
        <script>
            $(document).ready(function() {
                GetData(req,"userAttendance", formatattendance);
            });

            function formatattendance(data) { 
                var result = "";
                $.each(data, function(index, data) {
                    const dateObj = new Date(data.date_activity);
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
                                    <h6 class="mb-0 text-sm">${data.activity}</h6>
                                </div>
                                </div>
                            </td>
                            <td>${formattedDate}</td>
                            <td>${formatTime(data.time_start_activity)}</td>
                            <td>${formatTime(data.time_end_activity)}</td>
                            <td>${data.location}</td>
                            <td>${`<a href="#" data-toggle="modal" data-target="#downloadModal" class="btn btn-info btn-icon btn-sm btn-download" 
                                                title="edit data" data-training="${data.activity}" data-location="${data.location}" data-id="${data.id}">
                                                <span class="btn-inner--icon"><i class="ni ni-album-2"></i></span>
                                                <span class="btn-inner--text">download</span>
                                            </a>`}</td>
                            <td>
                                ${(data.user_attendance === true && data.attendance_status === 'Hadir') 
                                    ? '<span class="badge badge-primary">Hadir</span>' 
                                    : (data.user_attendance === false && data.attendance_status === 'Tidak Hadir') 
                                        ? '<span class="badge badge-danger">Tidak Hadir</span>' 
                                        : (data.user_attendance === false && data.attendance_status === null) 
                                            ? `<a href="#" data-toggle="modal" data-target="#markModal" class="btn btn-success btn-icon btn-sm btn-mark" 
                                                title="edit data" data-training="${data.activity}" data-location="${data.location}" data-id="${data.id}">
                                                <span class="btn-inner--icon"><i class="ni ni-ruler-pencil"></i></span>
                                                <span class="btn-inner--text">Mark</span>
                                            </a>` 
                                            : '-'
                                }
                            </td>
                        </tr>
                    `
                });
                return result;
            }

            $(document).on('click', '.btn-mark', function() {
                $('#activity').html($(this).data('training'));
                $('#location').html($(this).data('location'));
                $('#schedule_id').val($(this).data('id'));
            });

            $(document).on('click', '.btn-download', function() {
                const dataId = $(this).data('id');
                const dataTraining = $(this).data('training');
                const dataLocation = $(this).data('location');
                const role = session("role");
                const dataUrl = `${baseUrl}/api/v1/getImageDocumentation/${dataId}`;

                // Clear previous content
                $('#downloadModal .modal-body').html(`
                    <div id="documentationContainer" class="row">
                        <div class="col-12 text-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                `);

                ajaxData(dataUrl, 'GET', [], function(resp) {
                    if (resp.data && resp.data.length > 0) {
                        // Create a container for documentation cards
                        let cardsHtml = '<div class="row">';
                        
                        resp.data.forEach((doc, index) => {
                            // Construct full file URL
                            const fileUrl = `${baseUrl}/storage/${doc.file_path}`;
                            
                            cardsHtml += `
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="${fileUrl}" class="card-img-top" alt="Documentation Image ${index + 1}">
                                        <div class="card-body">
                                            <p class="card-text">
                                                Type: ${doc.file_type}<br>
                                                Size: ${(doc.file_size / 1024).toFixed(2)} KB
                                            </p>
                                            ${role == "admin" ? `<button class="btn btn-danger btn-delete-documentation" data-schedule-id="${dataId}" data-doc-id="${doc.id}">Delete</button>` : ""}
                                            <a href="${fileUrl}" class="btn btn-primary" download>Download</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        
                        cardsHtml += '</div>';
                        
                        // Update modal title and body
                        $('#downloadModal .modal-title').text(`Documentation for ${dataTraining}`);
                        $('#downloadModal .modal-body').html(cardsHtml);
                    } else {
                        $('#downloadModal .modal-body').html(`
                            <div class="alert alert-warning text-center" role="alert">
                                No documentation found for this schedule.
                            </div>
                        `);
                    }
                }, function(xhr) {
                    $('#downloadModal .modal-body').html(`
                        <div class="alert alert-danger text-center" role="alert">
                            Failed to load documentation. Please try again.
                        </div>
                    `);
                });
            });

            $(document).on('click', '.btn-delete-documentation', function() {
                const scheduleId = $(this).data('schedule-id');
                const docId = $(this).data('doc-id');
                console.log(scheduleId);
                
                const url = `${baseUrl}/api/v1/removeImageDocumentation`;
                ajaxData(url, 'POST', {
                    "schedule_id": scheduleId,
                    "doc_id": docId
                }, function(resp) {
                    toast(resp.message);
                    $('#downloadModal').modal('hide');
                    GetData(req,"userAttendance", formatattendance);
                }, function(xhr) {
                    toast(xhr.responseJSON.message);
                });
            });

            $("#attendance-verify").on('submit', function(e) {
                e.preventDefault();
                let id = $(this).find("#schedule_id").val();
                let attendance = $('input[name="customRadio"]:checked').val();
                
                let url = `${baseUrl}/api/v1/markAttendance/${id}`;
                
                let data = {
                    "attendance" : attendance
                };
               
                ajaxData(url, 'PUT', data, function(resp) {
                    toast(resp.message);
                    $('#markModal').modal('hide');
                    $('#attendance-verify').trigger('reset');
                    GetData(req,"userAttendance", formatattendance);
                }, function(data) {

                });
            });
        </script>
@endsection