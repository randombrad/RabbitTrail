<?
/******   CREATED BY    ********/
/******   BRAD WOOD     ********/
/******  KYLIE NELSON   ********/
/****** PHIL VanderMeer ********/
/******     MAY 2007    ********/

include("connect.php");
?>

	<script type="text/javascript">
	


var fV = {
  addEvent: function(elm, evType, fn, useCapture) {
    // cross-browser event handling for IE5+, NS6 and Mozilla 
    // By Scott Andrew
    if (elm.addEventListener) {
      elm.addEventListener(evType, fn, useCapture);
      return true;
    } else if (elm.attachEvent) { 
      var r = elm.attachEvent('on' + evType, fn);
      return r;
    } else {
      elm['on' + evType] = fn; 
    }
  },

  init: function() {
    for (var i in validationSet) {
      if (document.getElementsByName(i)) {
        var formField = document.getElementsByName(i)[0];
        fV.addEvent(formField, 'blur', fV.checkValid, false);

        if (!formField.form.validateSubmit) {
          fV.addEvent(formField.form, 'submit', fV.checkValidSubmit, false);
          formField.form.onsubmit = fV.checkSubmit; // Safari
          formField.form.validateSubmit = true;
        }
      }
    }
	
  },

  checkValidSubmit: function(e) {
    var frm = window.event ? window.event.srcElement : e ? e.target : null;
    if (!frm) return;
    var errText = [];

    for (var i = 0; i < frm.elements.length; i++) {
      if (frm.elements[i].name && validationSet[frm.elements[i].name]) {

        var failedE = fV.handleValidity(frm.elements[i]);

        var errDisplay = document.getElementById('error_' + frm.elements[i].name);

        if (failedE && errDisplay) {
          errDisplay.innerHTML =
              validationSet[failedE.name]['error'];
        }
        if (!failedE && errDisplay) {
          errDisplay.innerHTML = '';
        }

        if (failedE) {
          var labels = document.getElementsByTagName('label');
          errText[errText.length] = validationSet[failedE.name]['error'];
          for (var j = 0; j < labels.length; j++) {
            if (labels[j].htmlFor == failedE.id) {
              errText[errText.length - 1] +=
                  ' (field \'' + labels[j].firstChild.nodeValue + '\')';
            }
          }
        }
      }  /* end 'if' */
    } /* end 'for' */

var radio = document.getElementByName("rad");
		
var sel = false;

for (var i in radios){
	if (i.checked.value == "on"){
		sel = true;
	}
}
if (!sel){
	errText[errText.length] = "radio Not Selected";
} 
		
		
		
    if (errText.length > 0) {
      alert('Please fix the following errors and resubmit:\n' +
          errText.join('\n'));
      frm.submitAllowed = false;
      if (e && e.stopPropagation && e.preventDefault) {
        e.stopPropagation();
        e.preventDefault();
      }
      if (window.event) {
        window.event.cancelBubble = true;
        window.event.returnValue = false;
        return false;
      }
    } else {
      frm.submitAllowed = true;
    }
  },

  checkSubmit: function() {
    if (this.attachEvent) return true;
    return this.submitAllowed;
  },
  
  checkValid: function(e) {
    var target = window.event ? window.event.srcElement : e ? e.target : null;
    if (!target) return;

    var failedE = fV.handleValidity(target);

    var errDisplay = document.getElementById('error_' + target.name);

    if (failedE && errDisplay) {
      errDisplay.innerHTML = validationSet[failedE.name]['error'];
      failedE.focus();
    }
    if (failedE && !errDisplay) {
      alert(validationSet[failedE.name]['error']);
    }
    if (!failedE && errDisplay) {
      errDisplay.innerHTML = '';
    }
  },

  handleValidity: function(field) {
    //if text box
	if (field.type=="text"){
		if (!field.value) {
		  return null;
		}
		var re = validationSet[field.name]['regexp'];
		if (!field.value.match(re)) {
		  return field;
		} else {
		  return null;
		}
	}  
	if (field.type=="checkbox"){
		if (!field.value) {
		  return null;
		}else{
			return field;
		}
	} 
	if (field.type=="radio"){
		if (!field.value) {
		  return null;
		}else{
			return field;
		}
	} 	
	}
  };

fV.addEvent(window, 'load', fV.init, false);


	
	var validationSet = {
  'email': {
    'regexp': /^.+?@.+?\..+$/,
    'error': 'This email address is invalid. ' +
        'It should be of the form someone@example.com.'
  },
  'phone': {
    'regexp': /^[- ()0-9]+$/,
    'error': 'A phone number must be digits only.'
  },
  'agree': {
    'error': 'You Must Agree to the statements.'
  },
  'country': {
    'regexp': /^[a-zA-Z][a-zA-Z]$/,
    'error': 'Country codes are two letters only. ' +
        'Examples are US, UK or FR.'
  }
};
//==============================================================================
// labels.js 1.0
// lives at : www.thestandardhack.com/components/labels.html (soon my friend)
// born by  : aaron boodman aaron@youngpup.net www.youngpup.net
//==============================================================================
// this file uses the html label element to create one of those chill default 
// label things for form elements that flicks on and off when you focus and 
// blur the element.
//
// some cool features: 
//  - it uses event listening, so it doesn't interfere with anything else.
//  - it's easy to use: just drop this file in the head of your document.
//  - it degrades (users see traditional HTML labels)
//  - it cleans itself up before unload so that labels are never accidentally
//    submitted through forms.
//
// everything would be alot simpler if IE would just let you change the type
// of an input element (as mozilla does and the spec requires)
//==============================================================================

