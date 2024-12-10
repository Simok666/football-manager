@extends('layout.admin')

@section('title', 'Coach Management')
@section('title_page', 'Coach Management')
@section('desc_page', '')
@section('content')
<div class="row">
    <div class="col-12">
    <div class="add-button">
        <button class="btn btn-icon btn-primary btn-add-coach" type="button">
            <span class="btn-inner--icon"><i class="ni ni-bag-17"></i></span>
            <span class="btn-inner--text">Add Coach</span>
        </button>    
    </div>
    @include('components.table-pagenation', ['table' => 'coachManagement' , 'url' => '/api/v1/getCoach', 'headerTitle' => 'Coach Management Table' , 'headers' => [
            "Name",
            "Email",
            "Action"
        ] , 'pagination' => true])
    </div>
</div>

<div class="modal fade" id="modalAddCouchManagement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Coach Management</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="form-add-coachmanagement">
            <div class="mb-3">
                <input type="hidden" name="repeater[0][new_id]" class="form-control" data-bind-id value="null">
                <input type="email" name="repeater[0][email]" class="form-control" placeholder="Email" aria-label="Email"  required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][phone]" class="form-control" placeholder="No. Handphone" aria-label="No. Handphone" required>
            </div>
            <div class="mb-3">
                <input type="password" name="repeater[0][password]" class="form-control" placeholder="Password" aria-label="Password" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][name]" class="form-control" placeholder="Name" aria-label="Name" required>
            </div>
            <div class="mb-3">
                <input type="number" name="repeater[0][nik]" class="form-control" placeholder="NIK" aria-label="NIK" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][place_of_birth]" class="form-control" placeholder="Tempat Lahir" aria-label="Tempat Lahir" required>
            </div>
            <div class="mb-3">
                <input type="date" name="repeater[0][date_of_birth]" class="form-control" placeholder="Tanggal Lahir" aria-label="Tanggal Lahir" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][address]" class="form-control" placeholder="Alamat" aria-label="Alamat" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][status]" class="form-control" placeholder="Status" aria-label="Status" required>
            </div>
            <div class="mb-3">
                <input type="number" name="repeater[0][emergeny_contact]" class="form-control" placeholder="Kontak Darurat" aria-label="Kontak Darurat" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][weight]" class="form-control" placeholder="Berat Badan" aria-label="Berat Badan"  >
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][height]" class="form-control" placeholder="Tinggi Badan" aria-label="Tinggi Badan"  >
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][history]" class="form-control" placeholder="Riwayat" aria-label="Riwayat" >
            </div>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="form-add-coachmanagement" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editCoachManagement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User Management</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="form-edit-coachmanagement">
            <div class="mb-3">
                <input type="hidden" name="repeater[0][new_id]" class="form-control" data-bind-id value="not_null">
                <input type="hidden" name="repeater[0][id]" class="form-control" data-bind-id value="">
                <input type="email" name="repeater[0][email]" class="form-control" placeholder="Email" aria-label="Email" data-bind-email value="" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][phone]" class="form-control" placeholder="No. Handphone" aria-label="No. Handphone" data-bind-phone value="" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][name]" class="form-control" placeholder="Name" aria-label="Name" data-bind-name value="" required>
            </div>
            <div class="mb-3">
                <input type="number" name="repeater[0][nik]" class="form-control" placeholder="NIK" aria-label="NIK" data-bind-nik value="" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][place_of_birth]" class="form-control" placeholder="Tempat Lahir" aria-label="Tempat Lahir" data-bind-place_of_birth value="" required>
            </div>
            <div class="mb-3">
                <input type="date" name="repeater[0][date_of_birth]" class="form-control" placeholder="Tanggal Lahir" aria-label="Tanggal Lahir" data-bind-date_of_birth value="" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][address]" class="form-control" placeholder="Alamat" aria-label="Alamat" data-bind-address value="" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][status]" class="form-control" placeholder="Status" aria-label="Status" data-bind-status value="" required>
            </div>
            <div class="mb-3">
                <input type="number" name="repeater[0][emergeny_contact]" class="form-control" placeholder="Kontak Darurat" aria-label="Kontak Darurat" data-bind-emergeny_contact value="" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][weight]" class="form-control" placeholder="Berat Badan" aria-label="Berat Badan" data-bind-weight value="" >
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][height]" class="form-control" placeholder="Tinggi Badan" aria-label="Tinggi Badan" data-bind-height value="" >
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][history]" class="form-control" placeholder="Riwayat" aria-label="Riwayat" data-bind-history value="">
            </div>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="form-edit-coachmanagement" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
        <script>
            $(document).ready(function() {
                GetData(req,"coachManagement", formatcoachs);
            });

            function formatcoachs(data) { 
                var result = "";
                $.each(data, function(index, data) {
                    result += `
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                <div>
                                    <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user6">
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">${data.name}</h6>
                                    <p class="text-xs text-secondary mb-0">${data.nik ?? "Nik Belum Diisi"}</p>
                                </div>
                                </div>
                            </td>
                            <td>${data.email}</td>
                            <td>
                            <a  href="#" data-toggle="modal" data-target="#editModal" class="btn btn-success btn-icon btn-sm btn-edit" title="edit data" data-name="${data.name}" data-email="${data.email}" data-id="${data.id}">
                                    <span class="btn-inner--icon"><i class="ni ni-ruler-pencil"></i></span>
                                    <span class="btn-inner--text">Edit</span>
                            </a>
                            </td>
                        </tr>
                    `
                });
                return result;
            }

            $(document).on('click', '.btn-add-coach', function() {
                $('#modalAddCouchManagement').modal('show');
                $('#modalAddCouchManagement').find('form')[0].reset();
            });

            $("#form-add-coachmanagement").on('submit', function(e) {
                e.preventDefault();
                const url = `${baseUrl}/api/v1/addUpdateCoach`;
                const data = new FormData(this);
                
                ajaxDataFile(url, 'POST', data, function(resp) {
                    toast("Data has been saved");
                    $('#modalAddCouchManagement').modal('hide');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }, function(data) {
            
                });
            });

            $(document).on('click', '.btn-edit', function() {
                $('#editCoachManagement').modal('show');
                
                ajaxData(`${baseUrl}/api/v1/getCoach`, 'GET', {
                    "id" : $(this).data('id')
                }, function(resp) {

                    if (empty(resp.data)) {
                        toast("Data not found", 'warning');
                        $('#editCoachManagement').modal('hide');
                    }
                
                    let result = resp.data[0];
                    $.each(result, function(index, data) {
                        if (index == "image") return;
                        $('#editCoachManagement').find(`[data-bind-${index}]`).val(data).attr('value', data);
                    });

                },
                function() {
                    setTimeout(function() {
                        $('#editCoachManagement').modal('hide');
                    }, 1000);
                });
            });

            $("#form-edit-coachmanagement").on('submit', function(e) {
                e.preventDefault();
                const url = `${baseUrl}/api/v1/addUpdateCoach`;
                const data = new FormData(this);
                ajaxDataFile(url, 'POST', data, function(resp) {
                    toast("Update Data has been saved");
                    $('#editCoachManagement').modal('hide');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                    
                }, function(data) {
                    
                });
            });
        </script>
@endsection