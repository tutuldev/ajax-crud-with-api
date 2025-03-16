<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-4 mt-5">
            <div class="card">
                <div class="card-header">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button id="loginButton" class="btn btn-primary">Login</button>
                        <button id="signupButton" class="btn btn-success">Signup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function(){
        $("#loginButton").on('click',function(){
            const email = $("#email").val();
            const password = $("#password").val();

            $.ajax({
                url:'api/login',
                type:'POST',
                contentType:'application/json',
                data:JSON.stringify({
                    email:email,
                    password:password,
                }),
                success:function(response){
                    console.log(response);
                    localStorage.setItem('api_token',response.token);
                    window.location.href = "/allposts";
                },
                error:function(xhr){
                    alert('Error:' + xhr.responseText);
                }
            });
        });

        $("#signupButton").on('click', function(){
            window.location.href = "/signup";
        });
    });
</script>
</body>
</html>
