<?php
include('admin/session.php');
$titulo = "Bienvenido " . $_SESSION['name'];
require("conection.php");
include 'clases/MainClass.php';
?>

<?php
include('shared/html/head.php');
?>

<body class="text-center">
    <div class="container d-flex h-100 p-3 mx-auto flex-column">
        <?php include('shared/html/header.php');?>
        <main role="main" class="inner cover">
            <header>
                
                <h1>Vuelta Al mundo</h1>
            </header>
            <div class="btn-box">
                <a href="paises.php" class="btn btn-primary">ver paises</a>
            </div>
            <div class="btn-box">
                <a href="cities.php" class="btn btn-primary">ver cities</a>
            </div>
            <div class="countrybycode">
                <h2>Buscar pais por code</h2>
                <form class="form-inline my-lg-0 w-100" action="pais.php" method="get">
                    <div class="form-group">
                        <div class="col-11 pr-2">
                            <input name="q" id="search" class="form-control w-100" type="search" autocomplete="off" placeholder="Buscar" aria-label="Search" onkeyup="getResult(this)">
                        </div>
                        <div class="col-1 pl-0">
                            <button class="btn btn-outline-success my-sm-0" type="submit">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="citiesbycounrty">
                <h2>Buscar ciudades por nombre del pais</h2>
                <form class="form-inline my-lg-0 w-100" action="ciudades_pais.php" method="get">
                    <div class="form-group">
                        <div class="col-11 pr-2">
                            <input name="country" id="searchCountry" class="form-control w-100" type="search" autocomplete="off" placeholder="Buscar" aria-label="Search" onkeyup="getResult(this)">
                        </div>
                        <div class="col-1 pl-0">
                            <button class="btn btn-outline-success my-sm-0" type="submit">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
        <?php include('shared/html/footer.php');?>
    </div>

    <script>
        function getResult(element) {
            str = element.value;
            if (document.getElementById("showResult") == null) {
                element.insertAdjacentHTML("afterend", `<div id="showResult" class="list-group col-11 pr-2" style="display:none"></div>`);
            }
            if (str.length == 0) {
                document.getElementById("showResult").remove();
                //document.getElementById("showResult").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let elemnts = "";
                        const jsonObj = JSON.parse(this.response);
                        let lenght = jsonObj.length > 5 ? 5 : jsonObj.length;
                        for (let i = 0; i < lenght; i++) {
                            elemnts += `<li class="list-group-item list-group-item-action list-group-item-light" onclick="setValue(this.innerText, '${element.id}')">${jsonObj[i]}</li>`;

                        }
                        let showResultElemn = document.getElementById("showResult");
                        showResultElemn.innerHTML = elemnts;
                        showResultElemn.style.display = "block";
                    }
                };
                xmlhttp.open("GET", `ajaxRequest.php?${element.name}=` + str, true);
                xmlhttp.send();
            }
        }

        function setValue(value, id) {
            document.getElementById(id).value = value;
            document.getElementById("showResult").style.display = "none";
        }
    </script>
</body>

</html>