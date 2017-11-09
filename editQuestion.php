<?php

require 'core/init.php';

$user = new User();
$user->checkIsValidUser('teacher');
$difficulty = new Difficulty();
$difficulties = $difficulty->getDifficulties();
$topic = new Topic();
$topics = $topic->getTopics();

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

$answer = new Answer();
$answerA = $answer->getAnswer($questionToEdit->optionA)[0];
$answerB = $answer->getAnswer($questionToEdit->optionB)[0];
$answerC = $answer->getAnswer($questionToEdit->optionC)[0];
$answerD = $answer->getAnswer($questionToEdit->optionD)[0];
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
  <title>LSAT | Editar pregunta</title>
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
        <h3>Editar pregunta</h3>
        <hr>

        <form id="newQuestion">

            <div class="row">
                <div class="large-12 columns">
                    <label>Nombre
                        <input type="text" id="qname" name="name" placeholder="Nombre corto de la pregunta" value="<?php echo $questionToEdit->name; ?>"></input>
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns">
                    <label>Texto de la pregunta
                        <textarea id="qtext" name="text" style="width:100%; height: 200px;">
                            <?php echo $questionToEdit->text; ?>
                        </textarea>
                    </label>
                </div>
            </div>

          <div class="row">
            <div class="large-12 columns">
              <label>Url media
                <input type="text" id="qurl" name="url" value="<?php echo $questionToEdit->urlImage; ?>" placeholder="URL de una imagen o video que ayude a explicar la pregunta" />
              </label>
            </div>
          </div>

          <div class="row">
            <div class="large-6 columns">
              <label>Dificultad
                <select id="qgrade" name="grade">
                  <?php
                  foreach ($difficulties as $item) {
                    $selectedText = "";
                    if ($item->id == $questionToEdit->difficulty)
                      $selectedText = " selected ";
                    echo "<option value='$item->id' $selectedText>$item->name</option>";
                  }
                  ?>
                </select>
              </label>
            </div>

            <div class="large-6 columns">
              <label>Tema
                <select id="qtopic" name="topic">
                  <?php
                  foreach ($topics as $item) {
                    $selectedText = "";
                    if ($item->id == $questionToEdit->topic)
                      $selectedText = " selected ";
                    echo "<option value='$item->id' $selectedText>$item->name</option>";
                  }
                  ?>
                </select>
              </label>
            </div>
          </div>

          <hr>

          <h4>Respuestas</h4>

          <div class="row correctAns">
            <div class="large-6 columns">
              <label>Respuesta 1 - CORRECTA <textarea  name="ans1">
                      <?php echo $answerA->text; ?>
                  </textarea> </label>
            </div>

            <div class="large-6 columns">
              <label>Feedback <textarea  name="feed1">
                      <?php echo $answerA->textFeedback; ?>
                  </textarea> </label>
            </div>

            <div class="large-6 columns">
              <label>URL <input type="text" name="urla1" value="<?php echo $answerA->urlImage; ?>" placeholder="URL de una imagen o video que complemente la respuesta" />  </label>
            </div>

            <div class="large-6 columns">
              <label>URL feedback <input type="text" name="urlf1" value="<?php echo $answerA->imageFeedback; ?>" placeholder="URL de una imagen o video que complemente el feedback" />  </label>
            </div>

          </div>

          <div class="row grey1">
              <div class="large-6 columns">
                  <label>Respuesta 2<textarea  name="ans2">
                      <?php echo $answerB->text; ?>
                  </textarea> </label>
              </div>

              <div class="large-6 columns">
                  <label>Feedback <textarea  name="feed2">
                      <?php echo $answerB->textFeedback; ?>
                  </textarea> </label>
              </div>

              <div class="large-6 columns">
                  <label>URL <input type="text" name="urla2" value="<?php echo $answerB->urlImage; ?>" placeholder="URL de una imagen o video que complemente la respuesta" />  </label>
              </div>

              <div class="large-6 columns">
                  <label>URL feedback <input type="text" name="urlf2" value="<?php echo $answerB->imageFeedback; ?>" placeholder="URL de una imagen o video que complemente el feedback" />  </label>
              </div>

          </div>


          <div class="row grey2">
              <div class="large-6 columns">
                  <label>Respuesta 3<textarea  name="ans3">
                      <?php echo $answerC->text; ?>
                  </textarea> </label>
              </div>

              <div class="large-6 columns">
                  <label>Feedback <textarea  name="feed3">
                      <?php echo $answerC->textFeedback; ?>
                  </textarea> </label>
              </div>

              <div class="large-6 columns">
                  <label>URL <input type="text" name="urla3" value="<?php echo $answerC->urlImage; ?>" placeholder="URL de una imagen o video que complemente la respuesta" />  </label>
              </div>

              <div class="large-6 columns">
                  <label>URL feedback <input type="text" name="urlf3" value="<?php echo $answerC->imageFeedback; ?>" placeholder="URL de una imagen o video que complemente el feedback" />  </label>
              </div>

          </div>

          <div class="row grey1">
              <div class="large-6 columns">
                  <label>Respuesta 4<textarea  name="ans4">
                      <?php echo $answerD->text; ?>
                  </textarea> </label>
              </div>

              <div class="large-6 columns">
                  <label>Feedback <textarea  name="feed4">
                      <?php echo $answerD->textFeedback; ?>
                  </textarea> </label>
              </div>

              <div class="large-6 columns">
                  <label>URL <input type="text" name="urla4" value="<?php echo $answerD->urlImage; ?>" placeholder="URL de una imagen o video que complemente la respuesta" />  </label>
              </div>

              <div class="large-6 columns">
                  <label>URL feedback <input type="text" name="urlf4" value="<?php echo $answerD->imageFeedback; ?>" placeholder="URL de una imagen o video que complemente el feedback" />  </label>
              </div>

          </div>

          <br/>

          <a href="questionDetail.php?qId=<?php echo $qId?>" onclick="editQuestion()" class="button round small right">Guardar</a>

          <a href="questionDetail.php?qId=<?php echo $qId?>" class="button round small right">Salir Sin Cambios</a>
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

  <script type="text/javascript">

    (function ($) {
      $(document).ready(function () {
        $('#qtext').wysiwyg({autoGrow: true, maxHeight: 400, autoSave:true, initialContent: "" });
      });
    })(jQuery);


  </script>
  <script>
    $(document).foundation();

    function editQuestion(){

      var fields = $("#newQuestion").serializeArray();

      var topic  = $("#qtopic").val();
      var grade  = $("#qgrade").val();
      var url    = $("#qurl").val();
      var text   = $("#qtext").val();
      var name   = $("#qname").val();

      var len = fields.length,
      dataObj = {};

      for (i=0; i<len; i++) {
        dataObj[fields[i].name] = fields[i].value;
      }

        dataObj["qId"] = <?php echo "$questionToEdit->id"; ?>;
        dataObj["a1Id"] = <?php echo "$answerA->id"; ?>;
        dataObj["a2Id"] = <?php echo "$answerB->id"; ?>;
        dataObj["a3Id"] = <?php echo "$answerC->id"; ?>;
        dataObj["a4Id"] = <?php echo "$answerD->id"; ?>;

      var data = JSON.stringify(dataObj);
      console.log(data);


      $.post( "controls/doAction.php", {  action: "updateQuestion", data: data})
      .done(function( data ) {

        data = JSON.parse(data);
        if(data.message == 'success'){
          alert("La pregunta fue actualizada.");
          // window.location.reload();
        }else{
          alert("Error: \n\n" + data.message);
        }

      });

}

</script>
</body>
</html>
