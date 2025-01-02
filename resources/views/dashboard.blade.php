@extends('layout.admin')

@section('title', 'Dashboard')
@section('title_page', 'Dashboard')
@section('desc_page', '')

@section('styles')
<style>
.google-calendar {
    font-family: 'Google Sans', 'Roboto', Arial, sans-serif;
    background-color: white;
}

.calendar-header {
    border-bottom: 1px solid #e0e0e0;
    padding: 10px 0;
}

.day-label {
    flex: 1;
    text-align: center;
    color: #70757a;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.875rem;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    min-height: 600px;
}

.calendar-day {
    position: relative;
    cursor: pointer;
    transition: background-color 0.2s;
    min-height: 80px;
    padding: 5px;
    border: 1px solid #ddd;
}

.calendar-day:hover {
    background-color: #f1f3f4;
}

.calendar-day-number {
    position: absolute;
    right: 5px;
    font-size: 0.875rem;
    color: #70757a;
}

.calendar-day.today .calendar-day-number {
    color: #1a73e8;
    font-weight: bold;
}

.calendar-day.current-month {
    background-color: white;
}

.calendar-day.other-month {
    background-color: #f1f3f4;
    color: #70757a;
}

.event-dot {
    height: 4px;
    width: 4px;
    background-color: #1a73e8;
    border-radius: 50%;
    display: inline-block;
    margin: 2px;
}

.calendar-event {
    background-color: #e8f0fe;
    color: #1a73e8;
    border-radius: 4px;
    padding: 2px 4px;
    margin: 2px 0;
    font-size: 0.75rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.calendar-controls {
    display: flex;
    align-items: center;
}

.view-options .btn-group .btn {
    color: #1a73e8;
}

.view-options .btn-group .btn.active {
    background-color: #1a73e8;
    color: white;
}

.activity-mark {
    background-color: #f8f9fa;
    border-left: 4px solid #007bff;
    padding: 8px 12px;
    margin-bottom: 10px;
    border-radius: 4px;
    font-weight: 500;
    position: relative;
}

.event-action-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
}

.event-action-buttons .btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 6px 12px;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.event-action-buttons .btn i {
    margin-right: 5px;
}

.event-action-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.event-action-buttons .btn-outline-primary:hover {
    background-color: #007bff;
    color: white;
}

.event-action-buttons .btn-outline-success:hover {
    background-color: #28a745;
    color: white;
}

