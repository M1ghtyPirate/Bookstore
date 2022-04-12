function go(page)
{
	var val_page = page.value;
	document.getElementById('page1').style.display=(val_page==1) ? "" : "none";
	document.getElementById('page2').style.display=(val_page==2) ? "" : "none";
}

function ajaxFunction()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('ajaxDiv');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	var search = document.getElementById('id_genre').value;
	var queryString = "?search=" + search;
	ajaxRequest.open("GET", "search_genre_book.php" + queryString, true);
	ajaxRequest.send(null); 
}

function ajaxFunction1(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('ajaxDiv1');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	var tag = document.getElementById('tag').value;
	var queryString = "?tag=" + tag;
	ajaxRequest.open("GET", "search_name_book.php" + queryString, true);
	ajaxRequest.send(null); 
}

function ajaxFunction2(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('ajaxDiv2');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	var tag = document.getElementById('tag').value;
	var queryString = "?tag=" + tag;
	ajaxRequest.open("GET", "search_name_purchase.php" + queryString, true);
	ajaxRequest.send(null); 
}