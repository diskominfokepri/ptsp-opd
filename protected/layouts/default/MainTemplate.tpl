<!DOCTYPE html>
<html lang="id">
<com:THead>   
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link href="<%= $this->Page->Theme->baseUrl %>/css/ace-skins.css" rel="stylesheet" type="text/css">
</com:THead>
<body class="no-skin">  

<com:TForm Attributes.role="form">   
<com:TOutputCache>
    <com:TClientScript PradoScripts="bootstrap,effects" />
</com:TOutputCache>    
  <div id="navbar" class="navbar navbar-default ace-save-state">
      <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
          <span class="sr-only">Toggle sidebar</span>

          <span class="icon-bar"></span>

          <span class="icon-bar"></span>

          <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
          <a href="index.html" class="navbar-brand">
            <small>
              <i class="fa fa-leaf"></i>
              Ace Admin
            </small>
          </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
          <ul class="nav ace-nav">
            
            <li class="light-blue dropdown-modal">
              <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                <img class="nav-user-photo" src="<%= $this->Page->Theme->baseUrl %>/images/avatars/user.jpg" alt="Jason's Photo" />
                <span class="user-info">
                  <small>Welcome,</small>
                  Jason
                </span>

                <i class="ace-icon fa fa-caret-down"></i>
              </a>

              <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                <li>
                  <a href="#">
                    <i class="ace-icon fa fa-cog"></i>
                    Settings
                  </a>
                </li>

                <li>
                  <a href="profile.html">
                    <i class="ace-icon fa fa-user"></i>
                    Profile
                  </a>
                </li>

                <li class="divider"></li>

                <li>
                 
                    <com:TActiveLinkButton ID="btnLogout" ValidationGroup="userlogout" Onclick="doLogout">                     
                        <prop:Text> 
                          <i class="ace-icon fa fa-power-off"></i>      
                          Logout
                        </prop:Text>
                        <prop:ClientSide.OnPreDispatch>
                          $('#<%=$this->btnLogout->ClientId%>').prop('disabled',true);            
                        </prop:ClientSide.OnPreDispatch>
                        <prop:ClientSide.OnLoading>
                          $('#<%=$this->btnLogout->ClientId%>').prop('disabled',true);                                                      
                        </prop:ClientSide.OnLoading>
                        <prop:ClientSide.onComplete>                                    
                          $('#<%=$this->btnLogout->ClientId%>').prop('disabled',false);                        
                        </prop:ClientSide.OnComplete>
                      </com:TActiveLinkButton>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div><!-- /.navbar-container -->
    </div>

    <div class="main-container ace-save-state" id="main-container">
      <script type="text/javascript">
        try{ace.settings.loadState('main-container')}catch(e){}
      </script>

      <div id="sidebar" class="sidebar responsive ace-save-state">
        <script type="text/javascript">
          try{ace.settings.loadState('sidebar')}catch(e){}
        </script>

        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
          <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
              <i class="ace-icon fa fa-signal"></i>
            </button>

            <button class="btn btn-info">
              <i class="ace-icon fa fa-pencil"></i>
            </button>

            <button class="btn btn-warning">
              <i class="ace-icon fa fa-users"></i>
            </button>

            <button class="btn btn-danger">
              <i class="ace-icon fa fa-cogs"></i>
            </button>
          </div>

          <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
          </div>
        </div><!-- /.sidebar-shortcuts -->

        <ul class="nav nav-list">
          <li class="active">
            <a href="<%= $this->Page->constructUrl('Home',true) %>">
              <i class="menu-icon fa fa-tachometer"></i>
              <span class="menu-text"> Dashboard </span>
            </a>

            <b class="arrow"></b>
          </li>

          <li class="">
            <a href="#" class="dropdown-toggle">
              <i class="menu-icon fa fa-desktop"></i>
              <span class="menu-text">
                Menu 1
              </span>

              <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
              <li class="">
                <a href="#" class="dropdown-toggle">
                  <i class="menu-icon fa fa-caret-right"></i>

                  Sub Menu 1
                  <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                  <li class="">
                    <a href="top-menu.html">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Top Menu
                    </a>

                    <b class="arrow"></b>
                  </li>

                  <li class="">
                    <a href="two-menu-1.html">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Two Menus 1
                    </a>

                    <b class="arrow"></b>
                  </li>

                  <li class="">
                    <a href="two-menu-2.html">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Two Menus 2
                    </a>

                    <b class="arrow"></b>
                  </li>

                  <li class="">
                    <a href="mobile-menu-1.html">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Default Mobile Menu
                    </a>

                    <b class="arrow"></b>
                  </li>

                  <li class="">
                    <a href="mobile-menu-2.html">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Mobile Menu 2
                    </a>

                    <b class="arrow"></b>
                  </li>

                  <li class="">
                    <a href="mobile-menu-3.html">
                      <i class="menu-icon fa fa-caret-right"></i>
                      Mobile Menu 3
                    </a>

                    <b class="arrow"></b>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul><!-- /.nav-list -->

        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
          <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
      </div>

      <div class="main-content">
        <div class="main-content-inner">
          <div class="page-content">
            <div class="page-header">
              <com:TContentPlaceHolder ID="modulheader" />
            </div>
            <com:TContentPlaceHolder ID="maincontent" />
          </div>  
        </div>
      </div><!-- /.main-content -->

      <div class="footer">
        <div class="footer-inner">
          <div class="footer-content">
            <span class="bigger-120">
              <span class="blue bolder">PTSP</span>
              OPD &copy; 2018
            </span>
          </div>
        </div>
      </div>

      <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
      </a>
    </div><!-- /.main-container -->
	<!-- Navigation-->

			
	
</com:TForm>
    <!-- Core plugin JavaScript-->
    <script src="<%= $this->Page->Theme->baseUrl %>/js/ace-extra.min.js"></script>
    <script src="<%= $this->Page->Theme->baseUrl %>/js/jquery-ui.custom.min.js"></script>
    <script src="<%= $this->Page->Theme->baseUrl %>/js/ace-elements.min.js"></script>
    <script src="<%= $this->Page->Theme->baseUrl %>/js/ace.min.js"></script>
</body>
</html>
