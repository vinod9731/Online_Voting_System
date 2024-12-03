<?php  
    require_once("connect.php");

    // Use the correct variable name ($conn instead of $db)
    $fetchingElection = mysqli_query($conn, "SELECT * FROM election") or die(mysqli_error($conn));
    
    while ($data = mysqli_fetch_assoc($fetchingElection)) {
        $starting_date = $data['starting_date'];
        $ending_date = $data['ending_date'];
        $curr_date = date("Y-m-d");
        $election_id = $data['Id'];
        $status = $data['status'];

        if ($status == "Active") {
            $date1 = date_create($curr_date);
            $date2 = date_create($ending_date);
            $diff = date_diff($date1, $date2);

            

            if ((int)$diff->format("%R%a") < 0) {
                
                mysqli_query($conn, "UPDATE election SET status = 'Expired' WHERE ID = '".$election_id."'") 
                or die(mysqli_error($conn));
            } 
        } else if ($status == "Inactive") {
                $date1 = date_create($curr_date);
                $date2 = date_create($starting_date);
                $diff = date_diff($date1, $date2);
                
                

                if ((int)$diff->format("%R%a") <= 0) {
                    
                    mysqli_query($conn, "UPDATE election SET status = 'Active' WHERE ID = '".$election_id."'") 
                    or die(mysqli_error($conn));
                } 
        }
    }
