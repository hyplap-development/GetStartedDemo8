"use strict";
const sleep = (ms) => new Promise((res) => setTimeout(res, ms));

var KTSigninGeneral = function () {
    var e, t, i;
    return {
        init: function () {
            e = document.querySelector("#kt_sign_in_form"), t = document.querySelector("#kt_sign_in_submit"), i = FormValidation.formValidation(e, {
                fields: {
                    email: {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: "The value is not a valid email address"
                            },
                            notEmpty: {
                                message: "Email address is required"
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "The password is required"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), t.addEventListener("click", (function (n) {
                n.preventDefault();

                var loginn = document.getElementById("Login").value;
                var passwordd = document.getElementById("Password").value;
                console.log(loginn, passwordd);
                $.ajax({
                    type: "POST",
                    url: "/auth",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        login: loginn,
                        password: passwordd,
                    },
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 200) {
                            swal.fire({
                                text: "Your credentials matches our record",
                                icon: "success",
                            }).then(function () {
                                KTUtil.scrollTop();
                            });
                            const work = async () => {
                                await sleep(1000);
                                window.location = "/dashboard";
                            };
                            work();
                        } else if (response.status == 201) {
                            swal.fire({
                                text: "Password is incorrect",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Try Again",
                                customClass: {
                                    confirmButton:
                                        "btn font-weight-bold btn-light-primary",
                                },
                            }).then(function () {
                                KTUtil.scrollTop();
                            });
                        } else if (response.status == 202) {
                            swal.fire({
                                text: "User not found in out records",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Try Again",
                                customClass: {
                                    confirmButton:
                                        "btn font-weight-bold btn-light-primary",
                                },
                            }).then(function () {
                                KTUtil.scrollTop();
                            });
                        } else if (response.status == 204) {
                            swal.fire({
                                text: "You have been deactivated from loging in to the panel.\nKindly contact the admin to reinstate your privileges ",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Try Again",
                                customClass: {
                                    confirmButton:
                                        "btn font-weight-bold btn-light-primary",
                                },
                            }).then(function () {
                                KTUtil.scrollTop();
                            });
                        } else if (response.status == 205) {
                            swal.fire({
                                text: "You have been banned from accessing the Admin Panel ",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Try Again",
                                customClass: {
                                    confirmButton:
                                        "btn font-weight-bold btn-light-primary",
                                },
                            }).then(function () {
                                KTUtil.scrollTop();
                            });
                        }
                    },
                });


            }))
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    KTSigninGeneral.init()
}));