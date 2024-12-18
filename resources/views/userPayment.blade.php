@extends('layout.admin')

@section('title', 'User Payment')
@section('title_page', 'User Payment')
@section('desc_page', '')
@section('content')


<div class="row">
        <div class="col-xl-7 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Tata Cara Pembayaran</p>
                    <h5 class="font-weight-bolder">
                    <p class="mb-0">
                    1. Seperti ini
                    </p>
                    <p class="mb-0">
                    1. Seperti ini
                    </p>
                    <p class="mb-0">
                    1. Seperti ini
                    </p>
                    <p class="mb-0">
                    1. Seperti ini
                    </p>
                    </h5>
                    
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
          <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">Bukti Pembayaran</h6>
              <p class="text-sm mb-0">
                <i class="fa fa-arrow-up text-success"></i>
                <span class="font-weight-bold">December 25</span> in 2024
              </p>
            </div>
            <div class="card">
                <div class="card-body">
                    <form id="proofPayment">
                        <label for="formFileMultiple" class="form-label">Maximum size is 2MB</label>
                        <input class="form-control" type="hidden" name="repeater[0][event_name]" value="proof_payment" required>
                        <input class="form-control" type="hidden" name="repeater[0][user_id]" id="user_id" required>
                        <input class="form-control" type="file" name="repeater[0][proof_payment]" id="formFileMultiple" required>
                    </form>
                        <div class="button-upload" style="padding-top: 20px;
                            display: flex;
                            justify-content: end;">
                            <button type="submit" form="proofPayment" class="btn btn-primary">Upload</button>
                        </div>
                </div>
            </div>
          </div>
        </div>
        
      </div>
      <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                for a better web.
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>    
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let userId = session("userId");
            $('#user_id').val(userId);
        });

        $("#proofPayment").on('submit', function(e) {
                e.preventDefault();
                const url = `${baseUrl}/api/v1/addUpdatePayment`;
                ajaxDataFile(url, 'POST', new FormData(this),
                    function(resp) {
                        toast("Save data success", 'success');
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    },
                    function (xhr) {
                        if (xhr.status === 422) {
                            const errorMessage = xhr.responseJSON.message || "One or more files exceed the 2MB size limit";
                            toast(errorMessage, 'error');
                        } else {
                            toast("Save data failed", 'error');
                        }
                    }
            );
        });
    </script>
@endsection