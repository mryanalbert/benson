<?php require_once './assets/header.php'; ?>
<main>
  <div class="container-fluid">
    <button class="float-end btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-room-modal">Add Room</button>
    <br><br>

    <!-- Add Room Modal -->
    <div class="modal fade" id="add-room-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5">Add Room</h1>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="add-room-form">
              <div class="row">
                <div class="col-md-12">
                  <label class="form-label">Room name:</label>
                  <input type="text" name="room-name" id="room-name" class="form-control mb-2" required>
                  
                  <label class="form-label">Room building:</label>
                  <input type="text" name="room-bldg" id="room-bldg" class="form-control mb-3" required>

                  <input type="submit" value="Add Room" id="add-room-btn" class="btn btn-primary w-100">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- View Faculty Modal -->
    <div class="modal fade" id="view-room-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h1 class="modal-title fs-5">View room info</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="mx-auto d-flex flex-column align-items-center">
                  <span class="mb-1">
                    Room:
                    <span class="fw-bold" id="view-room-name"></span>
                  </span>

                  <span class="mb-1">
                    Building:
                    <span class="fw-bold" id="view-room-bldg"></span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal fade" id="edit-room-modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h1 class="modal-title fs-5">Edit Room</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="edit-room-form">
              <div class="row">
                <div class="col-md-12">
                  <input type="hidden" name="edit-room-id" id="edit-room-id">
                  <label class="form-label">Room name:</label>
                  <input type="text" name="edit-room-name" id="edit-room-name" class="form-control mb-2" required>
                  
                  <label class="form-label">Room Building:</label>
                  <input type="text" name="edit-room-bldg" id="edit-room-bldg" class="form-control mb-3" required>

                  <input type="submit" value="Update Room" id="update-room-btn" class="btn btn-warning w-100">
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
            <span class="fs-5 text-white">Rooms</span>
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

    function fetchRooms() {
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'fetchRooms' },
        success: function(res) {
          res = JSON.parse(res)
          if (res.length > 0) {
            let output = ''

            output += `
              <table class="table table-striped table-bordered w-100" id="room-table">
                <thead>
                  <tr>
                    <th>Room</th>
                    <th>Building</th>
                    <th>Actions</th>
                  </tr>
                  <tr>
                    <td>Room</td>
                    <td>Building</td>
                    <td class="d-none">Actions</td>
                  </tr>
                </thead>
                <tbody>
            `

            res.forEach(room => {
              output += `
                <tr>
                  <td>${room.room}</td>
                  <td>${room.bldg}</td>
                  <td>
                    <a href="#" title="Details" class="view-room-modal text-decoration-none" id="view-room-${room.ro_id}" data-bs-toggle="modal" data-bs-target="#view-room-modal">
                      <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                    </a>
                    <a href="#" title="Edit" class="edit-room-modal text-decoration-none" id="edit-room-${room.ro_id}" data-bs-toggle="modal" data-bs-target="#edit-room-modal">
                      <i class="bi bi-pencil-square fs-5 text-warning"></i>
                    </a>
                    <a href="#" title="Delete" class="del-room-modal" id="del-room-${room.ro_id}">
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
              $(this).html(`<input type="text" placeholder="Search ${title}" class="form-control w-100" />`)
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
    fetchRooms()

    $('#add-room-btn').click(function(e) {
      if ($('#add-room-form')[0].checkValidity()) {
        e.preventDefault()

        $(this).prop('disabled', true)
        $(this).val('Adding room...')

        $.ajax({
          url: 'assets/action.php',
          method: 'post',
          data: $('#add-room-form').serialize() + '&action=addRoom',
          success: function(res) {
            console.log(res)
            if (res == 1) {
              fetchRooms()
              $("#add-room-form")[0].reset()
              $('#add-room-modal').modal('hide')
              swal('success', 'Successfully Added!', '')
            } else {
              swal('error', 'Oops!', 'Something went wrong.')
            }
            $('#add-room-btn').prop('disabled', false)
            $('#add-room-btn').val('Add Room')
          }
        })
      }
    })

    $('body').on('click', '.view-room-modal', function(e) {
      let id = $(this).attr('id')
      id = id.substr(10)

      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'viewRoom', id: id },
        success: function(res) {
          res = JSON.parse(res)
          $('#view-room-name').text(res.room)
          $('#view-room-bldg').text(res.bldg)
        }
      })
    })

    $('body').on('click', '.edit-room-modal', function(e) {
      let id = $(this).attr('id')
      id = id.substr(10)
      
      $.ajax({
        url: 'assets/action.php',
        method: 'post',
        data: { action: 'fetchRoom', id: id },
        success: function(res) {
          res = JSON.parse(res)
          $('#edit-room-id').val(res.ro_id)
          $('#edit-room-name').val(res.room)
          $('#edit-room-bldg').val(res.bldg)
        }
      })
    })

    $('#update-room-btn').click(function(e) {
      if ($('#edit-room-form')[0].checkValidity()) {
        e.preventDefault()

        $(this).prop('disabled', true)
        $(this).val('Updating Room...')
        
        $.ajax({
          url: 'assets/action.php',
          method: 'post',
          data: $('#edit-room-form').serialize() + '&action=updateRoom',
          success: function(res) {
            if (res == 1) {
              fetchRooms()
              $('#edit-room-modal').modal('hide')
              swal('success', 'Successfully updated!', '')
            } else {
              swal('success', 'Oops!', 'Something went wrong, try again.')
            }
            $('#update-room-btn').prop('disabled', false)
            $('#update-room-btn').val('Update room')
            $('#edit-room-form')[0].reset()
          }
        })
      }
    })

    $('body').on('click', '.del-room-modal', function(e) {
      let id = $(this).attr('id')
      id = id.substr(9)

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
            data: { action: 'delRoom', id: id },
            success: function(res) {
              if (res == 1) {
                fetchRooms()
                swal('success', 'Deleted!', '')
              } else if (res == 'used') {
                swal('error', 'Oops!', 'Room data is being used in the schedule.')
              } else {
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