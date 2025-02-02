<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Vibes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <section class="vh-100">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6 text-black">      
              <div class="px-5 ms-xl-4">
                <i class="fas fa-crow fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i>
                <span class="h1 fw-bold mb-0">Event Vibes</span>
              </div>      
              <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5"> 
                @if(Session::has('message'))
                <p class="alert alert-danger">{{session()->get('message')}}</p> 
                @endif
                <form action="{{route('admin.login.post')}}" method="post">  
                 @csrf 
                <span style="width: 23rem;">     
                  <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign in</h3>
                  <div class="form-outline mb-4">
                    <input required name="email" type="email" id="form2Example18" class="form-control form-control-lg" placeholder="Enter a valid email address" />
                    <label class="form-label" for="form2Example18">Email Address</label>
                  </div>      
                  <div class="form-outline mb-4">
                    <input required name="password" type="password" id="form2Example28" class="form-control form-control-lg" placeholder="Enter your password"/>
                    <label class="form-label" for="form2Example28">Password</label>
                  </div>
                  <div class="pt-1 mb-4">
                    <button class="btn btn-primary" type="submit">Login </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-sm-6 px-0 d-none d-sm-block">
              <img src="https://th.bing.com/th/id/R.4951695e40e0e480d6334cf2f96e3f97?rik=wGsKIZ0961FW%2fA&riu=http%3a%2f%2fwishflowers.com.my%2fwp-content%2fuploads%2f2018%2f01%2fevent-decor-5.jpg&ehk=8sHwT08XSZphk%2b38PMNXLPmYqyTWr0TOI6r0sWtjuho%3d&risl=&pid=ImgRaw&r=0"
                alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
            </div>
          </div>
        </div>
      </section>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>