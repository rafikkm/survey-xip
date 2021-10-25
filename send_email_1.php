<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Potenza - Job Application Form Wizard with Resume upload and Branch feature">
    <meta name="author" content="Ansonika">
    <title>XIP -FORM ONLINE</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/menu.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	<link href="css/vendors.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="css/custom.css" rel="stylesheet">
    
	<script type="text/javascript">
    function delayedRedirect(){
        window.location = "index.html"
    }
    </script>

</head>
<body style="background-color:#fff;" onLoad="setTimeout('delayedRedirect()', 5000)">
<?php

	
	$servername = "localhost";
    $username = "root";
    $password = "070206682rR";
    $dbname = "xip";
  
    // Create connection
   
   
   
   $mysqli = new mysqli($servername, $username, $password, $dbname);

   if($mysqli->connect_error) {
   exit('Error connecting to database'); //Should be a message a typical user could understand in production
   }
   
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli->set_charset("utf8mb4");

  
// Check connection




	

	$mail = $_POST['email'];



	$to = "rafik.km@gmail.com";/* YOUR EMAIL HERE */
	$subject = "Allo Khedma Survey";
	$headers = "From: Allo Khedma Survey";

	$message  = "PRESENTATION\n";
	$message .= "\n<b>First Name: " . $_POST['fname'];
	$message .= "\nLast Name: " . $_POST['lname'];
	$message .= "\nEmail: " . $_POST['email'];
	$message .= "\nTelephone: " . $_POST['phone'];
	$message .= "\nGender: " . $_POST['gender'];	
    $message .= "\nCountry: " . $_POST['country'];	
	$message .= "\nRegion: " . $_POST['region'];
	$message .= "\nCity: " . $_POST['city'];
	$message .= "\nAddress: " . $_POST['Adresse'];
	$message .= "\nDiplome: " . $_POST['diplome'];
	$message .= "\nGraduation Date: " . $_POST['graddate'];
	$message .= "\nCertifications: " . $_POST['certification'];
	$message .= "\nExperience: " . $_POST['experience'];
	
	
	/* FILE UPLOAD */
	if(isset($_FILES['fileupload'])){
	$errors= array();
	$file_name = $_FILES['fileupload']['name'];
	$file_size =$_FILES['fileupload']['size'];
	$file_tmp =$_FILES['fileupload']['tmp_name'];
	$file_type=$_FILES['fileupload']['type'];
	$file_ext=strtolower(end(explode('.',$_FILES['fileupload']['name'])));

	$expensions= array("pdf","doc","docx");// Define with files are accepted
							  
	$OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['fileupload']['name']); 
	$FileCounter = 1; 
	while (file_exists( 'upload_files/'.$FinalFilename )) // The folder where the files will be stored; set the permission folder to  0755. 
   		$FinalFilename = $FileCounter++.'_'.$OriginalFilename; 

		if(in_array($file_ext,$expensions)=== false){
			$errors[]="Extension not allowed, please choose a .pdf, .doc, .docx file.";
		}
		// Set the files size limit. Use this tool to convert the file size param https://www.thecalculator.co/others/File-Size-Converter-69.html
		if($file_size > 153600){
			$errors[]='File size must be max 150Kb';
		}
		if(empty($errors)==true){
			move_uploaded_file($file_tmp,"upload_files/".$FinalFilename);
		/*	$message .= "\nResume: http://www.yourdomain.com/upload_files/".$FinalFilename; */ // Write here the path of your upload_files folder
			
		}else{
			/*$message .= "\nFile name: no files uploaded";*/
			}
		};
		
		
		/* end FILE UPLOAD */
		
	
		$message .= "\nEtes vous a la recherche?: " . $_POST['availability'];

		if (isset($_POST['searchtime']) && $_POST['searchtime'] != "")
			{
				$message .= "\nDepuis combien de temps êtes-vous à la recherche d’emploi ?: " . $_POST['searchtime'];
				$message .= "\nA combien d’offres d’emploi avez vous postulé ? " . $_POST['offers'];
				$message .= "\nCombien d’entretiens d’embauche avez-vous effectué ?" . $_POST['entretiens'];
			}
			
			
			
			
			
			
		if (isset($_POST['cursus']) && $_POST['cursus'] != "")
			{
				$message .= "\nDéfinissez ce qui vous manque dans votre cursus actuel ?" . $_POST['cursus'];
			}
			
			
			
			
			
			
		if (isset($_POST['qualitycv']) && $_POST['qualitycv'] != "")
			{
				$message .= "\nSi vous deviez définir la qualité de votre CV ?" . $_POST['qualitycv'];
				$message .= "\nAvez vous un profil LinkedIn ?" . $_POST['profilelinkedin'];
				$message .= "\nAvez vous défini votre projet professionnel ?" . $_POST['proproject'];

			}
			
			
			
						
		$message .= "\n\nTerms and conditions accepted: " . $_POST['terms'];
		
		
		$stmt = $mysqli->prepare("INSERT INTO survey (first_name,last_name,Email,Telephone,Gender,Country,Region,City,Address,Diplome,Graduation_Date,Certifications,Experience,Resume,recherche,searchtime,offers,entretiens,cursus,qualitycv,profilelinkedin,proproject) 
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssssssssssss", $_POST['fname'], $_POST['lname'], $_POST['email'],$_POST['phone'],$_POST['gender'],$_POST['country'],
		$_POST['region'],$_POST['city'],$_POST['Adresse'],$_POST['diplome'],$_POST['graddate'],
		$_POST['certification'],$_POST['experience'],$filelocation,$_POST['availability'],$_POST['searchtime'],$_POST['offers'],$_POST['entretiens'],$_POST['cursus'],$_POST['qualitycv'],$_POST['profilelinkedin'],$_POST['proproject']);
        $stmt->execute();
        $stmt->close();
		
		
												
		//Receive Variable
		$sentOk = mail($to,$subject,$message,$headers);
						
		//Confirmation page
		$user = "$mail";
		$usersubject = "Thank You";
		$userheaders = "From: Allo Khedma Survey <noreply@yourdomain.com>";
		/*$usermessage = "Thank you for your time. Your quotation request is successfully submitted.\n"; WITHOUT SUMMARY*/
						
		//Confirmation page WITH  SUMMARY
		$usermessage = "Thank you for your time. Your application is successfully submitted. We will reply soon.\n\nBELOW A SUMMARY\n\n$message"; 
		mail($user,$usersubject,$usermessage,$userheaders);
	
?>
<!-- END SEND MAIL SCRIPT -->   

<div id="success">
    <div class="icon icon--order-success svg">
         <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
          <g fill="none" stroke="#8EC343" stroke-width="2">
             <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
             <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
          </g>
         </svg>
     </div>
	<h4><span>Request successfully sent!</span></h4>
	<small>You will be redirect back in 5 seconds.</small>
</div>
</body>
</html>