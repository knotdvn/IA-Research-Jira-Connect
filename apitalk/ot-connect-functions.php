<?php
include('jira-functions.php');

$theme_dir = get_bloginfo('template_url');




function load_otbot(){
	$theme_dir = get_bloginfo('template_url');
	// embed the javascript file that makes the AJAX request

	wp_register_script('otbot-ajax',  $theme_dir . '/apitalk/js/otbot-ajax.js');

	
	
	//declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
	wp_localize_script( 'otbot-ajax', 'OtAjax', array(
	 'ajaxurl' => admin_url( 'admin-ajax.php' ),
	 'otbot_nonce' => wp_create_nonce( 'otbot_nonce') 
	) );
//OtAJAX is a javascript variable embedded into otbot-ajax.js for use
//otbox_nonce is a nonce name and value passed to the script from the server
}//end load otbot

load_otbot();
//load the file necessary


///////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
//this is also the app flow!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
///////////////////////////////////////////////////////////////////////////////////////////////

/// #1 ///
//attempt login ajax action and handler
add_action( 'wp_ajax_nopriv_otbot_attempt_login', 'otbot_attempt_login' );
add_action( 'wp_ajax_otbot_attempt_login', 'otbot_attempt_login');

function otbot_attempt_login(){
		$nonce = $_POST['otbot_nonce'];
		// check to see if the submitted nonce matches with the

// generated nonce we created earlier

	if ( ! wp_verify_nonce( $nonce, 'otbot_nonce' ) ){
		die ( 'Busted!');
	}else{
		
		if( isset($_POST['otbot_username']) && isset($_POST['otbot_password']) ){
			
			$response = retrieve_user_cookie($_POST['otbot_username'], $_POST['otbot_password']);
			
		}

	
	echo $response;//should be the name of the cookie we just stored
	//if something goes wrong it will be ERROR!!!
	
	// IMPORTANT: don't forget to "exit"
	exit;
	}//end if nonce match
}//end if attempt_login

/// End #1 ///


/// #2 ///
//attempt login ajax action and handler
add_action( 'wp_ajax_nopriv_otbot_query_projects', 'otbot_query_projects' );
add_action( 'wp_ajax_otbot_query_projects', 'otbot_query_projects');

function otbot_query_projects(){
		$nonce = $_POST['otbot_nonce'];
		// check to see if the submitted nonce matches with the

// generated nonce we created earlier

	if ( ! wp_verify_nonce( $nonce, 'otbot_nonce' ) ){
		die ( 'Busted!');
	}else{
		if( isset($_POST['otbot_cookieName'])  ){
		$response = query_all_projects($_POST['otbot_cookieName']);
				
			}else{
				$response="ERROR!!!";
			}//end if set
	
	echo $response;
	
	// IMPORTANT: don't forget to "exit"
	
	exit;
	}//end if nonce match
}//end query all posts

/// End #2 ///

/// #3 ///
//attempt login ajax action and handler
add_action( 'wp_ajax_nopriv_otbot_issue_types', 'otbot_issue_types' );
add_action( 'wp_ajax_otbot_issue_types', 'otbot_issue_types');

function otbot_issue_types(){
		$nonce = $_POST['otbot_nonce'];
		// check to see if the submitted nonce matches with the

// generated nonce we created earlier

	if ( ! wp_verify_nonce( $nonce, 'otbot_nonce' ) ){
		die ( 'Busted!');
	}else{
		if( isset($_POST['otbot_cookieName']) && isset($_POST['otbot_project_key']) ){
		$response = query_issue_types($_POST['otbot_project_key'], $_POST['otbot_cookieName']);
				
		}else{
			$response = "ERROR!!!";
		}//end if not set
		
		
	echo $response;
	
	// IMPORTANT: don't forget to "exit"
	
	exit;
	}//end if nonce match
}//end query issue types

/// End #3 ///



/// #4 ///
//attempt login ajax action and handler
add_action( 'wp_ajax_nopriv_otbot_find_user', 'otbot_find_user' );
add_action( 'wp_ajax_otbot_find_user', 'otbot_find_user');

function otbot_find_user(){
		$nonce = $_POST['otbot_nonce'];
		// check to see if the submitted nonce matches with the

// generated nonce we created earlier

	if ( ! wp_verify_nonce( $nonce, 'otbot_nonce' ) ){
		die ( 'Busted!');
	}else{
		if( isset($_POST['otbot_cookieName']) && isset($_POST['otbot_project_key']) && isset($_POST['otbot_searchString']) ){
			$response = query_users($_POST['otbot_project_key'], $_POST['otbot_searchString'], $_POST['otbot_cookieName']);
				
		}else{
			$response = "ERROR!!!";
		}//end if not set
		
	
	echo $response;
	
	// IMPORTANT: don't forget to "exit"
	
	exit;
	}//end if nonce match
}//end find all users

/// End #4 ///

/// #5 ///
//attempt login ajax action and handler
add_action( 'wp_ajax_nopriv_otbot_create_issue', 'otbot_create_issue' );
add_action( 'wp_ajax_otbot_create_issue', 'otbot_create_issue');

function otbot_create_issue(){
		$nonce = $_POST['otbot_nonce'];
		// check to see if the submitted nonce matches with the

// generated nonce we created earlier

	if ( ! wp_verify_nonce( $nonce, 'otbot_nonce' ) ){
		die ( 'Busted!');
	}else{
		
		if( isset($_POST['otbot_cookieName']) 
		&& isset($_POST['otbot_project_key']) 
		&& isset($_POST['otbot_consultant']) 
		&& isset($_POST['otbot_issueType']) 
		&& isset($_POST['otbot_summary']) 
		&& isset($_POST['otbot_description']) 
		&& isset($_POST['otbot_duedate']) 
		 ){
				$self = create_issue( 
				$_POST['otbot_project_key'],
				$_POST['otbot_issueType'],
				stripslashes($_POST['otbot_summary']),
				stripslashes($_POST['otbot_description']),
				$_POST['otbot_duedate'],
				$_POST['otbot_cookieName']
				 );//end create issue 
				
				 if($self == 'ERROR!!!'){
				 	$response = "ERROR!!!";
				 }else{
				 	//now lets assign the issue
				 $response =	assign_user_to_issue(
					$_POST['otbot_consultant'],
					$self['self'],
					$_POST['otbot_cookieName']
					);//end assiegn to user
					
				 }//end if issue created
		}else{
			$response = "ERROR!!!";
		}//end if not set
	echo $self["key"];
	
	// IMPORTANT: don't forget to "exit"
	
	exit;
	}//end if nonce match
}//end if create_issue

/// End #4 ///

