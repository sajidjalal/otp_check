$(document).ready(function () {
    $("#generateOtp").on("click", function (e) {
        e.preventDefault();

        var mobile_no = $("#mobile_no").val();
        var re = new RegExp("^[6-9][0-9]{9}$");
        if (!re.test(mobile_no)) {
            if (mobile_no == "" || mobile_no == null) {
                Swal.fire({
                    title: "Alert",
                    text: "Mobile number required",
                    icon: "warning",
                });
            } else {
                Swal.fire({
                    title: "Alert",
                    text: "Invalid Mobile Number!",
                    icon: "warning",
                });
            }

            return;
        } else {
            $.ajax({
                type: "POST",
                url: "/generate-OTP",
                dataType: "json",
                data: {
                    mobile_no: mobile_no,
                },
                success: function (e) {
                    if (e.status == 200) {
                        localStorage.setItem("txnId", e.txnId);
                        Swal.fire({
                            title: "e.message",
                            text: e.token,
                            icon: "success",
                        });
                    } else {
                        Swal.fire({
                            title: "Alert",
                            text: e.message,
                            icon: "warning",
                        });
                    }
                },
            });
        }
    });

    $("#checkOTP").on("click", function (e) {
        e.preventDefault();

        var otp = $("#otp").val();
        var txnId = localStorage.getItem("txnId");

        if (otp == "" || otp == null) {
            Swal.fire({
                title: "Alert",
                text: "OTP required",
                icon: "warning",
            });
            return;
        }

        $.ajax({
            url: "/check-OTP",
            type: "POST",
            dataType: "json",
            data: {
                txnId: txnId,
                otp: otp,
            },
            success: function (e) {
                if (e.status == 200) {
                    Swal.fire({
                        title: e.message,
                        text: e.token,
                        icon: "success",
                    });
                } else {
                    Swal.fire({
                        title: "Alert",
                        text: e.message,
                        icon: "warning",
                    });
                }
            },
        });
    });
});
