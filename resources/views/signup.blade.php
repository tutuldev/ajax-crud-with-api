<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="card">
                <div class="card-header">
                    <h3>Signup</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Full Name">
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>
                    <button id="signupButton" class="btn btn-success">Signup</button>
                    <a href="/login" class="btn btn-link">Already have an account? Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function(){
        $("#signupButton").on('click', function(){
            const name = $("#name").val();
            const email = $("#email").val();
            const password = $("#password").val();

            if (!name || !email || !password) {
                alert('All fields are required!');
                return;
            }

            $.ajax({
                url: 'api/signup',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    name: name,
                    email: email,
                    password: password,
                }),
                success: function(response){
                    if (response.status) {
                        // Auto login after signup
                        $.ajax({
                            url: 'api/login',
                            type: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                email: email,
                                password: password, // Using the same password to login
                            }),
                            success: function(loginResponse){
                                if (loginResponse.token) {
                                    localStorage.setItem('api_token', loginResponse.token); // Store API token
                                    window.location.href = "/allposts"; // Redirect to All Posts
                                }
                            }
                        });
                    } else {
                        alert('Signup Failed: ' + response.message);
                    }
                },
                error: function(xhr){
                    alert('Error: ' + xhr.responseText);
                }
            });
        });
    });
</script>

</body>
</html>
