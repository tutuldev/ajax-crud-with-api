
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
            <a href="/addpost" class="btn  btn-sm btn-primary">Add New</a>
            <button class="btn btn-sm btn-danger" id="logoutBtn">Logout</button>
        </div>
     </div>

            <div class="row">
                <div class="col-8">
                    <div id="postContainer">
                        <table class="table table-bordered table-striped ">
                            <tr class="table-dark">
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>View</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                            <tr>
                                <td><img src="" alt="" width="150px"></td>
                                <td>
                                    <h6>Post Title</h6></td>
                                </td>
                                <td>
                                    <p>
                                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae placeat sit
                                    </p>
                                </td>
                                <td><button>View</button></td>
                                <td><button>Update</button></td>
                                <td><button>Delete</button></td>
                              </tr>
                        </table>
                    </div>
        </div>
    </div>
</div>

<!--singel post show modal Modal -->
<div class="modal fade" id="singelPostModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="singelPostLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="singelPostLabel">Singel Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  {{-- update post modal  --}}
  <div class="modal fade" id="updatePostModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updatePostLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="updatePostLabel">Update Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateform">
            <div class="modal-body">
                    <input type="hidden" name="" id="postId" class="form-control mb-3" value="">
                    <b>Title</b> <input type="text" name="" id="postTitle" class="form-control mb-3" value="">
                    <b>Description</b> <input type="text" name="" id="postBody" class="form-control mb-3" value="">
                    <img src="" id="showImage" alt="" width="150px" class="mb-3"><br>
                    <b>Upload Image</b> <input type="file" name="" id="postImage" class="form-control mb-3" value="">
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Save Changes"  class="btn btn-primary">

        </div>
    </form>
      </div>
    </div>
  </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
{{-- ajax with fetch method--}}
<script>
document.querySelector("#logoutBtn").addEventListener('click',function(){
    const token = localStorage.getItem('api_token');

    fetch('/api/logout',{
        method:'POST',
        headers:{
            'Authorization': `Bearer ${token}`
        }
    })
    .then(response => response.json())
    .then(data =>{
        console.log(data);
        window.location.href = "/"
    });
});

function loadData(){
    const token = localStorage.getItem('api_token');

fetch('/api/posts',{
    method:'GET',
    headers:{
        'Authorization': `Bearer ${token}`
    }
})
.then(response => response.json())
.then(data =>{
    // console.log(data);
    // console.log(data.data.posts);
    var allpost = data.data.posts;
    const postContainer = document.querySelector("#postContainer");
              var tabledata= `  <table class="table table-bordered table-striped ">
                            <tr class="table-dark">
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>View</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>`;

                            allpost.forEach(post => {
                               tabledata += `<tr>
                                <td><img src="/uploads/${post.image}" alt="" width="150px" height="100px"></td>
                                <td>
                                    <h6>${post.title}</h6></td>
                                </td>
                                <td>
                                    <p>
                                        ${post.description}

                                    </p>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-postid="${post.id}" data-bs-toggle="modal" data-bs-target="#singelPostModel">View</button>
                                </td>
                                <td><button type="button" class="btn btn-sm btn-success" data-bs-postid="${post.id}" data-bs-toggle="modal" data-bs-target="#updatePostModel">Update</button></td>
                                <td><button onclick="deletePost(${post.id})" class="btn btn-sm btn-danger">Delete</button></td>
                              </tr>`
                            });

                       tabledata += `</table>`;

                       postContainer.innerHTML = tabledata;
});

}
            loadData();
            // open singel post modal
            var singelMOdel = document.querySelector("#singelPostModel");
            if (singelMOdel) {
                singelMOdel.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget

                const modalBody = document.querySelector("#singelPostModel .modal-body");
                modalBody.innerHTML = "";

                const id = button.getAttribute('data-bs-postid')
                console.log(id);

                const token = localStorage.getItem('api_token');

            fetch(`/api/posts/${id}`,{
                method:'GET',
                headers:{
                    'Authorization': `Bearer ${token}`,
                    'Content-type' : 'application/json'
                }
            })
            .then(response => response.json())
            .then(data =>{
                const post = data.data.post[0];


                modalBody.innerHTML = `
                    Title: ${post.title}
                    <br>
                    Description: ${post.description}
                    <br>
                    <img widht="150" src="/uploads/${post.image}"/>

                `;
            });


            })
            }

        //update post modal
        var updateModel = document.querySelector("#updatePostModel");
        if (updateModel) {
            updateModel.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget


            const id = button.getAttribute('data-bs-postid')
            console.log(id);

            const token = localStorage.getItem('api_token');

        fetch(`/api/posts/${id}`,{
            method:'GET',
            headers:{
                'Authorization': `Bearer ${token}`,
                'Content-type' : 'application/json'
            }
        })
        .then(response => response.json())
        .then(data =>{
            const post = data.data.post[0];

            document.querySelector("#postId").value = post.id;
            document.querySelector("#postTitle").value = post.title;
            document.querySelector("#postBody").value = post.description;
            document.querySelector("#showImage").src = `/uploads/${post.image}`;

        });


        })
        }
        // update post and change data
        var updateform = document.querySelector("#updateform");
        // add event with asyconus anonymous function
        updateform.onsubmit = async(e)=>{
        // form reload of
        e.preventDefault();
        // get token
        const token = localStorage.getItem('api_token');
        // value set form localStorage
        const postId = document.querySelector("#postId").value;
        const title = document.querySelector("#postTitle").value;
        const description = document.querySelector("#postBody").value;


        // data gulo ekta object er modde niye nibo
        var formData = new FormData();
        formData.append('id',postId);
        formData.append('title',title);
        formData.append('description',description);

          // check image upload or not
          if(!document.querySelector("#postImage").files[0] ==""){
            const image = document.querySelector("#postImage").files[0];
            formData.append('image',image);
        }

        // data surver a dite hbe
        // async use kora tai await user korte hobe
        let response = await fetch(`/api/posts/${postId}`,{
                method:'POST',
                body:formData,
                headers:{
                  'Authorization': `Bearer ${token}`,
                //   form data tai upore post use kore niche put method diye overrite kore dite hobe
                    'X-HTTP-Method-Override':'PUT'
                }
            })
                .then(response => response.json())
                .then(data =>{
                    console.log(data);
                    window.location.href = "/allposts"
                });

            }

            // delete post
        async function deletePost(postId){
                const token = localStorage.getItem('api_token');

                let response = await fetch(`/api/posts/${postId}`,{
                method:'DELETE',
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
