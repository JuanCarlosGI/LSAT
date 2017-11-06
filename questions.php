<?php

require 'core/init.php';

$user = new User();
$user->checkIsValidUser('teacher');
$teacherId = $user->data()->id;
$question = new Question();
$teacherQuestions = $question->getAll();

?>

<!doctype html>
<html class="no-js" lang="en">
<head>
  <title>LSAT | Questions</title>
  <?php include 'includes/templates/headTags.php' ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
  <script>
var barOptions_stacked = {
    responsive: false,
    tooltips: {
        enabled: false
    },
    hover :{
        animationDuration:0
    },
    scales: {
        xAxes: [{
            barThickness : 10,
            display: false,
            ticks: {
                beginAtZero:true,
                fontFamily: "'Open Sans Bold', sans-serif",
                fontSize:11
            },
            scaleLabel:{
                display:false
            },
            gridLines: {
            }, 
            stacked: true
        }],
        yAxes: [{
            barThickness : 10,
            gridLines: {
                display:false,
                color: "#fff",
                zeroLineColor: "#fff",
                zeroLineWidth: 0
            },
            ticks: {
                fontFamily: "'Open Sans Bold', sans-serif",
                fontSize:11
            },
            stacked: true
        }]
    },
    legend:{
        display:false
    },
    
    animation: {
        onComplete: function () {
            var chartInstance = this.chart;
            var ctx = chartInstance.ctx;
            ctx.textAlign = "left";
            ctx.font = "0px Open Sans";
            ctx.fillStyle = "#fff";

            Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                var meta = chartInstance.controller.getDatasetMeta(i);
                Chart.helpers.each(meta.data.forEach(function (bar, index) {
                    data = dataset.data[index];
                    if(i==0){
                        ctx.fillText(data, 50, bar._model.y+4);
                    } else {
                        ctx.fillText(data, bar._model.x-25, bar._model.y+4);
                    }
                }),this)
            }),this);
        }
    },
    pointLabelFontFamily : "Quadon Extra Bold",
    scaleFontFamily : "Quadon Extra Bold",
};

function createPlot(successRate, canvas) {
  var myChart = new Chart(canvas, {
    type: 'horizontalBar',
    data: {
        labels: [""],
        
        datasets: [{
            data: [successRate],
            backgroundColor: "rgba(37,177,219,1)",
            borderColor: "rgba(0,0,0,1)",
            borderWidth: 1
         
        },{
            data: [1-successRate],
            backgroundColor: "rgba(255,255,255,1)",
            borderColor: "rgba(0,0,0,1)",
            borderWidth: 1
        }]
    },

    options: barOptions_stacked,
  });
}

</script>
</head>

<body>



  <?php include 'includes/templates/header.php' ?>

  <section class="scroll-container" role="main">

    <div class="row">
    <?php include 'includes/templates/teacherSidebar.php' ?>
      <div class="large-9 medium-8 columns">
        <h3>Preguntas</h3>
        <h4 class="subheader">Catálogo de preguntas</h4>
        <hr>

        <table>
         <thead>
           <tr>
             <th width="300">Nombre de la pregunta</th>
             <td width="300">Tema</td>
             <th width="300">Dificultad</th>
             <th width='300'>% Correctos</th>
             <th width="300"></th>
           </tr>
         </thead>

         <tbody>
           <?php
           $topics = new Topic();
           $difficulties = new Difficulty();
           foreach ($teacherQuestions as $question) {
              $topic = $topics->getTopic($question->topic)[0];
              $difficulty = $difficulties->getDifficulty($question->difficulty)[0];
              $name = "Sin Nombre";
              if ($question->name != ""){
                $name = $question->name;
              }

              $statistic = ((new Question())->getSuccessRate($question->id)) * 100;
              $statNum = $statistic / 100;
              if($statNum == -1)
                $statNum = 0;
              if($statistic == -100){
                $statistic = "No tiene informacion";
              }
              else{
                $statistic = "$statistic%";
              }

              echo "<tr id='$question->id'>
                    <td><a href =\"questionDetail.php?qId=$question->id\">$name</a></td>
                    <td>$topic->name</td>
                    <td>$difficulty->name</td>
                    <td>$statistic
                    <td><canvas style=\"display:block;width:12vw;height:5vw;\" id=\"Canvas$question->id\"></canvas></td>
                    <script>createPlot($statNum, Canvas$question->id);</script>";
            }
         ?>
       </tbody>
     </table>

     </div>
   </div>
 </section>


<?php include 'includes/templates/footer.php' ?>


<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script>
  $(document).foundation();

</script>
</body>
</html>
