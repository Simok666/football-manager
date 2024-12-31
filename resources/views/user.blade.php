@extends('layout.admin')

@section('title', 'User Management')
@section('title_page', 'User Management')
@section('desc_page', '')
@section('content')
<div class="row">
    <div class="col-12">
    @include('components.table-pagenation', ['table' => 'userManagement' , 'url' => '/api/v1/getUser', 'headerTitle' => 'Player Management Table' , 'headers' => [
            "Name",
            "Email",
            "Action"
        ] , 'pagination' => true])
    </div>
</div>

<div class="modal fade" id="editUserManagement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User Management</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div id="user-role-note" class="alert alert-warning" style="display: none;">
          Note: As a user, you cannot modify these fields. Please contact an administrator for updates.
      </div>
      <form id="form-edit-usermanagement">
            <div class="mb-3">
            <label for="exampleFormControlInput1">Email</label>
                <input type="hidden" name="repeater[0][id]" class="form-control" data-bind-id value="">
                <input type="email" name="repeater[0][email]" class="form-control" placeholder="Email" aria-label="Email" data-bind-email value="" required>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1">Nama</label>
                <input type="text" name="repeater[0][name]" class="form-control" placeholder="Name" aria-label="Name" data-bind-name value="" required>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1">NIK</label>
                <input type="number" name="repeater[0][nik]" class="form-control" placeholder="NIK" aria-label="NIK" data-bind-nik value="" required>
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Tempat Lahir</label>
                <input type="text" name="repeater[0][place_of_birth]" class="form-control" placeholder="Tempat Lahir" aria-label="Tempat Lahir" data-bind-place_of_birth value="" required>
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Tanggal Lahir</label>
                <input type="date" name="repeater[0][birth_of_date]" class="form-control" placeholder="Tanggal Lahir" aria-label="Tanggal Lahir" data-bind-birth_of_date value="" required>
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Alamat</label>
                <input type="text" name="repeater[0][address]" class="form-control" placeholder="Alamat" aria-label="Alamat" data-bind-address value="" required>
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Sekolah</label>
                <input type="text" name="repeater[0][school]" class="form-control" placeholder="Sekolah" aria-label="Sekolah" data-bind-school value="" required>
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Kelas</label>
                <input type="text" name="repeater[0][class]" class="form-control" placeholder="Kelas" aria-label="Kelas" data-bind-class value="" required>
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Nama Ayah</label>
                <input type="text" name="repeater[0][father_name]" class="form-control" placeholder="Nama Ayah/Wali" aria-label="Nama Ayah/Wali" data-bind-father_name value="" required>
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Nama Ibu</label>
                <input type="text" name="repeater[0][mother_name]" class="form-control" placeholder="Nama Ibu/Wali" aria-label="Nama Ibu/Wali" data-bind-mother_name value="" required>
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Kontak Orang Tua</label>
                <input type="number" name="repeater[0][parents_contact]" class="form-control" placeholder="Kontak Orang Tua/Wali" aria-label="Kontak Orang Tua/Wali" data-bind-parents_contact value="" required>
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Berat Badan</label>
                <input type="text" name="repeater[0][weight]" class="form-control" placeholder="Berat Badan" aria-label="Berat Badan" data-bind-weight value="" >
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Tinggi Badan</label>
                <input type="text" name="repeater[0][height]" class="form-control" placeholder="Tinggi Badan" aria-label="Tinggi Badan" data-bind-height value="" >
            </div>
            <div class="form-group">
                <label for="position">Posisi</label>
                <select class="form-control list-position" name ="repeater[0][id_positions]" id="position" data-bind-id_positions value="">
                <option value="" selected>Pilih Posisi</option>
                </select>
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Riwayat</label>
                <input type="text" name="repeater[0][history]" class="form-control" placeholder="Riwayat" aria-label="Riwayat" data-bind-history value="">
            </div>
            <div class="form-group">
                <label for="contribution">Iuran</label>
                <select class="form-control list-contribution" name ="repeater[0][id_contributions]" id="contribution" data-bind-id_contributions value="">
                <option value="" selected>Pilih Iuran</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name ="repeater[0][id_statuses]" id="statusUser" data-bind-id_statuses value="">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Kekuatan</label>
                <input type="text" name="repeater[0][strength]" class="form-control" placeholder="Kekuatan" aria-label="Kekuatan" data-bind-strength value="">
            </div>
            <div class="mb-3">
            <label for="exampleFormControlInput1">Kelemahan</label>
                <input type="text" name="repeater[0][weakness]" class="form-control" placeholder="Kelemahan" aria-label="Kelemahan" data-bind-weakness value="">
            </div>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="form-edit-usermanagement" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
    <script>
        
        $(document).ready(function() {
            getListPosition();
            getListContribution();
            GetData(req,"userManagement", formatusers);
        });

        function formatusers(data) {
            let idUser = session("idUser");
            let userRole = session("role");
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
                        <td>${(data.id == idUser && userRole === "user") ?  `<a  href="#" data-toggle="modal" data-target="#editModal" class="btn btn-success btn-icon btn-sm btn-edit-user" title="edit data" data-user-id="${data.id}">
                                <span class="btn-inner--icon"><i class="ni ni-ruler-pencil"></i></span>
                                <span class="btn-inner--text">Edit</span>
                           </a>` : userRole === "admin" || userRole === "coach" ? `<a  href="#" data-toggle="modal" data-target="#editModal" class="btn btn-success btn-icon btn-sm btn-edit-user" title="edit data" data-user-id="${data.id}">
                                <span class="btn-inner--icon"><i class="ni ni-ruler-pencil"></i></span>
                                <span class="btn-inner--text">Edit</span>
                           </a>` : `<button type="button" class="btn btn-default" disabled>Anda bukan user ini</button>` }
                           
                        </td>
                    </tr>
                `
            });
            return result;
        }

        let getListPosition = () => {
            const url = `${baseUrl}/api/v1/getPosition`;
            ajaxData(url, 'GET', [], function(resp) {
                let data = resp.data;
                let option = ``;

                data.forEach(element => {
                    option += `<option value="${element.id}">${element.description}</option>`;
                });
                $(".list-position").append(option);
            }, function(data) {
                
            });
        }
        
        let getListContribution = () => {
            const url = `${baseUrl}/api/v1/getContribution`;
            ajaxData(url, 'GET', [], function(resp) {
                let data = resp.data;
                let option = ``;

                data.forEach(element => {
                    option += `<option value="${element.id}">${element.description}</option>`;
                });
                $(".list-contribution").append(option);
            }, function(data) {
                
            });
        }
            

        let currentEditingUserId = null;

        $(document).on('click', '.btn-edit-user', function() {
            currentEditingUserId = $(this).data('user-id');

            $('#editUserManagement').modal('show');

            $('#statusUser').empty();
            $('#statusUser').append('<option value="">Pilih Status</option>');
        
            if (currentEditingUserId) {
                let selectedContribution = '';
                $(document).on('change', '.list-contribution', function() {
                    selectedContribution = $(this).val();
                    const urlStatus = `${baseUrl}/api/v1/getStatus`;
                    ajaxData(urlStatus, 'GET', { "id": currentEditingUserId, "selectedContribution": selectedContribution }, function(resp) {
                        let dataStatus = resp.data;
                        let statusOptions = '';
                        statusOptions += `<option value="${dataStatus.id}">${dataStatus.description}</option>`;
                        // dataStatus.forEach(element => {
                            
                        // });
                        $('#statusUser').html(statusOptions);
                    });
                });
            } 
            ajaxData(`${baseUrl}/api/v1/getUser`, 'GET', {
                "id" : $(this).data('user-id')
            }, function(resp) {

                if (empty(resp.data)) {
                    toast("Data not found", 'warning');
                    $('#editUserManagement').modal('hide');
                }
                
                let result = resp.data[0];
                $.each(result, function(index, data) {
                    
                    if (index == "image") return;
                    $('#editUserManagement').find(`[data-bind-${index}]`).val(data).attr('value', data);
                
                
                });

                // Get user role from session
                const userRole = session('role');

                // Disable specific input fields based on role
                const userFieldsToDisable = [
                    '[name="repeater[0][weight]"]',
                    '[name="repeater[0][height]"]',
                    '[name="repeater[0][id_positions]"]',
                    '[name="repeater[0][history]"]',
                    '[name="repeater[0][id_contributions]"]',
                    '[name="repeater[0][id_statuses]"]',
                    '[name="repeater[0][strength]"]',
                    '[name="repeater[0][weakness]"]'
                ];

                const coachFieldsToDisable = [
                    '[name="repeater[0][email]"]',
                    '[name="repeater[0][name]"]',
                    '[name="repeater[0][nik]"]',
                    '[name="repeater[0][place_of_birth]"]',
                    '[name="repeater[0][birth_of_date]"]',
                    '[name="repeater[0][address]"]',
                    '[name="repeater[0][school]"]',
                    '[name="repeater[0][class]"]',
                    '[name="repeater[0][father_name]"]',
                    '[name="repeater[0][mother_name]"]',
                    '[name="repeater[0][parents_contact]"]',
                    '[name="repeater[0][id_contributions]"]',
                    '[name="repeater[0][id_statuses]"]',
                ];

                if (userRole === 'user') {
                    userFieldsToDisable.forEach(selector => {
                        $(`#editUserManagement ${selector}`).prop('disabled', true);
                        // Add a hidden input clone for each disabled field to ensure value submission
                        $(`#editUserManagement ${selector}`).each(function() {
                            // Skip if already has a hidden clone
                            if ($(this).data('hidden-clone')) return;
                            
                            // Create a hidden input with the same name and value
                            const $hiddenInput = $('<input>', {
                                type: 'hidden',
                                name: $(this).attr('name'),
                                value: $(this).val(),
                                'data-original-id': $(this).attr('id')
                            });
                            
                            // Mark that we've created a clone
                            $(this).data('hidden-clone', true);
                            
                            // Insert hidden input right after the disabled field
                            $(this).after($hiddenInput);
                        });
                    });
                    $('#user-role-note').text('Note: As a user, you cannot modify these fields. Please contact an administrator for updates.').show();
                } else if (userRole === 'coach') {
                    coachFieldsToDisable.forEach(selector => {
                        $(`#editUserManagement ${selector}`).prop('disabled', true);
                        // Add a hidden input clone for each disabled field to ensure value submission
                        $(`#editUserManagement ${selector}`).each(function() {
                            // Skip if already has a hidden clone
                            if ($(this).data('hidden-clone')) return;
                            
                            // Create a hidden input with the same name and value
                            const $hiddenInput = $('<input>', {
                                type: 'hidden',
                                name: $(this).attr('name'),
                                value: $(this).val(),
                                'data-original-id': $(this).attr('id')
                            });
                            
                            // Mark that we've created a clone
                            $(this).data('hidden-clone', true);
                            
                            // Insert hidden input right after the disabled field
                            $(this).after($hiddenInput);
                        });
                    });
                    $('#user-role-note').text('Note: Silakan hubungi admin untuk mengubah data pemain yang tidak bisa diubah oleh Pelatih.').show();
                }

                // Ensure hidden inputs are updated when original fields change
                $('#editUserManagement').on('change', 'input, select, textarea', function() {
                    const originalId = $(this).attr('id');
                    const $hiddenInput = $(`input[data-original-id="${originalId}"]`);
                    
                    if ($hiddenInput.length) {
                        $hiddenInput.val($(this).val());
                    }
                });
            },
            function() {
                setTimeout(function() {
                    $('#editUserManagement').modal('hide');
                }, 1000);
            });
        });

        $('#editUserManagement').on('submit', '#form-edit-usermanagement', function(e) {
            e.preventDefault();
            
            // Explicitly select the form element
            const form = document.getElementById('form-edit-usermanagement');
            
            // Create FormData using the form element
            const data = new FormData(form);
            
            if (currentEditingUserId) {
                data.delete('repeater[0][id]');
                data.append('repeater[0][id]', currentEditingUserId);
            }

            const url = `${baseUrl}/api/v1/userManagement`;
            ajaxDataFile(url, 'POST', data, function(resp) {
                toast("Data has been saved");
        
                $('#editUserManagement').modal('hide');

                currentEditingUserId = null;
    
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }, function(data) {
                toast("Failed to save data");
                
                currentEditingUserId = null;
            });
        });
    </script>
@endsection