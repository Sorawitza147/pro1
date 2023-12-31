<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Country</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-image: url('img/img.gif');
            background-position: center;
            min-height: 100vh;
            background-size: cover; /* ปรับขนาดภาพให้เต็มหน้าจอ */
            background-repeat: no-repeat; /* ปิดการทำซ้ำภาพพื้นหลัง */
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            background-color: #fff; /* เปลี่ยนสีพื้นหลังของคอนเทนเนอร์เป็นขาว */
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-12 mx-auto bg-light rounded p-5">
                <h5 class="text-center font-weight-bold">Country</h5>
                <hr class="my-1">
                <h5 class="text-center text-secondary">Country In The Search Box.</h5>
                <form action="search.php" method="POST" class="p-3" style="position: relative;">
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control form-control-lg border-info rounded-0" placeholder="Search Country..." autocomplete="off" required>
                        <div class="input-group-append">
                            <input type="submit" name="submit" value="Search" class="btn btn-warning btn-lg rounded-0">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="list-group" style="position: absolute; width: 400px;" id="show-list"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="main.js"></script>
</body>
</html>
