<?php
$connection = mysqli_connect('localhost', 'root', 'plo234hshjnjsaf23', 'test');

if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>A-Group Map</title>

  <link rel="stylesheet" href="./style.css" />
  <link rel="shortcut icon" href="./logo_red.png" type="image/x-icon">


</head>

<body>
  <div class="map_wrapper">

    <div class="map_container">








      <div class="map__list__wrapper">
        <!--Блок карты-->
        <div class="map__block">
          <!--Блок региона Баку-->
          <div onclick="openCity(event, 'Baku')" id="defaultOpen" class="region__block region__block_baku">Bakı</div>
          <!--Блок региона Сумгаит-->
          <div onclick="openCity(event, 'sumgait')" class="region__block region__block_sumgait">Sumqayıt</div>
          <!--Блок региона хачмаз-->
          <div onclick="openCity(event, 'hacmaz')" class="region__block region__block_hacmaz">Xaçmaz</div>
          <!--Блок региона ГУсар-->
          <div onclick="openCity(event, 'gusar')" class="region__block region__block_gusar">Qusar</div>
          <!--Блок региона Гябяля-->
          <div onclick="openCity(event, 'gabala')" class="region__block region__block_gabala">Qəbələ</div>
          <!--Блок региона Гёйчя-->
          <div onclick="openCity(event, 'goycay')" class="region__block region__block_goycay">Göyçay</div>
          <!--Блок региона Ширван-->
          <div onclick="openCity(event, 'shirvan')" class="region__block region__block_shirvan">Şirvan</div>
          <!--Блок региона Масалы-->
          <div onclick="openCity(event, 'masali')" class="region__block region__block_masali">Masallı</div>
          <!--Блок региона Lenkaran-->
          <div onclick="openCity(event, 'lenkaran')" class="region__block region__block_lenkaran">Lənkaran</div>
          <!--Блок региона Имышлы-->
          <div onclick="openCity(event, 'imisli')" class="region__block region__block_imisli">İmişli</div>
          <!--Блок региона Barda-->
          <div onclick="openCity(event, 'barda')" class="region__block region__block_barda">Bərdə</div>

          <!--Блок региона bilesuvar-->
          <div onclick="openCity(event, 'bilesuvar')" class="region__block region__block_bilesuvar">Biləsuvar</div>
          <!--Блок региона sheki-->
          <div onclick="openCity(event, 'sheki')" class="region__block region__block_sheki">Şəki</div>

          <!--Блок региона mingechivir-->
          <div onclick="openCity(event, 'mingechivir')" class="region__block region__block_mingechivir">Mingəçevir</div>
          <!--Блок региона zagatala-->
          <div onclick="openCity(event, 'zagatala')" class="region__block region__block_zagatala">Zaqatala</div>

          <!--Блок региона Qence-->
          <div onclick="openCity(event, 'gence')" class="region__block region__block_gence">Gəncə</div>
          <!--Блок региона Qazax-->
          <div onclick="openCity(event, 'qazax')" class="region__block region__block_qazax">Qazax</div>

          <!---Блок региона Tovuz----->
          <div onclick="openCity(event, 'tovuz')" class="region__block region__block_tovuz">Tovuz</div>

          <!--Блок региона Nachichevan-->
          <div onclick="openCity(event, 'nahcivan')" class="region__block region__block_nahcivan">Naxçıvan</div>
          <!--Блок региона Nachichevan-->
          <div onclick="openCity(event, 'Qaradag')" class="region__block region__block_Qaradag">Qaradağ</div>
          <!--Блок региона Georgia-->
          <div onclick="openCity(event, 'Georgia')" class="region__block region__block_georgia">Georgia</div>


          <div class="map__desc_">
            Məlumat əldə etmək üçün tələb olunan blokun üzərinə klikləyin *
          </div>
          <div class="map__desc__image">
            <img src="./logo_red.png" alt="">
          </div>
        </div>
        <!--Блок вариантов ответа-->
        <div class="map__desc">
          <div class="map_desc_name">Klinikaların siyahısı</div>
          <!--блок с отображением всеэ элементов-->
          <div class="map__desc__elements">

            <!--------------БАКУ---------------------->
            <!--------------БАКУ---------------------->
            <!--------------БАКУ---------------------->
            <!--------------БАКУ---------------------->
            <div id="Baku" class="tabcontent">
              <h3>Bakı</h3>
              <!--Блок клиники------------------->
              <?php

              $query_baku = "SELECT * FROM clinics WHERE city = 1 ";
              $select_baku = mysqli_query($connection, $query_baku);
              while ($row_baku = mysqli_fetch_assoc($select_baku)) {
                $clinic_name = $row_baku['clinic_name'];
                $clinic_numbers = $row_baku['numbers'];
                $clinic_adress = $row_baku['adress'];
                $clinic_adress2 = $row_baku['adress2'];
                $clinic_email = $row_baku['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
            <!----------SUMQAYIT------------------>
            <!----------SUMQAYIT------------------>
            <!----------SUMQAYIT------------------>
            <!----------SUMQAYIT------------------>
            <!----------SUMQAYIT------------------>
            <div id="sumgait" class="tabcontent">
              <h3>Sumqayıt</h3>
              <?php
              $query_sumq = "SELECT * FROM clinics WHERE city = 3 ";
              $select_sumq = mysqli_query($connection, $query_sumq);
              while ($row_sumq = mysqli_fetch_assoc($select_sumq)) {
                $clinic_name = $row_sumq['clinic_name'];
                $clinic_numbers = $row_sumq['numbers'];
                $clinic_adress = $row_sumq['adress'];
                $clinic_adress2 = $row_sumq['adress2'];
                $clinic_email = $row_sumq['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>

            <div id="hacmaz" class="tabcontent">
              <h3>Xaçmaz</h3>
              <?php
              $query_xac = "SELECT * FROM clinics WHERE city = 4 ";
              $select_xac = mysqli_query($connection, $query_xac);
              while ($row_xac = mysqli_fetch_assoc($select_xac)) {
                $clinic_name = $row_xac['clinic_name'];
                $clinic_numbers = $row_xac['numbers'];
                $clinic_adress = $row_xac['adress'];
                $clinic_adress2 = $row_xac['adress2'];
                $clinic_email = $row_xac['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>








            <div id="gusar" class="tabcontent">
              <h3>Gusar</h3>



              <?php
              $query_qusar = "SELECT * FROM clinics WHERE city = 5 ";
              $select_qusar = mysqli_query($connection, $query_qusar);
              while ($row_qusar = mysqli_fetch_assoc($select_qusar)) {
                $clinic_name = $row_qusar['clinic_name'];
                $clinic_numbers = $row_qusar['numbers'];
                $clinic_adress = $row_qusar['adress'];
                $clinic_adress2 = $row_qusar['adress2'];
                $clinic_email = $row_qusar['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>

            </div>
            <div id="gabala" class="tabcontent">
              <h3>Qəbələ</h3>
              <?php
              $query_qabala = "SELECT * FROM clinics WHERE city = 6 ";
              $select_qabala = mysqli_query($connection, $query_qabala);
              while ($row_qusar = mysqli_fetch_assoc($select_qabala)) {
                $clinic_name = $row_qusar['clinic_name'];
                $clinic_numbers = $row_qusar['numbers'];
                $clinic_adress = $row_qusar['adress'];
                $clinic_adress2 = $row_qusar['adress2'];
                $clinic_email = $row_qusar['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>
            <div id="goycay" class="tabcontent">
              <h3>Göyçay</h3>
              <?php
              $query_qoycay = "SELECT * FROM clinics WHERE city = 7 ";
              $select_qoycay = mysqli_query($connection, $query_qoycay);
              while ($row_qoycay = mysqli_fetch_assoc($select_qoycay)) {
                $clinic_name = $row_qoycay['clinic_name'];
                $clinic_numbers = $row_qoycay['numbers'];
                $clinic_adress = $row_qoycay['adress'];
                $clinic_adress2 = $row_qoycay['adress2'];
                $clinic_email = $row_qoycay['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>



            </div>
            <div id="shirvan" class="tabcontent">
              <h3>Şirvan</h3>

              <?php
              $query_sirvan = "SELECT * FROM clinics WHERE city = 8 ";
              $select_sirvan = mysqli_query($connection, $query_sirvan);
              while ($row_sirvan = mysqli_fetch_assoc($select_sirvan)) {
                $clinic_name = $row_sirvan['clinic_name'];
                $clinic_numbers = $row_sirvan['numbers'];
                $clinic_adress = $row_sirvan['adress'];
                $clinic_adress2 = $row_sirvan['adress2'];
                $clinic_email = $row_sirvan['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>

            </div>

            <div id="masali" class="tabcontent">
              <h3>Masallı</h3>
              <?php
              $query_masali = "SELECT * FROM clinics WHERE city = 9 ";
              $select_masali = mysqli_query($connection, $query_masali);
              while ($row_masali = mysqli_fetch_assoc($select_masali)) {
                $clinic_name = $row_masali['clinic_name'];
                $clinic_numbers = $row_masali['numbers'];
                $clinic_adress = $row_masali['adress'];
                $clinic_adress2 = $row_masali['adress2'];
                $clinic_email = $row_masali['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>
            <div id="lenkaran" class="tabcontent">
              <h3>lenkaran</h3>
              <?php
              $query_lankaran = "SELECT * FROM clinics WHERE city = 10 ";
              $select_lankaran = mysqli_query($connection, $query_lankaran);
              while ($row_lankaran = mysqli_fetch_assoc($select_lankaran)) {
                $clinic_name = $row_lankaran['clinic_name'];
                $clinic_numbers = $row_lankaran['numbers'];
                $clinic_adress = $row_lankaran['adress'];
                $clinic_adress2 = $row_lankaran['adress2'];
                $clinic_email = $row_lankaran['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>



            <div id="imisli" class="tabcontent">
              <h3>İmisli</h3>
              <?php
              $query_imisli = "SELECT * FROM clinics WHERE city = 11 ";
              $select_imisli = mysqli_query($connection, $query_imisli);
              while ($row_imisli = mysqli_fetch_assoc($select_imisli)) {
                $clinic_name = $row_imisli['clinic_name'];
                $clinic_numbers = $row_imisli['numbers'];
                $clinic_adress = $row_imisli['adress'];
                $clinic_adress2 = $row_imisli['adress2'];
                $clinic_email = $row_imisli['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>



            <div id="barda" class="tabcontent">
              <h3>Barda</h3>
              <?php
              $query_barda = "SELECT * FROM clinics WHERE city = 12 ";
              $select_barda = mysqli_query($connection, $query_barda);
              while ($row_barda = mysqli_fetch_assoc($select_barda)) {
                $clinic_name = $row_barda['clinic_name'];
                $clinic_numbers = $row_barda['numbers'];
                $clinic_adress = $row_barda['adress'];
                $clinic_adress2 = $row_barda['adress2'];
                $clinic_email = $row_barda['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>
            <div id="bilesuvar" class="tabcontent">
              <h3>Biləsuvar</h3>
              <?php
              $query_bilesu = "SELECT * FROM clinics WHERE city = 13 ";
              $select_bilesu = mysqli_query($connection, $query_bilesu);
              while ($row_bilesu = mysqli_fetch_assoc($select_bilesu)) {
                $clinic_name = $row_bilesu['clinic_name'];
                $clinic_numbers = $row_bilesu['numbers'];
                $clinic_adress = $row_bilesu['adress'];
                $clinic_adress2 = $row_bilesu['adress2'];
                $clinic_email = $row_bilesu['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>


            <div id="sheki" class="tabcontent">
              <h3>Şəki</h3>
              <?php
              $query_seki = "SELECT * FROM clinics WHERE city = 14 ";
              $select_seki = mysqli_query($connection, $query_seki);
              while ($row_seki = mysqli_fetch_assoc($select_seki)) {
                $clinic_name = $row_seki['clinic_name'];
                $clinic_numbers = $row_seki['numbers'];
                $clinic_adress = $row_seki['adress'];
                $clinic_adress2 = $row_seki['adress2'];
                $clinic_email = $row_seki['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>



            <div id="mingechivir" class="tabcontent">
              <h3>Mingechivir</h3>
              <?php
              $query_mingecevir = "SELECT * FROM clinics WHERE city = 15 ";
              $select_mingecevir = mysqli_query($connection, $query_mingecevir);
              while ($row_mingecevir = mysqli_fetch_assoc($select_mingecevir)) {
                $clinic_name = $row_mingecevir['clinic_name'];
                $clinic_numbers = $row_mingecevir['numbers'];
                $clinic_adress = $row_mingecevir['adress'];
                $clinic_adress2 = $row_mingecevir['adress2'];
                $clinic_email = $row_mingecevir['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>
            <div id="zagatala" class="tabcontent">
              <h3>Zagatala</h3>


              <?php
              $query_zagatala = "SELECT * FROM clinics WHERE city = 16 ";
              $select_zaqatala = mysqli_query($connection, $query_zagatala);
              while ($row_zaqatala = mysqli_fetch_assoc($select_zaqatala)) {
                $clinic_name = $row_zaqatala['clinic_name'];
                $clinic_numbers = $row_zaqatala['numbers'];
                $clinic_adress = $row_zaqatala['adress'];
                $clinic_adress2 = $row_zaqatala['adress2'];
                $clinic_email = $row_zaqatala['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>

            </div>
            <div id="gence" class="tabcontent">
              <h3>Gəncə</h3>
              <?php
              $query_gence = "SELECT * FROM clinics WHERE city = 17 ";
              $select_gence = mysqli_query($connection, $query_gence);
              while ($row_gence = mysqli_fetch_assoc($select_gence)) {
                $clinic_name = $row_gence['clinic_name'];
                $clinic_numbers = $row_gence['numbers'];
                $clinic_adress = $row_gence['adress'];
                $clinic_adress2 = $row_gence['adress2'];
                $clinic_email = $row_gence['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>
            <div id="qazax" class="tabcontent">
              <h3>Qazax</h3>
              <?php
              $query_qazax = "SELECT * FROM clinics WHERE city = 18 ";
              $select_qazax = mysqli_query($connection, $query_qazax);
              while ($row_qazax = mysqli_fetch_assoc($select_qazax)) {
                $clinic_name = $row_qazax['clinic_name'];
                $clinic_numbers = $row_qazax['numbers'];
                $clinic_adress = $row_qazax['adress'];
                $clinic_adress2 = $row_qazax['adress2'];
                $clinic_email = $row_qazax['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>

            <div id="tovuz" class="tabcontent">
              <h3>Tovuz</h3>
              <?php
              $query_tovuz = "SELECT * FROM clinics WHERE city = 21 ";
              $select_tovuz = mysqli_query($connection, $query_tovuz);
              while ($row_tovuz = mysqli_fetch_assoc($select_tovuz)) {
                $clinic_name = $row_tovuz['clinic_name'];
                $clinic_numbers = $row_tovuz['numbers'];
                $clinic_adress = $row_tovuz['adress'];
                $clinic_adress2 = $row_tovuz['adress2'];
                $clinic_email = $row_tovuz['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
            </div>




            <div id="nahcivan" class="tabcontent">
              <h3>Nahcivan</h3>
              <?php
              $query_naxcivan = "SELECT * FROM clinics WHERE city = 19 ";
              $select_naxcivan = mysqli_query($connection, $query_naxcivan);
              while ($row_naxcivan = mysqli_fetch_assoc($select_naxcivan)) {
                $clinic_name = $row_naxcivan['clinic_name'];
                $clinic_numbers = $row_naxcivan['numbers'];
                $clinic_adress = $row_naxcivan['adress'];
                $clinic_adress2 = $row_naxcivan['adress2'];
                $clinic_email = $row_naxcivan['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>





            </div>
            <div id="Qaradag" class="tabcontent">
              <h3>Qaradağ</h3>
              <?php
              $query_qaradag = "SELECT * FROM clinics WHERE city = 20 ";
              $select_qaradag = mysqli_query($connection, $query_qaradag);
              while ($row_qaradag = mysqli_fetch_assoc($select_qaradag)) {
                $clinic_name = $row_qaradag['clinic_name'];
                $clinic_numbers = $row_qaradag['numbers'];
                $clinic_adress = $row_qaradag['adress'];
                $clinic_adress2 = $row_qaradag['adress2'];
                $clinic_email = $row_qaradag['email'];
              ?>
                <div class="clinic_block">
                  <div class="clinic__name">
                    <?php echo $clinic_name ?>
                  </div>
                  <div class="clinic__number">
                    <p>Telefon</p>
                    <div class="clinic_number_block">
                      <?php echo $clinic_numbers ?>
                    </div>
                  </div>
                  <div class="clinic__adress">
                    <p>Ünvan:</p>
                    <div class="clinic__adress_block">
                      <?php echo $clinic_adress ?>
                    </div>
                  </div>
                  <div class="clinic_orientir">
                    <p>İstinad Nöqtəsi:</p>
                    <?php echo $clinic_adress2 ?>
                  </div>
                  <div class="clinic_email">
                    <p>e-mail:</p>
                    <?php echo $clinic_email ?>
                  </div>
                </div> <?php }
                        ?>
                                    </div>






            <div id="Georgia" class="tabcontent">
              <h3>Georgia</h3>

              <!--Блок клиники-->
              <div class="clinic_block">
                <div class="clinic__name">
                  MC GEORGIA



                </div>
                <div class="clinic__number">
                  <p>Telefon</p>
                  0099532 225 1991 <br> моб 00995 99 58 1991


                </div>
                <div class="clinic__adress">
                  <p>Ünvan:</p>
                  Tbilisi, Taşkent küç.22


                </div>
                <div class="clinic_orientir">


                </div>
                <div class="clinic_email">

                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function openCity(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
  </script>
</body>

</html>