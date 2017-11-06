<?php

require 'core/init.php';

$user = new User();
$user->checkIsValidUser('teacher');


$qId = Input::get('qId');
$qId = trim($qId);

if($qId == "" || !is_numeric($qId)){
    Redirect::to('./index.php');
}



$questionToEdit = new Question();
if(!$questionToEdit->getQuestion($qId)){
    //La pregunta no existe
    Redirect::to('./index.php');
}
$questionToEdit = $questionToEdit->getQuestion($qId)[0];

$difficulty = new Difficulty();
$difficulty = $difficulty->getDifficulty($questionToEdit->difficulty)[0];
$topic = new Topic();
$topic = $topic->getTopic($questionToEdit->topic)[0];

$answer = new Answer();
$answerA = $answer->getAnswer($questionToEdit->optionA)[0];
$answerB = $answer->getAnswer($questionToEdit->optionB)[0];
$answerC = $answer->getAnswer($questionToEdit->optionC)[0];
$answerD = $answer->getAnswer($questionToEdit->optionD)[0];
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
  <title>LSAT | Detalle de pregunta</title>
  <?php include 'includes/templates/headTags.php' ?>
  <link rel="stylesheet" href="css/jquery.wysiwyg.css" type="text/css"/>
</head>

<body>

  <?php include 'includes/templates/header.php' ?>

  <section class="scroll-container" role="main">

    <div class="row">
      <?php include 'includes/templates/teacherSidebar.php' ?>
      <div class="large-9 medium-8 columns">
        <br/>
        <h3>Detalle pregunta</h3>
        <hr>

        <form id="newQuestion">

            <div class="row">
                <div class="large-12 columns">
                        <div><h1> <?php echo $questionToEdit->name; ?></h1></div>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns">
                    <label>Pregunta:
                        <div>
                            <p><?php echo $questionToEdit->text; ?></p>
                        </div>
                    </label>
                </div>
            </div>

          <div class="row">
            <div class="large-12 columns">
              <label>Url media
                <div><?php echo $questionToEdit->urlImage; ?></div>
              </label>
            </div>
          </div>

          <div class="row">
            <div class="large-6 columns">
              <label>Dificultad:
               <?php echo $difficulty->name;?>
              </label>
            </div>

            <div class="large-6 columns">
              <label>Tema:
                  <?php
                  echo $topic->name;
                  ?>
              </label>
            </div>
          </div>

          <hr>

          <h4>Respuestas</h4>

          <div class="row correctAns">
            <div class="large-6 columns">
              <label>Respuesta 1 - CORRECTA <div>
                      <?php echo $answerA->text; ?>
                  </div> </label>
            </div>

            <div class="large-6 columns">
              <label>Feedback <div  name="feed1">
                      <?php echo $answerA->textFeedback; ?>
                  </div> </label>
            </div>

            <div class="large-6 columns">
              <label>URL <div><?php echo $answerA->urlImage; ?></div>  </label>
            </div>

            <div class="large-6 columns">
              <label>URL feedback <div><?php echo $answerA->imageFeedback; ?></div>  </label>
            </div>

          </div>

          <div class="row grey1">
              <div class="large-6 columns">
                  <label>Respuesta 2<div  name="ans2">
                      <?php echo $answerB->text; ?>
                  </div> </label>
              </div>

              <div class="large-6 columns">
                  <label>Feedback <div  name="feed2">
                      <?php echo $answerB->textFeedback; ?>
                  </div> </label>
              </div>

              <div class="large-6 columns">
                   <label>URL <div><?php echo $answerB->urlImage; ?></div>  </label>
              </div>

              <div class="large-6 columns">
                  <label>URL feedback <div><?php echo $answerB->imageFeedback; ?></div>  </label>
              </div>

          </div>


          <div class="row grey2">
              <div class="large-6 columns">
                  <label>Respuesta 3<div  name="ans3">
                      <?php echo $answerC->text; ?>
                  </div> </label>
              </div>

              <div class="large-6 columns">
                  <label>Feedback <div  name="feed3">
                      <?php echo $answerC->textFeedback; ?>
                  </div> </label>
              </div>

              <div class="large-6 columns">
                   <label>URL <div><?php echo $answerC->urlImage; ?></div>  </label>
              </div>

              <div class="large-6 columns">
                 <label>URL feedback <div><?php echo $answerC->imageFeedback; ?></div>  </label>
              </div>

          </div>

          <div class="row grey1">
              <div class="large-6 columns">
                  <label>Respuesta 4<div  name="ans4">
                      <?php echo $answerD->text; ?>
                  </div> </label>
              </div>

              <div class="large-6 columns">
                  <label>Feedback <div  name="feed4">
                      <?php echo $answerD->textFeedback; ?>
                  </div> </label>
              </div>

              <div class="large-6 columns">
                  <label>URL <div><?php echo $answerD->urlImage; ?></div>  </label>
              </div>

              <div class="large-6 columns">
                  <label>URL feedback <div><?php echo $answerD->imageFeedback; ?></div>  </label>
              </div>

          </div>

          <br/>

          <a href="editQuestion.php?qId=<?php echo $qId; ?>" class="button round small right">Editar</a>
          <a href="questions.php?" class="button round small right">Regresar</a>
        </form>

      </div>
    </div>
  </section>


  <?php include 'includes/templates/footer.php' ?>


  <script src="js/vendor/jquery.js"></script>
  <script src="js/foundation.min.js"></script>

  <script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
  <script type="text/javascript" src="js/controls/wysiwyg.image.js"></script>
  <script type="text/javascript" src="js/controls/wysiwyg.link.js"></script>
  <script type="text/javascript" src="js/controls/wysiwyg.table.js"></script>

 
  <script>
    $(document).foundation();

 

</script>
</body>
</html>
