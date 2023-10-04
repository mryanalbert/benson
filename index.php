<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./admin/libs/bootstrap.min.css"/>
  <title>Faculty Attendance</title>
</head>
<body>
  <h1 class="text-center mt-3">Scan QR CODE</h1>

  <div class="container">
    <div class="row mt-3">
      <div class="col-md-8">
        <video id="preview" class="w-100"></video>
      </div>
      <div class="col-md-4">
        <label for="">QR Code value:</label>
        <input type="text" name="qrcode" id="qrcode" class="form-control w-100 mt-2" style="width: 200px;" readonly>
        <br>
        <div>
          <input type="radio" name="options" id="fcam" value="1" checked>
          <label class="form-check-label" for="fcam">Front Camera</label>
        </div>
        <div>
          <input type="radio" name="options" id="bcam" value="2">
          <label class="form-check-label" for="bcam">Back Camera</label>
        </div>
      </div>
    </div>
  </div>


  <script src="./admin/libs/bootstrap.bundle.js"></script>
  <script src="./admin/libs/jquery.min.js"></script>
  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
  <script type="text/javascript">
    var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });

    scanner.addListener('scan',function(content){
      $('#qrcode').val(content)
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
    </script>
  </script>
</body>
</html>