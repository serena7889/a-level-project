<?php
require '../includes/config.php';
require '../includes/login-checks/super-admin-login-check.php';
include '../includes/constants.php';
$companyID = $_GET['companyID'];
include '../includes/handlers/handler-functions.php';
include '../includes/handlers/admin-handler.php';

$getCompanyDetailsQuery = "
SELECT companyName, companyEmailAddress, companyPassword, companyAbout, companySignUpDate, companyOffersWorkExperience, companyWorkExperienceDescription, companyWorkExperienceRequirements
FROM companies
WHERE companyID = '$companyID'
";

$result = $con->query($getCompanyDetailsQuery);
if ($result->num_rows == 1) {
	$row = $result->fetch_assoc();
	$name = $row['companyName'];
	$email = $row['companyEmailAddress'];
	$about = $row['companyAbout'];
	$we = $row['companyOffersWorkExperience'];
	$weDescription = $row['companyWorkExperienceDescription'];
	$weRequirements = $row['companyWorkExperienceRequirements'];
	$encryptedPassword = $row['companyPassword'];
}

?>


<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>EDIT COMPANY</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/css/forms.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script type="text/javascript">

    $(document).ready(function() {
      var wantsToOfferWorkExperience = $("#wantsToOfferWorkExperience").val();

      if (wantsToOfferWorkExperience == 'yes') {
        $("#yesWorkExperience").attr('hidden', false);
        $("#noWorkExperience").attr('hidden', true);
      } else {
        $("#noWorkExperience").attr('hidden', false);
        $("#yesWorkExperience").attr('hidden', true);
      }

      $("#yesWorkExperienceBtn").click(function() {
        $("#yesWorkExperience").attr('hidden', false);
        $("#noWorkExperience").attr('hidden', true);
      })
    })

    </script>
  </head>
  <body>

    <?php
    include '../includes/headers/admin-header.php';
    ?>

    <h1>Edit company</h1>
    <div class="row">
      <div class="col">
        <form method="POST">
          <p>
            <?php echo getError($errorArray, $cnWrongLength); ?>
            <label for="name">Company Name: </label>
            <input type="text" name="name" value="<?php echo $name; ?>">
          </p>
          <p>
            <?php echo getError($errorArray, $emTaken); ?>
            <?php echo getError($errorArray, $emInvalid); ?>
            <label for="email">Email address: </label>
            <input type="text" name="email" value="<?php echo $email; ?>">
          </p>
          <p>
            <?php echo getError($errorArray, $aboutWrongLength); ?>
            <label for="about">About your company:</label>
            <input type="text" name="about" value="<?php echo $about; ?>">
          </p>
          <input type="submit" name="updateCompanyDetails" value="Update company details">
        </form>

        <form method="POST">
          <p>
            <?php echo getError($errorArray, $pwNotCurrent); ?>
            <label for="oldPassword">Enter your current password: </label>
            <input type="password" name="oldPassword">
          </p>
          <p>
            <?php echo getError($errorArray, $pwWrongLength); ?>
            <?php echo getError($errorArray, $pwDoNotMatch); ?>
            <label for="newPassword1">Enter your new password: </label>
            <input type="password" name="newPassword1">
          </p>
          <p>
            <label for="newPassword2">Confirm your password: </label>
            <input type="password" name="newPassword2">
          </p>
          <input type="submit" name="updateCompanyPassword" value="Change password">
        </form>

			</div>

      <div class="col">
        <form method="POST">
          <input id="wantsToOfferWorkExperience" type="hidden" name="wantsToOfferWorkExperience" value="<?php echo $we; ?>">
          <div id="yesWorkExperience" hidden>
	          <p>
	            <?php echo getError($errorArray, $descWrongLength); ?>
	            <label for="description"> Work Experience Description:</label>
							<textarea id="description" name="description"><?php echo $weDescription; ?></textarea>
	          </p>
	          <p>
	            <?php echo getError($errorArray, $reqWrongLength); ?>
	            <label for="description"> Work Experience Requirements:</label>
							<textarea id="requirements" name="requirements"><?php echo $weRequirements; ?></textarea>
	          </p>
	          <input id="updateCompanyWorkExperienceBtn" type="submit" name="updateCompanyWorkExperienceBtn" value="Update work experience details">
	          <input id="noWorkExperienceBtn" type="submit" name="noWorkExperienceBtn" value="We don't want to offer work experience">
          </div>

          <div id="noWorkExperience" hidden>
            <button id="yesWorkExperienceBtn" type="button" name="yesWorkExperienceBtn">We want to offer work experience</button>
          </div>

        </form>
      </div>

    </div>

  </body>
