 <body>

    <!-- Static navbar -->
    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="home">finna-ninja</a>
        </div>
        <div class="navbar-collapse collapse">
          <!-- <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul> -->
          <ul class="nav navbar-nav navbar-right">
            <li <?php if($urlx[1]=="home") {print "class='active'";}?>><a href="home">Home</a></li>
            <li <?php if($urlx[1]=="documentation") {print "class='active'";}?>><a href="documentation">Documentation</a></li>
            <li <?php if($urlx[1]=="developers") {print "class='active'";}?>><a href="developers">Developers</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>


<div class="container" style="text-align:center;">
	<div class="jumbotron">
        <img src="logo.png" style="width: 250px;margin-bottom: 40px;">
        <p class="lead">Fina Ninja is a PHP Frame Work with super Cow Powers !! , It will help you to create your next big thing faster better and in a secure manner<br><br>
Fina Ninja is still in the kung-fu school. so sit back and enjoy while we make him the best PHP framework . Know some tricks ? finna Ninja is ready to learn it from you. Go ahead , we are waiting for your pull request</p>
        <p><a class="btn btn-lg btn-primary" href="documentation" role="button">Start with Documentation...</a></p>
    </div>
</div> <!-- /container -->