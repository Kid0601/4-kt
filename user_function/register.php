<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-secondary">
    <a class="navbar-brand ps-3" href="index.html"> <img class="w-25 d-block mx-auto mt-3" src="橫logo白.svg" alt=""></a>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                </div>
                                <div class="card-body">
                                    <form action="createUI.php" method="post" id="profileForm">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" name="firstName" type="text" placeholder="Enter your first name" required>
                                                    <label for="inputFirstName">First name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" name="lastName" type="text" placeholder="Enter your last name" required>
                                                    <label for="inputLastName">Last name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPhone" name="phone" type="text" placeholder="0912354568" required>
                                                    <label for="inputPhone">phone</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputBirthday" name="birthday" pattern="^\d{4}-\d{2}-\d{2}$" type="text" placeholder="1993-05-23" required>
                                                    <label for="inputBirthday">birthday <span style="font-size:12px; color:gray;" class="text-mute">(ex:1984-07-06)</span></label>
                                                </div>
                                            </div>
                                            <div class=" pt-3">
                                                <div class="d-flex justify-content-between">
                                                    <label for="gender" class="w-25 ">性別：</label>
                                                    <select class="form-select form-select-sm w-75" aria-label=".form-select-sm example" id="gender" name="gender">
                                                        <option value="0">男</option>
                                                        <option value="1">女</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required>
                                            <label for="inputEmail">Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="address" name="address" type="text" placeholder="address" required>
                                            <label for="address">Address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputAccount" name="account" type="account" placeholder="Account" required>
                                            <label for="inputAccount">Account</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Create a password" required>
                                                    <label for="inputPassword">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm" name="confirmPassword" type="password" placeholder="Confirm password" required>
                                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><input value="Create" type="submit" class="btn btn-dark btn-block" id="submit" href=""></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="dashboard.php" class="text-secondary">Go to dashboard</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#" class="text-muted">Privacy Policy</a>
                            &middot;
                            <a href="#" class="text-muted">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

    <script>
        // const submitForm = document.querySelector('#submit')
        const profileForm = document.querySelector('#profileForm')
        profileForm.addEventListener('submit', function(event) {
            const password = document.querySelector('#inputPassword').value;
            const passwordConfirm = document.querySelector('#inputPasswordConfirm').value;
            if (password !== passwordConfirm) {
                event.preventDefault();
                alert("Passwords do not match!");
            } else {
                profileForm.submit();
            }
        })
    </script>
</body>

</html>