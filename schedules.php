<?php require_once './assets/header.php'; ?>
<main>
  <div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
      <div class="d-flex">
        <select name="ac-year-filter" id="ac-year-filter" class="form-select" style="width:170px;"></select>

        <select name="sem-filter" id="sem-filter" class="form-select ms-2" style="width:150px;"></select>

        <button class="btn btn-secondary ms-2">Filter</button>
      </div>

      <button class="float-end btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-sched-modal">Add schedule</button>
    </div>

    <!-- Add Schedule Modal -->
    <div class="modal fade" id="add-sched-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5">Add Schedule</h1>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="add-sched-form">
              <div class="row">
                <div class="col-md-12">
                  <label class="form-label">Academic Year:</label>
                  <select name="sched-ay" id="sched-ay" class="form-select mb-2" required>
                    <option value="" selected disabled class="d-none">--Select Academic Year--</option>
                    <option value="2023">2023-2024</option>
                    <option value="2024">2024-2025</option>
                    <option value="2025">2025-2026</option>
                    <option value="2026">2026-2027</option>
                    <option value="2027">2027-2028</option>
                  </select>
                  
                  <label class="form-label">Semester:</label>
                  <select name="sched-sem" id="sched-sem" class="form-select mb-2" required>
                    <option value="" selected disabled class="d-none">--Select Semester--</option>
                    <option value="1">1st</option>
                    <option value="2">2nd</option>
                    <option value="3">3rd</option>
                    <option value="4">4th</option>
                    <option value="summer">Summer</option>
                  </select>

                  <label class="form-label">Days:</label>
                  <select name="sched-days[]" multiple id="sched-days" class="form-select mb-2">
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                  </select>
                  
                  <div class="row my-2">
                    <div class="col-6">
                      <label class="form-label">Start time:</label>
                      <input type="time" class="form-control" name="start-time" id="start-time" required>
                    </div>
                    <div class="col-6">
                      <label class="form-label">End time:</label>
                      <input type="time" class="form-control" name="end-time" id="end-time" required>
                    </div>
                  </div>

                  <label class="form-label">Subject:</label>
                  <select name="sched-sub" id="sched-sub" class="form-select mb-2">
                    <option value="" selected disabled class="d-none">--Select Subject--</option>
                    <option value="">HTML</option>
                  </select>
                  
                  <label class="form-label">Room:</label>
                  <select name="sched-room" id="sched-room" class="form-select mb-2">
                    <option value="" selected disabled class="d-none">--Select Room--</option>
                  </select>
                  
                  <label class="form-label">Faculty:</label>
                  <select name="sched-fac" id="sched-fac" class="form-select mb-3">
                    <option value="" selected disabled class="d-none">--Select Faculty--</option>
                  </select>

                  <input type="submit" value="Add schedule" id="add-sched-btn" class="btn btn-primary w-100">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- View Subject Modal -->
    <div class="modal fade" id="view-sub-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h1 class="modal-title fs-5">View subject info</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="mx-auto d-flex flex-column align-items-center">
                  <span class="mb-1">
                    Code:
                    <span class="fw-bold" id="view-sub-code"></span>
                  </span>

                  <span class="mb-1">
                    Title:
                    <span class="fw-bold" id="view-sub-title"></span>
                  </span>

                  <span class="mb-1">
                    Description:
                    <span class="fw-bold" id="view-sub-desc"></span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Subject Modal -->
    <div class="modal fade" id="edit-sub-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h1 class="modal-title fs-5">Edit Subject</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="edit-sub-form">
              <div class="row">
                <div class="col-md-12">
                  <input type="hidden" name="edit-sub-id" id="edit-sub-id">
                  <label class="form-label">Subject code:</label>
                  <input type="text" name="edit-sub-code" id="edit-sub-code" class="form-control mb-2" required>
                  
                  <label class="form-label">Subject title:</label>
                  <input type="text" name="edit-sub-title" id="edit-sub-title" class="form-control mb-3" required>
                  
                  <label class="form-label">Subject description:</label>
                  <input type="text" name="edit-sub-desc" id="edit-sub-desc" class="form-control mb-3" required>

                  <input type="submit" value="Update subject" id="update-sub-btn" class="btn btn-warning w-100">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Conflict Schedules Modal -->
    <div class="modal fade" id="conflict-sched-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h1 class="modal-title fs-5">Conflict Schedules</h1>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body table-responsive">
            <table class="table table-striped table-bordered table-responsive">
              <thead>
                <tr>
                  <th>Academic Year</th>
                  <th>Semester</th>
                  <th>Day</th>
                  <th>Time</th>
                  <th>Room</th>
                  <th>Subject</th>
                  <th>Instructor</th>
                </tr>
              </thead>
              <tbody id="modal-conflict-body">
                <tr>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card rounded-0 shadow-sm">
          <div class="card-header bg-primary rounded-0">
            <span class="fs-5 text-white">Schedules</span>
          </div>
          <div class="card-body rounded-0" id="data-wrapper">
            <div class="d-flex align-items-center justify-content-center">
              <div class="spinner-border text-secondary" role="status"></div>
              <h2 class="text-secondary ms-2">Loading...</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>
