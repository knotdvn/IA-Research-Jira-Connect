//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
//this is also the app flow!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
///////////////////////////////////////////////////////////////////////////////////////////////

var cookieName;



/// #1 ///
//javascript to grab the login cookie
function otbot_attempt_login(ot_username, ot_password){

	jQuery.post(
		
		// see tip #1 for how we declare global javascript variables
		
		OtAjax.ajaxurl,
		{// here we declare the parameters to send along with the request
			
		action : 'otbot_attempt_login',
		// other parameters can be added along with "action"
		//requests only come from pages which originate with our server
		otbot_nonce : OtAjax.otbot_nonce,
		//username and password for ot
		otbot_username: ot_username,
		otbot_password: ot_password
		},
		
			function( response ) {
				jQuery('#wait').hide();
			if(response =="ERROR!!!"){
				alert("Password or Username is incorrect, please try again.");
			}else{
				cookieName = response;
				jQuery('#status').append('1. ' + ot_username );
				jQuery('#status').attr('otusername',('1. ' + ot_username) );
				otbot_query_projects();
				jQuery('#wait').show();
				
			}
		});//end ajax post

}//end otbot_attempt_login

/// End #1 ///

/// #2///
//javascript to grab the login cookie
function otbot_query_projects(){

	jQuery.post(
		
		// see tip #1 for how we declare global javascript variables
		
		OtAjax.ajaxurl,
		{// here we declare the parameters to send along with the request
				
		action : 'otbot_query_projects',
		// other parameters can be added along with "action"
		otbot_nonce : OtAjax.otbot_nonce,
		otbot_cookieName: cookieName
		},
		
			function( response ) {
				jQuery('#wait').hide();
				if(response == 'ERROR!!!'){
					alert("Error retrieving Project List");
				}else{
					jQuery('#projects').show();
					jQuery('#projects').append( response);
			
				}
			
			
		});//end ajax post

}//end otbot_query projects

/// End #2 ///

/// #3///
//returns all of the issue types for a given project
function otbot_issue_types(key){

	jQuery.post(
		
		// see tip #1 for how we declare global javascript variables
		
		OtAjax.ajaxurl,
		{// here we declare the parameters to send along with the request
				
		action : 'otbot_issue_types',
		// other parameters can be added along with "action"
		otbot_nonce : OtAjax.otbot_nonce,
		otbot_project_key: key,
		otbot_cookieName: cookieName
		},
		
			function( response ) {
					jQuery('#wait').hide();
				if(response == 'ERROR!!!'){
					alert("Error retrieving Issue Types");
				}else{
					jQuery('#issues').show();
					jQuery('#issues').append( response);
			
				}
			
		});//end ajax post

}//end otbot_issue types

/// End #3 ///


/// #4///
//returns a list of users for selection
function otbot_find_user(searchString, key){

	jQuery.post(
		
		// see tip #1 for how we declare global javascript variables
		
		OtAjax.ajaxurl,
		{// here we declare the parameters to send along with the request
				
		action : 'otbot_find_user',
		// other parameters can be added along with "action"
		otbot_nonce : OtAjax.otbot_nonce,
		otbot_project_key: key,
		otbot_cookieName: cookieName,
		otbot_searchString: searchString
		},
		
			function( response ) {
			jQuery('#wait').hide();
					
				if(response == 'ERROR!!!'){
					alert("Error retrieving Consultants");
				}else{
					jQuery('#consultants').show();
					jQuery('#consultants_list').html( response);
			
				}
		});//end ajax post

}//end otbot_find user

/// End #4 ///

/// #5///
//sends all data to create an issue with assignee, then displays a successful operation.
function otbot_create_issue(key,consultant,issue,summary,description,duedate){

	jQuery.post(
		
		// see tip #1 for how we declare global javascript variables
		
		OtAjax.ajaxurl,
		{// here we declare the parameters to send along with the request
				
		action : 'otbot_create_issue',
		// other parameters can be added along with "action"
		otbot_nonce : OtAjax.otbot_nonce,
		otbot_project_key: key,
		otbot_consultant: consultant,
		otbot_issueType: issue,
		otbot_summary: summary,
		otbot_description: description,
		otbot_duedate:duedate,
		otbot_cookieName: cookieName
		
		},
		
			function( response ) {
					if(response == 'ERROR!!!'){
					alert("Error creating Issue");
				}else{
			jQuery('#wait').hide();
			jQuery('#creates').hide();
			jQuery('#ot_issue_link').attr('href','http://ot.syr.edu/browse/' +response);
			jQuery('#ot_issue_link').text('Issue created at http://ot.syr.edu/browse/' + response);
			jQuery('#ot_issue_link').show();
			}//end if no error
		});//end ajax post

}//end otbot_create_issue

/// End #5 ///



