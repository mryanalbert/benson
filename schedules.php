<?php require_once './assets/header.php'; ?>
<main>
  <div class="container-fluid">
    <button class="float-end btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-sched-modal">Add schedule</button>
    <br><br>

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
                    <option value="sunday">Sunday</option>
                    <option value="monday">Monday</option>
                    <option value="tuesday">Tuesday</option>
                    <option value="wednesday">Wednesday</option>
                    <option value="thursday">Thursday</option>
                    <option value="friday">Friday</option>
                    <option value="saturday">Saturday</option>
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
    $('#add-sched-modal').modal('show')
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
            console.log(res)
            if (res == 'time error') {
              swal('error', 'Time Error!', "Start time can't be greater or equal to end time.")
            } else if (res == 'empty') {
              swal('error', 'Empty field(s)!', "Fill in the empty fields.")
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