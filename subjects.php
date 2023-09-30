<?php require_once './assets/header.php'; ?>
<main>
<div class="container-fluid">
    <button class="float-end btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-sub-modal">Add subject</button>
    <br><br>

    <!-- Add Subject Modal -->
    <div class="modal fade" id="add-sub-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5">Add Subject</h1>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="add-sub-form">
              <div class="row">
                <div class="col-md-12">
                  <label class="form-label">Subject code:</label>
                  <input type="text" name="sub-code" id="sub-code" class="form-control mb-2" required>
                  
                  <label class="form-label">Subject title:</label>
                  <input type="text" name="sub-title" id="sub-title" class="form-control mb-3" required>
                  
                  <label class="form-label">Subject description:</label>
                  <input type="text" name="sub-desc" id="sub-desc" class="form-control mb-3" required>

                  <input type="submit" value="Add subject" id="add-sub-btn" class="btn btn-primary w-100">
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
            <span class="fs-5 text-white">Subjects</span>
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

    function fetchSubjects() {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'fetchSubjects' },
        success: function(res) {
          res = JSON.parse(res)
          if (res.length > 0) {
            let output = ''

            output += `
              <table class="table table-striped table-bordered w-100" id="sub-table">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                  <tr>
                    <td>Code</td>
                    <td>Title</td>
                    <td>Description</td>
                    <td class="d-none">Actions</td>
                  </tr>
                </thead>
                <tbody>
            `

            res.forEach(sub => {
              output += `
                <tr>
                  <td>${sub.sub_code}</td>
                  <td>${sub.sub_title}</td>
                  <td>${sub.sub_desc}</td>
                  <td>
                    <a href="#" title="Details" class="view-sub-modal text-decoration-none" id="view-sub-${sub.sub_id}" data-bs-toggle="modal" data-bs-target="#view-sub-modal">
                      <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                    </a>
                    <a href="#" title="Edit" class="edit-sub-modal text-decoration-none" id="edit-sub-${sub.sub_id}" data-bs-toggle="modal" data-bs-target="#edit-sub-modal">
                      <i class="bi bi-pencil-square fs-5 text-warning"></i>
                    </a>
                    <a href="#" title="Delete" class="del-sub-modal" id="del-sub-${sub.sub_id}">
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
            $('#sub-table thead td').each(function() {
              let title = $(this).text()
              $(this).html(`<input type="text" placeholder="Search ${title}" class="form-control w-100" />`)
            })

            // DataTable
            let table = $('#sub-table').DataTable({
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
              <h4 class="text-center text-secondary fst-italic">No Subjects.</h4>
            `)
          }
        }
      })
    }
    fetchSubjects()

    $('#add-sub-btn').click(function(e) {
      if ($('#add-sub-form')[0].checkValidity()) {
        e.preventDefault()

        $(this).prop('disabled', true)
        $(this).val('Adding subject...')

        $.ajax({
          url: 'assets/action.php',
          method: 'post',
          data: $('#add-sub-form').serialize() + '&action=addSubject',
          success: function(res) {
            console.log(res)
            if (res == 1) {
              fetchSubjects()
              $("#add-sub-form")[0].reset()
              $('#add-sub-modal').modal('hide')
              swal('success', 'Successfully Added!', '')
            } else if (res == 'exists') {
              swal('error', 'Oops!', 'Subject code is already added.')
            }
            else {
              swal('error', 'Oops!', 'Something went wrong.')
            }
            $('#add-sub-btn').prop('disabled', false)
            $('#add-sub-btn').val('Add subject')
          }
        })
      }
    })

    $('body').on('click', '.view-sub-modal', function(e) {
      let id = $(this).attr('id')
      id = id.substr(9)
      
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'viewSubject', id: id },
        success: function(res) {
          res = JSON.parse(res)
          $('#view-sub-code').text(res.sub_code)
          $('#view-sub-title').text(res.sub_title)
          $('#view-sub-desc').text(res.sub_desc)
        }
      })
    })

    $('body').on('click', '.edit-sub-modal', function(e) {
      let id = $(this).attr('id')
      id = id.substr(9)
      
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'editSubject', id: id },
        success: function(res) {
          res = JSON.parse(res)
          $('#edit-sub-id').val(res.sub_id)
          $('#edit-sub-code').val(res.sub_code)
          $('#edit-sub-title').val(res.sub_title)
          $('#edit-sub-desc').val(res.sub_desc)
        }
      })
    })

    $('#update-sub-btn').click(function(e) {
      if ($('#edit-sub-form')[0].checkValidity()) {
        e.preventDefault()

        $(this).prop('disabled', true)
        $(this).val('Updating subject...')

        $.ajax({
          url: 'assets/action.php',
          method: 'post',
          data: $('#edit-sub-form').serialize() + '&action=updateSubject',
          success: function(res) {
            console.log(res)
            if (res == 1) {
              fetchSubjects()
              $('#edit-sub-modal').modal('hide')
              swal('success', 'Successfully updated!', '')
            } else {
              swal('success', 'Oops!', 'Something went wrong, try again.')
            }
            $('#update-sub-btn').prop('disabled', false)
            $('#update-sub-btn').val('Update subject')
            $('#edit-sub-form')[0].reset()
          }
        })
      }
    })

    $('body').on('click', '.del-sub-modal', function(e) {
      let id = $(this).attr('id')
      id = id.substr(8)

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
            data: { action: 'delSubject', id: id },
            success: function(res) {
              if (res == 1) {
                fetchSubjects()
                swal('success', 'Deleted!', '')
              } else if (res == 'used') {
                swal('error', 'Oops!', 'Subject data is being used in the schedule.')
              }else {
                swal('error', 'Oops!', 'Something went wrong.')
              }
            }
          })
        }
      })
    })
  })
</script>
</body>
</html>