addEvent(window, "load", labels_init);


//==============================================================================
// Setup
//==============================================================================
// - turn display of labels off
// - initialize all labels
// - arrange for uninit to be called before any form submissions
//==============================================================================
function labels_init() {
	if (document.getElementById && document.styleSheets) {
		try {
			var s = document.styleSheets[document.styleSheets.length-1];
			// little hack: display:xxxx; does not work for labels in mozilla
			addStyleRule(s, "label", "position:absolute; visibility:hidden;");

			for (var i = 0, label = null; 
				(label = document.getElementsByTagName("label")[i]); 
				i++) 
			{
				// some may want to check for a special className here if only
				// some fields are to exibit the dhtml label behavior.
				label_init(label);
			}

			addEvent(document.forms[0], "submit", labels_uninit);
		} 
		catch (e) { }
	}
}
	


// tear-down.
// - clear all labels so they don't accidentally get submitted to the server
function labels_uninit(e) {
	if (document.getElementById && document.styleSheets) {
		for (var i = 0, label = null; 
			(label = document.getElementsByTagName("label")[i]); 
			i++) 
		{
			var el = document.getElementById(label.htmlFor);
			if (el && el.value == el._labeltext) label_hide(el);
		}
	}
}
	



// initialize a single label.
// - only applicable to textarea and input[text] and input[password]
// - arrange for label_focused and label_blurred to be called for focus and blur
// - show the initial label
// - for other element types, show the default label
function label_init(label) {
	try {
		var el = document.getElementById(label.htmlFor);
		var elName = el.nodeName;
		var elType = el.getAttribute("type");

		if (elName == "TEXTAREA" 
		|| (elType == "text" || elType == "password")) {
			el._labeltext = label.firstChild.nodeValue;
			el._type = el.getAttribute("type");
			addEvent(el, "focus", label_focused);
			addEvent(el, "blur", label_blurred);
			label_blurred({currentTarget:el});
		} else {
			label.style.position = "static";
			label.style.visibility = "visible";
		}
	}
	catch (e) { 
		label.style.position = "static";
		label.style.visibility = "visible";
	}
}




function label_focused(e) {
	e = fix_e(e);
	var el = e.currentTarget;
	if (el.value == el._labeltext) el = label_hide(el)
	el.select();
}

function label_hide(el) {
	if (el._type == "password") el = label_setInputType(el, "password");
	el.value = "";
	return el;
}

function label_blurred(e) {
	e = fix_e(e);
	var el = e.currentTarget;
	if (el.value == "") el = label_show(el);
}

function label_show(el) {
	if (el._type == "password") el = label_setInputType(el, "text");
	el.value = el._labeltext;
	return el;
}



//==============================================================================
// XXX hack:
//==============================================================================
// msie won't let us change the type of an existing input element, so to get this 
// functionality, we need to create the desired element type in an HTML string.
//==============================================================================
function label_setInputType(el, type) {
	if (navigator.appName == "Microsoft Internet Explorer") {
		var newEl = document.createElement("SPAN");
		newEl.innerHTML = '<input type="' + type + '" />';
		newEl = newEl.firstChild;
		var s = '';
		for (prop in el) {
			// some properties are read-only
			try {
				// the craziest browser bug ever: "height" and "width" (which 
				// should not even exist) return totally garbage numbers, like 
				// 458231 for instance, so we need to ignore those.
				if (prop != "type"
				&& prop != "height"
				&& prop != "width") newEl[prop] = el[prop];
			} 
			catch(e) { }
		}
		addEvent(newEl, "focus", label_focused);
		addEvent(newEl, "blur", label_blurred);
		el.parentNode.replaceChild(newEl, el);
		return newEl;
	} else {
		el.setAttribute("type", type);
		return el;
	}
}



//==============================================================================
// utility functions below...
//==============================================================================

// scott andrew (www.scottandrew.com) wrote this function. thanks, scott!
// adds an eventListener for browsers which support it.
function addEvent(obj, evType, fn){
  if (obj.addEventListener){
    obj.addEventListener(evType, fn, true);
    return true;
  } else if (obj.attachEvent){
	var r = obj.attachEvent("on"+evType, fn);
    return r;
  } else {
	return false;
  }
}

