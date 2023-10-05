<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./admin/libs/bootstrap.min.css"/>
  <title>Faculty Attendance</title>
</head>
<body>
  <h1 class="text-center mt-4">Scan QR CODE</h1>

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
    <div class="row mt-4">
      <div class="col-md-8">
        <video id="preview" class="w-100"></video>
      </div>
      <div class="col-md-4">
        <input type="hidden" name="cur-ay" id="cur-ay">
        <input type="hidden" name="cur-to" id="cur-to">
        <input type="hidden" name="cur-sem" id="cur-sem">
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
  </div>


  <script src="./admin/libs/bootstrap.bundle.js"></script>
  <script src="./admin/libs/jquery.min.js"></script>
  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#loading-modal').modal('show')

      async function fetchCurrent() {
        let reqCurYearsOrSems = await fetch(`./admin/assets/action.php`, {
          method: 'post',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({ action: 'fetchCurrent' })
        })
        current = await reqCurYearsOrSems.json()
        console.log(current)

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
              console.log(res)
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