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
        <h4 class="subheader">Mis preguntas</h4>
        <hr>

        <table>
         <thead>
           <tr>
             <th width="300">Nombre de la pregunta</th>
             <td width="300"> Id</td>
             <th width="300">Dificultad</th>
             <th width="300"></th>
           </tr>
         </thead>

         <tbody>
           <?php
           foreach ($teacherQuestions as $question) {

              echo "<tr id='$question->id'>
                    <td>$question->name</td>
                    <td>$question->id</td>
                    <td>$question->difficulty</td>
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
