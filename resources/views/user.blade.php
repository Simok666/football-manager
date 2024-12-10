@extends('layout.admin')

@section('title', 'User Management')
@section('title_page', 'User Management')
@section('desc_page', '')
@section('content')
<div class="row">
    <div class="col-12">
    @include('components.table-pagenation', ['table' => 'userManagement' , 'url' => '/api/v1/getUser', 'headerTitle' => 'User Management Table' , 'headers' => [
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
      <form id="form-edit-usermanagement">
            <div class="mb-3">
                <input type="hidden" name="repeater[0][id]" class="form-control" data-bind-id value="">
                <input type="email" name="repeater[0][email]" class="form-control" placeholder="Email" aria-label="Email" data-bind-email value="" required>
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
                <input type="date" name="repeater[0][birth_of_date]" class="form-control" placeholder="Tanggal Lahir" aria-label="Tanggal Lahir" data-bind-birth_of_date value="" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][address]" class="form-control" placeholder="Alamat" aria-label="Alamat" data-bind-address value="" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][school]" class="form-control" placeholder="Sekolah" aria-label="Sekolah" data-bind-school value="" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][class]" class="form-control" placeholder="Kelas" aria-label="Kelas" data-bind-class value="" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][father_name]" class="form-control" placeholder="Nama Ayah/Wali" aria-label="Nama Ayah/Wali" data-bind-father_name value="" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][mother_name]" class="form-control" placeholder="Nama Ibu/Wali" aria-label="Nama Ibu/Wali" data-bind-mother_name value="" required>
            </div>
            <div class="mb-3">
                <input type="number" name="repeater[0][parents_contact]" class="form-control" placeholder="Kontak Orang Tua/Wali" aria-label="Kontak Orang Tua/Wali" data-bind-parents_contact value="" required>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][weight]" class="form-control" placeholder="Berat Badan" aria-label="Berat Badan" data-bind-weight value="" >
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][height]" class="form-control" placeholder="Tinggi Badan" aria-label="Tinggi Badan" data-bind-height value="" >
            </div>
            <div class="form-group">
                <label for="position">Posisi</label>
                <select class="form-control list-position" name ="repeater[0][id_positions]" id="position" data-bind-id_positions value="">
                <option value="" selected>Pilih Posisi</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][history]" class="form-control" placeholder="Riwayat" aria-label="Riwayat" data-bind-history value="">
            </div>
            <div class="form-group">
                <label for="contribution">Iuran</label>
                <select class="form-control list-contribution" name ="repeater[0][id_contributions]" id="contribution" data-bind-id_contribution value="">
                <option value="" selected>Pilih Iuran</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name ="repeater[0][id_statuses]" id="status" data-bind-id_statuses value="">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="text" name="repeater[0][strength]" class="form-control" placeholder="Kekuatan" aria-label="Kekuatan" data-bind-strength value="">
            </div>
            <div class="mb-3">
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

        $(document).on('click', '.btn-edit', function() {
            $('#editUserManagement').modal('show');
            
            ajaxData(`${baseUrl}/api/v1/getUser`, 'GET', {
                "id" : $(this).data('id')
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

            },
            function() {
                setTimeout(function() {
                    $('#editUserManagement').modal('hide');
                }, 1000);
            });
        });

        $("#form-edit-usermanagement").on('submit', function(e) {
            e.preventDefault();
            const url = `${baseUrl}/api/v1/userManagement`;
            const data = new FormData(this);
            ajaxDataFile(url, 'POST', data, function(resp) {
                toast("Data has been saved");
                $('#editUserManagement').modal('hide');
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
                // loadingButton($("#form-edit-usermanagement"), false)
            }, function(data) {
                // loadingButton($("#form-edit-usermanagement"), false)
            });
        });
    </script>
@endsection