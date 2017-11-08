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
              echo "<tr id='$question->id'>
                    <td>$name</td>
                    <td>$topic->name</td>
                    <td>$difficulty->name</td>
                    <td> <a href =\"editQuestion.php?qId=$question->id\"class='tiny button secundary'>Editar</a></td>";
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
      //console.log(data);

      data = JSON.parse(data);
      if(data.message == 'error'){
        alert("Error: \n\n" + data.message);
      }else{
        //Llenar el contenedor con las preguntas
        //console.log(data);

        var i;
        var tbody = $("table.results tbody");
        tbody.empty();
        for(i=0; i<data.length; i++){

          var t = "<tr id='$question'><td>$name</td><td>$topic</td><td>$difficulty</td><td> <a href =\"editQuestion.php?qId=$question->id\"class='tiny button secundary'>Editar</a></td>";
          //console.log(t);
          var name = "Sin Nombre";
          if (data[i].id != ""){
            $name = data[i].id;
          } 


          t = t.replace("$question", data[i].id);
          t = t.replace("$name", name);
          t = t.replace("$topic", data[i].topic);
          t = t.replace("$difficulty", data[i].difficulty);
          tbody.append(t);

        }
      }

    });
    
  }

</script>
</body>
</html>
