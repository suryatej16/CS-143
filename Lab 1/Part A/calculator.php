<html>
	<head>
		<title>Sarah and Surya's Calculator</title>
	</head>
	<body>
	<h1>Calculator</h1>
	(Ver 1.4 1/14/2014 by Suryatej Mukkamalla and Sarah Wong)<br/>
	<p>
		<form method="GET">
		<input type="text" name="trial_1">
		<input type="submit" value="Calculate">
		</form>
	</p>

	<ul>
    	<li>Only numbers and +,-,* and / operators are allowed in the expression.
    	<li>The evaluation follows the standard operator precedence.
    	<li>The calculator does not support parentheses.
    	<li>The calculator handles invalid input "gracefully". It does not output PHP error messages.
	</ul>
	Here are some(but not limit to) reasonable test cases:
	<ol>
	  	<li> A basic arithmetic operation:  3+4*5=23 </li>
  		<li> An expression with floating point or negative sign : -3.2+2*4-1/3 = 4.46666666667, 3+-2.1*2 = -1.2 </li>
  		<li> Some typos inside operation (e.g. alphabetic letter): Invalid input expression 2d4+1 </li>
	</ol>
	<?php
		if($_GET["trial_1"]) //if there is any input
			{
				$zero = FALSE; //divide by zero error checking
				function e($errno, $errstr, $errfile, $errline)
					 {
    					if($errstr == "Division by zero") 
    						{
        					global $zero;
        					$zero = TRUE;
    						}
					}
				set_error_handler('e');
				$input = $_GET["trial_1"]; //load the input into a string
				$valid_input = true; //flag to check if the input is valid
				$invalid_punctuation = "/[A-Za-a]+/"; 
				if(preg_match($invalid_punctuation, $input) == 1) //making sure there are no letters in the input
					{
						$valid_input = false;
					}
				$parsed_input = str_replace(" ", "", $input); //get rid of all white spaces
				if(preg_match("$[-]{3,}$", $parsed_input) == 1) //make sure there are two or less minus signs in a row 
					{
						$valid_input = false;
					}
				$parsed_input = str_replace("--", "+", $parsed_input); //replace all double negatives with a positive
				echo "<html><h2>Result:</h2></html>";
				$valid_punctuation = "$^((-)?[0-9]+((\.)?[0-9]+)?)([-\+\*/]{1}((-)?[0-9]+((\.)?[0-9]+)?))*$"; //regex syntax for valid input
				if(preg_match($valid_punctuation, $parsed_input, $matches) == 1 && $valid_input) //if there is a match
					{
						if(strlen($matches[0]) != strlen($parsed_input)) //if the match isn't the whole expression, input is not valid
							{
								$valid_input = false;
							}
						if($valid_input)
							{		
								eval("\$output = $parsed_input;"); //only pass a valid input into eval()
								if(is_numeric($output) && !$zero)
									{
										echo $input." = ".$output."<br/>";
									}
								else
									{
										echo "Invalid input: Division by zero. <br/>"; //catching divide by zero error
									}	
							}		
						else
							{
								echo "Invalid input. <br/>";	
							}
					}
				else
					{
						echo "Invalid input. <br/>";
					}		
			}					
	?>
</body>
</html>
		
				
						
		