<?php /*
Template Name: Orange Tracker
*/

//Check for HTTPS
function isSecure() {
  return
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || $_SERVER['SERVER_PORT'] == 443;
}//end function isSecure




//this is the jira issue creator
$theme_dir = get_bloginfo('template_url'); 
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

        <link rel="stylesheet" href="<?php echo $theme_dir; ?>/apitalk/normalize.css">
        <link rel="stylesheet" href="<?php echo $theme_dir; ?>/apitalk/style.css">
  		
  		<?php
   		wp_enqueue_Script( 'jquery' );
    	wp_enqueue_Script( 'otbot-ajax'); ?>
		 		 
		<?php	wp_head(); ?>
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
		        	<img src="<?php echo $theme_dir; ?>/apitalk/OTForms.png" alt="Logo for OTForms" />
		        	<div id="status">
		        	</div>
		        	<a id="ot_issue_link" href="#">Empty</a>
		        	<div id="wait"><img src="<?php echo $theme_dir; ?>/apitalk/load.gif" /><p>Waiting for Jira</p></div>
		    		<iframe src="<?php echo $theme_dir;?>/apitalk/dummy.html" name="dummy" style="display: none"></iframe>
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
        
        
       
        <script type="text/javascript">
        
        
        	jQuery(document).ready(function($){
        		//the first part of human behavior starts with the login button being clicked
        		$('#ot_login').click(function(){
        			$('#wait').show();
        			$('#credentials').hide();
        			var ot_username = $('#ot_username').val();
        			var ot_password =$('#ot_password').val();
        			if(ot_username != '' && ot_password != ''){
        				otbot_attempt_login(ot_username, ot_password);
        				
        			}else{
        				alert("Please supply a password and a username to login.");
        				$('#credentials').show();
        				$('#wait').hide();
        			}
        		});
        		
        		//the 2nd part of human behaivor involves selecting a project
        		
        		var projectSelect;
        		$('#projects').delegate('li', 'click', function () {
    			// do stuff on click
    			$('#status').append('  2. ' + $(this).attr('key') );
    			$('#status').attr('otprojectkey',(' 2. ' + $(this).attr('key') ) );
    			
    			projectSelect = $(this);
    			
    			$('#project_go').show();
    			$('#projects').find('ul').hide();
    			$('#projects').find('h2').hide();
    			$('#project_again').show();
    			
				});
				
				//they have the right project
				$('#project_go').click(function(){
					$('#projects').hide();
					$('#wait').show();
					//this is where we make our THIRD ajax request
					$('#wait').show();
					otbot_issue_types( $(projectSelect).attr('key') );
					
				});//end click
				
				//what if they chose the wrong project
        			$('#project_again').click(function(){
        				$('#project_go').hide();
        				$('#projects').find('ul').show();
        				$('#project_again').hide();
						$('#status').text($('#status').attr('otusername'));        		
        			});//end function project again click
     
   
        		 //the 3rd part of human behaivor involves selecting an issue type
        		
        		var issueSelect;
        		$('#issues').delegate('li', 'click', function () {
    			// do stuff on click
	    			$('#status').append('  3. ' + $(this).text());
	    			$('#status').attr('otissuetype',(' 3. ' + $(this).text() ) );
	    			issueSelect = $(this);
	    			
	    			$('#issue_go').show();
	    			$('#issues').find('ul').hide();
	    			$('#issues').find('h2').hide();
	    			$('#issue_again').show();
				});
				
				//they have selected the right issue
				$('#issue_go').click(function(){
					$('#issues').hide();
					$('#consultants').show();
				});//end click
        		
        		//what if the chose the wrong issue
        			$('#issue_again').click(function(){
        				$('#issue_go').hide();
        				$('#issues').find('ul').show();
        				$('#issue_again').hide();
        				$('#status').text($('#status').attr('otusername') + $('#status').attr('otprojectkey' ) );
        			});//end function project again click	
     
     
     
     
     
     
     
			     /////this is the fourth part of human interaction, the user searches for a consultant
			     $('#ot_consultant').change(function(){
			     	jQuery('#wait').show();
			     	if($(this).val() == ''){
			     		//do nothing
			     	}else{
			     		//query users
			     		otbot_find_user($(this).val(), $(projectSelect).attr('key'));		     	
			     	}//we have a search string
			     });//end change value for consultant 
			     
			     //now they must select an assignee
			     var consultantSelect;
        		$('#consultants_list').delegate('li', 'click', function () {
    			// do stuff on click
	    			$('#status').append('  4. ' + $(this).text());
	    			consultantSelect = $(this);
	    			
	    			$('#consultant_go').show();
	    			$('#consultants').find('ul').hide();
	    			$('#consultants').find('h2').hide();
	    			$('#consultants').find('p').hide();
	    			$('#ot_consultant').hide();
	    			$('#consultant_again').show();
				});
				
				//they have the consultant lets move on
				$('#consultant_go').click(function(){
					$('#consultants').hide();
					$('#creates').show();
				});//end click
        		
        		//what if the chose the wrong consultant
        			$('#consultant_again').click(function(){
        				$('#consultant_go').hide();
        				$('#consultants').find('ul').show();
        				$('#consultants').find('h2').show();
	    			$('#consultants').find('p').show();
	    			$('#ot_consultant').show();
        				$('#consultant_again').hide();
        				 $('#status').text($('#status').attr('otusername') + $('#status').attr('otprojectkey' ) +  $('#status').attr('otissuetype') );

        			});//end function project again click	
				
        		
        		
        		/////////////This is the 5th and final part of human interaction
        		//a filled out issue form and the create issue button clicked
        		
        		$('#create_go').click(function(){
        			jQuery('#wait').show();
        			otbot_create_issue(
        				 $(projectSelect).attr('key'),
        				 $(consultantSelect).attr('name'),
        				 $(issueSelect).attr('issueid'),
        				 $('#ot_summary').val(),
        				 $('#ot_description').val(),
        				 $('#ot_duedate').val()
        			 );//end create issue ajax paramater list
        		});
        		
        	});
        </script>
        
        

   
<?php wp_footer(); ?>
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

        <link rel="stylesheet" href="<?php echo $theme_dir; ?>/apitalk/normalize.css">
        <link rel="stylesheet" href="<?php echo $theme_dir; ?>/apitalk/style.css">
  		
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
