
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="OCR Menggunakan Tesseract">
    <meta name="author" content="Laurensius Dede Suhardiman">
    <title>Laurensius - OCR Tesseract</title>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">Laurensius - OCR Tesseract</a>
        </div>
      </div>
    </div>
    <div class="container" style="margin-top:60px">
        <div class="row">
          <form id="my_form" role="form" method="post" enctype="multipart/form-data">
            <div class="col-lg-12">
                <input type="text" class="form-control" name="id_dealer">
                <input type="text" class="form-control" name="id_produk">
                <input type="text" class="form-control" name="price">
                <br>
              <button type="submit" id="btn_simpan" value="simpan" class="btn btn-success">login</button>
            </div>
          </form>
        </div>
        
    </div>
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script>
      var r;
      $("form#my_form").submit(function(e) {
        var konfirmasi = confirm("Login?");
        if(konfirmasi){
          e.preventDefault();
          var formData = new FormData(this);
          $.ajax({
              url: "<?php echo site_url('/api/dealer_add_product/'); ?>",
              type: 'POST',
              data: formData,
              success: function(response) {
                  console.log(response);
              },
              error: function(response){
                console.log(response);
              },
              cache: false,
              contentType: false,
              processData: false
          });
        }
      });

  
    </script>
  </body>
</html>