// add a style rule in ie or dom
function addStyleRule(stylesheet, selector, rule) {
	if (stylesheet.addRule) stylesheet.addRule(selector, rule);
	else {
		var index = stylesheet.cssRules.length;
		stylesheet.insertRule(selector + "{" + rule + "}", index);
	}
}

// makes ie behave like a sc browser with regard to events
function fix_e(e) {
	if (!e && window.event) e = window.event;
	if (!e.currentTarget && e.srcElement) e.currentTarget = e.srcElement;
	if (!e.originalTarget && e.srcElement) e.originalTarget = e.srcElement;
	// paul:
	// we can put more things in here as we go along, 
	// whenever we come across differences that need to
	// be fixed.
	return e;
}


function checkform()
{

	if (!document.getElementById(agree).nodeValue) {
	// box is not checked
	alert('Make Sure to Agree to the Aggreement');
	return false;
}
	
	// If the script gets this far through all of your fields
	// without problems, it's ok and you can submit the form

	return true;
}
	</script>

<?php
/**
 * Returns true if the username has been taken
 * by another user, false otherwise.
 */
function usernameTaken($username){
   global $db;
   if(!get_magic_quotes_gpc()){
      $username = addslashes($username);
   }
   $q = "Select UserName FROM UserLog WHERE UserName='$username'";
   $result = mysql_query($q,$db);
   return (mysql_numrows($result) > 0);
}


 /* Inserts the given (username, password) pair
 * into the database. Returns true on success,
 * false otherwise.
 */
function addNewUser($username, $password, $birthday, $email){
   global $db;
   $q = "INSERT INTO UserLog (UserName, Password) VALUES ('$username', '$password')";
   $result=mysql_query($q,$db);
   if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
   $userid=mysql_insert_id();
   $q2 = "INSERT INTO UserData (UserID, BDay, email, pic) VALUES ($userid, '$birthday', '$email','/images/man_icon.png')";
   
   $result2=mysql_query($q2,$db);
   if (!$result2) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	 return (mysql_query($q2,$db));
}

/**
 * Displays the appropriate message to the user
 * after the registration attempt. It displays a 
 * success or failure status depending on a
 * session variable set during registration.
 */
function displayStatus(){
   $uname = $_SESSION['reguname'];
   if($_SESSION['regresult']){
?>

<h1>Registered!</h1>
<p>Thank you <b><? echo $uname; ?></b>, your information has been added to the database, you may now <a href="index.php" title="Login">log in</a>.</p>

<?
   }
   else{
?>

<h1>Registration Failed</h1>
<p>We're sorry, but an error has occurred and your registration for the username <b><? echo $uname; ?></b>, could not be completed.<br>
Please try again at a later time. <a href='?cmd=reg'> Go Back And Try Again</a></p>

<?
   }
   unset($_SESSION['reguname']);
   unset($_SESSION['registered']);
   unset($_SESSION['regresult']);
}

if(isset($_SESSION['registered'])){
/**
 * This is the page that will be displayed after the
 * registration has been attempted.
 */
?>



<? //displayStatus(); ?>



<?
   return;
}

/**
 * Determines whether or not to show to sign-up form
 * based on whether the form has been submitted, if it
 * has, check the database for consistency and create
 * the new account.
 */
if(isset($_POST['subjoin'])){
   /* Make sure all fields were entered */
   if(!$_POST['user'] || !$_POST['pass'] ||  $_POST['pass2'] == '--' || $_POST['bdmonth'] == '--' || $_POST['bdday'] == '--' || $_POST['bdyear'] == '--' || !$_POST['email']){
      die("You didn\'t fill in a required field. <a href='?cmd=reg'> Go Back And Try Again</a>");
   }
   if($_POST['pass'] != $_POST['pass2']){
      die("Your passwords don't match! <a href='?cmd=reg'> Go Back And Try Again</a>");
   }

   /* Spruce up username, check length */
   $_POST['user'] = trim($_POST['user']);
   if(strlen($_POST['user']) > 30){
      die("Sorry, the username is longer than 30 characters, please shorten it. <a href='?cmd=reg'> Go Back And Try Again</a>");
   }

   /* Check if username is already in use */
   if(usernameTaken($_POST['user'])){
      $use = $_POST['user'];
      die("Sorry, the username: <strong>$use</strong> is already taken, please pick another one. <a href='?cmd=reg'> Go Back And Try Again</a>");
   }
	$email=$_POST['email'];
	$birthday = date("y-m-d",mktime(0,0,0,$_POST['bdmonth'],$_POST['bdday'],$_POST['bdyear']));
   /* Add the new account to the database */
   $md5pass = md5($_POST['pass']);
   $_SESSION['reguname'] = $_POST['user'];
   $_SESSION['regresult'] = addNewUser($_POST['user'], $md5pass, $birthday, $email);
   $_SESSION['registered'] = true;
   echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?cmd=login\">";
   return;
}
else{
/**
 * This is the page with the sign-up form, the names
 * of the input fields are important and should not
 * be changed.
 */
?>




<?
}
?>