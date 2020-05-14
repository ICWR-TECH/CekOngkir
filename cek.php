<?php
  $key="";
  //search province
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "key: $key"
    ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  $arr=json_decode($response,true);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ICWR-TECH | Cek ongkir</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  </head>
  <body class="container">
    <h2 class="text-center mt-5">Cek ongkir</h2>
    <form action="tahap1.php" method='get' class="form-group mt-5">
    <label for="provinsi_pertama">Provinsi pertama:</label>
    <select name='provinsi_pertama' class="form-control" id="provinsi_pertama">
    <?php
    for($i=0;$i<count($arr['rajaongkir']['results'])-1;$i++){
    	echo "<option value='".$arr['rajaongkir']['results'][$i]['province_id']."'>".$arr['rajaongkir']['results'][$i]['province']."</option>";
    }
    ?>
    </select>
    <br><br>
    <label for="provinsi_tujuan">Provinsi tujuan</label>
    <select name="keprovinsi" class="form-control" id="provinsi_tujuan">
    	<?php

    	for($tujuan=0;$tujuan<count($arr['rajaongkir']['results'])-1;$tujuan++){
    	        echo "<option value='".$arr['rajaongkir']['results'][$tujuan]['province_id']."'>".$arr['rajaongkir']['results'][$tujuan]['province']."</option>";
    	}

    	?>
    </select>
    <br><br>
    <input type='submit' class="btn btn-primary">
    </form>
  </body>
  <br><br>
  <p style="float:auto;opacity:0.5;" class="text-center">Powered by ICWR-TECH</p>
  <br><br>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</html>
