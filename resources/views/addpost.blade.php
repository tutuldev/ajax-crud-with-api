
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-8 bg-primary text-white mb-4">
            <h1>All Posts</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            <form action="" id="addForm">

                    <input type="text" name="title" id="title" class="form-control mb-3" placeholder="title">
                    <textarea name="description" id="description" class="form-control mb-3" placeholder="description"></textarea>
                    <input type="file" name="" id="image" class="form-control mb-3">
                    <input type="submit" value="Submit" class="btn btn-primary">
                    <a href="/allposts" class="btn btn-secondary ">Back</a>
            </form>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script>
    // target
    var addForm = document.querySelector("#addForm");
    // add event with asyconus anonymous function
    addForm.onsubmit = async(e)=>{
        // form reload of
        e.preventDefault();
        // get token
        const token = localStorage.getItem('api_token');

        // value set form localStorage
        const title = document.querySelector("#title").value;
        const description = document.querySelector("#description").value;
        // image so array hisebe ashbe
        const image = document.querySelector("#image").files[0];

        // data gulo ekta object er modde niye nibo
        var formData = new FormData();
        formData.append('title',title);
        formData.append('description',description);
        formData.append('image',image);

        // data surver a dite hbe
        // async use kora tai await user korte hobe
        let response = await fetch('/api/posts',{
                method:'POST',
                body:formData,
                headers:{
                  'Authorization': `Bearer ${token}`
                }
            })
                .then(response => response.json())
                .then(data =>{
                    console.log(data);
                    window.location.href = "/allposts"
                });

                }

</script>
</body>
</html>
