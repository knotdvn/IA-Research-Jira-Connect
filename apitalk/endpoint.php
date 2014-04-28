<?php

	include("jira-functions.php");
	

	//if a post lets roll
	if ( isset($_POST["action"]) ) {
		

		//if a login attempt
		if( $_POST["action"]=="otbot_attempt_login" ){
		    if( isset($_POST['otbot_username']) && isset($_POST['otbot_password']) ){
				//sanitize
				$inputID = filter_var($_POST['otbot_username'], FILTER_SANITIZE_STRING);
				$inputPSWD = filter_var($_POST['otbot_password'], FILTER_SANITIZE_STRING);	
				//make request			
				$response = retrieve_user_cookie($inputID,$inputPSWD);
				//send to client
				echo $response;
				die();			
			}//end if paramaters is set
			////end if login get cookie	

			//failure of paramaters
			$response="ERROR!!!";
			echo $response;		
			die();
		}//end if login



		//if a project query attempt
		if( $_POST["action"]=="otbot_query_projects" ){
			if( isset($_POST['otbot_cookieName'])  ){
				//sanitize
				$inputCOOKIE = filter_var($_POST['otbot_cookieName'], FILTER_SANITIZE_STRING);
				//respond to client
				$response = query_all_projects($inputCOOKIE);
				echo $response;
				die();					
			}//end if params
			//failure of paramaters
			$response="ERROR!!!";
			echo $response;
			die();				
		}//end if a query projects

		//if an issue type query attempt
		if( $_POST["action"]=="otbot_issue_types" ){
			if( isset($_POST['otbot_cookieName']) && isset($_POST['otbot_project_key']) ){
				//sanitize
				$inputCOOKIE = filter_var($_POST['otbot_cookieName'], FILTER_SANITIZE_STRING);
				$inputPROJECT = filter_var($_POST['otbot_project_key'], FILTER_SANITIZE_STRING);
				//respond
				$response = query_issue_types($inputPROJECT, $inputCOOKIE);	
				echo $response;	
				die();
			}//end if params
				//failure of params
				$response = "ERROR!!!";
				echo $response;
				die();
		}//end if issue type query



		////create issue
		if( $_POST["action"]=="otbot_create_issue" ){
			
			if( isset($_POST['otbot_cookieName']) 
			&& isset($_POST['otbot_project_key']) 
			&& isset($_POST['otbot_issueType']) 
			&& isset($_POST['otbot_summary']) 
			&& isset($_POST['otbot_description']) 
			){

				$inputCOOKIE = filter_var($_POST['otbot_cookieName'], FILTER_SANITIZE_STRING);
				$inputPROJECT = filter_var($_POST['otbot_project_key'], FILTER_SANITIZE_STRING);
				$inputISSUE = filter_var($_POST['otbot_issueType'], FILTER_SANITIZE_STRING);
				$inputSUMMARY = filter_var($_POST['otbot_summary'], FILTER_SANITIZE_STRING);
				$inputDESCRIPTION = filter_var($_POST['otbot_description'], FILTER_SANITIZE_STRING);



					$response = create_issue( 
					$inputPROJECT,
					$inputISSUE,
					$inputSUMMARY,
					$inputDESCRIPTION,
					$inputCOOKIE
					 );//end create issue 
					
					//was issue error?
					 if($response == 'ERROR!!!'){
					 	echo $response;
					 	die();
					 }else{
					 	//we did it!!!! send the key
						echo $response;
						die();				
					 }//end if issue created
			}//end if params set
			//param error
			echo "ERROR!!!";
			die();
		}//end action create issue

		//if we get here then wrong POST
		echo "ERROR!!!";
		die();

	}else{
		
		//else send them to the app, this page is not for access
		header( 'Location: https://researchrequest.syr.edu' ) ;
		die();
	}//end if else an ajax post	

?>
