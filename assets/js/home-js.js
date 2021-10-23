

$('#updateOffer').click(function(e) {
    $("#updateOffer").toggleClass("is-loading");
    $.ajax({
        url: 'api/public/api/v1/getLoanOffer',
        type: 'get',
        data: {
            'account_id': account_id
        },
        dataType: 'text',
        success: function(response) {
            console.log(JSON.stringify(response));
            $("#updateOffer").removeClass("is-loading");
            $("#offer_amount").text(response);
            $("#maxOffer").text(response);



        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            errorToast();
            $("#updateOffer").removeClass("is-loading");
        }
    });

});


$('#payLoan').click(function(e) {
    $("#payLoan").toggleClass("is-loading");
    $.ajax({
        url: 'api/public/api/v1/payBackLoan',
        type: 'get',
        data: {
            'account_id': account_id
        },
        dataType: 'text',
        success: function(response) {
            console.log(response)
            json = JSON.parse(response);
            $("#payLoan").removeClass("is-loading");
            console.log(json.payment_link);
            window.location.replace(json.payment_link);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $("#payLoan").removeClass("is-loading");
            errorToast();
        }
    });

});


$('#processLoan').click(function(e) {
    var amountToWithdraw = parseInt($("#amountToWithdraw").val());
    $("#processLoan").toggleClass("is-loading");
    $.ajax({
        url: 'api/public/api/v1/withdrawLoan',
        type: 'post',
        data: {
            'account_id': account_id,
            'amount': amountToWithdraw
        },
        dataType: 'json',
        success: function(response) {
            $('#quick-view').modal('hide');
            console.log(response);
            console.log(JSON.stringify(response));
            $("#processLoan").removeClass("is-loading");
            $("#debt").text(response.debt);


            if (response.status == 1) {
                successToast();
            } else {
                errorToast();
            }

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            errorToast();
            console.log(errorThrown);
            $("#processLoan").removeClass("is-loading");
        }
    });

});


$("#amountToWithdraw").on("input", function() {
    // alert('Changed!')
    var amountToWithdraw = $("#amountToWithdraw").val();
    $("#loanAmout").text(amountToWithdraw);
    $("#repaymentAmout").text(parseInt(amountToWithdraw) + amountToWithdraw * 0.01)

});




function errorToast() {
    var toastHTML = `<div class="toast fade hide" data-delay="5000">
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

function successToast() {
    var toastHTML = `<div class="toast fade hide" data-delay="5000">
        <div class="toast-header">
            <i class="anticon anticon-info-circle text-success m-r-5"></i>
            <strong class="mr-auto">Success</strong>
            <button type="button" class="ml-2 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            Your request was completed successfully.
        </div>
    </div>`

    $('#notification-toast').append(toastHTML)
    $('#notification-toast .toast').toast('show');
    setTimeout(function() {
        $('#notification-toast .toast:first-child').remove();
    }, 5000);
}

function getAccountData() {
    $.ajax({
        url: 'api/public/api/v1/getAccountData',
        type: 'get',
        data: {
            'account_id': account_id
        },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            console.log(JSON.stringify(response));
            $("#debt").text(response.debt);
            $("#offer_amount").text(response.loan_offer);
            $("#maxOffer").text(response.loan_offer);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            errorToast();
        }
    });

};