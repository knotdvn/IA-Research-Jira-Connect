<?php
	include('httpful.phar');
	
	//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
//this is also the app flow!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
///////////////////////////////////////////////////////////////////////////////////////////////

///1///

//pass user credentials and recieve cookie info to store
	function retrieve_user_cookie($username, $password){
		 $data = json_encode(array(
		"username" =>$username,
		"password" =>$password
		));
        
		$uri = "https://ot.syr.edu/rest/auth/latest/session" ;
		$response = \Httpful\Request::post($uri)
		->sendsJson()
		->body($data)
		->sendIt();
		
		if(isset($response->body->errorMessages)){
			$cookieName = "ERROR!!!";
		}else{
			$cookieName = $response->body->session->name;
		$cookieValue = $response->body->session->value;
		setcookie($cookieName, $cookieValue);
		}
		
		return $cookieName;
			
	
		
	}//end function retrieve user cookie
	
	///end 1///
	
	
	/// 2////
	
	
	//query projects with credentials
	//returns all of the projects
	function query_all_projects($cookieName){
		if (isset($_COOKIE[$cookieName])){
			$value = $_COOKIE[$cookieName];
		}else{
			return false;
		}
		
		$uri = "https://ot.syr.edu/rest/api/2/project";
		$response = \Httpful\Request::get($uri)
		->sendsJson()
		->addHeader('Cookie', $cookieName . "=" . $value)
		->sendIt(); 
		if(isset($response->body->errorMessages)){
			echo "ERROR!!!";
		}else{
		
		?>


				<ul>
				<?php
				
				foreach($response->body as $project){ 
		
					?>
					<li projectID="<?php echo $project->id; ?>" key="<?php echo $project->key; ?>">
						<?php echo $project->name; ?>
					</li>
					   
				<?php	
				}//end for each project object
		        ?>
		        </ul>
		        <?php }//end if not error
	
	}//end function query project
	
	
	
	//query issue types a required part of an issue
	function query_issue_types( $projectKey, $cookieName){
		if (isset($_COOKIE[$cookieName])){
			$value = $_COOKIE[$cookieName];
		}else{
			return false;
		}
		
		$uri = 'https://ot.syr.edu/rest/api/2/issue/createmeta?projectKeys=' . $projectKey . '&issuetypeId=null';
	$response = \Httpful\Request::get($uri)
		->sendsJson()
		->addHeader('Cookie', $cookieName . "=" . $value)
		->sendIt();
		if(isset($response->body->errorMessages)){
			echo "ERROR!!!";
		}else{
		?>
		<ul>
		<?php
		$projectArray= $response->body->projects;
		
		foreach($projectArray[0]->issuetypes as $issue){
		if($issue->subtask ==1){
			//	sub task support is not enabled!
		}else{
			?>
			<li issueID="<?php echo $issue->id; ?>">
			<?php echo $issue->name; ?>
			</li>
		<?php
			}//end else not a subtask	
		}//end for each project object
        ?>
        </ul>
		<?php
		}//end if else error or data
	}//end function query_issue_types
	

	
	
	
	//takes a project key and queries assignable users
	//returns ul full of users
	function query_users( $projectKey, $searchString, $cookieName){
		if (isset($_COOKIE[$cookieName])){
			$value = $_COOKIE[$cookieName];
		}else{
			return false;
		}
		
		$uri = "https://ot.syr.edu/rest/api/2/user/assignable/search?username=" . $searchString . "&project=" . $projectKey;
		$response = \Httpful\Request::get($uri)
		->sendsJson()
		->addHeader('Cookie', $cookieName . "=" . $value)
		->sendIt();
		if(isset($response->body->errorMessages)){
			echo "ERROR!!!";
		}else{
		?>
		
		<ul>
		<?php
		
		foreach($response->body as $user){ 

			?>
			<li name="<?php echo $user->name; ?>">
				<?php echo $user->displayName; ?>
			</li>
			   
		<?php	
		}//end for each project object
        ?>
        </ul>
		
		
	<?php	
		}//end if error or data
	}//end function query_users
	
	
	
	
	
	
	
	//this creates an issue with credentials, the project id is a number, summary and description are text, and due date is year-month-day 2013-2-14 is valentines day
	
	
	function create_issue($projectKey, $issuetypeID, $summary, $description, $duedate, $cookieName ){

		if (isset($_COOKIE[$cookieName])){
			$value = $_COOKIE[$cookieName];
		}else{
			return false;
		}
	
	//its ops spiders project id = 10161
	//test issue type id = 54
	 $data=json_encode(array(
	        "fields" => array(
				"project" => array(
					"key" => $projectKey
				),//end project
				"summary"=>$summary,
				"description" => $description,
				"issuetype" => array(
					"id" => $issuetypeID
				),//end issuetype
				"duedate" => $duedate
			)//end fields
		));//end data

		$uri = "https://ot.syr.edu/rest/api/2/issue";
		$response = \Httpful\Request::post($uri)
		->sendsJson()
		->addHeader('Cookie', $cookieName . "=" . $value)
		->body($data)
		->sendIt();
			if(isset($response->body->errorMessages)){
				echo $response;
			//echo "ERROR!!!";
		}else{
			return  array("key"=>$response->body->key , "self" => $response->body->self); 
		}//end if no error
	}//end function create issue
	
	
	
//this function takes cookie credentials, and a username to  be assigned to an issue number
// the self property of the issue query object is used
	function assign_user_to_issue( $assignee, $self, $cookieName){
		if (isset($_COOKIE[$cookieName])){
			$value = $_COOKIE[$cookieName];
		}else{
			return false;
		}
		
		
		 $data=json_encode(array(
	        "fields" => array(
				"assignee"=> array(
					"name" =>$assignee
				)//end assignee
			)//end fields
		));//end data

		$uri = $self;
		
		$response = \Httpful\Request::put($uri)
		->sendsJson()
		->addHeader('Cookie', $cookieName . "=" . $value)
		->body($data)
		->sendIt();
		if(isset($response->body->errorMessages)){
			echo "ERROR!!!";
		}else{
		
		}//end if no error in assignment
		
		
	}//end function 
