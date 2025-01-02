@extends('layout.admin')

@section('title', 'User Payment Confirmation')
@section('title_page', 'User Payment Confirmation')
@section('desc_page', '')
@section('content')
<div class="row">
    <div class="col-12">
    @include('components.table-pagenation', ['table' => 'paymentConfirmation' , 'url' => '/api/v1/getPayment', 'headerTitle' => 'Payment Confirmation Table' , 'headers' => [
            "Name",
            "Date Payment",
            "Payment Confirmation",
            "Proof Payment",
            "Action"
        ] , 'pagination' => true])
    </div>
</div>
<div class="modal fade" id="paidOFFModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Paid OFF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group  mb-3">
            Apakah anda yakin ingin Paid OFF untuk user ini? <br>
        </div>
        <div class="form-group  mb-3">
        <span class="">Nama: <strong id="name"></strong></span><br>
        </div>
        <div class="form-group  mb-3">
        <span class="">Email: <strong id="email"></strong></span><br>
        </div>
        <form action="index.html" id="payment-confirm">
            <input type="hidden" name="repeater[0][id]" id="payment_id">
            <input type="hidden" name="repeater[0][event_name]" value="payment_paid_off" id="payment_paid_off">
            <input type="hidden" name="repeater[0][user_id]"  id="user_id">
            <input type="hidden" name="repeater[0][proof_payment]" value=null id="payment_id">
            <input type="hidden" name="repeater[0][payment_confirmation]"  value="Paid Off" id="payment_confirmation">
        </form> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="payment-confirm" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endSection

@section('scripts')
        <script>
            $(document).ready(function() {
                GetData(req,"paymentConfirmation", formatpaymentconfirmation);
            });

            function formatpaymentconfirmation(data) { 
                var result = "";
             
                $.each(data, function(index, data) {
                    const dateObj = new Date(data.date_payment);
                    const formattedDate = dateObj.getFullYear() + 
                                                '-' + 
                                                String(dateObj.getMonth() + 1).padStart(2, '0') + 
                                                '-' + 
                                                String(dateObj.getDate()).padStart(2, '0');
    
                    const fileUrl = `${baseUrl}/storage/app/public/${data.proof_payment}`;
                   
                    result += `
                        <tr>
                            <td>
                                <div class="d-flex px-3 py-1">
                    
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">${data.user.name}</h6>
                                </div>
                                </div>
                            </td>
                            <td>${formattedDate}</td>
                            <td>${data.payment_confirmation}</td>
                            <td>${data.proof_payment == null ? "Belum Ada Bukti Pembayaran" : `<a href="${fileUrl}" target="_blank">Link Bukti Pembayaran </a>`}</td>
                            <td>
                                ${data.payment_confirmation === "Paid Off" ? `<button type="button" class="btn btn-success">Done Paid</button>` : `<a  href="#" data-toggle="modal" data-target="#paidOFFModal" class="btn btn-danger btn-icon btn-sm btn-paid" title="Paid Off" data-name="${data.user.name}" data-email="${data.user.email}" data-id="${data.id}" data-user-id="${data.user.id}">
                                    <span class="btn-inner--icon"><i class="ni ni-ruler-pencil"></i></span>
                                    <span class="btn-inner--text">Paid Off</span>
                                </a>`}
                            </td>
                        </tr>
                    `
                });
                return result;
            }

            $(document).on('click', '.btn-paid', function() {
                $('#name').html($(this).data('name'));
                $('#email').html($(this).data('email'));
                $('#user_id').val($(this).data('user-id'));
                $('#payment_id').val($(this).data('id'));
            });

            $("#payment-confirm").on('submit', function(e) {
                e.preventDefault();
                const url = `${baseUrl}/api/v1/addUpdatePayment`;
                const data = new FormData(this);
                
                
                ajaxDataFile(url, 'POST', data, function(resp) {
                    toast("Update Data has been saved");
                    $('#activityModal').modal('hide');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                            
                    }, function(data) {
                            
                    });
            });
        </script>
@endSection