<?php require_once './assets/footer.php'; ?>
<script>
  $(document).ready(function() {
    // $('#add-sched-modal').modal('show')
    function swal(icon, title, text) {
      Swal.fire({
        icon: icon,
        title: title,
        text: text,
      })
    }

    function fetchSubjects() {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'fetchSubjects' },
        success: function(res) {
          res = JSON.parse(res)
          if (res.length > 0) {
            let subjects = res.map(sub => {
              return `<option value="${sub.sub_id}">${sub.sub_title}-${sub.sub_desc} (${sub.sub_code})</option>`
            })
            subjects = subjects.join('')
            $('#sched-sub').html(subjects)
            $('#sched-sub').prepend(`<option value="" selected disabled class="d-none">--Select Subject--</option>`)
            dselect(document.querySelector('#sched-sub'), { search: true })
          } else {
            $('#sched-sub').html(`<option>No subjects.</option>`)
          }
        }
      })
    }
    fetchSubjects()

    function fetchRooms() {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'fetchRooms' },
        success: function(res) {
          res = JSON.parse(res)
          if (res.length > 0) {
            let rooms = res.map(room => {
              return `<option value="${room.ro_id}">${room.room} in ${room.bldg} bldg.</option>`
            })
            rooms = rooms.join('')
            $('#sched-room').html(rooms)
            $('#sched-room').prepend(`<option value="" selected disabled class="d-none">--Select Room--</option>`)
            dselect(document.querySelector('#sched-room'), { search: true })
          } else {
            $('#sched-room').html(`<option>No rooms.</option>`)
          }
        }
      })
    }
    fetchRooms()

    function fetchFaculties() {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'fetchFaculties' },
        success: function(res) {
          res = JSON.parse(res)
          // console.log(res)
          if (res.length > 0) {
            let faculties = res.map(fac => {
              return `<option value="${fac.fac_id}">${fac.fac_fname} ${fac.fac_mname ? `${fac.fac_mname[0]}.` : ''} ${fac.fac_lname}</option>`
            })
            faculties = faculties.join('')
            $('#sched-fac').html(faculties)
            $('#sched-fac').prepend(`<option value="" selected disabled class="d-none">--Select Room--</option>`)
            dselect(document.querySelector('#sched-fac'), { search: true })
          } else {
            $('#sched-fac').html(`<option>No faculties.</option>`)
          }
        }
      })
    }
    fetchFaculties()

    function fetchYearsFrom() {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'fetchYearsFrom' },
        success: function(res) {
          res = JSON.parse(res)
          let yearsFrom = res.map(year => {
            return `<option value="${year.school_year_from}">
              A.Y. ${year.school_year_from}-${year.school_year_from + 1}
            </option>`
          })
          yearsFrom = yearsFrom.join('')
          $('#ac-year-filter').html(yearsFrom)
          fetchSems()
        }
      })
    }
    fetchYearsFrom()
    
    function fetchSems() {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'fetchSems' },
        success: function(res) {
          res = JSON.parse(res)
          let sems = res.map(sem => {
            return `<option value="${sem.sem}">Sem ${sem.sem}</option>`
          })
          sems = sems.join('')
          $('#sem-filter').html(sems)
          fetchCurrent()
        }
      })
    }

    function fetchCurrent() {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'fetchCurrent' },
        success: function(res) {
          res = JSON.parse(res)
          $('#ac-year-filter').val(res.cur_ay_from)
          $('#sem-filter').val(res.cur_sem)
          fetchSchedules()
        }
      })
    }

    function fetchSchedules() {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { 
          ac_year_from: $('#ac-year-filter').val(),
          sem: $('#sem-filter').val(),
          action: 'fetchSchedules' 
        },
        success: function(res) {
          res = JSON.parse(res)
          console.log(res)
          if (res.length > 0) {
            let output = ''

            output += `
              <table class="table table-striped table-bordered w-100" id="room-table">
                <thead>
                  <tr>
                    <th>Academic Year</th>
                    <th>Semester</th>
                    <th>Day</th>
                    <th>Time start</th>
                    <th>Time end</th>
                    <th>Room</th>
                    <th>Subject</th>
                    <th>Instructor</th>
                    <th>Actions</th>
                  </tr>
                  <tr>
                    <td>Academic Year</td>
                    <td>Semester</td>
                    <td>Day</td>
                    <td>Time start</td>
                    <td>Time end</td>
                    <td>Room</td>
                    <td>Subject</td>
                    <td>Instructor</td>
                    <td class="d-none">Actions</td>
                  </tr>
                </thead>
                <tbody>
            `

            res.forEach(sched => {
              output += `
                <tr>
                  <td>${sched.school_year_from}-${sched.school_year_to}</td>
                  <td>${sched.sem}</td>
                  <td>${sched.day}</td>
                  <td>${sched.sch_time_from}</td>
                  <td>${sched.sch_time_to}</td>
                  <td>${sched.room}</td>
                  <td>${sched.sub_title} (${sched.sub_code})</td>
                  <td>${sched.fac_fname} ${sched.fac_lname}</td>
                  <td>
                    <a href="#" title="Details" class="view-room-modal text-decoration-none" id="view-room-${sched.ro_id}" data-bs-toggle="modal" data-bs-target="#view-room-modal">
                      <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                    </a>
                    <a href="#" title="Edit" class="edit-room-modal text-decoration-none" id="edit-room-${sched.ro_id}" data-bs-toggle="modal" data-bs-target="#edit-room-modal">
                      <i class="bi bi-pencil-square fs-5 text-warning"></i>
                    </a>
                    <a href="#" title="Delete" class="del-room-modal" id="del-room-${sched.ro_id}">
                      <i class="bi bi-trash-fill fs-5 text-danger"></i>
                    </a>
                  </td>
                </tr>
              `
            })
            
            output += `
                </tbody>
              </table
            `
            $("#data-wrapper").html(output)

            // Setup - add a text input to each footer cell
            $('#room-table thead td').each(function() {
              let title = $(this).text()
              $(this).html(`<input type="text" placeholder="Search ${title}" class="form-control form-control-sm w-100" />`)
            })

            // DataTable
            let table = $('#room-table').DataTable({
              initComplete: function() {
                // Apply the search
                this.api().columns().every(function() {
                  let that = this
                  
                  $('input', this.header()).on('keyup change clear', function() {
                    if (that.search() !== this.value) {
                      that
                        .search(this.value)
                        .draw()
                    }
                  })
                })
              }
            })
          } else {
            $("#data-wrapper").html(`
              <h4 class="text-center text-secondary fst-italic">No Rooms.</h4>
            `)
          }
        }
      })
    }

    $('#add-sched-btn').click(function(e) {
      if ($('#add-sched-form')[0].checkValidity()) {
        e.preventDefault()

        $('#add-sched-btn').attr('disabled', true)
        $(this).val('Adding schedule...')

        $.ajax({
          url: 'assets/action.php',
          method: 'post',
          data: {
            'sched-ay': $('#sched-ay').val(),
            'sched-sem': $('#sched-sem').val(),
            'sched-days': $('#sched-days') ? $('#sched-days').val() : $('#sched-days').val(3),
            'start-time': $('#start-time').val(),
            'end-time': $('#end-time').val(),
            'sched-sub': $('#sched-sub').val(),
            'sched-room': $('#sched-room').val(),
            'sched-fac': $('#sched-fac').val(),
            'action': 'addSchedule'
          },
          success: function(res) {
            if (res == 'time error') {
              swal('error', 'Time Error!', "Start time can't be greater or equal to end time.")
            } else if (res == 'empty') {
              swal('error', 'Empty field(s)!', "Fill in the empty fields.")
            } else if (res == 1) {
              fetchSchedules()
              $('#add-sched-modal').modal('hide')
              $('#add-sched-form')[0].reset()
              swal('success', 'Added!', "Schedule successfully added.")
            } else {
              res = JSON.parse(res)
              console.log(res)
              let conflicts = res.map(con => {
                return `<tr>
                  <td>${con.school_year_from}-${con.school_year_to}</td>
                  <td>${con.sem}</td>
                  <td>${con.day}</td>
                  <td>${con.sch_time_from} - ${con.sch_time_to}</td>
                  <td>${con.room} - ${con.bldg} bldg</td>
                  <td>${con.sub_title} ${con.sub_desc} (${con.sub_code})</td>
                  <td>${con.fac_fname} ${con.fac_lname}</td>
                </tr>`
              })
              conflicts = conflicts.join('')
              $('#modal-conflict-body').html(conflicts)
              $('#conflict-sched-modal').modal('show')
            }
            $('#add-sched-btn').attr('disabled', false)
            $('#add-sched-btn').val('Add schedule')
          }
        })
      }
    })

    new MultiSelectTag('sched-days')
  })
</script>
</body>
</html>