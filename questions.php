<?php

require 'core/init.php';

$user = new User();
$user->checkIsValidUser('teacher');
$teacherId = $user->data()->id;
$question = new Question();
$teacherQuestions = $question->getAll();
$difficulty = new Difficulty();
$difficulties = $difficulty->getDifficulties();
$topic = new Topic();
$topics = $topic->getTopics();
//$teacherQuestions = $question->getQuestionsForTeacher($teacherId);

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

<body onload="filterQuestions()">



  <?php include 'includes/templates/header.php' ?>

  <section class="scroll-container" role="main">

    <div class="row">
    <?php include 'includes/templates/teacherSidebar.php' ?>
      <div class="large-9 medium-8 columns">
        <h3>Preguntas</h3>
        <h4 class="subheader">Catálogo de preguntas</h4>
        <hr>

        <div id="questionFilter" class="questionFilter" align="right" style="display: inline-block; width: 100%;">

          <div id="filter"  >
            <div class="component" style="display: inline-block; width: 30%;">
              Tema
              <select id="topic" name="topic" >
                <option vaule = 0>Todos</option>
                <?php
                foreach ($topics as $item) {
                  echo "<option value='$item->id'>$item->name</option>";
                }
                ?>
              </select>
            </div>

            <div class="component" style="display: inline-block; width: 30%">
              Dificultad
              <select id="difficulty" name="difficulty" >
                <option vaule = 0>Todos</option>
                <?php
                foreach ($difficulties as $item) {
                  echo "<option value='$item->id'>$item->name</option>";
                }
                ?>
              </select>
            </div>
            
            <div class="component" style="display: inline-block;">
            <a href="#" onclick="filterQuestions()" class="tiny button secundary" style="background-color: #a1a1a1; color: black; " >Filtrar</a>
            </div>
          </div>

         

        </div>
        <div id="questionsForLevel">
            <div>
              <h6>Preguntas seleccionadas</h6>
              <ul>
              </ul>
            </div>
          </div>
        </div>

        <table class="results">
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
           /*
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
            }*/
         ?>
       </tbody>
     </table>

     </div>
   </div>
 </section>


<?php include 'includes/templates/footer.php' ?>


<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script  type="text/javascript">
  $(document).foundation();

  function filterQuestions() {
      var topic  = $("#topic").val();
      var difficulty  = $("#difficulty").val();
      var template =  "<tr id='id'> <td> $text </td><td> <a onclick='addQuestion($id);' class='tiny button secondary'>Agregar</a> </td> </tr>";

      $.post( "controls/doAction.php", {  action: "filterCatalog",
        topic: topic,
        difficulty: difficulty})

      .done(function( data ) {
      console.log(data);

      data = JSON.parse(data);
      if(data.message == 'error'){
        alert("Error: \n\n" + data.message);
      }else{
        //Llenar el contenedor con las preguntas

        data.sort(function(a, b){
          if(a.stat == "No tiene informacion" && b.stat == "No tiene informacion"){
            return -1;
          }
          if(a.stat == "No tiene informacion"){
            return 101- b.statNum*100;
          }
          if(b.stat == "No tiene informacion"){
            return a.statNum*100 -101;
          }
          return a.statNum*100-b.statNum*100});

        var i;
        var tbody = $("table.results tbody");
        tbody.empty();
        for(i=0; i<data.length; i++){
 

          var t = "<tr id='$question'><td><a href =\"questionDetail.php?qId=$question\">$name</a></td><td>$topic</td><td>$difficulty</td><td>$statistic<td><canvas style= \"display:block;width:12vw;height:5vw;\" id=\"Canvas$question\"></canvas></td><script>createPlot($statNum, Canvas$question);<\/script>";
          //console.log(t);
          var name = "Sin Nombre";
          if (data[i].name != null){
            name = data[i].name;
          } 


          t = t.replace("$question", data[i].id);
          t = t.replace("$name", name);
          t = t.replace("$topic", data[i].topic);
          t = t.replace("$statistic", data[i].stat);
          t = t.replace("$statNum", data[i].statNum);          
          t = t.replace("$difficulty", data[i].difficulty);

          t = t.replace("$question", data[i].id);

          t = t.replace("$question", data[i].id);
          t = t.replace("$question", data[i].id);
          tbody.append(t);

        }
      }

    });
    
  }

</script>
</body>
</html>
