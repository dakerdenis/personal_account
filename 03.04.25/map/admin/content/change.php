<?php
    session_start();

    if(isset($_SESSION['username'])){
        //////
    } else {
        header("Location: ../admin.php");
    }
?>
<?php
$connection = mysqli_connect('localhost', 'root', '', 'test');
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "";

if (isset($_GET['clinic_id'])) {
    $clinic__id = $_GET['clinic_id'];
}
$clinic__id = $_GET['clinic_id'];
$query = "SELECT * FROM clinics WHERE id = $clinic__id";
$select__posts_by_id = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select__posts_by_id)) {
    $clinic_id = $row['id'];
    $clinic_name = $row['clinic_name'];
    $clinic_numbers = $row['numbers'];
    $clinic_adress = $row['adress'];
    $clinic_adress2 = $row['adress2'];
    $clinic_email = $row['email'];
    $clinic_city = $row['city'];
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
    <link rel="stylesheet" href="style.css">
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
                    Редактирование 
                </div>

                <form action="./change_clinic.php" method="post" class="corm__add_element">
                    <div class="login__input_data">
                        <p>Выберите город</p>
                        <div class="custom-select" style="width:220px; margin-top: 10px;">
                            <select name="city" id="city">
                                <option value="<?php echo $clinic_city; ?>">
                                    <?php
                                    if($clinic_city==''){
                                        echo 'Выберите город';
                                    }echo $clinic_city;
                                 ?></option>

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
                    <div class="login__input_data">
                        <p>Название клиники</p>
                        <input style="font-size: 17px;" type="text" id="clinic_name" name="clinic_name" value="<?php echo $clinic_name; ?>" id="clinic_name">
                    </div>
                    <div class="login__input_data">
                        <p>Телефоны</p>
                        <input style="font-size: 17px;" type="text" id="phone" name="phone" value="<?php echo $clinic_numbers; ?>" id="clinic_numbers">
                    </div>
                    <div class="login__input_data">
                        <p>Адрес</p>
                        <input style="font-size: 17px;" type="text" id="adress" name="adress" value="<?php echo $clinic_adress; ?>" id="clinic_adress">
                    </div>
                    <div class="login__input_data">
                        <p>Ориентир</p>
                        <input style="font-size: 17px;" type="text" id="adress2" name="adress2" value="<?php echo $clinic_adress2; ?>" id="clinic_adress2">
                    </div>
                    <div class="login__input_data">
                        <p>Email</p>
                        <input style="font-size: 17px;" type="text" id="email" name="email" value="<?php echo $clinic_email; ?>" id="clinic_email">
                    </div>



                    <!--id клиники скрытое -->
                    <input style="opacity: 0;" type="number" id="clinic_id" name="clinic_id" value="<?php echo $clinic_id ?>">

                    <div class="submit__button">
                        <input type="submit" name="change_clinic" id="change_clinic" value="Сохранить изменения">
                    </div>
                </form>
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