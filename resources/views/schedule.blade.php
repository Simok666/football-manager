@extends('layout.admin')

@section('title', 'Schedule Management')
@section('title_page', 'Schedule Management')
@section('desc_page', 'Manage your training and team activities')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="calendar-controls d-flex align-items-center">
                            <button class="btn btn-primary mr-3" id="todayBtn">Today</button>
                            <a href="{{ url('addSchedule.html') }}" class="btn btn-primary mr-3" id="todayBtn">Add Schedule</a>
                            <div class="navigation-buttons">
                                <button id="prevMonth" class="btn btn-outline-secondary mx-1">&lt;</button>
                                <button id="nextMonth" class="btn btn-outline-secondary mx-1">&gt;</button>
                            </div>
                            <h4 id="currentMonthYear" class="ml-3 mb-0"></h4>
                        </div>
                        <div class="view-options">
                            <div class="btn-group" role="group">
                                <button id="monthView" class="btn btn-outline-primary active">Month</button>
                                <button id="weekView" class="btn btn-outline-primary">Week</button>
                                <button id="dayView" class="btn btn-outline-primary">Day</button>
                            </div>
                        </div>
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

    <!-- Activity Modal -->
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
                            <input type="hidden" name="repeater[0][id]" class="form-control" data-bind-id value="">
                            <input type="text" name="repeater[0][activity]" class="form-control" id="activityTitle" data-bind-activity value="" placeholder="Add title" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="activityDate">Date</label>
                                    <input type="date" name="repeater[0][date_activity]" class="form-control" id="activityDate" data-bind-date_activity value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="activityTime">Start Time</label>
                                    <input type="time" name="repeater[0][time_start_activity]" class="form-control" id="activityTime" data-bind-time_start_activity value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="activityTime">End Time</label>
                                    <input type="time" name="repeater[0][time_end_activity]" class="form-control" id="activityTime" data-bind-time_end_activity value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="activityDescription">Location</label>
                            <textarea class="form-control" name="repeater[0][location]" id="activityDescription" rows="3" placeholder="Add description" data-bind-location value="" required></textarea>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="activityForm" class="btn btn-primary" id="saveActivity">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Participants Modal -->
    <div class="modal fade" id="participantsModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activityModalLabel">
                        <i class="ni ni-calendar-grid-58 mr-2"></i>Add Particpiants
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="participantsForm">
                        <div class="form-group  mb-3">
                            Tambahkan murid yang berpartisipasi <br>
                        </div>
                        <div id="participantsCheckboxContainer">
                                <!-- Checkboxes will be dynamically added here -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="participantsForm" class="btn btn-primary" id="saveActivity">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Documentation Modal -->
    <div class="modal fade" id="documentationModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activityModalLabel">
                        <i class="ni ni-calendar-grid-58 mr-2"></i>Add Documentation
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="documentationForm">
                        <div class="mb-3">
                            <input type="hidden" name="repeater[0][id]" class="form-control" data-bind-id value="">
                            <input type="hidden" name="repeater[0][event_name]" class="form-control"  value="add_documentation">
                            <input type="hidden" name="repeater[0][activity]" class="form-control" id="activityTitle" data-bind-activity value="" placeholder="Add title" required>
                            
                            <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                            <input class="form-control" type="file" name="repeater[0][example][]" id="formFileMultiple" multiple>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="documentationForm" class="btn btn-primary" id="saveActivity">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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

@section('scripts')
<script>

$(document).ready(function() {
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
                            .append('Edit Event')
                    )
                    .append(
                        $('<button>')
                            .addClass('btn btn-sm btn-outline-success btn-add-participants mr-1')
                            .attr('data-event-id', activityForDate.id)
                            .append(
                                $('<i>')
                                    .addClass('fas fa-user-plus')
                            )
                            .append('Add Participants')
                    )
                    .append(
                        $('<button>')
                            .addClass('btn btn-sm btn-outline-info btn-add-documentation')
                            .attr('data-event-id', activityForDate.id)
                            .append(
                                $('<i>')
                                    .addClass('fas fa-file-upload')
                            )
                            .append('Add Documentation')
                    );
                dayCell.append(activityMark).append(eventActionButtons);
            }


            // Add click event
        //     dayCell.on('click', function() {
        //     // Open the activity modal
        //     $('#activityModal').modal('show');
            
        //     const data_id = $(this).data('id')
        //     const selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), parseInt($(this).find('.calendar-day-number').text()));
            
        //     // Format the date as YYYY-MM-DD for date input
        //     const formattedDateInput = selectedDate.getFullYear() + 
        //                             '-' + 
        //                             String(selectedDate.getMonth() + 1).padStart(2, '0') + 
        //                             '-' + 
        //                             String(selectedDate.getDate()).padStart(2, '0');
            
        //     // Set the date input to the selected date
        //     $('#activityDate').val(formattedDateInput);

        //     if (data_id === undefined) {
        //         // Clear other fields if no existing activity
        //         $('#activityModal').find('[data-bind-activity], [data-bind-time_start_activity], [data-bind-time_end_activity], [data-bind-location]').val('');
        //     } else {
        //         ajaxData(`${baseUrl}/api/v1/getSchedule`, 'GET', {
        //             "id" : data_id
        //         }, function(resp) {
        //             if (empty(resp.data)) {
        //                 toast("Data not found", 'warning');
        //                 $('#activityModal').modal('hide');
        //             }
        //             let result = resp.data[0];
                    
        //             $.each(result, function(index, data) {
                        
        //                 if (index == "image") return;

        //                 // Special handling for date and time inputs
        //                 if (index === 'date_activity') {
        //                     // Convert ISO date to YYYY-MM-DD format
        //                     const dateObj = new Date(data);
        //                     const formattedDate = dateObj.getFullYear() + 
        //                                         '-' + 
        //                                         String(dateObj.getMonth() + 1).padStart(2, '0') + 
        //                                         '-' + 
        //                                         String(dateObj.getDate()).padStart(2, '0');
                                                
        //                     $('#activityModal').find(`[data-bind-${index}]`).val(formattedDate).attr('value', formattedDate);
        //                 } else if (index === 'time_start_activity' || index === 'time_end_activity') {
        //                     const isoTimestamp = data;
        //                     const date = new Date(isoTimestamp);

        //                     const hours = date.getUTCHours().toString().padStart(2, '0');
        //                     const minutes = date.getUTCMinutes().toString().padStart(2, '0');

        //                     const formattedTime = `${hours}:${minutes}`;
                            
        //                     $('#activityModal').find(`[data-bind-${index}]`).val(formattedTime).attr('value', formattedTime);
        //                 } else {
        //                     $('#activityModal').find(`[data-bind-${index}]`).val(data).attr('value', data);
        //                 }
        //             });
        //         },
        //         function() {
        //             setTimeout(function() {
        //                 $('#activityModal').modal('hide');
        //             }, 1000);
        //         });
        //     }
        // });
            
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
});
</script>
@endsection