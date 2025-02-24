
<?php
    session_start();

    if(isset($_SESSION['username'])){
        //////
        $connection = mysqli_connect('localhost', 'root', '', 'test');
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

    <link rel="stylesheet" href="../admin.css">
    <link rel="stylesheet" href="./style.css">

    <style>
        .dont_change{
            position: absolute;
            top: 14px;
            color: red;
            font-weight: 500;
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
                <p>admin</p>
                <a href="">Выйти</a>
            </div>
        </div>

        <div class="main__container">
            <div class="content__wrapper">
                <div class="admin__clinics_name">
                    Добавление новой клиники или аптеки
                </div>

                <form action="./addclinic.php" method="post" class="corm__add_element">
                    <div class="login__input_data">
                        <p>Выберите город</p>
                        <div class="custom-select" style="width:220px; margin-top: 10px;">
                            <select name="city" id="city">
                                <option value="0">Выберите город</option>

                                <?php
                                
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
                    <?php
                    $connection = mysqli_connect('localhost', 'root', '', 'test');
                    if (!$connection) {
                        die("Connection failed: " . mysqli_connect_error());
                      } echo "";
                    $query = "SELECT  * FROM clinics ORDER BY id DESC LIMIT 1";
                    $select__clinics = mysqli_query($connection, $query);
                    $select__clinics = mysqli_fetch_assoc($select__clinics);
                    $number_clinics = $select__clinics['id'];
                     $number_clinics = $number_clinics + 1;
                    ?>
                    <div style="position: relative;" class="login__input_data">
                        <p>Порядковый номер</p>
                        <input style="font-size: 17px;" type="text" name="id" id="id"  value="<?php echo $number_clinics;   ?>">
                        <div class="dont_change">
                            Это поле не трогать.
                        </div>
                    </div>
                    <div class="login__input_data">
                        <p>Название клиники</p>
                        <input style="font-size: 17px;" type="text" name="clinic_name" id="clinic_name">
                    </div>
                    
                    <div class="login__input_data">
                        <p>Телефоны</p>
                        <input style="font-size: 17px;" type="text" name="phone"  id="phone">
                    </div>
                    <div class="login__input_data">
                        <p>Адрес</p>
                        <input style="font-size: 17px;" type="text" name="adress"  id="adress">
                    </div>
                    <div class="login__input_data">
                        <p>Ориентир</p>
                        <input style="font-size: 17px;" type="text" name="adress2"  id="adress2">
                    </div>
                    <div class="login__input_data">
                        <p>Email</p>
                        <input style="font-size: 17px;" type="text" name="email" id="email">
                    </div>

                    <div class="submit__button">
                        <input type="submit" value="Добавить клинику" name="add_clinic">
                    </div>
                </form>
            </div>
        </div>
        <?php echo $query3; ?>
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