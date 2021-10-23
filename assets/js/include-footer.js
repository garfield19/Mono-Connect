const copyToClipboard = text => {
    const elm = document.createElement('textarea');
    elm.value = text;
    document.body.appendChild(elm);
    elm.select();
    document.execCommand('copy');
    document.body.removeChild(elm);
};
var connect;
var code;
var config = {
    key: "test_pk_rsBlgOY1zfY1NzjfP9bk",
    onSuccess: function(response) {
        copyToClipboard(response.code);
        console.log(JSON.stringify(response));
        code = response;

        $("#connect-btn").toggleClass("is-loading");
        $.ajax({
            url: 'api/public/api/v1/getAccountID',
            type: 'post',
            data: JSON.stringify(code),
            dataType: 'json',
            success: function(response) {
                console.log(response);
                var account_id = response.id;
                $.ajax({
                    url: 'api/public/api/v1/getUserInformation',
                    type: 'get',
                    data: {
                        'account_id': response['id']
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(JSON.stringify(response));
                        $("#inputFullName").val(response.fullName);
                        $("#inputPhone").val(response.phone);
                        $("#inputEmail").val(response.email);
                        $("#inputAddress").val(response.addressLine1);
                        $("#inputAddress2").val(response.addressLine2);
                        $("#inputAddress2").val(response.addressLine2);
                        $("#inputAccountID").val(account_id);
                        $("#connect-btn").removeClass("is-loading");


                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        errorToast();
                        $("#connect-btn").removeClass("is-loading");
                    }
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                errorToast();
                $("#connect-btn").removeClass("is-loading");
            }
        });
    },
    onClose: function() {

    }
};
connect = new Connect(config);
connect.setup();
var launch = document.getElementById('connect-btn');
launch.onclick = function(e) {
    connect.open();
};


//submit button clicked
$('#submitForm').click(function(e) {
    e.preventDefault();
    $("#submitForm").toggleClass("is-loading");
    $.ajax({
        url: 'api/public/api/v1/signUpUser',
        data: {
            'name': $('#inputFullName').val(),
            'email': $('#inputEmail').val(),
            'phone': $('#inputPhone').val(),
            'address1': $('#inputAddress').val(),
            'address2': $('#inputAddress2').val(),
            'password': $('#inputPassword').val(),
            'id': $('#inputAccountID').val(),
        },
        error: function() {
            errorToast();
            $("#submitForm").removeClass("is-loading");
        },
        dataType: 'text',
        success: function(data) {
            console.log(data);
            if (data == 1) {
                window.location.replace("http://localhost/app/home.php");
            } else {
                errorToast();
                $("#submitForm").removeClass("is-loading");
            }
        },
        type: 'POST'
    });
});




function errorToast() {
    var toastHTML = `<div class="toast fade hide" data-delay="3000">
    <div class="toast-header">
        <i class="anticon anticon-info-circle text-danger m-r-5"></i>
        <strong class="mr-auto">Something Went Wrong</strong>
        <button type="button" class="ml-2 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        There was an error with your request, please try again.
    </div>
</div>`

    $('#notification-toast').append(toastHTML)
    $('#notification-toast .toast').toast('show');
    setTimeout(function() {
        $('#notification-toast .toast:first-child').remove();
    }, 5000);
}