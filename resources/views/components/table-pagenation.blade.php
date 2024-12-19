<div class="card mb-4">
            <div class="card-header pb-0">
              <h6>{{ $headerTitle }}</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0 datatable-{{ $table }}" data-action="{{ $url }}">
                  <thead>
                  @if ($headers)
                    <tr>
                    @foreach ($headers as $header)
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ $header }}</th>
                    @endforeach
                    </tr>
                  @endif
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            @if ($pagination)
            <!-- <nav aria-label="Page navigation example" class="pagination-setting-{{ $table }}">
                <ul class="pagination justify-content-end" style="margin: 10px 20px 15px;">
                    <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                        <i class="fa fa-angle-left"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                    <a class="page-link btn-next" href="#">
                        <i class="fa fa-angle-right"></i>
                        <span class="sr-only">Next</span>
                    </a>
                    </li>
                </ul>
            </nav> -->
            @endif
</div>