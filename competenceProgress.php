<?php

require 'core/init.php';

$competenceId = Input::get("cId");
$groupId = Input::get("gId");

$stats = new Statistics();

$stat = $stats->getCompetenceProgress($groupId, $competenceId);
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
  <title>LSAT | Statistics</title>
  <?php include 'includes/templates/headTags.php' ?>

</head>

<body>


<div style="width: 50vw;">
    <canvas id="pie-chart"></canvas>
</div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
  <script>
    var lbls = ["Bloqueado", "Sin empezar", "Empezado", "Terminado"];
    var dta = [];

    <?php
    $count = 0;

    echo "dta.push(".$stat['blocked'].");";
    echo "dta.push(".$stat['notStarted'].");";
    echo "dta.push(".$stat['started'].");";
    echo "dta.push(".$stat['finished'].");";

    ?>

    new Chart(document.getElementById("pie-chart"), {
        type: 'pie',
        data: {
          labels: lbls,
          datasets: [{
            label: "Estatus de los alumnos",
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9"],
            data: dta
          }]
        },
        options: {
          title: {
            display: true,
            text: 'Distribución de los estatus (%)'
          }
        }

        });
  </script>
</body>
</html>