<?php
session_start();

if (isset($_SESSION['username'])) {
    //////
} else {
    header("Location: ../admin.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
  background: rgb(215, 31, 36);
  background: -moz-linear-gradient(
    273deg,
    rgba(215, 31, 36, 1) 39%,
    rgba(255, 255, 255, 1) 100%
  );
  background: -webkit-linear-gradient(
    273deg,
    rgba(215, 31, 36, 1) 39%,
    rgba(255, 255, 255, 1) 100%
  );
  background: linear-gradient(
    273deg,
    rgba(215, 31, 36, 1) 39%,
    rgba(255, 255, 255, 1) 100%
  );
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#d71f24",endColorstr="#ffffff",GradientType=1);
}
    </style>
</head>

<body>
    <div class="main__wrapper">

        <div class="header">
            <div class="header__logo">
                <a href="./index.php">
                    <img src="../imgs/Logo.svg" alt="">
                </a>
            </div>
            <div class="header__block__admin">
                <img src="../imgs/account.png" alt="">
                <p><?php echo $_SESSION['username']; ?></p>
                <a href="../vendor/logout.php">Выйти</a>
            </div>
        </div>

        <div class="main__container">
            <div class="content__wrapper">
                <div class="admin__clinics_name">
                    Список клиник и аптек
                </div>
                <div class="admin__clinics_desc">
                    <!--кол во клиник общее-->

                    <div class="admin_clinics__numberof">
                        Общее количество клиник и аптек: <span>25</span>
                    </div>
                    <!--Добавить клинику--->
                    <div class="admin__add_clinic">
                        <a href="./add.php">Добавить клинику</a>
                    </div>
                </div>
                <div class="sortirovka">
                    <!---сортировка по дате добавления--->
                    <div class="sortirovka__form_data">
                        <a href="">Сортировать по дате добавления</a>
                    </div>

                    <!--сортировать-->
                    <div class="custom-select" style="width:220px; margin-top: 10px; display: none;">
                        <select>
                            <option value="0">Выберите город</option>

                            <?php
                            $connection = mysqli_connect('localhost', 'root', '', 'test');
                            $query2 = "SELECT * FROM cities";
                            $cities = mysqli_query($connection, $query2);


                            while ($row2 = mysqli_fetch_assoc($cities)) {
                                $city_id = $row2['id'];
                                $city_name = $row2['name'];
                            ?>
                                <option value="<?php echo $city_id; ?>"><?php echo $city_name; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="clinics__wrapper">
                    <?php
                    $connection = mysqli_connect('localhost', 'root', '', 'test');
                    if (!$connection) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    echo "";
                    $query = "SELECT * FROM clinics";
                    $select__clinics = mysqli_query($connection, $query);



                    while ($row = mysqli_fetch_assoc($select__clinics)) {
                        $clinic_id = $row['id'];
                        $clinic_name = $row['clinic_name'];
                        $clinic_numbers = $row['numbers'];
                        $clinic_adress = $row['adress'];
                        $clinic_adress2 = $row['adress2'];
                        $clinic_email = $row['email'];
                        $clinic_city = $row['city'];

                    ?>

                        <!--Элемент клиники-->
                        <div class="element_clinic">
                            <div class="number_of_clinic"><?php echo $clinic_id; ?></div>
                            <div style="  width: 45%; font-size: 18px;" class="name_of_clinic"><?php echo $clinic_name; ?></div>
                            <div style="    width: 9%;
    font-size: 18px;
    font-weight: 600;" class="city_of_clinic">
                                <?php

                                switch ($clinic_city) {
                                    case 1:
                                        echo "Baku";
                                        break;
                                    case 3:
                                        echo "Sumqayıt";
                                        break;
                                    case 4:
                                        echo "Xaçmaz";
                                        break;
                                    case 5:
                                        echo "Qusar";
                                        break;
                                    case 6:
                                        echo "Qəbələ";
                                        break;
                                    case 7:
                                        echo "Göyçəy";
                                        break;
                                    case 8:
                                        echo "Şirvan";
                                        break;
                                    case 9:
                                        echo "Masallı";
                                        break;
                                    case 10:
                                        echo "Lənkaran";
                                        break;
                                    case 11:
                                        echo "İmişli";
                                        break;
                                    case 12:
                                        echo "Bərdə";
                                        break;
                                    case 13:
                                        echo "Biləsuvar";
                                        break;
                                    case 14:
                                        echo "Şəki";
                                        break;
                                    case 15:
                                        echo "Mingəçevir";
                                        break;
                                    case 16:
                                        echo "Zaqatala";
                                        break;
                                    case 17:
                                        echo "Gəncə";
                                        break;
                                    case 18:
                                        echo "Qazax";
                                        break;
                                    case 19:
                                        echo "Naxçivan";
                                        break;
                                    case 20:
                                        echo "Qaradağ";
                                        break;
                                        case 21:
                                            echo "Tovuz";
                                            break;
                                    default:
                                        echo "Укажите город !";
                                        break;
                                }

                                ?></div>
                            <!--редактирование клиники-->
                            <div class="settings__clinics">
                                <a href="./change.php?clinic_id=<?php echo $clinic_id; ?>">Редактировать</a>
                            </div>
                            <!--удаление клиники-->
                            <div class="delete__clinic">
                                <a href="./delete.php?clinic_id=<?php echo $clinic_id; ?>">Удалить</a>
                            </div>
                        </div>

                    <?php


                    }
                    ?>


                </div>
            </div>
        </div>
    </div>


    <script>
        var x, i, j, l, ll, selElmnt, a, b, c;
        /*look for any elements with the class "custom-select":*/
        x = document.getElementsByClassName("custom-select");
        l = x.length;
        for (i = 0; i < l; i++) {
            selElmnt = x[i].getElementsByTagName("select")[0];
            ll = selElmnt.length;
            /*for each element, create a new DIV that will act as the selected item:*/
            a = document.createElement("DIV");
            a.setAttribute("class", "select-selected");
            a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
            x[i].appendChild(a);
            /*for each element, create a new DIV that will contain the option list:*/
            b = document.createElement("DIV");
            b.setAttribute("class", "select-items select-hide");
            for (j = 1; j < ll; j++) {
                /*for each option in the original select element,
                create a new DIV that will act as an option item:*/
                c = document.createElement("DIV");
                c.innerHTML = selElmnt.options[j].innerHTML;
                c.addEventListener("click", function(e) {
                    /*when an item is clicked, update the original select box,
                    and the selected item:*/
                    var y, i, k, s, h, sl, yl;
                    s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                    sl = s.length;
                    h = this.parentNode.previousSibling;
                    for (i = 0; i < sl; i++) {
                        if (s.options[i].innerHTML == this.innerHTML) {
                            s.selectedIndex = i;
                            h.innerHTML = this.innerHTML;
                            y = this.parentNode.getElementsByClassName("same-as-selected");
                            yl = y.length;
                            for (k = 0; k < yl; k++) {
                                y[k].removeAttribute("class");
                            }
                            this.setAttribute("class", "same-as-selected");
                            break;
                        }
                    }
                    h.click();
                });
                b.appendChild(c);
            }
            x[i].appendChild(b);
            a.addEventListener("click", function(e) {
                /*when the select box is clicked, close any other select boxes,
                and open/close the current select box:*/
                e.stopPropagation();
                closeAllSelect(this);
                this.nextSibling.classList.toggle("select-hide");
                this.classList.toggle("select-arrow-active");
            });
        }

        function closeAllSelect(elmnt) {
            /*a function that will close all select boxes in the document,
            except the current select box:*/
            var x, y, i, xl, yl, arrNo = [];
            x = document.getElementsByClassName("select-items");
            y = document.getElementsByClassName("select-selected");
            xl = x.length;
            yl = y.length;
            for (i = 0; i < yl; i++) {
                if (elmnt == y[i]) {
                    arrNo.push(i)
                } else {
                    y[i].classList.remove("select-arrow-active");
                }
            }
            for (i = 0; i < xl; i++) {
                if (arrNo.indexOf(i)) {
                    x[i].classList.add("select-hide");
                }
            }
        }
        /*if the user clicks anywhere outside the select box,
        then close all select boxes:*/
        document.addEventListener("click", closeAllSelect);
    </script>
</body>

</html>