?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "poppins", sans-serif;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url('back4.jpg');
            background-size: cover;
            background-position: center;
            height: 95vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: #fff;
            width: 450px;
            padding: 1.5rem;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0, 0, 1, 0.9);
        }

        form {
            margin: 0 2rem;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            padding: 1.3rem;
            margin-bottom: 0.4rem;
        }

        input,
        select {
            color: inherit;
            width: 100%;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #757575;
            padding-left: 1.5rem;
            font-size: 15px;
        }

        .input-group {
            padding: 1% 0;
            position: relative;
        }

        .input-group i {
            position: absolute;
            color: black;
        }

        input:focus,
        select:focus {
            background-color: transparent;
            outline: transparent;
            border-bottom: 2px solid hsl(327, 90%, 28%);
        }

        input::placeholder {
            color: transparent;
        }

        label {
            color: #757575;
            position: relative;
            left: 1.2em;
            top: -1.3em;
            cursor: auto;
            transition: 0.3s ease all;
        }

        input:focus~label,
        input:not(:placeholder-shown)~label {
            top: -3em;
            color: hsl(327, 90%, 28%);
            font-size: 15px;
        }

        .recover {
            text-align: right;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .recover a {
            text-decoration: none;
            color: rgb(125, 125, 235);
        }

        .recover a:hover {
            color: blue;
            text-decoration: underline;
        }

        .btn {
            font-size: 1.1rem;
            padding: 8px 0;
            border-radius: 5px;
            outline: none;
            border: none;
            width: 100%;
            background: rgb(125, 125, 235);
            color: white;
            cursor: pointer;
            transition: 0.9s;
        }

        .btn:hover {
            background: #07001f;
        }

        .or {
            font-size: 1.1rem;
            margin-top: 0.5rem;
            text-align: center;
        }

        .icons {
            text-align: center;
        }

        .icons i {
            color: rgb(125, 125, 235);
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-size: 1.5rem;
            cursor: pointer;
            border: 2px solid #dfe9f5;
            margin: 0 15px;
            transition: 1s;
        }

        .icons i:hover {
            background: #07001f;
            font-size: 1.6rem;
            border: 2px solid rgb(125, 125, 235);
        }

        .links {
            display: flex;
            justify-content: space-around;
            padding: 0 4rem;
            margin-top: 0.9rem;
            font-weight: bold;
        }

        button {
            color: rgb(125, 125, 235);
            border: none;
            background-color: transparent;
            font-size: 1rem;
            font-weight: bold;
        }
        

        button:hover {
            text-decoration: underline;
            color: blue;
        }

        .warning {
            color: red;
            font-size: 0.9rem;
            display: none;
        }
    </style>
</head>

<body>
    <div class="container" id="signup" style="display:none;">
        <h1 class="form-title">Register</h1>
        <form method="post" action="register.php">
    <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" name="fName" id="fName" placeholder="First Name" required>
        <label for="fName">Username</label>
    </div>
    
    <div class="input-group">
    <i class="fas fa-envelope"></i>
    <input type="email" name="email" id="email" placeholder="Email" onblur="validateEmail()" required>
    <label for="email">Email</label>
    <span id="emailWarning" class="warning" style="display:none; color: red;">Email must include "@" and end with ".com".</span>
    <span id="duplicateEmailWarning" class="warning" style="display:none; color: red;">This email is already registered. Please use a different email.</span>
</div>

    <div class="input-group">
        <i class="fas fa-calendar-alt"></i>
        <input type="date" name="dob" id="dob" required onblur="calculateAge()">
        <label for="dob">Date of Birth</label>
    </div>
    <div class="input-group">
        <i class="fas fa-user-clock"></i>
        <input type="text" name="age" id="age" placeholder="Age" readonly>
        <label for="age"> Age</label>
    </div>
    <div class="input-group">
        <i class="fas fa-venus-mars"></i>
        <select name="gender" id="gender" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <label for="gender">'     </label>
    </div>
    
    <div class="input-group">
        <i class="fas fa-phone"></i>
        <input type="text" name="tPhone" id="tPhone" placeholder="Phone Number" required>
        <label for="tPhone"> Phone Number</label>
    </div>
    <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="password" placeholder="Password" onblur="validatePassword()" required>
        <label for="password"> Password</label>
        <span id="passwordWarning" class="warning">Password must contain at least one uppercase letter, one lowercase letter, one special character, and one number.</span>
    </div>
    <input type="submit" class="btn" value="Sign Up" name="signUp">
</form>



        <p class="or">----------or--------</p>
        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook"></i>
        </div>
        <div class="links">
            <p>Already Have Account?</p>
            <button id="signInButton">Sign In</button>
        </div>
    </div>

    <div class="container" id="signIn">
        <h1 class="form-title">User Sign In</h1>
        <form method="post" action="register.php">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="emailSignIn" placeholder="Email" required>
                <label for="emailSignIn">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="passwordSignIn" placeholder="Password" required>
                <label for="passwordSignIn">Password</label>
            </div>
            <p class="recover"><a href="#">Forgot your password?</a></p>
            <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        <p class="or">----------or--------</p>
        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook"></i>
        </div>
        <div class="links">
            <p>Don't Have Account?</p>
            <button id="signUpButton">Sign Up</button>
        </div>
    </div>

    <script>
    const signUpButton = document.getElementById('signUpButton');
const signInButton = document.getElementById('signInButton');
const signInForm = document.getElementById('signIn');
const signUpForm = document.getElementById('signup');
const registeredEmails = []; // Store registered emails

signUpButton.addEventListener('click', function() {
    signInForm.style.display = "none";
    signUpForm.style.display = "block";
});

signInButton.addEventListener('click', function() {
    signInForm.style.display = "block";
    signUpForm.style.display = "none";
});

function calculateAge() {
    const dob = document.getElementById('dob').value;
    const ageInput = document.getElementById('age');
    if (dob) {
        const birthDate = new Date(dob);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDifference = today.getMonth() - birthDate.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        ageInput.value = age;
    }
}


function validatePassword() {
    const password = document.getElementById('password').value;
    const warning = document.getElementById('passwordWarning');
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (!passwordPattern.test(password)) {
        warning.style.display = 'block';
    } else {
        warning.style.display = 'none';
    }
}

function validateEmail() {
    const email = document.getElementById('email').value;
    const warning = document.getElementById('emailWarning');
    const duplicateWarning = document.getElementById('duplicateEmailWarning');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const endsWithCom = email.endsWith('.com');
    
    // Check for valid email pattern and '.com' ending
    if (!emailPattern.test(email) || !endsWithCom) {
        warning.style.display = 'block';
        duplicateWarning.style.display = 'none';
        document.getElementById('email').value = ''; // Clear the input if invalid.
    } else {
        warning.style.display = 'none';
        
        // Check for duplicate email
        if (registeredEmails.includes(email)) {
            duplicateWarning.style.display = 'block';
            document.getElementById('email').value = ''; // Clear the input if email already exists.
        } else {
            duplicateWarning.style.display = 'none';
        }
    }
}

// Function to register the user and store their email
function registerUser() {
    const email = document.getElementById('email').value;
    
    // Check if email is valid and not a duplicate before adding
    if (email && !registeredEmails.includes(email)) {
        registeredEmails.push(email);
        alert('User registered successfully!');
        signUpForm.style.display = "none";
        signInForm.style.display = "block";
    } else {
        alert('Please provide a valid and unique email.');
    }
}


</script>

</body>

</html>
