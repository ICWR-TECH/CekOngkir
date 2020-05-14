<?php
  /*
  *NOTE: Khusus kurir JNE,POS,TIKI
  */
  $key="";
  //kota pertama
  $curl_ProvPertama = curl_init();
  curl_setopt_array($curl_ProvPertama, array(
    CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=".$_GET['provinsi_pertama'],
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
  $response = curl_exec($curl_ProvPertama);
  $err = curl_error($curl_ProvPertama);
  curl_close($curl_ProvPertama);
  $json_prov_pertama=json_decode($response,true);

  //kota tujuan
  $curl_ProvTujuan = curl_init();
  curl_setopt_array($curl_ProvTujuan, array(
    CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=".$_GET['keprovinsi'],
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
  $response_1 = curl_exec($curl_ProvTujuan);
  $err = curl_error($curl_ProvTujuan);
  curl_close($curl_ProvTujuan);
  $json_prov_tujuan=json_decode($response_1,true);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ICWR-TECH | Cek ongkir tahap selanjutnya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  </head>
  <body class="container mt-5">
    <h2>Tahap kedua</h2><br>
    <form action="" class="form-group" method="post">
    <label for="kota_pertama">Kota pertama</label>
    <select name="kota_pertama" class="form-control" id="kota_pertama">
      <option value=""></option>
    	<?php
    	for($kota_pertama=0;$kota_pertama<count($json_prov_pertama['rajaongkir']['results']);$kota_pertama++){
    		?>
    		<option value="<?php echo $json_prov_pertama['rajaongkir']['results'][$kota_pertama]['city_id']; ?>"><?php echo $json_prov_pertama['rajaongkir']['results'][$kota_pertama]['type']." ".$json_prov_pertama['rajaongkir']['results'][$kota_pertama]['city_name']; ?></option>
    		<?php
    	}
    	?>
    </select>
    <br>
    <label for="kota_tujuan">Kota tujuan</label>
    <select name="kota_tujuan" class="form-control" id="kota_tujuan">
      <option value=""></option>
    	<?php
    	for($kota_tujuan1=0;$kota_tujuan1<count($json_prov_tujuan['rajaongkir']['results']);$kota_tujuan1++){
    		?>
    		<option value="<?php echo $json_prov_tujuan['rajaongkir']['results'][$kota_tujuan1]['city_id']; ?>"><?php echo $json_prov_pertama['rajaongkir']['results'][$kota_tujuan1]['type']." ".$json_prov_tujuan['rajaongkir']['results'][$kota_tujuan1]['city_name']; ?></option>
    		<?php
    	}
    	?>
    </select>
    <br>
    <label for="kurir">Pilih kurir:</label>
    <select class="form-control" name="kurir" id="kurir">
      <option value="">Pilih kurir</option>
      <option value="jne">JNE</option>
      <option value="pos">POS Indonesia</option>
      <option value="tiki">TIKI</option>
    </select>
    <br><br>
    <input type="submit" value="Cek sekarang" class="btn btn-primary">
    </form>
    <br><br>

          <?php
          //penentuan ongkir
          if($_POST){
          ?>
          <div class="card bg-light">
            <div class="card-body">
              <h3 class="card-title">Hasil: </h3>
              <br>
              <p class="card-text">
          <?php
          $curl_ongkir = curl_init();
          curl_setopt_array($curl_ongkir, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=".$_POST['kota_pertama']."&destination=".$_POST['kota_tujuan']."&weight=1000&courier=".$_POST['kurir'],
            CURLOPT_HTTPHEADER => array(
              "content-type: application/x-www-form-urlencoded",
              "key: $key"
            ),
          ));
          $response_ongkir = curl_exec($curl_ongkir);
          $err_ongkir = curl_error($curl_ongkir);
          curl_close($curl_ongkir);
          $hasil=json_decode($response_ongkir,true);
          echo "Tempat pengirim: <b>Provinsi ".$hasil['rajaongkir']['origin_details']['province'].", ".$hasil['rajaongkir']['origin_details']['type']." ".$hasil['rajaongkir']['origin_details']['city_name']."</b>";
          echo "<br>";
          echo "Tempat tujuan: <b>Provinsi ".$hasil['rajaongkir']['destination_details']['province'].", ".$hasil['rajaongkir']['destination_details']['type']." ".$hasil['rajaongkir']['destination_details']['city_name']."</b>";
          echo "<br>";
          echo "Kurir: <b>".htmlentities($hasil['rajaongkir']['query']['courier'])."</b>";
          echo "<br>";
          echo "Berat per: <b>".$hasil['rajaongkir']['query']['weight']." Gram</b>";
          echo "<br>";
          ?>
          <div class="container">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Tarif:</h5>
                <p class="card-text">
                  <?php
                  for ($arr=0;$arr<count($hasil['rajaongkir']['results'][0]['costs']);$arr++) {
                    echo "<b>Deskripsi:</b> ".$hasil['rajaongkir']['results'][0]['costs'][$arr]["description"]." <b>Tarif: </b>".$hasil['rajaongkir']['results'][0]['costs'][$arr]["cost"][0]['value']." ";
                    echo " <b>Waktu: </b>".$hasil['rajaongkir']['results'][0]['costs'][$arr]["cost"][0]['etd']." hari<br>";
                  }
                   ?>
                </p>
              </div>
            </div>
          </div>
          </p>
        </div>
      </div>
          <?php
          }
           ?>
  </body>
  <br><br><br><br>
  <p style="float:auto;opacity:0.5;" class="text-center">Powered by ICWR-TECH</p>
  <br><br>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</html>