</html>











<!-- <?php
// require '../includes/config.php';
// require '../includes/login-checks/admin-login-check.php';
// include '../includes/constants.php';
// $companyID = $_GET['companyID'];
// include '../includes/handlers/handler-functions.php';
// include '../includes/handlers/company-handler.php';

?>

<html>
<head>
	<title>EDIT COMPANY</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Dosis|Hind|KoHo|Krub|Montserrat|Muli|PT+Sans" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script type="text/javascript">

    $(document).ready(function() {
      var wantsToOfferWorkExperience = document.getElementById("wantsToOfferWorkExperience").value;

      if (wantsToOfferWorkExperience == 'yes') {
        console.log('yes');
        $("#yesWorkExperience").attr('hidden', false);
        $("#noWorkExperience").attr('hidden', true);
      } else {
        console.log('no');
        $("#noWorkExperience").attr('hidden', false);
        $("#yesWorkExperience").attr('hidden', true);
      }

      $("#yesWorkExperienceBtn").click(function() {
        $("#yesWorkExperience").attr('hidden', false);
        $("#noWorkExperience").attr('hidden', true);

      })
    })

    </script>
</head>
<body>

<?php
// include '../includes/headers/admin-header.php';
//
// $getCompanyDetailsQuery = "
// SELECT companyName, companyEmailAddress, companyPassword, companyAbout, companySignUpDate, companyOffersWorkExperience, companyWorkExperienceDescription, companyWorkExperienceRequirements
// FROM companies
// WHERE companyID = $companyID
// ";
// $result = $con->query($getCompanyDetailsQuery);
//
// if ($result->num_rows == 1) {
//   $row = $result->fetch_assoc();
//   $name = $row['companyName'];
//   $email = $row['companyEmailAddress'];
//   $about = $row['companyAbout'];
//   $we = $row['companyOffersWorkExperience'];
//   $weDescription = $row['companyWorkExperienceDescription'];
//   $weRequirements = $row['companyWorkExperienceRequirements'];
//   $encryptedPassword = $row['companyPassword'];
//   $signUp = $row['companySignUpDate'];
// } else {
//   echo 'query error';
// }

?>

  <form action="edit-company.php" method="post">
    <p>
      <label for="name">Company Name: </label>
      <input type="text" name="name" value="<?php echo $name; ?>">
    </p>
    <p>
      <label for="email">Email address: </label>
      <input type="text" name="email" value="<?php echo $email; ?>">
    </p>
    <p>
      <label for="about">About your company:</label>
      <input type="text" name="about" value="<?php echo $about; ?>">
    </p>
    <input type="submit" name="updateDetails" value="Update company details">
  </form>

  <br>

  <form action="edit-company.php" method="post">
    <p>
      <label for="oldPassword">Enter your current password: </label>
      <input type="password" name="oldPassword">
    </p>
    <p>
      <label for="newPassword1">Enter your new password: </label>
      <input type="password" name="newPassword1">
    </p>
    <p>
      <label for="newPassword2">Confirm your password: </label>
      <input type="password" name="newPassword2">
    </p>
    <input type="submit" name="updatePassword" value="Change password">
  </form>

  <br>

  <form action="edit-company.php" method="post">
    <input id="wantsToOfferWorkExperience" type="hidden" name="wantsToOfferWorkExperience" value="<?php echo $we; ?>">

    <div id="yesWorkExperience" hidden>
    <p>
      <label for="description"> Work Experience Description:</label>
      <input id="description" type="text" name="description" value="<?php echo $weDescription; ?>">
    </p>
    <p>
      <label for="description"> Work Experience Requirements:</label>
      <input id="requirements" type="text" name="requirements" value="<?php echo $weRequirements; ?>">
    </p>
    <input id="updateWorkExperienceBtn" type="submit" name="updateWorkExperienceBtn" value="Update work experience details">
    <input id="noWorkExperienceBtn" type="submit" name="noWorkExperienceBtn" value="We don't want to offer work experience">
    </div>

    <div id="noWorkExperience" hidden>
      <button id="yesWorkExperienceBtn" type="button" name="yesWorkExperienceBtn">We want to offer work experience</button>
    </div>

  </form>

  </body>
</html>


</body>
</html> -->
