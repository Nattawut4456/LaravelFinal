<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body style="background-color: #eeeeee">
    <div class="container" style="max-width: 500px">

        <div class="mt-5 p-3 bg-white rounded-3">
            <div class="mt-3 mb-5" style="text-align: center"><h1>Login</h1></div>
            <form action="{{url('/checklogin')}}" method="POST">
                @csrf
                <input type="hidden" name="uri" value="{{$uri}}">
                <div class="my-3">
                    <label>Email</label>
                    <input class="form-control" type="text" name="email" value="{{old('email')}}">
                    @error('email')
                    <div class="invalid-feedback d-block">{{$errors->first('email')}}</div>
                    @enderror
                </div>
                <div class="my-3">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" value="{{old('password')}}">
                    @error('password')
                    <div class="invalid-feedback d-block">{{$errors->first('password')}}</div>
                    @enderror
                </div>
                <button type="submit" class="form-control btn btn-primary mt-3">Login</button>
                <div class="mt-5" style="text-align: center">
                    <p>Don't have account <a href="{{url('/register')}}">Regiser</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</body>
</html>
