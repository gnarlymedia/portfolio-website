<?php
/*

Script:  Secure Contact Form Script (FREE Version)
Version: 3.6 FREE
Date:    February 2009
Author:  Stuart Cochrane
URL:     www.freecontactform.com

-- License start --

Copyright (c) 2009 Stuart Cochrane <stuartc1@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software with little restriction, including the rights to use, copy, 
modify, merge, convey and publish the Software, subject to the following conditions:

A. The copyright, permission and conditional notices shall be included in
   all copies or substantial portions of the Software.

B. You will not convey the software (in any form) at a monetary cost (you can't sell it).
	 This includes any derived or merged works which contain any part of this software.

C. If you convey/distribute this software, in any form, you must include the source code.

D. Any derived or merged works must support this license.

E. You will link to the Authors website (www.freecontactform.com) from 
   all interface screens (forms). Links must be standard HTML and link directly.
   You may use any of the following as the link anchor text:
   Contact Form, Website Form, Spam Prevention, Free Contact Form, FreeContactForm.com,
   Email Form, Email Contact Form. Please contact the Author if you wish to remove the
   link.
   
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.


-- License end --

NOTE: 
 We now offer Professional Version (suitable for Professional/Commercial websites).
 Professional version license holders gain more features, more support and more updates.
 Visit: www.freecontactform.com for details.

*/




/*
 THIS IS YOUR CONFIGURATION FILE
 PLEASE ONLY EDIT THE PARTS WHICH 
 ARE INDICATED
*/
  
// script name of your contact form
$form_page_name = "../contact.php";

/* where to send emails to */
$email_it_to = "simon@gnarlymedia.com.au";

// email subject line
$email_subject = "Contact Us Form";

// email subject line - used on suspected form hack attempts
// for example, if someone enters HTML or scripts into the form - it will be removed
// if you choose to receive these cleaned up emails, you can set the subject line
// this lets you filter them out in your email client or mail server
$email_suspected_spam = "*SUSPECT Contact Us Form";

// do you wish to receive emails which had HTML or SCRIPTS (code will be stripped)?
$accept_suspected_hack = "no"; // change to "yes" to accept

// success page - the page the user gets when the form is successful
$success_page = "thankyou.php";

// OR

// if you prefer to have the user sent back to the contact form (with a confirmation message shown)
$send_back_to_form = "yes"; // change to "no" to redirect to above $success_page

// failure page - can be html or php (use php if you want to show actual error message, see next declaration)
$failure_page = "form_error.php";

// do you want to receive an error messaage passed into your failure page
$failure_accept_message = "yes";


// if $send_back_to_form is set to "yes", set your confirmation message bellow
$confirmation_message = "Thank you, we have received your message and will be in touch!";

/* your secret unique code used as part of our encryption */

// please edit the values within the double quotes.
// only use a-zA-Z0-9, other characters have been found to cause problems
// keep the string length to 3,6,9 or 12 characters long
$mkMine = "Yy6W4hUqggra";



/* your unique question and answer section */

// if you want to keep the default random maths questions
// just leave the next few lines as they are.
$rnumA = rand(1,9);
$rnumB = rand(1,9);
$tmmp = rand(0,2);
$tmmp_a = array("plus", "add", "+");

// if you want to create your own custom question and answer
// edit the two lines below.
$question = "$rnumA $tmmp_a[$tmmp] $rnumB?";
$answer = $rnumA+$rnumB;


/*

Some other examples...

ALTERNATIVE TO MATH QUESTION:

$question = "What color is the sky during the daytime?";
$answer = "blue";

$question = "Twinkle Twinkle Little _ _ _ _ ?";
$answer = "star";

// but you are best to ask a question related to your own website,
// something which your site visitors will know.


*/



/* ONLY EDIT BELOW HERE IF YOU HAVE SOME PHP/PROGRAMMING EXPERIENCE */







  
  
