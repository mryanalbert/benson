<?php require_once './assets/header.php'; ?>
<main>
  <div class="container-fluid">
    <button class="float-end btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-faculty-modal">Add faculty</button>
    <br><br>

    <!-- Add Faculty Modal -->
    <div class="modal fade" id="add-faculty-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5">Add faculty</h1>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="add-faculty-form">
              <div class="row">
                <div class="col-md-12">
                  <label class="form-label">First name:</label>
                  <input type="text" name="fname" id="fname" class="form-control mb-2" required>
                  
                  <label class="form-label">Middle name:</label>
                  <input type="text" name="mname" id="mname" class="form-control mb-2">
                  
                  <label class="form-label">Last name:</label>
                  <input type="text" name="lname" id="lname" class="form-control mb-2" required>
                  
                  <label class="form-label">Department:</label>
                  <select class="form-select mb-3" name="dep" id="dep" required>
                    <option selected disabled value="">--Select Department--</option>
                  </select>
                </div>
              </div>
              <div class="row h-100 align-items-center mb-3">
                <div class="col-md-6">
                  <div class="d-flex flex-column justify-content-between">
                    <label class="form-label">Gender:</label>
                    <select class="form-select mb-2 form-select-sm" name="gen" id="gen" required>
                      <option value="1">Male</option>
                      <option value="0">Female</option>
                    </select>

                    <label class="form-label">Image:</label>
                    <input type="file" name="img" id="img" class="form-control form-control-sm" accept="image/*">
                  </div>
                </div>
                <div class="col-md-6">
                  <img src="./assets/img/avatar man.jpg" alt="image output" id="img-preview" class="ms-auto img-thumbnail img-fluid" style="width:200px;height:200px;object-fit:cover;">
                </div>
              </div>
              <input type="submit" value="Add faculty" id="add-faculty-btn" class="btn btn-primary w-100">
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- View Faculty Modal -->
    <div class="modal fade" id="view-faculty-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h1 class="modal-title fs-5">View faculty info</h1>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="mx-auto d-flex flex-column align-items-center">
                  <img src="./assets/img/avatar man.jpg" alt="image pic" id="view-img" class="img-fluid img-thumbnail mb-3" style="object-fit:cover;width:330px;height:330px">
                  <span class="mb-1">
                    First name:
                    <span class="fw-bold" id="view-fname">Ryan Albert</span>
                  </span>

                  <span class="mb-1">
                    Middle name:
                    <span class="fw-bold" id="view-mname">Sulapas</span>
                  </span>
                  
                  <span class="mb-1">
                    Last name:
                    <span class="fw-bold" id="view-lname">Masungsong</span>
                  </span>

                  <span class="mb-4">
                    Gender:
                    <span class="fw-bold" id="view-gender">Male</span>
                  </span>

                  <small class="fw-bold" id="view-dep">College of Information Technology</small>
                  <small class="fw-bold" id="view-desc"></small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Faculty Modal -->
    <div class="modal fade" id="edit-faculty-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h1 class="modal-title fs-5">Update faculty</h1>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="edit-faculty-form">
              <div class="row">
                <div class="col-md-12">
                  <input type="hidden" name="edit-id" id="edit-id">
                  <label class="form-label">First name:</label>
                  <input type="text" name="edit-fname" id="edit-fname" class="form-control mb-2" required>
                  
                  <label class="form-label">Middle name:</label>
                  <input type="text" name="edit-mname" id="edit-mname" class="form-control mb-2">
                  
                  <label class="form-label">Last name:</label>
                  <input type="text" name="edit-lname" id="edit-lname" class="form-control mb-2" required>
                  
                  <label class="form-label">Department:</label>
                  <select class="form-select mb-3" name="edit-dep" id="edit-dep" required>
                    <option selected disabled value="">--Select Department--</option>
                  </select>
                </div>
              </div>
              <div class="row h-100 align-items-center mb-3">
                <div class="col-md-6">
                  <div class="d-flex flex-column justify-content-between">
                    <label class="form-label">Gender:</label>
                    <select class="form-select mb-2 form-select-sm" name="edit-gen" id="edit-gen" required>
                      <option value="1">Male</option>
                      <option value="0">Female</option>
                    </select>

                    <label class="form-label">Image:</label>
                    <input type="file" name="edit-img" id="edit-img" class="form-control form-control-sm" accept="image/*">
                  </div>
                </div>
                <div class="col-md-6">
                  <img src="./assets/img/avatar man.jpg" alt="image output" id="edit-img-preview" class="ms-auto img-thumbnail img-fluid" style="width:200px;height:200px;object-fit:cover;">
                </div>
              </div>
              <input type="submit" value="Update faculty" id="edit-faculty-btn" class="btn btn-warning w-100">
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card rounded-0 shadow-sm">
          <div class="card-header bg-primary rounded-0">
            <span class="fs-5 text-white">Faculties</span>
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
    function swal(icon, title, text) {
      Swal.fire({
        icon: icon,
        title: title,
        text: text,
      })
    }

    function fetchFaculties() {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'fetchFaculties' },
        success: function(res) {
          res = JSON.parse(res)
          if (res.length > 0) {
            let output = ''

            output += `
              <table class="table table-striped table-bordered w-100" id="faculty-table">
                <thead>
                  <tr>
                    <th>First name</th>
                    <th>Middle name</th>
                    <th>Last name</th>
                    <th>Department</th>
                    <th>Gender</th>
                    <th>Actions</th>
                  </tr>
                  <tr>
                    <td>First name</td>
                    <td>Middle name</td>
                    <td>Last name</td>
                    <td>Department</td>
                    <td>Gender</td>
                    <td class="d-none">Actions</td>
                  </tr>
                </thead>
                <tbody>
            `

            res.forEach(faculty => {
              output += `
                <tr>
                  <td>${faculty.fac_fname}</td>
                  <td>${faculty.fac_mname}</td>
                  <td>${faculty.fac_lname}</td>
                  <td>${faculty.dep_desc} (${faculty.dep_name})</td>
                  <td>${faculty.gender == 1 ? 'Male' : 'Female'}</td>
                  <td>
                    <a href="#" title="Details" class="view-faculty-modal text-decoration-none" id="view-faculty-${faculty.fac_id}" data-bs-toggle="modal" data-bs-target="#view-faculty-modal">
                      <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                    </a>
                    <a href="#" title="Edit" class="edit-faculty-modal text-decoration-none" id="edit-faculty-${faculty.fac_id}" data-bs-toggle="modal" data-bs-target="#edit-faculty-modal">
                      <i class="bi bi-pencil-square fs-5 text-warning"></i>
                    </a>
                    <a href="#" title="Delete" class="del-faculty-modal text-decoration-none" id="del-faculty-${faculty.fac_id}">
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
            $('#faculty-table thead td').each(function() {
              let title = $(this).text()
              $(this).html(`<input type="text" placeholder="Search ${title}" class="form-control form-control-sm w-100" />`)
            })

            // DataTable
            let table = $('#faculty-table').DataTable({
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
              <h4 class="text-center text-secondary fst-italic">No faculties.</h4>
            `)
          }
        }
      })
    }
    fetchFaculties()

    function imgPreview(img, imgPreview) {
      img.change(function() {
        let [file] = this.files
        if (file) {
          imgPreview.attr('src', URL.createObjectURL(file))
        }
      })
    }
    imgPreview($('#img'), $('#img-preview'))
    imgPreview($('#edit-img'), $('#edit-img-preview'))

    $('#gen').change(function() {
      if (!$('#img').val()) {
        if ($('#gen').val() == '1') {
          $('#img-preview').attr('src', './assets/img/avatar man.jpg')
        } else {
          $('#img-preview').attr('src', './assets/img/avatar woman.jpg')
        }
      }
    })


    $('#add-faculty-btn').click(function(e) {
      if ($('#add-faculty-form')[0].checkValidity()) {
        e.preventDefault()

        $(this).prop('disabled', true)
        $(this).val('Adding faculty...')

        data = new FormData($('#add-faculty-form')[0])
        data.append('action', 'addFaculty')

        $.ajax({
          url: 'assets/action.php',
          method: 'post',
          processData: false,
          contentType: false,
          cache: false,
          data: data,
          success: function(res) {
            if (res) {
              fetchFaculties()
              $('#add-faculty-modal').modal('hide')
              swal('success', 'Successfully added!', '')
            } else {
              swal('success', 'Oops!', 'Something went wrong, try again.')
            }
            $('#add-faculty-btn').prop('disabled', false)
            $('#add-faculty-btn').val('Add faculty')
            $('#add-faculty-form')[0].reset()
          }
        })
      }
    })

    $('body').on('click', '.view-faculty-modal', function(e) {
      id = $(this).attr('id')
      id = id.substr(13)

      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { 
          id: id,
          action: 'viewFaculty',
        },
        success: function(res) {
          if (res) {
            res = JSON.parse(res)
            let img = 'assets/img/avatar man.jpg'

            if (res.fac_img) {
              img = `assets/uploads/img/${res.fac_img}`
            } else {
              if (!res.gender) {
                img = 'assets/img/avatar woman.jpg'
              }
            }

            $('#view-img').prop('src', img)
            $('#view-fname').text(`${res.fac_fname}`)
            $('#view-mname').text(`${res.fac_mname}`)
            $('#view-lname').text(`${res.fac_lname}`)
            $('#view-gender').text(`${res.gender == 1 ? 'Male' : 'Female'}`)
            $('#view-dep').text(`${res.dep_name}`)
            $('#view-desc').text(`${res.dep_desc}`)
          }
        }
      })
    })

    function fetchDeps() {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'fetchDeps' },
        success: function(res) {
          res = JSON.parse(res)
          if (res.length > 0) {
            let deps = res.map(dep => `<option value="${dep.dep_id}">${dep.dep_desc} (${dep.dep_name})</option>`)
            deps = deps.join('')
            $('#edit-dep').html(deps)
            $('#edit-dep').prepend(`<option selected disabled value="">--Select Department--</option>`)
            $('#dep').html(deps)
            $('#dep').prepend(`<option selected disabled value="">--Select Department--</option>`)
          } else {
            $('#edit-dep').html(`<option value="">No any departments.</option>`)
            $('#dep').html(`<option value="">No any departments.</option>`)
          }
        }
      })
    }
    fetchDeps()

    $('body').on('click', '.edit-faculty-modal', function(e) {
      let id = $(this).attr('id')
      id = id.substr(13)
      
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'editFaculty', id: id },
        success: function(res) {
          res = JSON.parse(res)
          let img = 'assets/img/avatar man.jpg'

          if (res.fac_img) {
            img = `assets/uploads/img/${res.fac_img}`
          } else {
            if (res.gender == 0) {
              img = 'assets/img/avatar woman.jpg'
            }
          }
          $('#edit-id').val(res.fac_id)
          $('#edit-fname').val(res.fac_fname)
          $('#edit-mname').val(res.fac_mname)
          $('#edit-lname').val(res.fac_lname)
          $('#edit-dep').val(res.dep_id)
          $('#edit-gen').val(res.gender)
          $('#edit-img-preview').attr('src', img)
        }
      })
    })

    $('body').on('click', '.del-faculty-modal', function(e) {
      let id = $(this).attr('id')
      id = id.substr(12)

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
            data: { action: 'delFaculty', id: id },
            success: function(res) {
              if (res == 1) {
                fetchFaculties()
                swal('success', 'Deleted!', '')
              } else if (res == 'used') {
                swal('error', 'Oops!', 'This faculty has a schedule.')
              } else {
                swal('error', 'Oops!', 'Something went wrong, try agin.')
              }
              console.log(res)
            }
          })
        }
      })
    })
    
    $('#edit-faculty-btn').click(function(e) {
      if ($('#edit-faculty-form')[0].checkValidity()) {
        e.preventDefault()

        $(this).prop('disabled', true)
        $(this).val('Updating faculty...')

        data = new FormData($('#edit-faculty-form')[0])
        data.append('action', 'updateFaculty')

        $.ajax({
          url: 'assets/action.php',
          method: 'post',
          processData: false,
          contentType: false,
          cache: false,
          data: data,
          success: function(res) {
            if (res) {
              fetchFaculties()
              $('#edit-faculty-modal').modal('hide')
              swal('success', 'Successfully updated!', '')
            } else {
              swal('success', 'Oops!', 'Something went wrong, try again.')
            }
            $('#edit-faculty-btn').prop('disabled', false)
            $('#edit-faculty-btn').val('Update faculty')
            $('#edit-faculty-form')[0].reset()
          }
        })
      }
    })

  })
</script>
</body>
</html>