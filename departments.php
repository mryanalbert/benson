<?php require_once './assets/header.php'; ?>
<main>
  <div class="container-fluid">
    <button class="float-end btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-dep-modal">Add Department</button>
    <br><br>

    <!-- Add Department Modal -->
    <div class="modal fade" id="add-dep-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5">Add Department</h1>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="add-dep-form">
              <div class="row">
                <div class="col-md-12">
                  <label class="form-label">Department name:</label>
                  <input type="text" name="dep-name" id="dep-name" class="form-control mb-2" required>
                  
                  <label class="form-label">Department Description:</label>
                  <input type="text" name="dep-desc" id="dep-desc" class="form-control mb-3" required>

                  <input type="submit" value="Add Department" id="add-dep-btn" class="btn btn-primary w-100">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Department Modal -->
    <div class="modal fade" id="edit-dep-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h1 class="modal-title fs-5">Edit Department</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="edit-dep-form">
              <div class="row">
                <div class="col-md-12">
                  <input type="hidden" name="edit-dep-id" id="edit-dep-id">
                  <label class="form-label">Department name:</label>
                  <input type="text" name="edit-dep-name" id="edit-dep-name" class="form-control mb-2" required>
                  
                  <label class="form-label">Department Description:</label>
                  <input type="text" name="edit-dep-desc" id="edit-dep-desc" class="form-control mb-3" required>

                  <input type="submit" value="Update Department" id="update-dep-btn" class="btn btn-warning w-100">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- View Faculty Modal -->
    <div class="modal fade" id="view-dep-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h1 class="modal-title fs-5">View department info</h1>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="mx-auto d-flex flex-column align-items-center">
                  <span class="mb-1">
                    Department:
                    <span class="fw-bold" id="view-dep-name"></span>
                  </span>

                  <span class="mb-1">
                    Description:
                    <span class="fw-bold" id="view-dep-desc"></span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card rounded-0 shadow-sm">
          <div class="card-header bg-primary rounded-0">
            <span class="fs-5 text-white">Departments</span>
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

    function fetchDeps() {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'fetchDeps' },
        success: function(res) {
          res = JSON.parse(res)
          if (res.length > 0) {
            let output = ''

            output += `
              <table class="table table-striped table-bordered w-100" id="department-table">
                <thead>
                  <tr>
                    <th>Department</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                  <tr>
                    <td>Department</td>
                    <td>Description</td>
                    <td class="d-none">Actions</td>
                  </tr>
                </thead>
                <tbody>
            `

            res.forEach(dep => {
              output += `
                <tr>
                  <td>${dep.dep_name}</td>
                  <td>${dep.dep_desc}</td>
                  <td>
                    <a href="#" title="Details" class="view-dep-modal text-decoration-none" id="view-dep-${dep.dep_id}" data-bs-toggle="modal" data-bs-target="#view-dep-modal">
                      <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                    </a>
                    <a href="#" title="Edit" class="edit-dep-modal text-decoration-none" id="edit-dep-${dep.dep_id}" data-bs-toggle="modal" data-bs-target="#edit-dep-modal">
                      <i class="bi bi-pencil-square fs-5 text-warning"></i>
                    </a>
                    <a href="#" title="Delete" class="del-dep-modal" id="del-dep-${dep.dep_id}">
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
            $('#department-table thead td').each(function() {
              let title = $(this).text()
              $(this).html(`<input type="text" placeholder="Search ${title}" class="form-control w-100" />`)
            })

            // DataTable
            let table = $('#department-table').DataTable({
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
              <h4 class="text-center text-secondary fst-italic">No Deparments.</h4>
            `)
          }
        }
      })
    }
    fetchDeps()

    $('#add-dep-btn').click(function(e) {
      if ($("#add-dep-form")[0].checkValidity()) {
        e.preventDefault()

        $(this).prop('disabled', true)
        $(this).val('Adding department...')

        $.ajax({
          url: 'assets/action.php',
          method: 'post',
          data: $("#add-dep-form").serialize() + '&action=addDep',
          success: function(res) {
            if (res == 'true') {
              $("#add-dep-form")[0].reset()
              $('#add-dep-modal').modal('hide')
              swal('success', 'Successfully Added!', '')
              fetchDeps()
            } else {
              swal('error', 'Oops!', 'Something went wrong.')
            }
            $('#add-dep-btn').prop('disabled', false)
            $('#add-dep-btn').val('Add department')
          }
        })
      }
    })

    $('body').on('click', '.view-dep-modal', function(e) {
      let id = $(this).attr('id')
      id = id.substr(9)
      
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { 
          action: 'fetchDep',
          id: id
         },
        success: function(res) {
          res = JSON.parse(res)
          if (res) {
            $('#view-dep-name').text(res.dep_name)
            $('#view-dep-desc').text(res.dep_desc)
          } else {
            swal('error', 'Oops!', 'Something went wrong.')
          }
        }
      })
    })

    $('body').on('click', '.edit-dep-modal', function(e){
      let id = $(this).attr('id')
      id = id.substr(9)

      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'editDep', id: id },
        success: function(res) {
          res = JSON.parse(res)
          if (res) {
            $('#edit-dep-id').val(res.dep_id)
            $('#edit-dep-name').val(res.dep_name)
            $('#edit-dep-desc').val(res.dep_desc)
          } else {
            swal('error', 'Oops!', 'Something went wrong.')
          }
        }
      })
    })

    $('#update-dep-btn').click(function(e) {
      if ($('#edit-dep-form')[0].checkValidity()) {
        e.preventDefault()

        $(this).prop('disabled', true)
        $(this).val('Updating department...')

        $.ajax({
          url: 'assets/action.php',
          method: 'post',
          data: $('#edit-dep-form').serialize() + '&action=updateDep',
          success: function(res) {
            if (res) {
              fetchDeps()
              $('#edit-dep-form')[0].reset()
              $('#edit-dep-modal').modal('hide')
              swal('success', 'Updated!', '')
            } else {
              swal('error', 'Oops!', 'Something went wrong.')
            }
            $('#update-dep-btn').prop('disabled', false)
            $('#update-dep-btn').val('Update department')
          }
        })
      }
    })

    $('body').on('click', '.del-dep-modal', function(e) {
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
            data: { action: 'delDep', id: id },
            success: function(res) {
              if (res == 1) {
                fetchDeps()
                swal('success', 'Deleted!', '')
              } else if (res == 'used') {
                swal('error', 'Oops!', 'Department data is being used by a faculty.')
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