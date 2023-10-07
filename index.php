<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./admin/libs/bootstrap.min.css"/>
  <title>Faculty Attendance</title>
</head>
<body>
  <h1 class="text-center my-5">Scan QR CODE</h1>

  <div class="modal" id="loading-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content rounded-0">
        <div class="modal-body text-center">
          <h2 class="text-primary mt-2 mb-3">Loading...</h2>
          <div class="spinner-border text-primary mb-2" style="width:80px;height:80px;">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p>Please wait...</p>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="validating-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content rounded-0">
        <div class="modal-body text-center">
          <h2 class="text-primary mt-2 mb-3">Validating...</h2>
          <div class="spinner-border text-primary mb-2" style="width:80px;height:80px;">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p>Please wait...</p>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row" id="scan">
      <div class="col-md-8 mx-auto">
        <video id="preview" class="w-100"></video>
        <!-- <label for="">QR Code value:</label> -->
        <input type="hidden" name="qrcode" id="qrcode" class="form-control w-100 mt-2" style="width: 200px;">
        <br>
        <!-- <div>
          <input type="radio" name="options" id="fcam" value="1" checked>
          <label class="form-check-label" for="fcam">Front Camera</label>
        </div>
        <div>
          <input type="radio" name="options" id="bcam" value="2">
          <label class="form-check-label" for="bcam">Back Camera</label>
        </div> -->
      </div>
    </div>

    <div class="row mt-5 d-none" id="invalid">
      <div class="col-md-6 mx-auto text-center">
        <h1 class="text-danger">Invalid</h1>
        <p class="fs-5">QR Code is not registered.</p>
      </div>
    </div>

    <div class="row mt-5 d-none" id="not-sched">
      <div class="col-md-6 mx-auto text-center">
        <h1 class="text-danger" id="not-sched-text"></h1>
      </div>
    </div>
    
    <div class="row mt-5 d-none" id="log-in">
      <div class="col-md-6 mx-auto text-center">
        <h1 class="text-success" id="log-in-text"></h1>
        <h3 class="text-secondary" id="log-in-faculty"></h3>
      </div>
    </div>

    <div class="row mt-5 d-none" id="log-out">
      <div class="col-md-6 mx-auto text-center">
        <h1 class="text-success" id="log-out-text"></h1>
        <h3 class="text-secondary" id="log-out-faculty"></h3>
      </div>
    </div>
    
    <div class="row mt-5 d-none" id="log-out-update">
      <div class="col-md-6 mx-auto text-center">
        <h1 class="text-success" id="log-out-update-text"></h1>
        <h3 class="text-secondary" id="log-out-update-faculty"></h3>
      </div>
    </div>
  </div>


  <script src="./admin/libs/bootstrap.bundle.js"></script>
  <script src="./admin/libs/jquery.min.js"></script>
  <script src="./admin/libs/rawgit_instascan.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#loading-modal').modal('show')

      function swal(icon, title, text) {
        Swal.fire({
          icon: icon,
          title: title,
          text: text,
        })
      }

      async function fetchCurrent() {
        let reqCurYearsOrSems = await fetch(`./admin/assets/action.php`, {
          method: 'post',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({ action: 'fetchCurrent' })
        })
        current = await reqCurYearsOrSems.json()

        var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
        
        $('#loading-modal').modal('hide')

        scanner.addListener('scan',function(content){
          $('#qrcode').val(content)
          $('#validating-modal').modal('show')
          $.ajax({
            url: './admin/assets/action.php',
            method: 'post',
            data: {
              yearFrom: current.cur_ay_from,
              yearTo: current.cur_ay_to,
              sem: current.cur_sem,
              qrcode: $('#qrcode').val(),
              action: 'attendance'
            },
            success: function(res) {
              if (res == 'QR Code not registered.') {
                // console.log(res)
                $('#scan').addClass('d-none')
                $('#invalid').removeClass('d-none')

                setTimeout(() => {
                  $("#scan").removeClass('d-none')
                  $('#invalid').addClass('d-none')
                }, 2200)
              } else if (res.includes('Not your schedule')) {
                // console.log(res)
                $('#scan').addClass('d-none')
                $('#not-sched').removeClass('d-none')
                $('#not-sched-text').text(res)

                setTimeout(() => {
                  $("#scan").removeClass('d-none')
                  $('#not-sched').addClass('d-none')
                }, 2200)
              } 
              else {
                res = JSON.parse(res)

                let call = 'Sir'
                if (res.gender == 0) {
                  call = "Ma'am"
                }

                if (res.action == 'login') {
                  $('#scan').addClass('d-none')
                  $('#log-in').removeClass('d-none')
                  $('#log-in-text').text('Logged in!')
                  $('#log-in-faculty').text(`${call} ${res.fac_fname} ${res.fac_lname}`)

                  setTimeout(() => {
                    $("#scan").removeClass('d-none')
                    $('#log-in').addClass('d-none')
                  }, 2200)
                } else if (res.action == 'logout') {
                  $('#scan').addClass('d-none')
                  $('#log-out').removeClass('d-none')
                  $('#log-out-text').text('Logged out!')
                  $('#log-out-faculty').text(`${call} ${res.fac_fname} ${res.fac_lname}`)

                  setTimeout(() => {
                    $("#scan").removeClass('d-none')
                    $('#log-out').addClass('d-none')
                  }, 2200)
                } else {
                  $('#scan').addClass('d-none')
                  $('#log-out-update').removeClass('d-none')
                  $('#log-out-update-text').text('Updated log out time!')
                  $('#log-out-update-faculty').text(`${call} ${res.fac_fname} ${res.fac_lname}`)

                  setTimeout(() => {
                    $("#scan").removeClass('d-none')
                    $('#log-out-update').addClass('d-none')
                  }, 2200)
                }
              }
              $('#validating-modal').modal('hide')
            }
          })
        });

        Instascan.Camera.getCameras().then(function (cameras){
          if(cameras.length>0){
            scanner.start(cameras[0]);
            $('[name="options"]').on('change',function(){
              if($(this).val()==1){
                if(cameras[0]!=""){
                  scanner.start(cameras[0]);
                }else{
                  alert('No Front camera found!');
                }
              }else if($(this).val()==2){
                if(cameras[1]!=""){
                  scanner.start(cameras[1]);
                }else{
                  alert('No Back camera found!');
                }
              }
            });
          }else{
            console.error('No cameras found.');
            alert('No cameras found.');
          }
        }).catch(function(e){
          console.error(e);
          alert(e);
        });
      }
      fetchCurrent()

    })
  </script>
</body>
</html>