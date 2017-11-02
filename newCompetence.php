<?php

require 'core/init.php';

$user = new User();
$user->checkIsValidUser('teacher');
$teacherId = $user->data()->id;
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
  <title>LSAT | Nueva competencia</title>
  <?php include 'includes/templates/headTags.php' ?>
</head>

<body onload="getWebs()">

  <?php include 'includes/templates/header.php' ?>

  <section class="scroll-container" role="main">

    <div class="row">
      <?php include 'includes/templates/teacherSidebar.php' ?>
      <div class="large-9 medium-8 columns">
        <br/>
        <h3>Nueva competencia</h3>
        <h4 class="subheader">Crear una nueva competencia reuniendo varias redes de aprendizaje</h4>
        <hr>

        <form id="newCompetence">

          <div class="row">
            <label>Nombre de la competencia<input type="text" name="name" id="name"/></label>

            <h5>A continuacion, selecciona las redes que formaran la competencia.</h5>
			<ol>
      <li><select id="web1">
        <option value= "" selected="selected"></option>
      </select></li>
      <li><select id="web2">
        <option value= "" selected="selected"></option>
      </select></li>
      <li><select id="web3">
        <option value= "" selected="selected"></option>
      </select></li>
      <li><select id="web4">
        <option value= "" selected="selected"></option>
      </select></li>
      <li><select id="web5">
        <option value= "" selected="selected"></option>
      </select></li>
			</ol>
          </div>

        </form>

        <a onclick="createCompetence()" class="button round small right">Crear</a>

      </div>
    </div>
  </section>



  <?php include 'includes/templates/footer.php' ?>

  <script src="js/vendor/jquery.js"></script>
  <script src="js/foundation.min.js"></script>

  <script>
    $(document).foundation();

    function getWebs(){
      $.post( "controls/doAction.php", {  action: "getWeb",})
      .done(function( data ) {
      data = JSON.parse(data);

      var sel1 = document.getElementById('web1');
      var sel2 = document.getElementById('web2');
      var sel3 = document.getElementById('web3');
      var sel4 = document.getElementById('web4');
      var sel5 = document.getElementById('web5');
      for (var web in data) {
        if (data.hasOwnProperty(web)) {
          var id = parseInt(data[web]['id']);
          var name = data[web]['name'];
          var opt = document.createElement('option');
          opt.value = id;
          opt.innerHTML = name;
          opt2= opt.cloneNode(true);
          opt3= opt.cloneNode(true);
          opt4= opt.cloneNode(true);
          opt5= opt.cloneNode(true);
          sel1.appendChild(opt);
          sel2.appendChild(opt2);
          sel3.appendChild(opt3);
          sel4.appendChild(opt4);
          sel5.appendChild(opt5);
        }
    }
    });
    }
    

    function createCompetence(){
      var name = $("input#name").val();
      var ids = [];
      ids[0] = $("select#web1").val();
      ids[1] = $("select#web2").val();
      ids[2] = $("select#web3").val();
      ids[3] = $("select#web4").val();
      ids[4] = $("select#web5").val();

      $.post( "controls/doAction.php", {  action: "createCompetence", name: name, webIds:ids})
      .done(function( data ) {

        data = JSON.parse(data);
        console.log(data);
        if(data.message == 'success'){
          //Llevar al explorador de la red para mostrar detalle de la red creada
          window.location.replace('./competenceDetail.php?competence='+data.response);
        }else{
          alert("Error: \n\n" + data.message);
      }
    });
  }

  </script>
</body>
</html>
