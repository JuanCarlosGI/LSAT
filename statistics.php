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
  <title>LSAT | Statistics</title>
  <?php include 'includes/templates/headTags.php' ?>
</head>

<body>



  <?php include 'includes/templates/header.php' ?>

  <section class="scroll-container" role="main">

    <div class="row">
    <?php include 'includes/templates/teacherSidebar.php' ?>
      <div class="large-9 medium-8 columns">
        <h3>Estadisticas</h3>
        <h4 class="subheader">Estadisticas de preguntas</h4>
        <hr>

        <table>
         <thead>
           <tr>
             <th width="300">Nombre de la pregunta</th>
             <td width="300">Tema</td>
             <th width="300">Dificultad</th>
             <th width="300">Exito de la pregunta</th>
           </tr>
         </thead>

         <tbody>
           <?php
           $topics = new Topic();
           $difficulties = new Difficulty();
           $max = 101;
           foreach ($teacherQuestions as $question) {
              $topic = $topics->getTopic($question->topic)[0];
              $difficulty = $difficulties->getDifficulty($question->difficulty)[0];
              $name = "Sin Nombre";
              $statistic = ((new Question())->getSuccessRate($question->id)) * 100;
              if($statistic < $max && $statistic != -100){
                $max_id = $question->id;
                $max_name = $name;
                $max_topic = $topic;
                $max_difficulty = $difficulty;
                $max = $statistic;
              }
              if($statistic == -100){
                $statistic = "No tiene informacion";
              }
              else{
                $statistic = "$statistic%";
              }
              if ($question->name != ""){
                $name = $question->name;
              }
              echo "<tr id='$question->id'>
                    <td>$name</td>
                    <td>$topic->name</td>
                    <td>$difficulty->name</td>
                    <td>$statistic</td>";
            }
         ?>
       </tbody>
     </table>

        <h4 class="subheader">Pregunta mas dificil</h4>
        <hr>

        <table>
          <thead>
            <tr>
             <th width="300">Nombre de la pregunta</th>
             <td width="300">Tema</td>
             <th width="300">Dificultad</th>
             <th width="300">Exito de la pregunta</th>
            </tr>
          </thead>
          <tbody>
            <?php  
            echo "<tr id='$question->id'>
                    <td>$max_name</td>
                    <td>$max_topic->name</td>
                    <td>$max_difficulty->name</td>
                    <td>$max %</td>";

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
