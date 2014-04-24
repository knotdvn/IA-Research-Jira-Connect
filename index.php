<?php /*
*/

//Check for HTTPS
function isSecure() {
  return
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || $_SERVER['SERVER_PORT'] == 443;
}//end function isSecure




//this is the jira issue creator

//if not https we don't send the form
if( isSecure()){

?>
	
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Responsive Jira Issue Creator</title>
        <meta name="description" content="A responsive form for creating Jira Issues. For use at Syracuse university, created by dvn.">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="apitalk/style/normalize.css">
        <link rel="stylesheet" href="apitalk/style/style.css">
        
        

  		
	</head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class="ribbon">
        	<div class="wrap">
		        <div id="ot_container">
		        <div id="ot_machine">
		        	<img src="apitalk/style/OTForms.png" alt="Logo for OTForms" />
		        	<div id="status">
		        	</div>
		        	<a id="ot_issue_link" href="#">Empty</a>
		        	<div id="wait"><img src="apitalk/style/load.gif" /><p>Waiting for Jira</p></div>
		    		<iframe src="apitalk/dummy.html" name="dummy" style="display: none"></iframe>
						<!--- Part 1 -->
		        	<div id="credentials" >
		        		<form id="ot_login_form" method="post" action=""  target="dummy">
		        		<p>Please authenticate with your NetID and password.</p>
		        		 <input id="ot_username" type="text" placeholder="Ot Username" required="required">
		        		 <input id="ot_password" type="password" placeholder="Ot Password" required="required">
		        		 <input type="submit" name="doLogin" value="Login" style="display:none" />
		        		 </form>
		        		 <div id="ot_login" class="button"><p>Login</p></div>
		        	</div>
		        	
		        	<!--- Part 2 -->
		        	<div id="projects" >
		        		<div id="project_again" class="button">Retry?</div>
		        		<div id="project_go" class="button">Next</div>
		        		<h2>Please Select a Project from the drop down</h2>
		        	</div>
		        	
		        	<!--- Part 3-->
		        	<div id="issues">
		        		<div id="issue_again" class="button">Retry?</div>
		        		<div id="issue_go" class="button">Next</div>
		        		<h2>Please Select an issue type</h2>
		        	</div>
		        	
		        	<!--- Part 4 -->
		        	<div id="consultants">
		        		<div id="consultant_again" class="button">Retry?</div>
		        		<div id="consultant_go" class="button">Next</div>
		        		<h2>Please search for an assignee</h2>
		        		<p>A single letter is usually sufficient</p>
		        		<input id="ot_consultant" type="text" placeholder="Assignee Name">
		        		<div id="consultants_list"></div>
		        	</div>
		        	
		        	<!--- Part 5 -->
		        	<div id="creates">
		        		<div id="create_form">
		        			<h2>Issue Summary</h2>
		        			<input id="ot_summary" type="text" placeholder="Issue Summary">
		        			<h2>Issue Description</h2>
		        			<textarea id="ot_description"></textarea>
		        			<h2>Due Date</h2>
		        			<input id="ot_duedate" placeholder="year-month-day">
		        			<div id="create_go" class="button">Create Issue</div>
		        		</div>
		        	</div>
		        	
		        	
		        </div><!-- otmachine -->
		        </div><!--container-->
        	</div><!-- wrap -->
        </div><!-- ribbon -->
        
        
       <script src="apitalk/js/otbot-ajax.js"/>
        <script src="apitalk/js/otbot-front.js" />
        
        
        	
        

   

	</body>
</html>

<?php


//end secure
}else{ ?>


	<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Responsive Jira Issue Creator</title>
        <meta name="description" content="A responsive form for creating Jira Issues. For use at Syracuse university, created by dvn.">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="apitalk/style/normalize.css">
        <link rel="stylesheet" href="apitalk/style/style.css">
  		
	</head>
    <body>

     <!-- Add your site or application content here -->
        <div class="ribbon">
        	<div class="wrap">
		        <div id="ot_container">
		        <div id="ot_machine">
		        	<h2>Security Warning</h2>
		        	<p>Please make sure this site is on an HTTPS server.</p>
		        </div>
		        </div>
		    </div>
		</div>
	</body>
</html>

<?php
//end not secure
}//end if else not secure