.event-action-buttons .btn-outline-info:hover {
    background-color: #17a2b8;
    color: white;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .event-action-buttons {
        flex-direction: column;
        align-items: stretch;
    }

    .event-action-buttons .btn {
        margin-bottom: 5px;
    }
}
</style>
@endsection
@section('content')
    <div class="row" >
      <div class="all-card" style="z-index:1000; position: sticky; top: 0;" id="all-card" >
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Money</p>
                    <h5 class="font-weight-bolder">
                      $53,000
                    </h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+55%</span>
                      since yesterday
                    </p>
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
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Users</p>
                    <h5 class="font-weight-bolder">
                      2,300
                    </h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+3%</span>
                      since last week
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">New Clients</p>
                    <h5 class="font-weight-bolder">
                      +3,462
                    </h5>
                    <p class="mb-0">
                      <span class="text-danger text-sm font-weight-bolder">-2%</span>
                      since last quarter
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Sales</p>
                    <h5 class="font-weight-bolder">
                      $103,430
                    </h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4" id="adminChart">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">Monthly New User Registrations</h6>
              <p class="text-sm mb-0">
                <i class="fa fa-arrow-up text-success"></i>
                <span class="font-weight-bold"></span> 
              </p>
            </div>
            <div class="card-body p-3">
              <!-- <div class="chart">
                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
              </div> -->
              <div class="chart">
                  <canvas id="monthlyNewUsersChart" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card card-carousel overflow-hidden h-100 p-0">
            <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
              <div class="carousel-inner border-radius-lg h-100">
                <div class="carousel-item h-100 active" style="background-image: url({{ asset('assets/img/bg-carousel.jpeg') }});
      background-size: cover;">
                  <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    <!-- <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                      <i class="ni ni-camera-compact text-dark opacity-10"></i>
                    </div> -->
                    <!-- <h5 class="text-white mb-1">Get started with Argon</h5>
                    <p>There’s nothing I really wanted to do in life that I wasn’t able to get good at.</p> -->
                  </div>
                </div>
                <div class="carousel-item h-100" style="background-image: url({{ asset('assets/img/bg-carousel.jpeg') }});
      background-size: cover;">
                  <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                      <i class="ni ni-bulb-61 text-dark opacity-10"></i>
                    </div>
                    <h5 class="text-white mb-1">Faster way to create web pages</h5>
                    <p>That’s my skill. I’m not really specifically talented at anything except for the ability to learn.</p>
                  </div>
                </div>
                <div class="carousel-item h-100" style="background-image: url({{ asset('assets/img/bg-carousel.jpeg') }});
      background-size: cover;">
                  <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                      <i class="ni ni-trophy text-dark opacity-10"></i>
                    </div>
                    <h5 class="text-white mb-1">Share with us your design tips!</h5>
                    <p>Don’t be afraid to be wrong because you can’t learn anything from a compliment.</p>
                  </div>
                </div>
              </div>
              <button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid pt-4" id="userCalendar">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="calendar-controls d-flex align-items-center">
                            <button class="btn btn-primary mr-3" id="todayBtn">Today</button>
                            <!-- <a href="{{ url('addSchedule.html') }}" class="btn btn-primary mr-3" id="todayBtn">Add Schedule</a> -->
                            <div class="navigation-buttons">
                                <button id="prevMonth" class="btn btn-outline-secondary mx-1">&lt;</button>
                                <button id="nextMonth" class="btn btn-outline-secondary mx-1">&gt;</button>
                            </div>
                            <h4 id="currentMonthYear" class="ml-3 mb-0"></h4>
                        </div>
                        <!-- <div class="view-options">
                            <div class="btn-group" role="group">
                                <button id="monthView" class="btn btn-outline-primary active">Month</button>
                                <button id="weekView" class="btn btn-outline-primary">Week</button>
                                <button id="dayView" class="btn btn-outline-primary">Day</button>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="calendar-container" class="google-calendar">
                        <div id="calendar-header" class="calendar-header d-flex bg-light">
                            <div class="day-label">Sun</div>
                            <div class="day-label">Mon</div>
                            <div class="day-label">Tue</div>
                            <div class="day-label">Wed</div>
                            <div class="day-label">Thu</div>
                            <div class="day-label">Fri</div>
                            <div class="day-label">Sat</div>
                        </div>
                        <div id="calendarDays" class="calendar-grid"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  
      <div class="row mt-4" >
        <div class="col-lg- mb-lg-0 mb-4">
          <div class="card ">
            <div class="card-header pb-0 p-3" id="headerCoachTable">
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">List Nama Player</h6>
              </div>
            </div>
            <div class="card-header pb-0 p-3" id="headerAdminTable">
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">Status Iuran Pembayaran</h6>
              </div>
            </div>
            <div class="table-responsive" id="coachTable">
              <table class="table align-items-center ">
                <tbody>
                  <tr>
                    <td class="w-30">
                      <div class="d-flex px-2 py-1 align-items-center">
                        <div>
                          <img src="../assets/img/icons/flags/US.png" alt="Country flag">
                        </div>
                        <div class="ms-4">
                          <p class="text-xs font-weight-bold mb-0">Country:</p>
                          <h6 class="text-sm mb-0">United States</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Sales:</p>
                        <h6 class="text-sm mb-0">2500</h6>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Value:</p>
                        <h6 class="text-sm mb-0">$230,900</h6>
                      </div>
                    </td>
                    <td class="align-middle text-sm">
                      <div class="col text-center">
                        <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                        <h6 class="text-sm mb-0">29.9%</h6>
                      </div>
                    </td>
                  </tr>
                
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activityModalLabel">
                        <i class="ni ni-calendar-grid-58 mr-2"></i>Edit Event
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="activityForm">
                        <input type="hidden" id="selectedDate" name="selected_date">
                        <div class="form-group">
                            <label for="activityTitle">Activity Title</label>
                            <input type="hidden" name="repeater[0][event_name]" class="form-control"  value="edit_event">
                            <input type="hidden" name="repeater[0][new_id]" class="form-control"  value="not_null">
                            <input type="hidden" name="repeater[0][id]" class="form-control" data-bind-id value="">
                            <input type="text" name="repeater[0][activity]" class="form-control" id="activityTitle" data-bind-activity value="" placeholder="Add title" required disabled>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="activityDate">Date</label>
                                    <input type="date" name="repeater[0][date_activity]" class="form-control" id="activityDate" data-bind-date_activity value="" required disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="activityTime">Start Time</label>
                                    <input type="time" name="repeater[0][time_start_activity]" class="form-control" id="activityTime" data-bind-time_start_activity value="" required disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="activityTime">End Time</label>
                                    <input type="time" name="repeater[0][time_end_activity]" class="form-control" id="activityTime" data-bind-time_end_activity value="" required disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="activityDescription">Location</label>
                            <textarea class="form-control" name="repeater[0][location]" id="activityDescription" rows="3" placeholder="Add description" data-bind-location value="" required disabled></textarea>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <!-- <button type="submit" form="activityForm" class="btn btn-primary" id="saveActivity">Save</button> -->
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
      <script>
          $(document).ready(function() {
              let role = session("role")
              let roleUser = session("roleUser")
              let allCard = $('#all-card').empty();
              let adminChart = $('#adminChart').hide();
              let headerCoachTable = $('#headerCoachTable').hide();
              let headerAdminTable = $('#headerAdminTable').hide();
              let userCalendar = $('#userCalendar').hide();
              let coachTable = $('#coachTable').empty();
              
              let url = `${baseUrl}/api/v1/dashboard`;
              let urlUser = `${baseUrl}/api/v1/dashboard-player`;
              let urlCoach =  `${baseUrl}/api/v1/dashboard-coach`;
  
      
              if (roleUser == "admin") {
                $('#adminChart').show()
                $('#headerAdminTable').show()
                ajaxData(url, 'GET', [], function(resp) {
                  let cardItem = `
                    <div class="row">
                      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                          <div class="card-body p-3">
                            <div class="row">
                              <div class="col-8">
                                <div class="numbers">
                                  <p class="text-sm mb-0 text-uppercase font-weight-bold">All Player</p>
                                  <h5 class="font-weight-bolder">
                                  
                                  </h5>
                                  <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">${resp.getDataCard.getAllPlayer}</span>
                                    
                                  </p>
                                </div>
                              </div>
                              <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                  <img src="{{ asset('assets/img/groups.svg') }}" alt="Example SVG" style="margin: 10px" class="text-lg opacity-10 center">
                                  
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
  
                      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <div class="card">
                        <div class="card-body p-3">
                          <div class="row">
                            <div class="col-8">
                              <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Member Trial</p>
                                <h5 class="font-weight-bolder">
                                  
                                </h5>
                                <p class="mb-0">
                                  <span class="text-success text-sm font-weight-bolder">${resp.getDataCard.getAllMemberTrialPlayer}</span>
                                  
                                </p>
                              </div>
                            </div>
                            <div class="col-4 text-end">
                              <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                  <img src="{{ asset('assets/img/membertrial.svg') }}" alt="Example SVG" style="margin: 10px" class="text-lg opacity-10  center">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <div class="card">
                        <div class="card-body p-3">
                          <div class="row">
                            <div class="col-8">
                              <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Member Active</p>
                                <h5 class="font-weight-bolder">
                                  
                                </h5>
                                <p class="mb-0">
                                  <span class="text-danger text-sm font-weight-bolder">${resp.getDataCard.getAllMemberActivePlayer}</span>
                                  
                                </p>
                              </div>
                            </div>
                            <div class="col-4 text-end">
                              <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                  <img src="{{ asset('assets/img/memberactive.svg') }}" alt="Example SVG" style="margin: 10px" class="text-lg opacity-10  center">

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                      <div class="card">
                        <div class="card-body p-3">
                          <div class="row">
                            <div class="col-8">
                              <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Member Non Active</p>
                                <h5 class="font-weight-bolder">
                                 
                                </h5>
                                <p class="mb-0">
                                  <span class="text-success text-sm font-weight-bolder">${resp.getDataCard.getAllMemberNonActivePlayer}</span> 
                                </p>
                              </div>
                            </div>
                            <div class="col-4 text-end">
                              <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <img src="{{ asset('assets/img/membernonactive.svg') }}" alt="Example SVG" style="margin: 10px" class="text-lg opacity-10 center">

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  `;
                  allCard.append(cardItem);

                  
                  let userTablePayment = resp.userTablePayment;
                  
                  let adminTableItem = ``;
                  userTablePayment.forEach((data) => {

                    adminTableItem += `
                     <table class="table align-items-center ">
                       <tbody>
                         <tr>
                           <td class="w-30">
                             <div class="d-flex px-1 py-1 align-items-center">
                               
                               <div class="ms-4">
                                 <p class="text-xs font-weight-bold mb-0">Nama</p>
                                 <h6 class="text-sm mb-0">${data.name}</h6>
                               </div>
                             </div>
                           </td>
                           <td>
                             <div class="text-center">
                               <p class="text-xs font-weight-bold mb-0">Status Iuran:</p>
                               <h6 class="text-sm mb-0">${data.contribution == null ? "Belum ada Iuran" :data.contribution.description}</h6>
                             </div>
                           </td>
                         </tr>
                       
                         
                       </tbody>
                     </table>
                          
                    `;
                  })

                  coachTable.append(adminTableItem);
                })

                  $.ajax({
                    url: `${baseUrl}/api/v1/get-monthly-new-users`,
                    method: 'GET',
                    success: function(response) {
                        // Prepare chart data
                        const months = response.monthly_new_users.map(item => item.month);
                        const newUsers = response.monthly_new_users.map(item => item.new_users);

                        // Create chart
                        const ctx = document.getElementById('monthlyNewUsersChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: months,
                                datasets: [{
                                    label: 'New Users',
                                    data: newUsers,
                                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Number of New Users'
                                        },
                                        ticks: {
                                            stepSize: 1,
                                            precision: 0
                                        },
                                        min: 0,
                                        max: 3
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Months'
                                        }
                                    }
                                },
                                plugins: {
                                    title: {
                                        display: true,
                                        text: `New User Registrations in ${response.year}`
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error('Failed to fetch monthly new users', xhr);
                        toast('Failed to load new users chart', 'error');
                    }
                });
              } else if (roleUser == "user") {
                $('#userCalendar').show();
                ajaxData(urlUser, 'GET', [], function(resp) {
                  // console.log(resp.getStatus.status.description);
                  
                  let cardItem = `
                    <div class="row">
                      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                          <div class="card-body p-3">
                            <div class="row">
                              <div class="col-8">
                                <div class="numbers">
                                  <p class="text-sm mb-0 text-uppercase font-weight-bold">Status Player</p>
                                  <h5 class="font-weight-bolder">
                                  
                                  </h5>
                                  <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">${resp.getStatus.status == null ? "belum ada status" : resp.getStatus.status.description}</span>
                                    
                                  </p>
                                </div>
                              </div>
                              <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                  <img src="{{ asset('assets/img/statusplayer.svg') }}" alt="Example SVG" style="margin: 10px" class="text-lg opacity-10 center">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
  
                      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <div class="card">
                        <div class="card-body p-3">
                          <div class="row">
                            <div class="col-8">
                              <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Attendance Persentation</p>
                                <h5 class="font-weight-bolder">
                                  
                                </h5>
                                <p class="mb-0">
                                  <span class="text-success text-sm font-weight-bolder">${resp.totalAttendance} %</span>
                                  
                                </p>
                              </div>
                            </div>
                            <div class="col-4 text-end">
                              <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <img src="{{ asset('assets/img/attendence.svg') }}" alt="Example SVG" style="margin: 10px" class="text-lg opacity-10 center">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <div class="card">
                        <div class="card-body p-3">
                          <div class="row">
                            <div class="col-8">
                              <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total ${resp.getStatus.id_positions	== 1 ? "Saved" : "Goals"}</p>
                                <h5 class="font-weight-bolder">
                                  
                                </h5>
                                <p class="mb-0">
                                  <span class="text-danger text-sm font-weight-bolder">${resp.totalGoalOrSave}</span>
                                  
                                </p>
                              </div>
                            </div>
                            <div class="col-4 text-end">
                              <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <img src="{{ asset('assets/img/goal.svg') }}" alt="Example SVG" style="margin: 10px" class="text-lg opacity-10 center">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <div class="card">
                        <div class="card-body p-3">
                          <div class="row">
                            <div class="col-8">
                              <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">General Scoring</p>
                                <h5 class="font-weight-bolder">
                                  
                                </h5>
                                <p class="mb-0">
                                  <span class="text-danger text-sm font-weight-bolder">${resp.grade}</span>
                                  
                                </p>
                              </div>
                            </div>
                            <div class="col-4 text-end">
                              <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <img src="{{ asset('assets/img/generalscoring.svg') }}" alt="Example SVG" style="margin: 10px" class="text-lg opacity-10 center">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  `;
                  allCard.append(cardItem);
                })

                // Initialize variables
                  let currentDate = getIndonesiaTime();
                  let activities = JSON.parse(localStorage.getItem('googleCalendarActivities')) || {};
                  let currentView = 'month';
                  let scheduleData = []; // Store API data

                  // Fetch schedule data once at start
                  const url = `${baseUrl}/api/v1/getSchedule`;
                  ajaxData(url, 'GET', [], function(resp) {
                      scheduleData = resp.data;
                      renderCalendar(currentDate); // Re-render with data
                  }, function(error) {
                      console.error('Error fetching schedule data:', error);
                  });

                  // Function to get current time in Indonesia (GMT+7)
                  function getIndonesiaTime() {
                      const now = new Date();
                      const indonesiaTime = new Date  (now.toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }));
                      return indonesiaTime;
                  }

                  // Modify renderCalendar to use Indonesia time
                  function renderCalendar(date) {
                      const year = date.getFullYear();
                      const month = date.getMonth();
                      
                      // Update month and year display
                      $('#currentMonthYear').text(`${date.toLocaleString('default', { month: 'long' })} ${year}`);
                      
                      // Clear previous calendar
                      $('#calendarDays').empty();
                      
                      // Get first and last day of the month
                      const firstDay = new Date(year, month, 1);
                      const lastDay = new Date(year, month + 1, 0);
                      
                      // Determine start day of the week for the first day
                      const startingDay = firstDay.getDay();
                      
                      // Create calendar grid
                      for (let i = 0; i < 42; i++) {
                          const currentDate = new Date(year, month, i - startingDay + 1);
                          const dayCell = $('<div>').addClass('calendar-day');
                          
                          // Determine month classification
                          if (currentDate.getMonth() === month) {
                              dayCell.addClass('current-month');
                          } else {
                              dayCell.addClass('other-month');
                          }

                          // Add day number
                          const dayNumber = $('<span>')
                              .addClass('calendar-day-number')
                              .text(currentDate.getDate());
                          dayCell.append(dayNumber);
                          
                          // Highlight today
                          const todayIndonesia = getIndonesiaTime();
                          if (currentDate.toDateString() === todayIndonesia.toDateString()) {
                              dayCell.addClass('today');
                          }

                          // Check if there's an activity for this date
                          const activityForDate = scheduleData.find(schedule => {
                              // Convert ISO date string to Date object
                              const activityDate = new Date(schedule.date_activity);
                              // Compare year, month, and date
                              return activityDate.getFullYear() === currentDate.getFullYear() &&
                                    activityDate.getMonth() === currentDate.getMonth() &&
                                    activityDate.getDate() === currentDate.getDate();
                          });

                          // Add activity mark if there's a matching activity
                          if (currentDate.getMonth() === month && activityForDate) {
                              dayCell.attr('data-id', activityForDate.id);
                              const activityMark = $('<div>')
                                  .addClass('activity-mark')
                                  .text(activityForDate.activity);
                              const eventActionButtons = $('<div>')
                                  .addClass('event-action-buttons mt-2')
                                  .append(
                                      $('<button>')
                                          .addClass('btn btn-sm btn-outline-primary btn-edit-event mr-1')
                                          .attr('data-event-id', activityForDate.id)
                                          .append(
                                              $('<i>')
                                                  .addClass('fas fa-edit')
                                          )
                                          .append('Detail Event')
                                  );
                                  // .append(
                                  //     $('<button>')
                                  //         .addClass('btn btn-sm btn-outline-success btn-add-participants mr-1')
                                  //         .attr('data-event-id', activityForDate.id)
                                  //         .append(
                                  //             $('<i>')
                                  //                 .addClass('fas fa-user-plus')
                                  //         )
                                  //         .append('Add Participants')
                                  // )
                                  // .append(
                                  //     $('<button>')
                                  //         .addClass('btn btn-sm btn-outline-info btn-add-documentation')
                                  //         .attr('data-event-id', activityForDate.id)
                                  //         .append(
                                  //             $('<i>')
                                  //                 .addClass('fas fa-file-upload')
                                  //         )
                                  //         .append('Add Documentation')
                                  // );
                              dayCell.append(activityMark).append(eventActionButtons);
                          }
                          
                          $('#calendarDays').append(dayCell);
                      }
                  }

                  // Today button now uses Indonesia time
                  $('#todayBtn').click(function() {
                      currentDate = getIndonesiaTime();
                      renderCalendar(currentDate);
                  });

                  // Navigation buttons use Indonesia time context
                  $('#prevMonth').click(function() {
                      currentDate.setMonth(currentDate.getMonth() - 1);
                      renderCalendar(currentDate);
                  });

                  $('#nextMonth').click(function() {
                      currentDate.setMonth(currentDate.getMonth() + 1);
                      renderCalendar(currentDate);
                  });

                  // View mode buttons
                  $('.view-options .btn').click(function() {
                      $('.view-options .btn').removeClass('active');
                      $(this).addClass('active');
                      currentView = $(this).attr('id').replace('View', '');
                      // TODO: Implement week and day views
                      renderCalendar(currentDate);
                  });

                  $(document).on('click', '.btn-edit-event', function() {
                      const data_id = $(this).data('event-id');
                      
                      // Open the activity modal
                      $('#activityModal').modal('show');
                      
                      ajaxData(`${baseUrl}/api/v1/getSchedule`, 'GET', {
                          "id": data_id
                      }, function(resp) {
                          if (empty(resp.data)) {
                              toast("Data not found", 'warning');
                              $('#activityModal').modal('hide');
                          }
                          let result = resp.data[0];
                          
                          $.each(result, function(index, data) {
                              if (index == "image") return;

                              // Special handling for date and time inputs
                              if (index === 'date_activity') {
                                  // Convert ISO date to YYYY-MM-DD format
                                  const dateObj = new Date(data);
                                  const formattedDate = dateObj.getFullYear() + 
                                                      '-' + 
                                                      String(dateObj.getMonth() + 1).padStart(2, '0') + 
                                                      '-' + 
                                                      String(dateObj.getDate()).padStart(2, '0');
                                                      
                                  $('#activityModal').find(`[data-bind-${index}]`).val(formattedDate).attr('value', formattedDate);
                              } else if (index === 'time_start_activity' || index === 'time_end_activity') {
                                  const isoTimestamp = data;
                                  const date = new Date(isoTimestamp);

                                  const hours = date.getUTCHours().toString().padStart(2, '0');
                                  const minutes = date.getUTCMinutes().toString().padStart(2, '0');

                                  const formattedTime = `${hours}:${minutes}`;
                                  
                                  $('#activityModal').find(`[data-bind-${index}]`).val(formattedTime).attr('value', formattedTime);
                              } else {
                                  $('#activityModal').find(`[data-bind-${index}]`).val(data).attr('value', data);
                              }
                          });
                      },
                      function() {
                          setTimeout(function() {
                              $('#activityModal').modal('hide');
                          }, 1000);
                      });
                  });

                  $(document).on('click', '.btn-add-participants', function() {
                      const data_id = $(this).data('event-id');
                      $('#participantsModal').modal('show');

                      $('#participantsCheckboxContainer').empty();
                      ajaxData(`${baseUrl}/api/v1/getSchedule`, 'GET', {
                          "id": data_id
                      }, function(resp) {
                          if (empty(resp.data)) {
                              toast("Data not found", 'warning');
                              $('#activityModal').modal('hide');
                          }

                          let participantsAdded = resp.data[0].participants_added;
                          let dataUserParticipiants = resp.data[0].user_participiants;
                          let userIndex = 0; 
                          
                          dataUserParticipiants.forEach((element, index) => {
                              
                              if (element.attendance_status == "Hadir") {
                                  // Check if the user is already a participant
                                  const isParticipant = participantsAdded.some(participant => participant.id === element.user.id);
                                  
                                  let checkboxHtml = `
                                      <input type="hidden" name="repeater[${userIndex}][event_name]" class="form-control"  value="add_participants">
                                      <input type="hidden" name="repeater[${userIndex}][id]" class="form-control" data-bind-id value="${data_id}">

                                      <div class="custom-control custom-checkbox">
                                      <input class="custom-control-input" type="checkbox" name="repeater[${userIndex}][user_id]" value="${element.user.id}" id="customCheck${index}" ${isParticipant ? 'checked ' : ''} required>
                                      <label class="custom-control-label" for="customCheck${userIndex}">
                                                      ${element.user.name} ${isParticipant ? '(Already Participant)' : ''}
                                      </label>
                                      </div>
                                      `;
                                      $('#participantsCheckboxContainer').append(checkboxHtml);
                                      userIndex++; 
                              }
                          })
                      },

                      function() {
                          setTimeout(function() {
                              $('#activityModal').modal('hide');
                          }, 1000);
                      });
                      
                  });

                  $(document).on('click', '.btn-add-documentation', function() {
                      const data_id = $(this).data('event-id');
                      $('#documentationModal').modal('show');

                      

                      ajaxData(`${baseUrl}/api/v1/getSchedule`, 'GET', {
                          "id": data_id
                      }, function(resp) {
                          if (empty(resp.data)) {
                              toast("Data not found", 'warning');
                              $('#documentationModal').modal('hide');
                          }
                          let result = resp.data[0];
                          
                          $.each(result, function(index, data) {
                              if (index == "image") return;
                              // Special handling for date and time inputs
                              $('#documentationModal').find(`[data-bind-${index}]`).val(data).attr('value', data);
                          });
                      },
                      function() {
                          setTimeout(function() {
                              $('#documentationModal').modal('hide');
                          }, 1000);
                      });
                  });

                  $('#documentationModal').on('hidden.bs.modal', function () {
                      // Reset file input
                      $('#formFileMultiple').val('');
                      
                      // Reset other form fields
                      $('#documentationForm')[0].reset();
                  });

                  // Date input interaction with Indonesia time
                  $('#activityDate').on('click', function() {
                      
                      // Create a temporary date input that opens immediately
                      const tempDateInput = $('<input>')
                          .attr('type', 'date')
                          .css({
                              position: 'absolute',
                              opacity: 0,
                              top: 0,
                              left: 0,
                              width: 0,
                              height: 0
                          })
                          .appendTo('body')
                          .trigger('click')
                          .on('change', function() {
                              // Parse the date from the input
                              const selectedDateStr = $(this).val();
                              
                              const [year, month, day] = selectedDateStr.split('-').map(Number);
                              
                              // Create date with correct month (JavaScript months are 0-indexed)
                              const selectedDate = new Date(year, month - 1, day);
                              
                              // Format the date as MM/DD/YYYY
                              const formattedDate = (selectedDate.getMonth() + 1).toString().padStart(2, '0') + 
                                                    '/' + 
                                                    selectedDate.getDate().toString().padStart(2, '0') + 
                                                    '/' + 
                                                    selectedDate.getFullYear();
                              
                              $('#activityDate').val(formattedDate);
                              tempDateInput.remove();
                          })
                          .on('blur', function() {
                              tempDateInput.remove();
                          });
                  });

                  // Prevent manual text input on date field
                  $('#activityDate').on('keydown paste', function(e) {
                      e.preventDefault();
                      return false;
                  });



                  // Initial render with Indonesia time
                  // renderCalendar(currentDate);

                  $("#activityForm").on('submit', function(e) {
                      e.preventDefault();
                      const url = `${baseUrl}/api/v1/addUpdateSchedule`;
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

                  $("#participantsForm").on('submit', function(e) {
                      e.preventDefault();
                      const url = `${baseUrl}/api/v1/addUpdateSchedule`;
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

                  $("#documentationForm").submit(function(e) {
                          e.preventDefault();
                          const url = `${baseUrl}/api/v1/addUpdateSchedule`;
                          ajaxDataFile(url, 'POST', new FormData(this),
                              function(resp) {
                                  toast("Save data success", 'success');
                                  $("#documentationModal").modal('hide');
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



              } else if (roleUser == "coach") {
                $('#headerCoachTable').show();
                ajaxData(urlCoach, 'GET', [], function(resp) {
                  let getCountPosition = resp.getCountPosition;
                  let cardItem = `
                    <div class="row">
                      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                          <div class="card-body p-3">
                            <div class="row">
                              <div class="col-8">
                                <div class="numbers">
                                  <p class="text-sm mb-0 text-uppercase font-weight-bold">Defending Player</p>
                                  <h5 class="font-weight-bolder">
                                  
                                  </h5>
                                  <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">${getCountPosition.countDef}</span>
                                    
                                  </p>
                                </div>
                              </div>
                              <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                  <img src="{{ asset('assets/img/defend.svg') }}" alt="Example SVG" style="margin: 10px" class="text-lg opacity-10  center">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
  
                      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <div class="card">
                        <div class="card-body p-3">
                          <div class="row">
                            <div class="col-8">
                              <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Forward Player</p>
                                <h5 class="font-weight-bolder">
                                  
                                </h5>
                                <p class="mb-0">
                                  <span class="text-success text-sm font-weight-bolder">${getCountPosition.countFD}</span>
                                  
                                </p>
                              </div>
                            </div>
                            <div class="col-4 text-end">
                              <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <img src="{{ asset('assets/img/forward.svg') }}" alt="Example SVG" style="margin: 10px" class="text-lg opacity-10  center">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <div class="card">
                        <div class="card-body p-3">
                          <div class="row">
                            <div class="col-8">
                              <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Goal Keeper Player</p>
                                <h5 class="font-weight-bolder">
                                  
                                </h5>
                                <p class="mb-0">
                                  <span class="text-danger text-sm font-weight-bolder">${getCountPosition.countGK}</span>
                                  
                                </p>
                              </div>
                            </div>
                            <div class="col-4 text-end">
                              <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <img src="{{ asset('assets/img/goalkeeper.svg') }}" alt="Example SVG" style="margin: 10px" class="text-lg opacity-10  center">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                      <div class="card">
                        <div class="card-body p-3">
                          <div class="row">
                            <div class="col-8">
                              <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Midfielder Player</p>
                                <h5 class="font-weight-bolder">
                                 
                                </h5>
                                <p class="mb-0">
                                  <span class="text-success text-sm font-weight-bolder">${getCountPosition.countMid}</span> 
                                </p>
                              </div>
                            </div>
                            <div class="col-4 text-end">
                              <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <img src="{{ asset('assets/img/midfielder.svg') }}" alt="Example SVG" style="margin: 10px" class="text-lg opacity-10  center">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  `;
              
                  allCard.append(cardItem);

                  const getCoachTableResp = resp.coachTable;
                  
                  let coachTableItem = ``;
                  getCoachTableResp.forEach((data) => {
                    
                   coachTableItem += `
                   <table class="table align-items-center ">
                     <tbody>
                       <tr>
                         <td class="w-30">
                           <div class="d-flex px-1 py-1 align-items-center">
                             
                             <div class="ms-4">
                               <p class="text-xs font-weight-bold mb-0">Nama</p>
                               <h6 class="text-sm mb-0">${data.name}</h6>
                             </div>
                           </div>
                         </td>
                         <td>
                           <div class="text-center">
                             <p class="text-xs font-weight-bold mb-0">Training Activity:</p>
                             <h6 class="text-sm mb-0">${data.training_activity}</h6>
                           </div>
                         </td>
                         <td>
                           <div class="text-center">
                             <p class="text-xs font-weight-bold mb-0">General:</p>
                             <h6 class="text-sm mb-0">${data.grade}</h6>
                           </div>
                         </td>
                         <td>
                           <div class="text-center">
                             <p class="text-xs font-weight-bold mb-0">Total ${data.positions == "GK" ? "Saved" : "Goals"}:</p>
                             <h6 class="text-sm mb-0">${data.totalGoalOrSave}</h6>
                           </div>
                         </td>
                         <td class="align-middle text-sm">
                           <div class="col text-center">
                             <p class="text-xs font-weight-bold mb-0">Foul:</p>
                             <h6 class="text-sm mb-0">${data.foul}</h6>
                           </div>
                         </td>
                       </tr>
                     
                       
                     </tbody>
                   </table>
                        
                  `;
                
                });
                coachTable.append(coachTableItem)
                });
              }
          });
      </script>
@endSection