if(phpversion() < "5.1") {
 // date setting should be fine
} else {
 // feel free to edit the value as desired
 date_default_timezone_set('UTC');
}




    class encdec {
        // __construct
        function encdec() {
            $this->cseta = $this->charset_a();
            $this->csetb = $this->charset_b();
        }
        // public
        function encrypt($s) {
            $s = str_replace(" ", "", $s);
            $s = base64_encode(trim($s));
            $a = $this->charset_a();
            $b = $this->charset_b();
            $len = strlen($s);
            $new = "";
            for($i=0; $i < $len; $i++){
            $new .= $b[array_search($s[$i],$a)];
            }
            return $new;
        }
        // public
        function decrypt($s) {
            $a = $this->charset_a();
            $b = $this->charset_b();
            $len = strlen($s);
            $new = "";
            for($i=0; $i < $len; $i++){
            $new .= $a[array_search($s[$i],$b)];
            }
            return trim(base64_decode($new));
        }
        // protected
        function charset_a() {
            return array("a","b","c","j","7","8","9","A","B",
            "G","H","o","p","q","r","s","t","u","h","i","Q",
            "R","S","C","k","l","m","n","6","T","D","E","F",
            "U","V","W","X","Y","Z","v","w","x","y","z","0",
            "1","2","3","4","5","I","J","K","L","M","N","O",
            "P","d","e","f","g","=","*");
        }
        // protected
        function charset_b() {
            return array("G","H","o","p","z","q","r","s","t",
            "1","2","3","4","5","I","J","K","L","M","N","O",
            "u","h","i","Q","R","S","C","k","l","m","n","6",
            "0","P","d","e","f","g","T","D","E","F","a","b",
            "c","j","7","8","9","A","B","U","V","W","X","Y",
            "Z","v","w","x","y","*","=");
        }
    }
/*
    // PHP 5 version - comment out the above class and use this one if you have PHP 5
    
    class encdec {
        
        private $cseta;
        private $csetb;
        
        function __construct() {
            $this->cseta = $this->charset_a();
            $this->csetb = $this->charset_b();
        }
        
        public function encrypt($s) {
            $s = str_replace(" ", "", $s);
            $s = base64_encode(trim($s));
            $a = $this->cseta;
            $b = $this->csetb;
            $len = strlen($s);
            $new = "";
            for($i=0; $i < $len; $i++){
            $new .= $b[array_search($s[$i],$a)];
            }
            return $new;
        }

        public function decrypt($s) {
            $a = $this->cseta;
            $b = $this->csetb;
            $len = strlen($s);
            $new = "";
            for($i=0; $i < $len; $i++){
            $new .= $a[array_search($s[$i],$b)];
            }
            return trim(base64_decode($new));
        }

        protected function charset_a() {
            return array("a","b","c","j","7","8","9","A","B",
            "G","H","o","p","q","r","s","t","u","h","i","Q",
            "R","S","C","k","l","m","n","6","T","D","E","F",
            "U","V","W","X","Y","Z","v","w","x","y","z","0",
            "1","2","3","4","5","I","J","K","L","M","N","O",
            "P","d","e","f","g","=","*");
        }

        protected function charset_b() {
            return array("G","H","o","p","z","q","r","s","t",
            "1","2","3","4","5","I","J","K","L","M","N","O",
            "u","h","i","Q","R","S","C","k","l","m","n","6",
            "0","P","d","e","f","g","T","D","E","F","a","b",
            "c","j","7","8","9","A","B","U","V","W","X","Y",
            "Z","v","w","x","y","*","=");
        }
    }    

*/
$e = new encdec;

// pass the answer into the function below
$answer_pass = $e->encrypt($answer);

$mkNow = date("YmdHi");
$enc = $e->encrypt($mkNow)."::".$e->encrypt($mkMine);

function valEncStr($s,$m) {
 $sides = explode("::", $s);
 $f = new encdec;
 $sides[0] = $f->decrypt($sides[0]);
 $sides[1] = $f->decrypt($sides[1]);
 if(!count($sides) == 2) {
  $error = "String invalid!";
 }
 
 // compare date/time
 $plTime = date("YmdHi",mktime(date("H"),date("i")+60));
 $msTime = date("YmdHi",mktime(date("H"),date("i")-60));
 
 if($sides[0] > $plTime || $sides[0] < $msTime) {
  $error = "Date not valid!";
 }
 
 // compare custom word
 if(!$m == $sides[1]) {
  $error = "words do not match!";
 }
 
 if(isset($error)) {
  return $error;
 } else {
  return true;
 }
 
}
?>