<?php

require 'core/init.php';

$user = new User();
$user->checkIsValidUser('teacher');
$teacherId = $user->data()->id;
$question = new Question();
$teacherQuestions = $question->getAll();
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

        <table>
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
<script>
  $(document).foundation();

</script>
</body>
</html>
