<?php require_once './assets/header.php'; ?>
<main>
  <div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
      <div class="d-flex">
        <select name="ac-year-filter" id="ac-year-filter" class="form-select" style="width:170px;"></select>

        <select name="sem-filter" id="sem-filter" class="form-select ms-2" style="width:150px;"></select>

        <button class="btn btn-secondary ms-2" id="filter-scheds-btn">Filter</button>
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
    <div class="modal fade" id="view-sched-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h1 class="modal-title fs-5">View schedule info</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="mx-auto d-flex flex-column align-items-center">
                  <span id="view-acyear-sem">2023-2024 | Sem 1</span>
                  <img src="" alt="" class="my-1" id="view-img" style="width:230px;height:230px;">

                  <span class="fw-bold">Instructor:</span>
                  <span id="view-instructor" class="underlined">Ryan Albert Masungsong</span>

                  <span class="fw-bold mt-2">Schedule:</span>
                  <span id="view-day">Monday Thursday</span>
                  <span id="view-time">8:00am - 9:00am</span>

                  <span class="fw-bold mt-2">Room:</span>
                  <span id="view-room-bldg">CBRm4 in Cong Bingo building</span>
                  
                  <span class="fw-bold mt-2">Subject:</span>
                  <span id="view-subject">ITP112 Data Structures and Algorithms (23140000)</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Subject Modal -->
    <div class="modal fade" id="edit-sched-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h1 class="modal-title fs-5">Edit Schedule</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="edit-sched-form">
              <div class="row">
                <div class="col-md-12">
                  <input type="hidden" name="edit-sched-id" id="edit-sched-id">
                  <label class="form-label">Academic Year:</label>
                  <select name="edit-sched-ay" id="edit-sched-ay" class="form-select mb-2" required>
                    <option value="" selected disabled class="d-none">--Select Academic Year--</option>
                    <option value="2023">2023-2024</option>
                    <option value="2024">2024-2025</option>
                    <option value="2025">2025-2026</option>
                    <option value="2026">2026-2027</option>
                    <option value="2027">2027-2028</option>
                  </select>
                  
                  <label class="form-label">Semester:</label>
                  <select name="edit-sched-sem" id="edit-sched-sem" class="form-select mb-2" required>
                    <option value="" selected disabled class="d-none">--Select Semester--</option>
                    <option value="1">1st</option>
                    <option value="2">2nd</option>
                    <option value="3">3rd</option>
                    <option value="4">4th</option>
                    <option value="summer">Summer</option>
                  </select>

                  <label class="form-label">Day:</label>
                  <select name="edit-sched-day" id="edit-sched-day" class="form-select mb-2">
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
                      <input type="time" class="form-control" name="edit-start-time" id="edit-start-time" required>
                    </div>
                    <div class="col-6">
                      <label class="form-label">End time:</label>
                      <input type="time" class="form-control" name="edit-end-time" id="edit-end-time" required>
                    </div>
                  </div>

                  <label class="form-label">Subject:</label>
                  <select name="edit-sched-sub" id="edit-sched-sub" class="form-select mb-2">
                    <option value="" selected disabled class="d-none">--Select Subject--</option>
                  </select>
                  
                  <label class="form-label">Room:</label>
                  <select name="edit-sched-room" id="edit-sched-room" class="form-select mb-2">
                    <option value="" selected disabled class="d-none">--Select Room--</option>
                  </select>
                  
                  <label class="form-label">Faculty:</label>
                  <select name="edit-sched-fac" id="edit-sched-fac" class="form-select mb-3">
                    <option value="" selected disabled class="d-none">--Select Faculty--</option>
                  </select>

                  <input type="submit" value="Update schedule" id="update-sched-btn" class="btn btn-warning w-100">
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

    <!-- Filtering modal -->
    <div class="modal" id="filtering-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-0">
          <div class="modal-body text-center">
            <h2 class="text-primary mt-2 mb-3">Loading...</h2>
            <div class="spinner-border text-primary mb-2" style="width:80px;height:80px;">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p>Filtering schedules...</p>
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
            
            $('#edit-sched-sub').html(subjects)
            dselect(document.querySelector('#sched-sub'), { search: true })
          } else {
            $('#sched-sub').html(`<option>No subjects.</option>`)
            $('#edit-sched-sub').html(`<option>No subjects.</option>`)
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
            
            $('#edit-sched-room').html(rooms)
            $('#edit-sched-room').prepend(`<option value="" selected disabled class="d-none">--Select Room--</option>`)
            dselect(document.querySelector('#sched-room'), { search: true })
          } else {
            $('#edit-sched-room').html(`<option>No rooms.</option>`)
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
            
            $('#edit-sched-fac').html(faculties)
            $('#edit-sched-fac').prepend(`<option value="" selected disabled class="d-none">--Select Room--</option>`)
          } else {
            $('#sched-fac').html(`<option>No faculties.</option>`)
            $('#edit-sched-fac').html(`<option>No faculties.</option>`)
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

    function fetchSchedules(ac_year_from = $('#ac-year-filter').val(), sem = $('#sem-filter').val()) {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { 
          ac_year_from: ac_year_from,
          sem: sem,
          action: 'fetchSchedules' 
        },
        success: function(res) {
          res = JSON.parse(res)
          if (res.length > 0) {
            let output = ''

            output += `
              <table class="table table-striped table-bordered w-100" id="sched-table">
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
                    <a href="#" title="Details" class="view-sched-modal text-decoration-none" id="view-sched-${sched.sch_id}" data-bs-toggle="modal" data-bs-target="#view-sched-modal">
                      <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                    </a>
                    <a href="#" title="Edit" class="edit-sched-modal text-decoration-none" id="edit-sched-${sched.sch_id}" data-bs-toggle="modal" data-bs-target="#edit-sched-modal">
                      <i class="bi bi-pencil-square fs-5 text-warning"></i>
                    </a>
                    <a href="#" title="Delete" class="del-sched-modal" id="del-sched-${sched.sch_id}">
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
            $('#sched-table thead td').each(function() {
              let title = $(this).text()
              $(this).html(`<input type="text" placeholder="Search ${title}" class="form-control form-control-sm w-100" />`)
            })

            // DataTable
            let table = $('#sched-table').DataTable({
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
              <h4 class="text-center text-secondary fst-italic">No Schedules.</h4>
            `)
          }

          $('#filter-scheds-btn').click(function(e) {
            $('#filtering-modal').modal('show')
            fetchSchedules()
          })
          $('#filtering-modal').modal('hide')
        }
      })
    }

    $('#add-sched-btn').click(function(e) {
      if ($('#add-sched-form')[0].checkValidity()) {
        e.preventDefault()

        $(this).attr('disabled', true)
        $(this).val('Adding schedule...')

        $.ajax({
          url: 'assets/action.php',
          method: 'post',
          data: {
            'sched-ay': $('#sched-ay').val(),
            'sched-sem': $('#sched-sem').val(),
            'sched-days': $('#sched-days') ? $('#sched-days').val() : '',
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
              fetchYearsFrom()
              $('#add-sched-modal').modal('hide')
              $('#add-sched-form')[0].reset()
              swal('success', 'Added!', "Schedule successfully added.")
            } else {
              res = JSON.parse(res)
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

    $('body').on('click', '.view-sched-modal', function(e) {
      e.stopPropagation()

      let id = $(this).attr('id')
      id = id.substr(11)

      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: {
          id: id,
          action: 'view-sched'
        },
        success: function(res) {
          res = JSON.parse(res)
          console.log(res)
          let img = 'assets/img/avatar man.jpg'

          if (res.fac_img) {
            img = `assets/uploads/img/${res.fac_img}`
          } else {
            if (res.gender == 0) {
              img = 'assets/img/avatar woman.jpg'
            }
          }

          $('#view-acyear-sem').text(`${res.school_year_from}-${res.school_year_to} | Sem ${res.sem}`)
          $('#view-img').attr('src', img)
          $('#view-instructor').text(`${res.fac_fname} ${res.fac_lname}`)
          $('#view-day').text(`${res.day}`)
          $('#view-time').text(`${res.sch_time_from} - ${res.sch_time_to}`)
          $('#view-room-bldg').text(`${res.room} in ${res.bldg} building`)
          $('#view-subject').text(`${res.sub_title} ${res.sub_desc} (${res.sub_code})`)
        }
      })
    })

    $('body').on('click', '.edit-sched-modal', function(e) {
      e.stopPropagation()

      let id = $(this).attr('id')
      id = id.substr(11)

      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: {
          id: id,
          action: 'edit-sched'
        },
        success: function(res) {
          res = JSON.parse(res)
          $('#edit-sched-id').val(res.sch_id)
          $('#edit-sched-ay').val(res.school_year_from)
          $('#edit-sched-sem').val(res.sem)
          $('#edit-sched-day').val(res.day)
          $('#edit-start-time').val(res.sch_time_from)
          $('#edit-end-time').val(res.sch_time_to)
          $('#edit-sched-sub').val(res.sub_id)
          $('#edit-sched-room').val(res.ro_id)
          $('#edit-sched-fac').val(res.fac_id)
        }
      })
    })

    $('body').on('click', '.del-sched-modal', function(e) {
      e.stopPropagation()

      let id = $(this).attr('id')
      id = id.substr(10)

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'assets/action.php',
            method: 'post',
            data: {
              id: id,
              action: 'del-sched'
            },
            success: function(res) {
              if (res == 1) {
                fetchSchedules()
                swal('success', 'Deleted!', '')
              } else {
                swal('error', 'Oops!', 'Something went wrong.')
              }
            }
          })
        }
      })
    })

    $('#update-sched-btn').click(function(e) {
      if ($("#edit-sched-form")[0].checkValidity()) {
        e.preventDefault()

        $(this).attr('disabled', true)
        $(this).val('Updating schedule...')

        $.ajax({
          url: 'assets/action.php',
          method: 'post',
          data: {
            'edit-sched-id': $('#edit-sched-id').val(),
            'edit-sched-ay': $('#edit-sched-ay').val(),
            'edit-sched-sem': $('#edit-sched-sem').val(),
            'edit-sched-days': $('#edit-sched-day') ? [$('#edit-sched-day').val()] : '',
            'edit-start-time': $('#edit-start-time').val(),
            'edit-end-time': $('#edit-end-time').val(),
            'edit-sched-sub': $('#edit-sched-sub').val(),
            'edit-sched-room': $('#edit-sched-room').val(),
            'edit-sched-fac': $('#edit-sched-fac').val(),
            'action': 'updateSchedule'
          },
          success: function(res) {
            console.log(res)
            if (res == 'time error') {
              swal('error', 'Time Error!', "Start time can't be greater or equal to end time.")
            } else if (res == 'empty') {
              swal('error', 'Empty field(s)!', "Fill in the empty fields.")
            } else if (res == 1) {
              fetchYearsFrom()
              $('#edit-sched-modal').modal('hide')
              $('#edit-sched-form')[0].reset()
              swal('success', 'Updated!', "Schedule successfully updated.")
            } else {
              res = JSON.parse(res)
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
            $('#update-sched-btn').attr('disabled', false)
            $('#update-sched-btn').val('Update schedule')
          }
        })
      }
    })
    // $('#view-sched-modal').modal('show')
    new MultiSelectTag('sched-days')
  })
</script>
</body>
</html>